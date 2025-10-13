<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminProductController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'product.', 
        'title'=>'Product', 
        'table_name'=>'product',
        'page_title'=>'Product',
        "folder_name"=>'backend/admin/product',
        "upload_path"=>'upload/',
        "page_name"=>'single-product.php',
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
            ->where([$this->arr_values['table_name'] . '.status' => $status])
            ->orderBy($this->arr_values['table_name'] . '.id', $order_by)

            ->join('client_logo', 'client_logo.id = ' . $this->arr_values['table_name'] . '.brand', 'left')

            ->select("{$this->arr_values['table_name']}.*,
                CASE 
                  WHEN category = 1 THEN 'Bikes' 
                  WHEN category = 2 THEN 'Scooters' 
                  ELSE 'other' 
              END AS category_name,
              client_logo.name as brand_name
            ")

            ->limit($limit, $offset);

        if (!empty($filter_search_value)) {
            $escaped = $this->db->escape("%{$filter_search_value}%");

            $data_list->where("JSON_SEARCH(engine, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(features, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(features_safety, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(mileage_performance, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(chassis_suspension, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(dimensions_capacity, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(electricals, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(tyres_brakes, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(performance, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(motor_battery, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(underpinnings, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(included, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orWhere("JSON_SEARCH(app_features, 'all', {$escaped}, NULL, '$[*].title') IS NOT NULL");
            $data_list->orLike($this->arr_values['table_name'].'.name', $filter_search_value);
        }

        $data_list = $data_list->get()->getResult();
          


        $total = $this->db->table($this->arr_values['table_name'])->countAllResults();
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

        $data = [
            "name"=>$this->request->getPost('name'),
            "category"=>$this->request->getPost('category'),
            "brand"=>$this->request->getPost('brand'),
            "fuel_type"=>$this->request->getPost('fuel_type'),
            "body_type"=>$this->request->getPost('body_type'),
            "speed"=>$this->request->getPost('speed'),
            "vehicle_type"=>$this->request->getPost('vehicle_type'),
            "tworange"=>$this->request->getPost('tworange'),
            "biketime"=>$this->request->getPost('biketime'),
            "feature"=>json_encode($this->request->getPost('feature')),
            "color"=>json_encode($this->request->getPost('color')),
            "price"=>$this->request->getPost('price'),
            "booking_price"=>$this->request->getPost('booking_price'),
            "model_year"=>$this->request->getPost('model_year'),



            "front_break"=>$this->request->getPost('front_break'),
            "back_break"=>$this->request->getPost('back_break'),
            "max_power"=>$this->request->getPost('max_power'),
            "max_torque"=>$this->request->getPost('max_torque'),
            "fuel_capacity"=>$this->request->getPost('fuel_capacity'),
            "engine_type"=>$this->request->getPost('engine_type'),
            "clock"=>$this->request->getPost('clock'),
            "led_tail_light"=>$this->request->getPost('led_tail_light'),
            "speedometer"=>$this->request->getPost('speedometer'),
            "odometer"=>$this->request->getPost('odometer'),
            "tripmeter"=>$this->request->getPost('tripmeter'),




            "mileage"=>$this->request->getPost('mileage'),
            "displacement"=>$this->request->getPost('displacement'),
            "ranges"=>$this->request->getPost('ranges'),
            "charging_time"=>$this->request->getPost('charging_time'),
            "kilometres"=>$this->request->getPost('kilometres'),
            "per_hour"=>$this->request->getPost('per_hour'),
            
            "battery_capacity"=>$this->request->getPost('battery_capacity'),
            "kerb_weight"=>$this->request->getPost('kerb_weight'),
            "acceleration"=>$this->request->getPost('acceleration'),
            "battery_warranty"=>$this->request->getPost('battery_warranty'),
            "tyre_type"=>$this->request->getPost('tyre_type'),



            "is_new_variant"=>$this->request->getPost('is_new_variant'),
            "is_upcoming"=>$this->request->getPost('is_upcoming'),
            

            "slug"=>$this->request->getPost('slug'),
            "sort_description"=>$this->request->getPost('sort_description'),
            "status"=>$this->request->getPost('status'),
            "is_delete"=>0,
        ];


        $multicolumns = ['engine','features','features_safety','mileage_performance','chassis_suspension','dimensions_capacity','electricals','tyres_brakes','performance','motor_battery','underpinnings','included','app_features'];
        foreach ($multicolumns as $key => $value) {

            $multititle = $this->request->getPost('title'.$value);
            $multivalue = $this->request->getPost('value'.$value);
            $dataColumn = [];
            foreach ($multititle as $key2 => $value2) {
                $stitle = $multititle[$key2];
                $svalue = $multivalue[$key2];
                if(!empty($stitle))
                {
                    $dataColumn[] = ["title"=>$stitle,"value"=>$svalue,];
                }
            }
            $data[$value] = json_encode($dataColumn);            
        }



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


           $brochure = $ImageModel->upload_image('brochure', $this->request,['pdf','xlx','xlxs','csv']);
           if(!empty($brochure)) $update_data['brochure'] = $brochure;

            $all_image_column_names = ['images'];
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