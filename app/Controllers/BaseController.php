<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $mainData;
    protected $db;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');



        $this->db = \Config\Database::connect();
        $this->pager = \Config\Services::pager();

        $page = $this->request->getUri()->getSegment(1);

        $uri2 = '';
        $segment2 = $this->request->getUri()->getSegments();
        if(!empty($segment2))
            if(!empty($segment2[1]))
                $uri2 = $segment2[1];
        $data = [];
        $table_name = '';
        $p_id = '';
        $meta_image = '';

        // Get the full base URL
        $request = service('request');
        $base = base_url();
        $slug = $url = $request->getUri()->getSegment(1); // Get the path from URL
        $stateCity = '';
        if(!empty($url))
        {
            $checkStateCity = explode('-in-',$url);
            if(count($checkStateCity)>1)
            {
                $stateCity = decodeSlug($checkStateCity[1]);
                $emptyCehck1 = $this->db->table('states')->where("name", $stateCity)->get()->getRow();
                $emptyCehck2 = $this->db->table('city')->where("name", $stateCity)->get()->getRow();
                if(!empty($emptyCehck1) || !empty($emptyCehck2))
                {
                    $url = $checkStateCity[0];
                }
            }
        }

        
        if(empty($page))
        {
            $url = 'home';
            $page = 'index.php';
        }

        // Check if the slug exists in the database
        $slug_data = $this->db->table("slugs")
            ->where("slug", $url)
            ->get()
            ->getResultObject();

        if (!empty($slug_data)) {
            $slug_data = $slug_data[0];
            $page = $slug_data->page_name;
            $table_name = $slug_data->table_name;
            $p_id = $slug_data->p_id;
        } else {
            $count = explode(".", $page);
            if (count($count) == 1) {
                $page = $count[0] . '.php';
            } else {
                $page = $count[0] . '.' . $count[1];
            }
        }

        $role = 0;  
        $user_id = 0;   
        $user = get_user();
        if(!empty($user))
        {
            $role = $user->role;
            $user_id = $user->id;
            $user_role = get_role_by_id($user->role);
        }
        $data['user'] = $user;
        $data['role'] = $role;
        $data['user_id'] = $user_id;
        $data['uri2'] = $uri2;


        if($page=='advocates.php' || $page=='ca.php' || $page=='advisers.php')
        {
            $page = 'partners.php';
        }

        if($page=='advocate.php' || $page=='ca.php' || $page=='adviser.php')
        {
            $page = 'partner-profile.php';
        }

        // Check if the page file exists
        $data['check_page'] = $check_page = ROOTPATH . 'app/Views/web/' . $page;
        $data['page'] = $page;
        $data['table_name'] = $table_name;
        $data['p_id'] = $p_id;


        $data['contact_detail'] = json_decode($this->db->table('setting')->getWhere(["name"=>'main',])->getRow()->data);
        $data['policy'] = json_decode($this->db->table('setting')->getWhere(["name"=>'policy',])->getRow()->data);
        $data['logo'] = json_decode($this->db->table('setting')->getWhere(["name"=>'logo',])->getRow()->data);
        $data['db'] = $this->db;
        $data['request'] = $this->request;
        $data['pager'] = $this->pager;
        $data['slug'] = $slug;
        $data['id'] = 0;
        $data['stateCity'] = $stateCity ? ' In '.$stateCity : $stateCity;
        $data['script'] = $this->db->table('script')->get()->getRow();


        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session()->set('captcha_answer', $num1 + $num2);
        $data['captcha_num1'] = $num1;
        $data['captcha_num2'] = $num2;



        
        $meta_select = "page_name, meta_title, meta_keywords, meta_description, meta_author";
        $meta_data = $this->db->table("meta_tags")->select($meta_select)->where("slug", $url)->get()->getResultObject();
        $meta_title = '';
        $meta_keyword = '';
        $meta_description = '';
        $meta_auther = '';
        if (!empty($meta_data)) {
            $meta_data = $meta_data[0];
            $meta_title = $meta_data->meta_title;
            $meta_keyword = $meta_data->meta_keywords;
            $meta_description = $meta_data->meta_description;
            $meta_auther = $meta_data->meta_author;
        } else {
            $meta_data = $this->db->table("meta_tags")->select($meta_select)->where(["slug" => 'home', "is_delete" => 0, "status" => 1])->limit(1)->get()->getResultObject();
            if (!empty($meta_data)) {
                $meta_data = $meta_data[0];
                $meta_title = $meta_data->meta_title;
                $meta_keyword = $meta_data->meta_keywords;
                $meta_description = $meta_data->meta_description;
                $meta_auther = $meta_data->meta_author;
            }
        }
        $data['meta_data'] = $meta_data;

        $this->mainData = $data;



    }
}
