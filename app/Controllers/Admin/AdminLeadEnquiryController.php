<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

use App\Models\Custom;

class AdminLeadEnquiryController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'lead-enquiry.', 
        'title'=>'Lead Enquiry', 
        'table_name'=>'enquiry_lead',
        'page_title'=>'Lead Enquiry',
        "folder_name"=>'backend/admin/enquiry/lead-enquiry',
        "upload_path"=>'upload/',
        "page_name"=>'lead-enquiry.php',
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
        $db = $this->db;
        return view($this->arr_values['folder_name'].'/index',compact('data','db'));
    }
    public function load_data()
    {
        
        $session = session()->get('user');
        $user_id = $session['id'];
        $role = $session['role'];
        
        
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
            ->join('service', 'service.id = ' . $this->arr_values['table_name'] . '.service_id', 'left')
            ->join('states', 'states.id = ' . $this->arr_values['table_name'] . '.state', 'left')
            ->join(
                'partner_lead as partner_lead',
                'partner_lead.lead_id = ' . $this->arr_values['table_name'] . '.id AND partner_lead.status = 1',
                'left'
            )
            ->join(
                'employee_lead as employee_lead',
                'employee_lead.lead_id = ' . $this->arr_values['table_name'] . '.id AND employee_lead.status = 1',
                'left'
            )
            ->join('users as partner', 'partner.id = ' . 'partner_lead.partner_id', 'left')
            ->join('users as employee', 'employee.id = ' . 'employee_lead.employee_id', 'left')
            ->select("
                {$this->arr_values['table_name']}.*, 
                CASE 
                    WHEN {$this->arr_values['table_name']}.service_type = 1 THEN 'CA' 
                    WHEN {$this->arr_values['table_name']}.service_type = 2 THEN 'Advocate' 
                    WHEN {$this->arr_values['table_name']}.service_type = 3 THEN 'Adviser' 
                    ELSE 'other' 
                END AS service_type_name,


                states.name as state_name,
                service.name as service_name,

                partner.name as partner_name,
                partner.phone as partner_phone,
                partner.email as partner_email,

                employee.name as employee_name,
                employee.phone as employee_phone,
                employee.email as employee_email,

                partner_lead.is_view as is_view,


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

        if($role!=1)
        {
            $query->where('employee_lead.employee_id', $user_id);            
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
        $partner_id = $this->request->getVar('partner_id');        
        $data = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        

        $transferData['lead_id'] = $id;
        $transferData['partner_id'] = $partner_id;


        $transferData['add_date_time'] = date("Y-m-d H:i:s");
        $transferData['update_date_time'] = date("Y-m-d H:i:s");
        $transferData['status'] = 1;
        $transferData['is_view'] = 0;

        $check = $this->db->table("partner_lead")->where(["lead_id"=>$id,"partner_id"=>$partner_id,"status"=>1,])->get()->getFirstRow();
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

        $Custom = new Custom();
        $inId = $Custom->transfer($id,$partner_id);

        
        if($inId)
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

    public function update()
    {
        $id = decript($this->request->getPost('id'));
        $followup_status = $this->request->getPost('followup_status');
        $message = $this->request->getPost('message');
        $date = $this->request->getPost('date');

        $session = session()->get('user');
        $user_id = $session['id'];

        $data = [
            "followup_status"=>$followup_status,
        ];

        $entryStatus = false;        
        $data['update_date_time'] = date("Y-m-d H:i:s");
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;
        
        if($entryStatus)
        {

            $this->db->table('lead_followup')->insert([
                'user_id'=>$user_id,
                'lead_id'=>$id,
                'followup_status'=>$followup_status,
                'message'=>$message,
                'date'=>$date,
                'add_date_time'=>date("Y-m-d H:i:s"),
            ]);

            $action = 'modalsubmitadd';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['action'] = $action;
            $result['modalid'] = 'addStatus';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);            
        }
        else
        {
            $action = 'modalsubmitadd';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['modalid'] = 'addStatus';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }

    public function assign()
    {
        $id = decript($this->request->getVar('id'));        
        $employee_id = $this->request->getVar('employee_id');        
        $data = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        

        $transferData['lead_id'] = $id;
        $transferData['employee_id'] = $employee_id;


        $transferData['add_date_time'] = date("Y-m-d H:i:s");
        $transferData['update_date_time'] = date("Y-m-d H:i:s");
        $transferData['status'] = 1;
        $transferData['is_view'] = 0;

        $check = $this->db->table("employee_lead")->where(["lead_id"=>$id,"employee_id"=>$employee_id,"status"=>1,])->get()->getFirstRow();
        if(!empty($check))
        {
            $action = 'delete';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Already Assign This Inquiry!';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }

        $Custom = new Custom();
        $inId = $Custom->employee_transfer($id,$employee_id);

        
        if($inId)
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

    public function time_line()
    {        
        $id = decript($this->request->getPost('id'));

        $table_name = 'lead_followup';
        $status = 1;
        $order_by = 'desc';
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   
        
        $data_list = $this->db->table($table_name)
        ->join('users', 'users.id = ' . $table_name . '.user_id', 'left')

        ->select("users.name as employee_name, {$table_name}.*")
        ->where(["lead_id"=>$id,])
        ->orderBy($table_name . '.id', $order_by)
        ->get()
        ->getResult();


        foreach ($data_list as &$item) {
            $item->add_date_time = date("d M, Y h:i A");
            $item->followup_status = lead_status($item->followup_status);
        }
        unset($item); // good practice when using references

        
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = $data_list;
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }

}