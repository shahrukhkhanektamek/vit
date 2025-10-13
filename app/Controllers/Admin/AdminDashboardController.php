<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;


class AdminDashboardController extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $data = [];
        $leads_count = [];
        $db = $this->db;
        return view('backend/admin/dashboard/index',compact('leads_count','data','db'));
    }
}