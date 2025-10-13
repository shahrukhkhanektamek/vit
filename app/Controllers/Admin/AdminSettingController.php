<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
 
class AdminSettingController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'setting.', 
        'title'=>'Setting', 
        'table_name'=>'setting',
        'page_title'=>'Setting',
        "folder_name"=>'backend/admin/setting',
        "upload_path"=>'upload/',
        "page_name"=>'setting.php',
       );

      public function __construct()
      {
        $this->db = \Config\Database::connect();
      }

    public function main()
    {
        $session = session()->get('user');
        $id = 2;
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'main-update'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $form_data = json_decode($row->data);
        return view($this->arr_values['folder_name'].'/main-form',compact('data','form_data','row'));
    }
    public function main_update()
    {
        $session = session()->get('user');
        $id = decript($this->request->getPost('id'));

        $data['data'] = json_encode([
            "google_map"=>$this->request->getPost('google_map'),
            "school_time"=>$this->request->getPost('school_time'),
            "email"=>$this->request->getPost('email'),
            "mobile"=>$this->request->getPost('mobile'),
            "facebook"=>$this->request->getPost('facebook'),
            "twitter"=>$this->request->getPost('twitter'),
            "whatsapp"=>$this->request->getPost('whatsapp'),
            "youtube"=>$this->request->getPost('youtube'),
            "address"=>$this->request->getPost('address'),
            "location_map"=>$this->request->getPost('location_map'),
            "instagram"=>$this->request->getPost('instagram'),
            "telegram"=>$this->request->getPost('telegram'),
            "linkedin"=>$this->request->getPost('linkedin'),            
        ]);

        $entryStatus = false;        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;        
        if($entryStatus)
        {
            $action = 'edit';
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

    public function policy()
    {
        $session = session()->get('user');
        $id = 14;
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'policy-update'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $form_data = json_decode($row->data);
        return view($this->arr_values['folder_name'].'/policy-form',compact('data','form_data','row'));
    }
    public function policy_update()
    {
        $session = session()->get('user');
        $id = decript($this->request->getPost('id'));

        $data['data'] = json_encode([
            "terms_policy"=>$this->request->getPost('terms_policy'),      
            "privacy_policy"=>$this->request->getPost('privacy_policy'),      
            "refund_policy"=>$this->request->getPost('refund_policy'),      
        ]);

        $entryStatus = false;        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;        
        if($entryStatus)
        {
            $action = 'edit';
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

    public function logo()
    {
        $session = session()->get('user');
        $id = 13;
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'logo-update'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $form_data = json_decode($row->data);
        return view($this->arr_values['folder_name'].'/logo-form',compact('data','form_data','row'));
    }
    public function logo_update()
    {
        $session = session()->get('user');
        $id = decript($this->request->getPost('id'));

        $data['data'] = json_encode([
            "company_name"=>$this->request->getPost('company_name'),
            "logo_image"=>$this->request->getPost('logo_image'),
            "favicon_image"=>$this->request->getPost('favicon_image'),
        ]);

        $entryStatus = false;        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;        
        if($entryStatus)
        {
            $action = 'edit';
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