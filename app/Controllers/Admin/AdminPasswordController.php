<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
 
class AdminPasswordController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'admin.password.', 
        'title'=>'Password', 
        'table_name'=>'users',
        'page_title'=>'Password',
        "folder_name"=>'backend/admin/password',
        "upload_path"=>'upload/',
        "page_name"=>'password.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
      }

    public function index()
    {
        $session = session()->get('user');
        $id = $session['id'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'index'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        return view($this->arr_values['folder_name'].'/form',compact('data','row'));
    }
    public function update()
    {
        $session = session()->get('user');
        $add_by = $session['id'];
        $id = $add_by;

        $opassword = $this->request->getPost('opassword');
        $npassword = $this->request->getPost('npassword');
        $cpassword = $this->request->getPost('cpassword');


        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();

        if($npassword!=$cpassword)
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Confirm Password Not Match!';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result); 
        }        
        if($row->password!=md5($opassword))
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Old Password Not Match!';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result); 
        }  


        $data = [
            "status"=>1,
        ];
        $data['password'] = md5($cpassword);

        $entryStatus = false;
        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;        


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