<?php

namespace App\Controllers\Partner;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;


class PartnerDashboardController extends BaseController
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
        return view('partner/dashboard/index',compact('leads_count','data','db'));
    }
}