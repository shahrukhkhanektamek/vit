<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminServiceController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'service.', 
        'title'=>'Service', 
        'table_name'=>'service',
        'page_title'=>'Service',
        "folder_name"=>'backend/admin/service',
        "upload_path"=>'upload/',
        "page_name"=>'single-service.php',
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
        
        ->select("service_category.name as category_name, 
                CASE 
                  WHEN service_type = 1 THEN 'CA' 
                  WHEN service_type = 2 THEN 'Advocate' 
                  WHEN service_type = 3 THEN 'Adviser' 
                  ELSE 'other' 
              END AS service_type_name,
            {$this->arr_values['table_name']}.*")
        ->join('service_category', 'service_category.id = ' . $this->arr_values['table_name'] . '.category', 'left')

        ->where([$this->arr_values['table_name'] . '.status' => $status]);
        

        if(!empty($filter_search_value))
        {
            $data_list->groupStart()
                ->like($this->arr_values['table_name'] . '.name', $filter_search_value)
            ->groupEnd();
        }
        
        $data_list = $data_list->orderBy($this->arr_values['table_name'] . '.id', $order_by)->limit($limit, $offset)->get()->getResult();


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

        $faqqsn = $this->request->getPost('faqqsn');
        $faqans = $this->request->getPost('faqans');
        $qsn = [];
        foreach ($faqqsn as $key => $value) {
            $qsn[] = [
                "qsn"=>$faqqsn[$key],
                "ans"=>$faqans[$key],
            ];
        }

        $data = [
            "name"=>$this->request->getPost('name'),
            "service_type"=>$this->request->getPost('service_type'),
            "category"=>$this->request->getPost('category'),
            "slug"=>$this->request->getPost('slug'),
            "sort_description"=>$this->request->getPost('sort_description'),
            "sort_description_detail_page"=>$this->request->getPost('sort_description_detail_page'),
            "full_description"=>$this->request->getPost('full_description'),


            // "basic_status"=>$this->request->getPost('basic_status'),
            // "basic_price"=>$this->request->getPost('basic_price'),
            // "basic_market_price"=>$this->request->getPost('basic_market_price'),
            // "basic_smartfiling_price"=>$this->request->getPost('basic_smartfiling_price'),
            // "basic_you_save"=>$this->request->getPost('basic_you_save'),
            // "basic_government_fee"=>$this->request->getPost('basic_government_fee'),
            // "basic_description"=>$this->request->getPost('basic_description'),
            // "basic_price_description"=>$this->request->getPost('basic_price_description'),
            // "standard_status"=>$this->request->getPost('standard_status'),
            // "standard_price"=>$this->request->getPost('standard_price'),
            // "standard_market_price"=>$this->request->getPost('standard_market_price'),
            // "standard_smartfiling_price"=>$this->request->getPost('standard_smartfiling_price'),
            // "standard_you_save"=>$this->request->getPost('standard_you_save'),
            // "standard_government_fee"=>$this->request->getPost('standard_government_fee'),
            // "standard_description"=>$this->request->getPost('standard_description'),
            // "standard_price_description"=>$this->request->getPost('standard_price_description'),
            // "pro_status"=>$this->request->getPost('pro_status'),
            // "pro_price"=>$this->request->getPost('pro_price'),
            // "pro_market_price"=>$this->request->getPost('pro_market_price'),
            // "pro_smartfiling_price"=>$this->request->getPost('pro_smartfiling_price'),
            // "pro_you_save"=>$this->request->getPost('pro_you_save'),
            // "pro_government_fee"=>$this->request->getPost('pro_government_fee'),
            // "pro_description"=>$this->request->getPost('pro_description'),
            // "pro_price_description"=>$this->request->getPost('pro_price_description'),

            "document_area"=>json_encode($this->request->getPost('document_area')),
            "document_area_description"=>$this->request->getPost('document_area_description'),
            "overview_description"=>$this->request->getPost('overview_description'),
            "faq_description"=>$this->request->getPost('faq_description'),
            "faq"=>json_encode($qsn),
            "extra"=>$this->request->getPost('extra'),
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

            insert_meta_tag($new_slug,$name);


            $ImageModel = new ImageModel();


           $image = $ImageModel->upload_image('image', $this->request);
           if(!empty($image)) $update_data['image'] = $image;

           $document_area_image = $ImageModel->upload_image('document_area_image', $this->request);
           if(!empty($document_area_image)) $update_data['document_area_image'] = $document_area_image;

           $faq_image = $ImageModel->upload_image('faq_image', $this->request);
           if(!empty($faq_image)) $update_data['faq_image'] = $faq_image;


            $all_image_column_names = ['image2','overview_images'];
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