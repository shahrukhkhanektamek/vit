<?php

namespace App\Controllers;
use CodeIgniter\Database\Database;
use CodeIgniter\HTTP\RequestInterface;

class Home extends BaseController
{

    protected $db;
    protected $pager;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pager = \Config\Services::pager();
    }
    public function index()
    {
        return view('web/index');
    }
    public function all($page = null)
    {        
        $data = $this->mainData;
        $check_page = $data['check_page'];
        $page = $data['page'];
        $table_name = $data['table_name'];
        $p_id = $data['p_id'];
        
        

        if (file_exists($check_page)) {

            if (!empty($table_name)) {
                $data['row_data'] = $this->db->table($table_name)
                    ->where("id", $p_id)
                    ->get()
                    ->getRow();
                if(!empty($data['row_data']))
                {
                    $data['id'] = $data['row_data']->id;
                }
                $data['row'] = $data['row_data'];
            }
            return view('web/' . $page, $data);

        } else {
            return view('web/404', $data);
        }
    }
    public function bike_modal()
    {
        $return_data = [];
        $id = decript($this->request->getPost('id'));
        $type = (int) $this->request->getPost('type');

        $session = session()->get('user');
        $user_id = @$session['id'];
        $role = @$session['role'];

        $data['is_logedin'] = 0;
        $data['type'] = $type;

        if($role==2)
        {
            $data['user'] = get_user();
            $data['is_logedin'] = 1;
        }

        $table_name = 'product';
        $row = $this->db->table("product")
        ->join('product_top_speed', 'product_top_speed.id = '.$table_name.'.speed', 'left')
        ->select("{$table_name}.*, product_top_speed.name as speed_name")
        ->where([$table_name.".id"=>$id,])->get()->getFirstRow();        
        $row->price = price_formate($row->price);
        $row->image = image_check($row->images);

        if($type==1 || $type==2)
        {
            if($data['is_logedin']==1)
            {
                $colors = [];
                if(json_decode($row->color))
                {
                    $colorId = json_decode($row->color);
                    $colors = $this->db->table("color")->whereIn("id", $colorId)->get()->getResultObject();
                }

                $responseCode = 200;
                $result['status'] = $responseCode;
                $result['message'] = 'Fetch Successfuly';
                $result['action'] = 'search';
                $result['data'] = ["row"=>$row,"data"=>$data,"colors"=>$colors,];
                return $this->response->setStatusCode(200)->setJSON($result);                
            }
            else
            {
                $responseCode = 400;
                $result['status'] = $responseCode;
                $result['message'] = 'Login First!';
                $result['action'] = 'search';
                $result['data'] = ["row"=>$row,"data"=>$data,];
                return $this->response->setStatusCode(200)->setJSON($result);                
            }
        }
        else
        {
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Fetch Successfuly';
            $result['action'] = 'search';
            $result['data'] = ["row"=>$row,"data"=>$data,];
            return $this->response->setStatusCode(200)->setJSON($result); 
        }
    }

    public function search_vendor($value='')
    {        
        $search = $this->request->getVar('search');
        $table_name = 'users';
        // $package_table = 'vendor_package';
        // $builder = $this->db->table($table_name)

        //     ->select("{$table_name}.*, city.name as city_name")
        //     ->join('city', 'city.id = '.$table_name.'.city', 'left')
        //     ->join($package_table, "{$package_table}.vendor_id = {$table_name}.id", 'left')
        //     ->where("{$table_name}.status", 1)
        //     ->where("{$table_name}.role", 3)
        //     ->where("{$package_table}.is_delete", 0)
        //     ->where("{$package_table}.plan_end_date_time >=", date('Y-m-d H:i:s'));
        // if (!empty($search)) {
        //     $builder->groupStart()
        //         ->like("{$table_name}.name", $search)
        //         ->groupEnd();
        // }
        // $builder->groupBy("{$table_name}.id");
        // $data_list = $builder
        //     ->orderBy("{$table_name}.id", 'desc')
        //     ->limit(50, 0)
        //     ->get()
        //     ->getResult();


        $table_name = 'users';
        $builder = $this->db->table($table_name)
            ->join('city', 'city.id = '.$table_name.'.city', 'left')
            ->join('states', 'states.id = '.$table_name.'.state', 'left')

            ->select("{$table_name}.*, city.name as city_name, states.name as state_name,
                CASE 
                    WHEN {$table_name}.role = 3 THEN 'Advocate' 
                    WHEN {$table_name}.role = 4 THEN 'CA' 
                    WHEN {$table_name}.role = 5 THEN 'Adviser' 
                    ELSE 'other' 
                END AS role_name,
                ")
            ->where("{$table_name}.status", 1)
            ->where("{$table_name}.is_delete", 0);
        if (!empty($search)) {
            $builder->groupStart()
                ->like("{$table_name}.name", $search)
                ->groupEnd();
        }

        $data_list = $builder
            ->orderBy("{$table_name}.id", 'desc')
            ->limit(50, 0)
            ->get()
            ->getResult();

        $return_data[] = ["id"=>"","text"=>"All Partner",];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name.' '.$value->phone.', '.$value->email.', '.$value->state_name.' ('.$value->role_name.')',
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }


    public function search_partner($value='')
    {        
        $search = $this->request->getVar('search');       

        $table_name = 'users';
        $builder = $this->db->table($table_name)
            ->join('city', 'city.id = '.$table_name.'.city', 'left')
            ->join('states', 'states.id = '.$table_name.'.state', 'left')

            ->select("{$table_name}.*, city.name as city_name, states.name as state_name,
                CASE 
                    WHEN {$table_name}.role = 3 THEN 'Advocate' 
                    WHEN {$table_name}.role = 4 THEN 'CA' 
                    WHEN {$table_name}.role = 5 THEN 'Adviser' 
                    ELSE 'other' 
                END AS role_name,
                ")
            ->where("{$table_name}.status", 1)
            ->whereIn("{$table_name}.role", [3,4,5])
            ->where("{$table_name}.is_delete", 0);
        if (!empty($search)) {
            $builder->groupStart()
                ->like("{$table_name}.name", $search)
                ->groupEnd();
        }
        $data_list = $builder
            ->orderBy("{$table_name}.id", 'desc')
            ->limit(50, 0)
            ->get()
            ->getResult();
        $return_data[] = ["id"=>"","text"=>"All Partner",];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name.' '.$value->phone.', '.$value->email.', '.$value->state_name.' ('.$value->role_name.')',
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }
    public function search_user($value='')
    {        
        $search = $this->request->getVar('search');       

        $table_name = 'users';
        $builder = $this->db->table($table_name)
            ->join('city', 'city.id = '.$table_name.'.city', 'left')
            ->join('states', 'states.id = '.$table_name.'.state', 'left')

            ->select("{$table_name}.*, city.name as city_name, states.name as state_name,
                CASE 
                    WHEN {$table_name}.role = 3 THEN 'Advocate' 
                    WHEN {$table_name}.role = 4 THEN 'CA' 
                    WHEN {$table_name}.role = 5 THEN 'Adviser' 
                    WHEN {$table_name}.role = 2 THEN 'User' 
                    ELSE 'other' 
                END AS role_name,
                ")
            ->where("{$table_name}.status", 1)
            ->whereIn("{$table_name}.role", [2])
            ->where("{$table_name}.is_delete", 0);
           if (!empty($search)) {
                $builder->like("CONCAT({$table_name}.name, ' ', {$table_name}.email, ' ', {$table_name}.phone, ' ', {$table_name}.user_id)", $search);
            }
        $data_list = $builder
            ->orderBy("{$table_name}.id", 'desc')
            ->limit(50, 0)
            ->get()
            ->getResult();
        $return_data[] = ["id"=>"","text"=>"All User",];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name.' '.$value->phone.', '.$value->email.', '.$value->state_name.' ('.$value->role_name.')',
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }
    public function search_employee($value='')
    {        
        $search = $this->request->getVar('search');       

        $table_name = 'users';
        $builder = $this->db->table($table_name)
            ->join('city', 'city.id = '.$table_name.'.city', 'left')
            ->join('states', 'states.id = '.$table_name.'.state', 'left')

            ->select("{$table_name}.*, city.name as city_name, states.name as state_name,
                CASE 
                    WHEN {$table_name}.role = 3 THEN 'Advocate' 
                    WHEN {$table_name}.role = 4 THEN 'CA' 
                    WHEN {$table_name}.role = 5 THEN 'Adviser' 
                    ELSE 'other' 
                END AS role_name,
                ")
            ->where("{$table_name}.status", 1)
            ->whereIn("{$table_name}.role", [6])
            ->where("{$table_name}.is_delete", 0);
        if (!empty($search)) {
            $builder->groupStart()
                ->like("{$table_name}.name", $search)
                ->groupEnd();
        }
        $data_list = $builder
            ->orderBy("{$table_name}.id", 'desc')
            ->limit(50, 0)
            ->get()
            ->getResult();
        $return_data[] = ["id"=>"","text"=>"All Employee",];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name.' '.$value->phone.', '.$value->email.', '.$value->state_name.' ('.$value->role_name.')',
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }


    public function search_country($value='')
    {        
        $search = $this->request->getVar('search');
        $table_name = 'countries';
        $builder = $this->db->table($table_name)->where("{$table_name}.status", 1);
        if (!empty($search)) {
            $builder->groupStart()->like("{$table_name}.name", $search)->groupEnd();
        }
        $data_list = $builder->orderBy("{$table_name}.id", 'desc')->limit(50, 0)->get()->getResult();
        $return_data = [];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name,
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }
    public function search_state($value='')
    {        
        $search = $this->request->getVar('search');
        $id = $this->request->getVar('id');
        $table_name = 'states';
        $builder = $this->db->table($table_name)->where("{$table_name}.status", 1)->where("{$table_name}.country_id",$id);
        if (!empty($search)) {
            $builder->groupStart()->like("{$table_name}.name", $search)->groupEnd();
        }
        $data_list = $builder->orderBy("{$table_name}.id", 'desc')->limit(50, 0)->get()->getResult();
        $return_data = [];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name,
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }
    public function search_city($value='')
    {        
        $search = $this->request->getVar('search');
        $table_name = 'city';
        $builder = $this->db->table($table_name)->where("{$table_name}.status", 1);
        if (!empty($search)) {
            $builder->groupStart()->like("{$table_name}.name", $search)->groupEnd();
        }
        $data_list = $builder->orderBy("{$table_name}.id", 'desc')->limit(50, 0)->get()->getResult();
        $return_data = [];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name,
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }
    public function search_education($value='')
    {        
        $search = $this->request->getVar('search');
        $table_name = 'education';
        $builder = $this->db->table($table_name)->where("{$table_name}.status", 1);
        if (!empty($search)) {
            $builder->groupStart()->like("{$table_name}.name", $search)->groupEnd();
        }
        $data_list = $builder->orderBy("{$table_name}.id", 'desc')->limit(50, 0)->get()->getResult();
        $return_data = [];
        foreach ($data_list as $key => $value) {
            $return_data[] = [
                "id" => $value->id,
                "text" => $value->name,
            ];
        }
        $data['results'] = $return_data;
        return $this->response->setStatusCode(200)->setJSON($data);       
    }
}
