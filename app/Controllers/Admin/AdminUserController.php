<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;
use App\Models\ImageEditorModel;

class AdminUserController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'admin-user.', 
        'title'=>'Student', 
        'table_name'=>'users',
        'page_title'=>'Student',
        "folder_name"=>'backend/admin/user',
        "upload_path"=>'upload/',
        "page_name"=>'single-user.php',
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
        return view($this->arr_values['folder_name'].'/index',compact('data'));
    }
    public function load_data()
    { 
        $limit = $this->request->getVar('limit');
        $status = $this->request->getVar('status');
        $type = $this->request->getVar('type');
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;


        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   

        $data_list = $this->db->table($this->arr_values['table_name'])->where([$this->arr_values['table_name'].'.status' => $status,])        
        ->where($this->arr_values['table_name'].'.role =', $type)
        ->orderBy($this->arr_values['table_name'].'.id',$order_by)
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
    public function add()
    {
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Add ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));    
        $data['pagenation'] = array($this->arr_values['title']);
        $row = [];
        $db=$this->db;
        return view($this->arr_values['folder_name'].'/form',compact('data','row','db'));
    }
    public function edit($id=null)
    {   
        $id = decript($id);
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Edit ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));           
        $data['pagenation'] = array($this->arr_values['title']);

        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        if(!empty($row))
        {
            $db=$this->db;
            return view($this->arr_values['folder_name'].'/form',compact('data','row','db'));
        }
        else
        {
            return view('admin/404',compact('data'));            
        }
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

        $row = $this->db->table($this->arr_values['table_name'])
        ->where([$this->arr_values['table_name'] .".id"=>$id,])->get()->getFirstRow();
        if(!empty($row))
        {
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







            return view($this->arr_values['folder_name'].'/view',compact('data','row','db','certificate','result','results','certificates'));
        }
        else
        {
            return view('admin/404',compact('data'));            
        }
    }
    public function change_password($id=null)
    {   
        $id = decript($id);
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "View ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));           
        $data['pagenation'] = array($this->arr_values['title']);

        $row = $this->db->table($this->arr_values['table_name'])
        ->join('countries', 'countries.id = ' . $this->arr_values['table_name'] . '.country', 'left')
        ->join('states', 'states.id = ' . $this->arr_values['table_name'] . '.state', 'left')

        ->select("
                {$this->arr_values['table_name']}.*, 
                CASE
                    WHEN {$this->arr_values['table_name']}.role = 3 THEN 'Advocate'
                    WHEN {$this->arr_values['table_name']}.role = 4 THEN 'CA'
                    WHEN {$this->arr_values['table_name']}.role = 5 THEN 'Adviser'
                    ELSE 'other'
                END AS role_name,
                states.name as state_name,
                countries.name as country_name,
            ")

        ->where([$this->arr_values['table_name'] .".id"=>$id,])->get()->getFirstRow();
        if(!empty($row))
        {
            $db=$this->db;
            return view($this->arr_values['folder_name'].'/change-password',compact('data','row','db'));
        }
        else
        {
            return view('admin/404',compact('data'));            
        }
    }

    public function change_password_action()
    {
        $id = decript($this->request->getPost('id'));

        $session = session()->get('user');
        $add_by = $session['id'];

        $data = [
            "password"=>md5($this->request->getPost('password')),
        ];


        if($this->request->getPost('password')!=$this->request->getPost('cpassword'))
        {
            $action = 'add';
            if(empty($insertId)) $action = 'edit';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Confirm Password Not Match!';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);               
        }


        $entryStatus = false;
        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;
        


        if($entryStatus)
        {
            $action = 'add';
            if(empty($insertId)) $action = 'edit';
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

    public function update()
    {
        $id = decript($this->request->getPost('id'));

        $session = session()->get('user');
        $add_by = $session['id'];

        $data = [
            "name"=>$this->request->getPost('name'),
            "reg_no"=>$this->request->getPost('reg_no'),
            "phone"=>$this->request->getPost('phone'),
            "email"=>$this->request->getPost('email'),
            "gender"=>$this->request->getPost('gender'),
            "dob"=>$this->request->getPost('dob'),
            "address"=>$this->request->getPost('address'),
            "country"=>$this->request->getPost('country'),
            "state"=>$this->request->getPost('state'),
            "city"=>$this->request->getPost('city'),
            "pincode"=>$this->request->getPost('pincode'),
            "status"=>$this->request->getPost('status'),
            "is_delete"=>0,
            "role"=>2,
        ];


        $email = $this->request->getPost('email');
        $checkEmail = $this->db->table($this->arr_values['table_name'])->where('id !=', $id)->where(["email"=>$email,])->get()->getFirstRow();
        if(!empty($checkEmail))
        {
            $action = 'add';
            if(empty($insertId)) $action = 'edit';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Email id exist!';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);               
        }





        $entryStatus = false;
        if(empty($id))
        {
            $userId = 100;
            $getUser = $this->db->table($this->arr_values['table_name'])->orderBy('id', 'desc')->get()->getFirstRow();
            if(!empty($getUser)) $userId = $getUser->user_id+1;
            $data['user_id'] = $userId;
            
            
            $data['add_by'] = $add_by;
            $data['add_date_time'] = date("Y-m-d H:i:s");
            $data['update_date_time'] = date("Y-m-d H:i:s");
            if($this->db->table($this->arr_values['table_name'])->insert($data)) $entryStatus = true;
            else $entryStatus = false;
            $id = $insertId = $this->db->insertID();
            
            
            
        }
        else
        {
            $data['update_date_time'] = date("Y-m-d H:i:s");
            if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
            else $entryStatus = false;
        }


        if($entryStatus)
        {

            $ImageModel = new ImageModel();
            $image = $ImageModel->upload_image('image', $this->request);
            if(!empty($image)) $update_data['image'] = $image;


            
            if(!empty($update_data))
            {
                $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->update($update_data);
            } 
            

            $action = 'add';
            if(empty($insertId)) $action = 'edit';
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
    public function block_unblock($id)
    {
        $id = decript($id);
        $status = $this->request->getPost('status');

        $user = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();

        $status = 1;
        if($user->status==1) $status = 0;
        else $status = 1;

        $data = [
            "status"=>$status,
        ];
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data))
        {
            $action = 'view';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Successfuly';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $action = 'view';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
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

}