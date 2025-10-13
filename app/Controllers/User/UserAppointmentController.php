<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class UserAppointmentController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'user.appointment.', 
        'title'=>'Appointment', 
        'table_name'=>'appointment',
        'page_title'=>'Appointment',
        "folder_name"=>'user/appointment',
        "upload_path"=>'upload/',
        "page_name"=>'appointment.php',
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
        $user_id = $session['id'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $db = $this->db;
        return view($this->arr_values['folder_name'].'/index',compact('data','db'));
    }
    
    public function load_data()
    {
        $session = session()->get('user');
        $user_id = $session['id'];


        $type = $this->request->getVar('type');
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


        $query = $this->db->table($this->arr_values['table_name'])
            ->join('states', 'states.id = ' . $this->arr_values['table_name'].'.state', 'left')
            ->join('users', 'users.id = ' . $this->arr_values['table_name'].'.user_id', 'left')
            ->join('users as partner', 'partner.id = ' . $this->arr_values['table_name'].'.partner_id', 'left')
            ->select("{$this->arr_values['table_name']}.*, 
                CASE
                    WHEN partner.role = 2 THEN 'User'
                    WHEN partner.role = 3 THEN 'Advocate'
                    WHEN partner.role = 4 THEN 'CA'
                    WHEN partner.role = 5 THEN 'Adviser'
                    WHEN partner.role = 6 THEN 'Employee'
                    ELSE 'other'
                END AS role_name,

                states.name as state_name,                
                partner.image as image,
                partner.name as name,
                partner.email as email,
                partner.phone as phone,

                ")
            ->where([
                $this->arr_values['table_name'] . '.status' =>1,
                $this->arr_values['table_name'] . ".user_id" => $user_id
            ]);

        if(!empty($from_date))
        {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
            $query->where($this->arr_values['table_name'].".add_date_time >=", $from_date);
        }
        if(!empty($to_date))
        {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $query->where($this->arr_values['table_name'].".add_date_time <=", $to_date);
        }


        if(!empty($filter_search_value))
        {
            $query->groupStart()
                ->like($this->arr_values['table_name'] . '.name', $filter_search_value)
            ->groupEnd();
        }

        $total = $query->countAllResults(false);
        $data_list = $query->orderBy($this->arr_values['table_name'] . '.id', $order_by)->limit($limit, $offset)->get()->getResult();
        $data['pager'] = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = $offset + 1;
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

    public function appointment_success($id='')
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $id = decript($id);

        $db = $this->db;
        $data = [];
        $row = $this->db->table('appointment')
        ->join('users', 'users.id = '.'appointment.partner_id', 'left')
        ->join('transaction', 'transaction.id = '.'appointment.transaction_table_id', 'left')
        ->select("
            appointment.*, 
            users.name as partner_name,
            transaction.detail as detail,
        ")
        ->where("appointment.id",$id)->where("appointment.payment_status",1)->get()->getRow();
        
        return view($this->arr_values['folder_name'].'/appointment-success',compact('data','db','row'));

    }

    public function appointment_invoice($id='')
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $id = decript($id);

        $db = $this->db;
        $data = [];
        $row = $this->db->table('appointment')
        ->join('users', 'users.id = '.'appointment.partner_id', 'left')
        ->join('transaction', 'transaction.id = '.'appointment.transaction_table_id', 'left')
        ->select("
            appointment.*, 
            users.name as partner_name,
            transaction.detail as detail,
            transaction.id as invoice_id,
            transaction.amount as amount,
            transaction.gst as gst,
            transaction.final_amount as final_amount,
        ")
        ->where("appointment.id",$id)->where("appointment.payment_status",1)->get()->getRow();
        
        return view($this->arr_values['folder_name'].'/appointment-invoice',compact('data','db','row'));

    }

    public function book()
    {
        $session = session()->get('user');
        $user_id = $add_by = $session['id'];

        $partner_id = decript($this->request->getPost('partner_id'));
        
        $data['partner_id'] = $partner_id;
        $data['user_id'] = $user_id;
        $data['add_by'] = $user_id;

        $data['name'] = $this->request->getPost('name');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        $data['country'] = $this->request->getPost('country');
        $data['state'] = $this->request->getPost('state');

        $data['status'] = 1;
        $data['add_date_time'] = date("Y-m-d H:i:s");
        $data['update_date_time'] = date("Y-m-d H:i:s");

        
        if(empty($this->request->getPost('term')))
        {
            $action = 'add';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = "Select Terms & Consition!";
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }

        
        $entryStatus = false;
        
        if($this->db->table($this->arr_values['table_name'])->insert($data)) $entryStatus = true;
        else $entryStatus = false;        


        if($entryStatus)
        {
            $action = 'redirect';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['action'] = $action;
            $result['url'] = base_url();
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