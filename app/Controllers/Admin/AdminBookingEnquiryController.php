<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminBookingEnquiryController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'booking-enquiry.', 
        'title'=>'Booking Enquiry', 
        'table_name'=>'enquiry_booking',
        'page_title'=>'Booking Enquiry',
        "folder_name"=>'backend/admin/enquiry/booking-enquiry',
        "upload_path"=>'upload/',
        "page_name"=>'booking-enquiry.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
        $this->pager = \Config\Services::pager();
      }

    public function index()
    {
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));      
        $data['pagenation'] = array($this->arr_values['title']);
        return view($this->arr_values['folder_name'].'/index',compact('data'));
    }
    public function load_data()
    {
        $limit = $this->request->getVar('limit');
        $status = $this->request->getVar('status');
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;

        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   

        $from_date = $this->request->getVar('from_date');
        $to_date = $this->request->getVar('to_date');
        $where = [];
        $query = $this->db->table($this->arr_values['table_name'])
            ->join('product', 'product.id = ' . $this->arr_values['table_name'] . '.bike_id', 'left')
            ->join('color', 'color.id = ' . $this->arr_values['table_name'] . '.color', 'left')
            ->select("
                {$this->arr_values['table_name']}.*, 
                product.price as price, 
                color.name as color_name,
                color.code as color_code
            ")
            ->where([
                $this->arr_values['table_name'] . '.status' => $status
            ]);

        
        if (!empty($filter_search_value)) {
            $query->groupStart()
                ->like($this->arr_values['table_name'] . '.email', $filter_search_value)
                ->groupEnd();
        }

        
        if (!empty($from_date)) {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
            $query->where($this->arr_values['table_name'] . '.add_date_time >=', $from_date);
        }
        if (!empty($to_date)) {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $query->where($this->arr_values['table_name'] . '.add_date_time <=', $to_date);
        }

        
        $total = $query->countAllResults(false);

        
        $data_list = $query
            ->orderBy($this->arr_values['table_name'] . '.id', $order_by)
            ->limit($limit, $offset)
            ->get()
            ->getResult();

        
        $data['pager'] = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = ($total > 0) ? $offset + 1 : 0;
        $data['endData'] = ($offset + $limit > $total) ? $total : ($offset + $limit);
        $data['data_list'] = $data_list;

          

        $view = view($this->arr_values['folder_name'].'/table',compact('data_list','data'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    
    public function view($id=null)
    {   
        $id = decript($id);
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "View ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));           
        $data['pagenation'] = array($this->arr_values['title']);

        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        if(!empty($row))
        {
            $db=$this->db;
            return view($this->arr_values['folder_name'].'/view',compact('data','row','db'));
        }
        else
        {
            return view('admin/404',compact('data'));            
        }
    }

    
   
    public function delete($id)
    {
        $id = decript($id);
        $data = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $slug = $data->slug;
        if($this->db->table($this->arr_values['table_name'])->where("id", $id)->delete())
        {
            $this->db->table('slugs')->where(["slug"=>$slug,"table_name"=>$this->arr_values['table_name'],])->delete();
            $this->db->table("meta_tags")->where("slug", $slug)->delete();
            $action = 'delete';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Delete Successfuly';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $action = 'delete';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }   
   
    public function transfer_now()
    {
        $id = decript($this->request->getVar('id'));        
        $vendor_id = $this->request->getVar('vendor_id');        
        $data = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        

        $transferData['inquiry_table_id'] = $id;
        $transferData['vendor_id'] = $vendor_id;
        $transferData['name'] = $data->name;
        $transferData['email'] = $data->email;
        $transferData['phone'] = $data->phone;
        $transferData['bike_id'] = $data->bike_id;
        $transferData['bike_name'] = $data->bike_name;
        $transferData['color'] = $data->color;
        $transferData['amount'] = $data->amount;

        $transferData['add_date_time'] = date("Y-m-d H:i:s");
        $transferData['update_date_time'] = date("Y-m-d H:i:s");
        $transferData['status'] = 1;

        $check = $this->db->table("vendor_enquiry_booking")->where(["inquiry_table_id"=>$id,"vendor_id"=>$vendor_id,])->get()->getFirstRow();
        if(!empty($check))
        {
            $action = 'delete';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Already Transfered This Inquiry!';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        


        
        if($this->db->table("vendor_enquiry_booking")->insert($transferData))
        {
            $action = 'delete';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Transfer Successfuly';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $action = 'delete';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }

}