<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminPayoutController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'payout.', 
        'title'=>'Payout History', 
        'table_name'=>'report',
        'page_title'=>'Payout History',
        "folder_name"=>'backend/admin/payout',
        "upload_path"=>'upload/',
        "page_name"=>'payout.php',
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


    public function getQuery($limit='')
    {
        $kyc = $this->request->getVar('kyc');
        if(empty($limit)) $limit = $this->request->getVar('limit');
        $status = $this->request->getVar('status');
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;

        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   

      
        $db=$this->db;


        $payment = '';
        if ($status == 1) $payment = 1;
        if ($status == 2) $payment = 0;

        $builder = $db->table('report');
        $builder->join("kyc as kyc","kyc.user_id = report.partner_id","left");
        $builder->select([
            'report.partner_id',
            'users.name',
            'users.phone',
            'SUM(amount) as amount',
            'SUM(amount * tds / 100) as tds_amount',
            'SUM(amount - (amount * tds / 100) ) as final_amount',
            'kyc.bank_name as bank_name',
            'kyc.bank_holder_name as bank_holder_name',
            'kyc.account_number as account_number',
            'kyc.pan as pan',
            'kyc.ifsc as ifsc',
            'users.user_id as user_id2',
            'users.kyc_step as kyc_step',            
            'users.status as user_status',            
        ]);
        $builder->join('users as users', 'users.id = report.partner_id', 'left');
        $builder->where('report.status', 1);
        $builder->whereIn('report.type', [1, 2, 3, 4, 5, 6]);
        $builder->groupBy(['report.partner_id', 'users.name']);

        // payment filter
        if (!empty($status)) {
            $builder->where('report.payment', $payment);
        }

        // kyc filter
        if ($kyc == 1) {
            $builder->where('users.kyc_step', 1);
        }

        // date filter
        
        if (!empty($this->request->getVar('from_date')) && !empty($this->request->getVar('to_date'))) {
            $from_date = $this->request->getVar('from_date') . " 00:00:00";
            $to_date   = $this->request->getVar('to_date') . " 23:59:00";
            $builder->where("report.package_payment_date_time >=", $from_date);
            $builder->where("report.package_payment_date_time <=", $to_date);
        }
      

        // user filter
        if (!empty($this->request->getVar('user_id'))) {
            $user_id = $this->request->getVar('user_id');
            $builder->where('report.partner_id', $user_id);
        }

       if (empty($this->request->getVar('amount'))) {
            // total count ke liye builder clone
            $totalBuilder = clone $builder;
            $total = $totalBuilder->countAllResults(false);

            // paginated records
            $query = $builder->get($limit, $offset);
        } else {
            $subquery = $builder->getCompiledSelect();
            $builder2 = $db->table("({$subquery}) as subquery");
            $builder2->where('final_amount >=', $this->request->getVar('amount'));

            // total count ke liye builder clone
            $totalBuilder = clone $builder2;
            $total = $totalBuilder->countAllResults(false);

            // paginated records
            $query = $builder2->get($limit, $offset);
        }

        $data_list = $query->getResult();
        

        // pagination info
        $data['pager']     = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = ($total > 0) ? $offset + 1 : 0;
        $data['endData']   = ($offset + $limit > $total) ? $total : ($offset + $limit);

        return ["data"=>$data,"data_list"=>$data_list,];
    }


    public function load_data()
    {
        
        $db=$this->db;
        $getQuery = $this->getQuery();
        $data = $getQuery['data'];
        $data_list = $getQuery['data_list'];
        
        
        $view = view($this->arr_values['folder_name'].'/table',compact('data_list','data','db'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }


    public function payout_submit()
    {
        $db = \Config\Database::connect();
        $session = session();

        $pin     = $this->request->getVar('pin');
        $setting = $db->table('setting')->where("name","payoutpin")->get()->getFirstRow();
        $setting_pin = @json_decode(@$setting->data)->pin ?? null;

        if (empty($pin)) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Invalid PIN!',
                'action'  => 'modalform',
                'data'    => []
            ])->setStatusCode(400);
        } elseif ($setting_pin != $pin) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'PIN Not Match!',
                'action'  => 'modalform',
                'data'    => []
            ])->setStatusCode(400);
        }

        $date_time = date("Y-m-d H:i:s");

        

        $limit = 1200000000000;        
        $getQuery = $this->getQuery($limit);
        $data = $getQuery['data'];
        $data_list = $getQuery['data_list'];


        // collect partner_ids
        $affiliate_ids = [];
        foreach ($data_list as $row) {
            $affiliate_ids[] = $row->partner_id;
        }

        // update reports
        if (!empty($affiliate_ids)) {
            $update = $db->table('report')
                ->whereIn('partner_id', $affiliate_ids)
                ->where(['status' => 1, 'payment' => 0]);

            // if ($search_type == 1) {
            //     if (!empty($this->request->getVar('from_date')) && !empty($this->request->getVar('to_date'))) {
            //         $from_date = $this->request->getVar('from_date') . " 00:00:00";
            //         $to_date   = $this->request->getVar('to_date') . " 23:59:00";
            //         $update->where("report.package_payment_date_time >=", $from_date);
            //         $update->where("report.package_payment_date_time <=", $to_date);
            //     }
            // }

            $update->update(['payment' => 1, 'payout_date_time' => $date_time]);
        }

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Success',
            'action'  => 'modalform',
            'data'    => []
        ])->setStatusCode(200);
    }


    public function excel_export()
    {        
        $session = session();

        $limit = 1200000000000;        
        $getQuery = $this->getQuery($limit);
        $data = $getQuery['data'];
        $data_list = $getQuery['data_list'];

        // Prepare Excel
        $Admin_id = $session->get('user')['id'];
        $columns = "User Name,Bank Name,Bank Holder Name,Bank Account No.,IFSC Code,PanCard,Phone,Amount,TDS,R. Wallet,Final Amount,Status,KYC";
        $fileName = "Payout-Detail-" . date("Y-m-d-H-i-s") . "-" . $Admin_id . ".xlsx";

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $columns_array = explode(",", $columns);
        $a_to_z = range('A', 'Z');

        // Set Header
        $row = 1;
        foreach ($columns_array as $i => $col) {
            $sheet->setCellValue($a_to_z[$i] . $row, ucfirst(str_replace("_", " ", $col)));
        }

        // Fill Data
        $row = 2;
        foreach ($data_list as $value) {
           
            $status = $value->user_status;
            $statusHtml = 'Income';
            if ($status == 1) $statusHtml = 'Paid';
            else if ($status == 2) $statusHtml = 'UnPaid';

            $kycStatus = 'KYC Not Update';
            
            if ($value->kyc_step == 1) $kycStatus = 'KYC Complete';
            if ($value->kyc_step == 2) $kycStatus = 'KYC Under Review';
            if ($value->kyc_step == 3) $kycStatus = 'KYC Rejected';
        

            $sheet->setCellValue("A" . $row, @$value->bank_holder_name . ', ' . @$value->user_id2);
            $sheet->setCellValue("B" . $row, @$value->bank_name);
            $sheet->setCellValue("C" . $row, @$value->bank_holder_name);
            $sheet->setCellValue("D" . $row, @$value->account_number);
            $sheet->setCellValue("E" . $row, @$value->ifsc);
            $sheet->setCellValue("F" . $row, @$value->pan);
            $sheet->setCellValue("G" . $row, @$value->phone);
            $sheet->setCellValue("H" . $row, @$value->amount);
            $sheet->setCellValue("I" . $row, @$value->tds_amount);
            $sheet->setCellValue("J" . $row, @$value->wallet_amount);
            $sheet->setCellValue("K" . $row, @$value->final_amount);
            $sheet->setCellValue("L" . $row, $statusHtml);
            $sheet->setCellValue("M" . $row, $kycStatus);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $directory = FCPATH . 'excel';
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $filePath = $directory . '/' . $fileName;
        $writer->save($filePath);

        $result = [
            'status' => 200,
            'message' => 'Success',
            'action' => 'exportdata',
            'url' => base_url("excel/" . $fileName),
            'data' => ['fileName' => $fileName]
        ];

        return $this->response->setJSON($result);
    }
    

    
   
    

}