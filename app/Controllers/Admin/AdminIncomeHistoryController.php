<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminIncomeHistoryController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'income-history.', 
        'title'=>'Income History', 
        'table_name'=>'report',
        'page_title'=>'Income History',
        "folder_name"=>'backend/admin/income-history',
        "upload_path"=>'upload/',
        "page_name"=>'income-history.php',
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

        


        $db=$this->db;


        $payment = '';
        if ($status == 1) $payment = 1;
        if ($status == 2) $payment = 0;

        $builder = $db->table('report');
        
        $builder->select([
            'report.partner_id',
            'report.only_date',
            'users.name',
            'users.phone',
            'amount as amount',
            '(amount * tds / 100) as tds_amount',
            '(amount - (amount * tds / 100) ) as final_amount',
            
        ]);
        $builder->join('users as users', 'users.id = report.partner_id', 'left');
        $builder->where('report.status', 1);
        $builder->whereIn('report.type', [1, 2, 3, 4, 5, 6]);

        // payment filter
        if (!empty($status)) {
            $builder->where('report.payment', $payment);
        }

        // date filter
        
        if (!empty($this->request->getVar('from_date')) && !empty($this->request->getVar('to_date'))) {
            $from_date = $this->request->getVar('from_date') . " 00:00:00";
            $to_date   = $this->request->getVar('to_date') . " 23:59:00";
            $builder->where("report.package_payment_date_time >=", $from_date);
            $builder->where("report.package_payment_date_time <=", $to_date);
        }
      

        // user filter
        if (!empty($this->request->getVar('user_id'))) {
            $user_id = $this->request->getVar('user_id');
            $builder->where('report.partner_id', $user_id);
        }

      
        // total count ke liye builder clone
        $totalBuilder = clone $builder;
        $total = $totalBuilder->countAllResults(false);

        // paginated records
        $query = $builder->get($limit, $offset);
        

        $data_list = $query->getResult();
        if(empty($data_list)) $data_list = [];



        // pagination info
        $data['pager']     = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = ($total > 0) ? $offset + 1 : 0;
        $data['endData']   = ($offset + $limit > $total) ? $total : ($offset + $limit);

        

        $view = view($this->arr_values['folder_name'].'/table',compact('data_list','data'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
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

}