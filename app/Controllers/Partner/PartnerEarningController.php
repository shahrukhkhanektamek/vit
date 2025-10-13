<?php

namespace App\Controllers\Partner;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;


class PartnerEarningController extends BaseController
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

        $session = session()->get('user');
        $user_id = $session['id'];

        // total earning
        $totalEarning = $db->table('report')
            ->where('partner_id', $user_id)
            ->selectSum('amount')
            ->get()
            ->getRow()
            ->amount;

        $data['totalEarning'] = $totalEarning ?? 0;

        // total TDS
        $totalTds = $db->table('report')
            ->where('partner_id', $user_id)
            ->select('SUM(amount * tds / 100) as total_tds')
            ->get()
            ->getRow()
            ->total_tds;

        $data['totalTds'] = $totalTds ?? 0;

       

        // unpaid
        $unPaid = $db->table('report')
            ->where('partner_id', $user_id)
            ->where('payment', 0)
            ->select('SUM(amount - (amount * tds / 100)) as final_amount')
            ->get()
            ->getRow()
            ->final_amount;

        $data['unPaid'] = $unPaid ?? 0;

        // paid
        $paid = $db->table('report')
            ->where('partner_id', $user_id)
            ->where('payment', 1)
            ->select('SUM(amount - (amount * tds / 100)) as final_amount')
            ->get()
            ->getRow()
            ->final_amount;

        $data['paid'] = $paid ?? 0;

        // final earning
        $data['finalEarning'] = $totalEarning - ($totalTds);

        return view('partner/earning/index',compact('leads_count','data','db'));
    }



    public function load_data()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $limit = $this->request->getVar('limit');
        $status = $this->request->getVar('status');
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;

        

        


        $db=$this->db;


        $payment = '';
        if ($status == 1) $payment = 1;
        if ($status == 2) $payment = 0;

        $builder = $db->table('report');
        
        $builder->select([
            'report.partner_id',
            'report.only_date',
            'report.payment',
            'users.name',            
            'users.phone',
            'amount as amount',
            '(amount * tds / 100) as tds_amount',
            '(amount - (amount * tds / 100) ) as final_amount',
            
        ]);
        $builder->join('users as users', 'users.id = report.partner_id', 'left');
        $builder->where('report.status', 1);
        $builder->whereIn('report.type', [1, 2, 3, 4, 5, 6]);

        // payment filter
        if (!empty($status)) {
            $builder->where('report.payment', $payment);
        }

        // date filter
        
        if (!empty($this->request->getVar('from_date')) && !empty($this->request->getVar('to_date'))) {
            $from_date = $this->request->getVar('from_date') . " 00:00:00";
            $to_date   = $this->request->getVar('to_date') . " 23:59:00";
            $builder->where("report.package_payment_date_time >=", $from_date);
            $builder->where("report.package_payment_date_time <=", $to_date);
        }
      

        // user filter
        
        
        $builder->where('report.partner_id', $user_id);
        

      
        // total count ke liye builder clone
        $totalBuilder = clone $builder;
        $total = $totalBuilder->countAllResults(false);

        // paginated records
        $query = $builder->get($limit, $offset);
        

        $data_list = $query->getResult();
        if(empty($data_list)) $data_list = [];



        // pagination info
        $data['pager']     = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = ($total > 0) ? $offset + 1 : 0;
        $data['endData']   = ($offset + $limit > $total) ? $total : ($offset + $limit);

        

        $view = view('partner/earning/table',compact('data_list','data'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }



}