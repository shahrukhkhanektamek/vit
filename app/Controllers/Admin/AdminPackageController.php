<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminPackageController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'package.', 
        'title'=>'Package', 
        'table_name'=>'package',
        'page_title'=>'Package',
        "folder_name"=>'backend/admin/package',
        "upload_path"=>'upload/',
        "page_name"=>'package-single.php',
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

        $data_list = $this->db->table($this->arr_values['table_name'])
        
        // ->select("main_menu.name as menu_name, {$this->arr_values['table_name']}.*")
        // ->join('main_menu', 'main_menu.id = ' . $this->arr_values['table_name'] . '.menu', 'left')

        ->where([$this->arr_values['table_name'] . '.status' => $status])
        ->orderBy($this->arr_values['table_name'] . '.id', $order_by)
        
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

    public function update()
    {
        $id = decript($this->request->getPost('id'));

        $session = session()->get('user');
        $add_by = $session['id'];

        $price = $this->request->getPost('price');
        $discount = $this->request->getPost('discount');

        $discountAmt = $price*$discount/100;

        $final_price = $price-$discountAmt;


        $data = [
            "name"=>$this->request->getPost('name'),
            "sub_name"=>$this->request->getPost('sub_name'),
            "validation"=>$this->request->getPost('validation'),
            "price"=>$this->request->getPost('price'),
            "discount"=>$this->request->getPost('discount'),
            "final_price"=>$final_price,
            "full_description"=>$this->request->getPost('full_description'),            
            "status"=>$this->request->getPost('status'),
            "is_delete"=>0,
        ];

        $entryStatus = false;
        if(empty($id))
        {
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


            $ImageModel = new ImageModel();


           $image = $ImageModel->upload_image('image', $this->request);
           if(!empty($image)) $update_data['image'] = $image;


            $all_image_column_names = ['image2'];
            $return_image_array = $ImageModel->upload_multiple_image($all_image_column_names,$this->arr_values['table_name'],$id,$this->request);
            if(!empty($return_image_array))
            {
                foreach ($return_image_array as $key => $value)
                {
                    if(!empty($value)) $update_data[$key] = $value;
                }
            }
            else
            {
                foreach ($all_image_column_names as $key => $value)
                {
                    $update_data[$value] = json_encode([]);
                }
            }

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