<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class VendorPackageController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'vendor.package.', 
        'title'=>'Package', 
        'table_name'=>'package',
        'page_title'=>'Package',
        "folder_name"=>'backend/vendor/package',
        "upload_path"=>'upload/',
        "page_name"=>'package-single.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
        $this->pager = \Config\Services::pager();
      }

    public function index()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));      
        $data['pagenation'] = array($this->arr_values['title']);
        return view($this->arr_values['folder_name'].'/index',compact('data'));
    }
    public function load_data()
    {

        $session = session()->get('user');
        $vendor_id = $session['id'];


        $limit = $this->request->getVar('limit');
        $status = $this->request->getVar('status');
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;

        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   

        $data_list = $this->db->table($this->arr_values['table_name'])
        
        // ->select("main_menu.name as menu_name, {$this->arr_values['table_name']}.*")
        // ->join('main_menu', 'main_menu.id = ' . $this->arr_values['table_name'] . '.menu', 'left')

        ->where([$this->arr_values['table_name'] . '.status' => $status])
        ->orderBy($this->arr_values['table_name'] . '.id', $order_by)
        
        ->limit($limit, $offset)
        ->get()->getResult();
          


        $total = $this->db->table($this->arr_values['table_name'])->countAll();
        $data['pager'] = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = $offset+1;
        $data['endData'] = ($offset + $limit > $total) ? $total : ($offset + $limit);
          

        

        $view = view($this->arr_values['folder_name'].'/table',compact('data_list','data'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    public function get_package()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];

        $id = decript($this->request->getPost('id'));

        $date_time = date("Y-m-d H:i:s");

        $package = $this->db->table("package")->where(["id"=>$id,])->get()->getFirstRow();
        if(empty($package))
        {
            $action = 'add';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = "Wrong Package!";
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }

        $data = [
            "vendor_id"=>$vendor_id,
            "package_id"=>$package->id,
            "package_name"=>$package->name,
            "validity"=>$package->validation,
            "amount"=>$package->price,
            "gst"=>0,
            "final_amount"=>$package->final_price,

            "status"=>0,
            "is_delete"=>0,
        ];

        $data['add_by'] = $vendor_id;
        $data['add_date_time'] = date("Y-m-d H:i:s");
        $data['update_date_time'] = date("Y-m-d H:i:s");
        $entryStatus = false;


        $data['payment_date_time'] = $date_time;
        $data['plan_start_date_time'] = $date_time;
        $data['plan_end_date_time'] = date("Y-m-d H:i:s", strtotime($date_time."+$package->validation month"));
        $data['status'] = 1;

        if($this->db->table("vendor_package")->insert($data)) $entryStatus = true;


        if($entryStatus)
        {
            $action = 'reload';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);    
        }
        else
        {
            $action = 'add';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }        
    }
   
    

}