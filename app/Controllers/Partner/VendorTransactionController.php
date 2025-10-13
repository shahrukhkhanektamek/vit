<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class VendorTransactionController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'vendor.transaction.', 
        'title'=>'Payment History', 
        'table_name'=>'transaction',
        'page_title'=>'Payment History',
        "folder_name"=>'backend/vendor/transaction',
        "upload_path"=>'upload/',
        "page_name"=>'transaction.php',
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

        $where = [];
        $data_list = $this->db->table($this->arr_values['table_name'])
        ->where([$this->arr_values['table_name'] . '.status' => $status])
        ->orderBy($this->arr_values['table_name'] . '.id', $order_by)
        ->limit($limit, $offset);


        $from_date = $this->request->getVar('from_date');
        $to_date = $this->request->getVar('to_date');
        if(!empty($from_date))
        {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
            $where["add_date_time >="] = $from_date;
        }
        if(!empty($to_date))
        {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $where["add_date_time <="] = $to_date;
        }

        if(!empty($where)) $data_list->where($where);
        $data_list = $data_list->get()->getResult();


        $total = $this->db->table($this->arr_values['table_name']);
        if(!empty($where)) $total->where($where);
        $total = $total->countAllResults();
        $data['pager'] = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = ($total > 0) ? $offset+1 : 0;
        $data['endData'] = ($offset + $limit > $total) ? $total : ($offset + $limit);
          

        

        $view = view($this->arr_values['folder_name'].'/table',compact('data_list','data'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    
  


}