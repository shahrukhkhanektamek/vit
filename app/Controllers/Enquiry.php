<?php

namespace App\Controllers;
use CodeIgniter\Database\Database;
use CodeIgniter\HTTP\RequestInterface;

use App\Models\Custom;

class Enquiry extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function contact_enquiry()
    {
        $table_name = 'enquiry_contact';
        $data['name'] = $this->request->getPost('name');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        // $data['subject'] = $this->request->getPost('subject');
        $data['coment'] = $this->request->getPost('message');
        

        $data['url'] = $this->request->getPost('url');
        $data['status'] = 1;
        $data['is_delete'] = 0;
        $data['add_date_time'] = date("Y-m-d H:i:s");
        $data['update_date_time'] = date("Y-m-d H:i:s");


        // if ($this->request->getPost('captcha') != session()->get('captcha_answer'))
        // {
        //     $action = 'modalsubmitadd';
        //     $responseCode = 400;
        //     $result['status'] = $responseCode;
        //     $result['message'] = 'Wrong Captcha!';
        //     $result['modalid'] = 'enquiryModal';
        //     $result['action'] = $action;
        //     $result['data'] = [];
        //     return $this->response->setStatusCode($responseCode)->setJSON($result);
        // }



        $entryStatus = false;
        if($this->db->table($table_name)->insert($data)) $entryStatus = true;
        else $entryStatus = false;
        $id = $insertId = $this->db->insertID();

        if($entryStatus)
        {
            $action = 'modalsubmitadd';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['modalid'] = 'enquiryModal';
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
    public function lead_enquiry()
    {
        $table_name = 'enquiry_lead';

        $session = session()->get('user');
        $user_id = @$session['id'];
        $role = @$session['role'];
        if($role!=1 && $role!='') $data['user_id'] = $user_id;
        else $data['user_id'] = $this->request->getPost('uniqueId');

        $data['name'] = $this->request->getPost('name');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        $data['country'] = $this->request->getPost('country');
        $data['state'] = $this->request->getPost('state');
        $data['message'] = $this->request->getPost('message');
        $data['service_id'] = $service_id = decript($this->request->getPost('service'));
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        

        $data['url'] = $this->request->getPost('url');
        $data['status'] = 1;
        $data['is_delete'] = 0;
        $data['add_date_time'] = date("Y-m-d H:i:s");
        $data['update_date_time'] = date("Y-m-d H:i:s");


        $service = $this->db->table("service")->where(["id"=>$service_id,])->get()->getFirstRow();
        $data['service_name'] = $service->name;
        $data['service_type'] = $service->service_type;
        
        




        // if ($this->request->getPost('captcha') != session()->get('captcha_answer'))
        // {
        //     $action = 'modalsubmitadd';
        //     $responseCode = 400;
        //     $result['status'] = $responseCode;
        //     $result['message'] = 'Wrong Captcha!';
        //     $result['modalid'] = 'enquiryModal';
        //     $result['action'] = $action;
        //     $result['data'] = [];
        //     return $this->response->setStatusCode($responseCode)->setJSON($result);
        // }


        $entryStatus = false;
        if($this->db->table($table_name)->insert($data)) $entryStatus = true;
        else $entryStatus = false;
        $id = $insertId = $this->db->insertID();

        if($entryStatus)
        {

            $Custom = new Custom();

            $date = date("Y-m-d");
            $date_time = date("Y-m-d H:i:s");
            $partner = $this->db->table("users")->where(["status"=>1,"role"=>1,])->get()->getFirstRow();
            $partner_id = $partner->id;


            $lead_transfers_data['add_date_time'] = $date_time;
            $lead_transfers_data['update_date_time'] = $date_time;
            $lead_transfers_data['from_partner_id'] = $partner_id;
            $lead_transfers_data['to_partner_id'] = $partner_id;
            $lead_transfers_data['lead_id'] = $insertId;
            $lead_transfers_data['status'] = 1;
            $lead_transfers_data['add_by'] = $partner_id;
            $this->db->table("lead_transfers")->insert($lead_transfers_data);



            // $Custom->transfer($insertId,$partner_id);
            $Custom->employee_auto_transfer($insertId,1,$date);

            // $action = 'mainmodalsubmitadd';
            $action = 'reload';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['modalid'] = 'enquiryModal';
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
