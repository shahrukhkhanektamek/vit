<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
 
class AdminScriptController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'script.', 
        'title'=>'Script', 
        'table_name'=>'script',
        'page_title'=>'Script',
        "folder_name"=>'backend/admin/script',
        "upload_path"=>'upload/',
        "page_name"=>'script.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
      }

    public function index()
    {
        $session = session()->get('user');
        $id = 1;

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
        $id = decript($this->request->getPost('id'));

        $data = [
            "before_head"=>$this->request->getPost('before_head'),
            "after_body"=>$this->request->getPost('after_body'),
            "bottom_script"=>$this->request->getPost('bottom_script'),
            "status"=>1,
        ];

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