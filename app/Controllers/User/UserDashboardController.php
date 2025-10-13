<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;


class UserDashboardController extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pager = \Config\Services::pager();
    }
    public function index()
    {

        $data = [];
        $leads_count = [];
        $db = $this->db;
        return view('user/dashboard/index',compact('leads_count','data','db'));
    }
}