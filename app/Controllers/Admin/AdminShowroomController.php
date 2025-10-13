<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminShowroomController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'showroom.', 
        'title'=>'Showroom', 
        'table_name'=>'users',
        'page_title'=>'Showroom',
        "folder_name"=>'backend/admin/showroom',
        "upload_path"=>'upload/',
        "page_name"=>'howroom-single.php',
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
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;


        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   

        
        $query = $this->db->table($this->arr_values['table_name'])
            ->join('city', 'city.id = ' . $this->arr_values['table_name'] . '.city', 'left')
            ->join('client_logo', 'client_logo.id = ' . $this->arr_values['table_name'] . '.brand', 'left')
            ->select("{$this->arr_values['table_name']}.*, city.name as city_name")
            ->where([
                $this->arr_values['table_name'] . '.status' => $status,
                $this->arr_values['table_name'] . '.role'   => 3
            ])
            ->orderBy($this->arr_values['table_name'] . '.id', $order_by);

        
        $total = $query->countAllResults(false);

        
        $data_list = $query->limit($limit, $offset)->get()->getResult();

        foreach ($data_list as $key => $row) {
            $brand_ids = json_decode($row->brand, true);
            if (is_array($brand_ids) && !empty($brand_ids)) {
                $brands = $this->db->table('client_logo')->select('name')->whereIn('id', $brand_ids)->get()->getResult();
                $data_list[$key]->brand_names = implode(', ', array_column($brands, 'name'));
            } else {
                $data_list[$key]->brand_names = '';
            }
        }


        $data['pager'] = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = ($total > 0) ? $offset + 1 : 0;
        $data['endData'] = ($offset + $limit > $total) ? $total : ($offset + $limit);
        $data['data_list'] = $data_list;



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

    public function update()
    {
        $id = decript($this->request->getPost('id'));

        $session = session()->get('user');
        $add_by = $session['id'];

        $data = [
            "company_name"=>$this->request->getPost('company_name'),
            "name"=>$this->request->getPost('name'),
            "phone"=>$this->request->getPost('phone'),
            "email"=>$this->request->getPost('email'),

            "area"=>$this->request->getPost('area'),
            "city"=>$this->request->getPost('city'),
            "brand"=>json_encode($this->request->getPost('brand')),
            "sales_contact"=>$this->request->getPost('sales_contact'),
            "authorized_person"=>$this->request->getPost('authorized_person'),
            "person_contact"=>$this->request->getPost('person_contact'),
            "gst"=>$this->request->getPost('gst'),
            "pan"=>$this->request->getPost('pan'),
            "udyam"=>$this->request->getPost('udyam'),
            "workshop_address"=>$this->request->getPost('workshop_address'),
            "service_contact"=>$this->request->getPost('service_contact'),
            "spares_accessories_contact"=>$this->request->getPost('spares_accessories_contact'),


            "status"=>$this->request->getPost('status'),
            "role"=>3,
            "is_delete"=>0,
        ];


        $password = $this->request->getPost('password');
        if(!empty($password)) $data['password'] = md5($password);


        $entryStatus = false;
        if(empty($id))
        {

            $user_id = 0;
            $lastUser = $this->db->table($this->arr_values['table_name'])->orderBy('user_id','desc')->get()->getFirstRow();
            if(!empty($lastUser)) $user_id = $lastUser->user_id+1;

            $data['user_id'] = $user_id;

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

            $name = $data['name'];
            if(empty($this->request->getPost('slug'))) $slug = slug($name);
            else $slug = slug($this->request->getPost('slug'));
            $p_id = $id;
            $table_name = $this->arr_values['table_name'];
            $new_slug = insert_slug($slug,$p_id,$table_name,$this->arr_values['page_name']);

            // insert_meta_tag($new_slug,$name);

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

        if($status==1) $status = 0;
        else $status = 1;

        $data = [
            "status"=>$status,
        ];
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data))
        {
            $action = 'statusChange';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Successfuly';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $action = 'statusChange';
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