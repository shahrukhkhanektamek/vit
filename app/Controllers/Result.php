<?php

namespace App\Controllers;
use CodeIgniter\Database\Database;
use CodeIgniter\HTTP\RequestInterface;

use App\Models\ImageEditorModel;

class Result extends BaseController
{
    protected $db;
    protected $arr_values = array(
        'routename'=>'admin-user.', 
        'title'=>'User', 
        'table_name'=>'users',
        'page_title'=>'User',
        "folder_name"=>'backend/admin/user',
        "upload_path"=>'upload/',
        "page_name"=>'single-user.php',
       );
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function get($id=null)
    {   

        $roll_no = $this->request->getVar('roll_no');
        $name = $this->request->getVar('name');
        $date_of_birth = $this->request->getVar('date_of_birth');
        
        $roll_no = str_replace(env('APP_SORT'), '', strtoupper($roll_no));

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "View ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));           
        $data['pagenation'] = array($this->arr_values['title']);

        $row = $this->db->table($this->arr_values['table_name'])
        ->where([
            $this->arr_values['table_name'] .".name"=>$name,
            $this->arr_values['table_name'] .".user_id"=>$roll_no,
            $this->arr_values['table_name'] .".dob"=>$date_of_birth,
        ])
        ->get()->getFirstRow();
        if(!empty($row))
        {
            $id = $row->id;
            $db=$this->db;


            
            
            
            $result = $this->db->table("result")
            ->join('users', 'users.id = result.user_id', 'left')        
            ->select("
                result.*,
                users.name as name,
                users.email as email,
                users.phone as phone,
                users.image as image,
                users.user_id as user_idd,
                users.reg_no as reg_no,            
                "
            )
            ->where(["result.user_id"=>$id,])->get()->getResult();

            
            
            $certificate = $this->db->table("certificate")
            ->join('users', 'users.id = certificate.user_id', 'left')        
            ->select("
                certificate.*,
                users.name as name,
                users.email as email,
                users.phone as phone,
                users.image as image,
                users.user_id as user_idd,
                users.reg_no as reg_no,            
                "
            )
            ->where(["certificate.user_id"=>$id,])->get()->getResult();

            $results = [];
            $certificates = [];
            foreach ($result as $key => $value) {
                $ImageEditorModel = new ImageEditorModel();
                $results[] = $ImageEditorModel->createResult($value);
            }
            
            foreach ($certificate as $key => $value) {
                $ImageEditorModel = new ImageEditorModel();
                $certificates[] = $ImageEditorModel->createCertificate($value);
            }








            return view('web/result',compact('data','row','db','certificate','result','results','certificates'));
        }
        else
        {
            return view('web/404',compact('data'));            
        }
    }
    
   
}
