<?php

namespace App\Controllers;
use CodeIgniter\Database\Database;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\MemberModel;

class Test extends BaseController
{

    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        // $id = 11;
        // $user_id = 3;
        // $amount = 10;
        // $memberModel = new MemberModel();

        // $orders = $this->db->table('transaction')->where("id",$id)
        // ->get()->getRow();
        // $memberModel->appointmentIncome($user_id, $amount, $orders);



        // die;
        // $table_name = 'service';
        // $page_name = 'single-service.php';
        // $expertise = $this->db->table("expertise")->getWhere(["status"=>1,])->getResultObject();
        // // die;
        // foreach ($expertise as $key => $value)
        // {
        //     $data = [
        //         "name"=>$value->name,
        //         "service_type"=>3,
        //         "category"=>18,
        //         "slug"=>'',
        //         "sort_description"=>'',
        //         "full_description"=>'',
        //         "document_area"=>'',
        //         "extra"=>'',
        //         "status"=>1,
        //         "is_delete"=>0,
        //     ];
        //     $data['add_by'] = 1;
        //     $data['add_date_time'] = date("Y-m-d H:i:s");
        //     $data['update_date_time'] = date("Y-m-d H:i:s");
        //     if($this->db->table($table_name)->insert($data)) $entryStatus = true;
        //     else $entryStatus = false;
        //     $id = $insertId = $this->db->insertID();

        //     $name = $data['name'];
        //     if(empty($this->request->getPost('slug'))) $slug = slug($name);
        //     else $slug = slug($this->request->getPost('slug'));
        //     $p_id = $id;
        //     $table_name = $table_name;
        //     $new_slug = insert_slug($slug,$p_id,$table_name,$page_name);

        //     insert_meta_tag($new_slug,$name);


        // }


        

        die;
        $table_name = 'certification';
        $page_name = 'partners.php';
        $main_menus = $this->db->table($table_name)->getWhere(["status"=>1,])->getResultObject();
        foreach ($main_menus as $key => $value)
        {
            $name = $value->name;
            $slug = $value->slug;
            $id = $value->id;
            if(empty($slug)) $slug = slug($name);
            else $slug = slug($slug);
            $p_id = $id;
            $table_name = $table_name;
            $new_slug = insert_slug($slug,$p_id,$table_name,$page_name);
            insert_meta_tag($new_slug,$name);
        }

    }
    
}
