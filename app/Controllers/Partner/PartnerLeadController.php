<?php
namespace App\Controllers\Partner;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class PartnerLeadController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'partner.lead.', 
        'title'=>'Lead Enquiry', 
        'table_name'=>'partner_lead',
        'page_title'=>'Lead Enquiry',
        "folder_name"=>'partner/lead',
        "upload_path"=>'upload/',
        "page_name"=>'lead.php',
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
        $partner_id = $session['id'];

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
        $partner_id = $session['id'];


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
            ->join('enquiry_lead', 'enquiry_lead.id = ' . $this->arr_values['table_name'] . '.lead_id', 'left')
            ->join('service', 'service.id = ' . 'enquiry_lead.service_id', 'left')
            ->join('states', 'states.id = ' . 'enquiry_lead.state', 'left')
            ->join('users', 'users.id = ' . 'enquiry_lead.user_id', 'left')
            ->select("{$this->arr_values['table_name']}.*, 
                CASE 
                    WHEN {$this->arr_values['table_name']}.is_view = 1 THEN enquiry_lead.email 
                    ELSE 'xxxxx' 
                END AS email,
                CASE 
                    WHEN {$this->arr_values['table_name']}.is_view = 1 THEN enquiry_lead.phone 
                    ELSE 'xxxxx' 
                END AS phone,

                enquiry_lead.name as name,
                enquiry_lead.message as message,
                enquiry_lead.service_name as service_name,

                states.name as state_name,                
                users.image as image,

                ")
            ->where([
                $this->arr_values['table_name'] . '.status' =>1,
                $this->arr_values['table_name'] . ".partner_id" => $partner_id
            ]);

        if($type==1)
        {
            $from_date = date('Y-m-d 00:00:00');
            $to_date = date('Y-m-d 23:59:59');
            $query->where($this->arr_values['table_name'].".add_date_time >=", $from_date);
            $query->where($this->arr_values['table_name'].".add_date_time <=", $to_date);
        }

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
    
    public function scratch()
    {
        $session = session()->get('user');
        $partner_id = $add_by = $session['id'];
        $id = decript($this->request->getPost('id'));
        $row = $this->db->table($this->arr_values['table_name'])
        ->join('enquiry_lead', 'enquiry_lead.id = ' . $this->arr_values['table_name'] . '.lead_id', 'left')
        ->select("{$this->arr_values['table_name']}.*, 

            enquiry_lead.name as name,
            enquiry_lead.phone as phone,
            enquiry_lead.email as email,

            ")
        ->where([$this->arr_values['table_name'].".id"=>$id,$this->arr_values['table_name'].".partner_id"=>$partner_id,])->get()->getFirstRow();
        if(empty($row))
        {
            $action = 'reload';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = "Unknown!";
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }

        $data = [
            "is_view"=>1,
        ];

        $entryStatus = false;
        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;        


        if($entryStatus)
        {
            $action = 'view';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['action'] = $action;
            $result['data'] = $row;
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