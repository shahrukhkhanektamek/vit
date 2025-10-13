<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class MemberModel extends Model
{
    protected $table            = 'setting';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = []; // fill as per your table columns
    protected $useTimestamps    = true;
    const CREATED_AT            = 'add_date_time';
    const UPDATED_AT            = 'update_date_time';

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::connect();
    }

    public function appointmentIncome($user_id, $amount, $orders)
    {
        $appointment_commision = json_decode($this->db->table('setting')->getWhere(["name"=>'appointment_commision',])->getRow()->data)->percent;


        $report_date_time = date("Y-m-d H:i:s");
        $date             = date("Y-m-d");
        $actual_link      = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $gst              = 0;
        $tds              = 5;

        $amount       = $amount / 100 * $appointment_commision;
        $gst_amount       = $amount / 100 * $gst;
        $repurchase_amount= $amount / 100 * 5;
        $final_amount     = $amount;


        $ordersDetail = json_decode($orders->detail)[0];



        if (!empty($final_amount)) {
            $data = [
                "partner_id"              => $user_id,
                "user_id"                => $orders->user_id,
                "transaction_id"         => $orders->transaction_id,
                "amount"                 => $amount,
                "gst"                    => $gst_amount,
                "tds"                    => $tds,
                "final_amount"           => $final_amount,
                "type"                   => 1,
                "package_name"           => $ordersDetail->name,
                "add_date_time"          => $report_date_time,
                "package_payment_date_time"=> $report_date_time,
                "status"                 => 1,
                "payment"                => 0,
                "slug"                   => $actual_link,
                "only_date"              => $date,
                "is_delete"              => 0,
            ];

            $builder = $this->db->table('report');
            $check = $builder->where(["transaction_id" => $orders->transaction_id, "only_date" => $date, "type" => 1])->get()->getRow();

            if (empty($check)) {
                $builder->insert($data);
            } else {
                $builder->where('id', $check->id)->update($data);
            }

            $this->dayWiseIncome($user_id, $date);
            $this->monthWiseIncome($user_id, $date);
            $this->yearWiseIncome($user_id, $date);
        }
    }

    public function dayWiseIncome($user_id, $wise_date)
    {
        $this->getTypeAllIncome($user_id);

        $builder = $this->db->table("report");
        $day_wise_earning_data = $builder
            ->select('SUM(final_amount) as final_amount, type')
            ->where('only_date', $wise_date)
            ->where('status', 1)
            ->where('partner_id', $user_id)
            ->groupBy('type')
            ->get()->getResult();

        $data = [];
        foreach ($day_wise_earning_data as $value) {
            $data['income' . $value->type] = $value->final_amount;
        }

        if (!empty($data)) {
            $data['user_id'] = $user_id;
            $data['date']    = $wise_date;

            $builder = $this->db->table('day_wise_income');
            $check_amount_data = $builder->where('user_id', $user_id)->where("date", $wise_date)->get()->getRow();

            if (empty($check_amount_data)) {
                $builder->insert($data);
            } else {
                $builder->where('user_id', $user_id)->where("date", $wise_date)->update($data);
            }
        }
    }

    public function monthWiseIncome($user_id, $date_time)
    {
        $month = date("m", strtotime($date_time));
        $year  = date("Y", strtotime($date_time));

        $builder = $this->db->table("day_wise_income");
        $month_wise_earning_data = $builder
            ->selectSum('income1')
            ->selectSum('income2')
            ->selectSum('income3')
            ->selectSum('income4')
            ->selectSum('income5')
            ->selectSum('income6')
            ->where('user_id', $user_id)
            ->where("YEAR(date)", $year, false)
            ->where("MONTH(date)", $month, false)
            ->get()->getRow();

        $data = [
            "income1" => $month_wise_earning_data->income1,
            "income2" => $month_wise_earning_data->income2,
            "income3" => $month_wise_earning_data->income3,
            "income4" => $month_wise_earning_data->income4,
            "income5" => $month_wise_earning_data->income5,
            "income6" => $month_wise_earning_data->income6,
            "user_id" => $user_id,
            "month"   => $month,
            "year"    => $year,
        ];

        $builder = $this->db->table('month_wise_income');
        $check = $builder->where('user_id', $user_id)->where("month", $month)->where("year", $year)->get()->getRow();

        if (empty($check)) {
            $builder->insert($data);
        } else {
            $builder->where('user_id', $user_id)->where("month", $month)->where("year", $year)->update($data);
        }
    }

    public function yearWiseIncome($user_id, $date_time)
    {
        $year = date("Y", strtotime($date_time));

        $builder = $this->db->table("month_wise_income");
        $year_wise_earning_data = $builder
            ->selectSum('income1')
            ->selectSum('income2')
            ->selectSum('income3')
            ->selectSum('income4')
            ->selectSum('income5')
            ->selectSum('income6')
            ->where('user_id', $user_id)
            ->where('year', $year)
            ->get()->getRow();

        $data = [
            "income1" => $year_wise_earning_data->income1,
            "income2" => $year_wise_earning_data->income2,
            "income3" => $year_wise_earning_data->income3,
            "income4" => $year_wise_earning_data->income4,
            "income5" => $year_wise_earning_data->income5,
            "income6" => $year_wise_earning_data->income6,
            "user_id" => $user_id,
            "year"    => $year,
        ];

        $builder = $this->db->table('year_wise_income');
        $check = $builder->where('user_id', $user_id)->where("year", $year)->get()->getRow();

        if (empty($check)) {
            $builder->insert($data);
        } else {
            $builder->where('user_id', $user_id)->where("year", $year)->update($data);
        }

        // Update wallet
        $total = $this->db->table("year_wise_income")
            ->selectSum('income1')
            ->selectSum('income2')
            ->selectSum('income3')
            ->selectSum('income4')
            ->selectSum('income5')
            ->selectSum('income6')
            ->where("user_id", $user_id)
            ->get()->getRow();

        $this->getTypeAllIncome($user_id);

        $this->db->table('wallet')->where('user_id', $user_id)->update([
            "income1" => $total->income1,
            "income2" => $total->income2,
            "income3" => $total->income3,
            "income4" => $total->income4,
            "income5" => $total->income5,
            "income6" => $total->income6,
        ]);
    }

    public function getTypeAllIncome($user_id)
    {
        $builder = $this->db->table('wallet');
        $wallet  = $builder->where('user_id', $user_id)->get()->getRow();

        if (empty($wallet)) {
            $builder->insert([
                "user_id" => $user_id,
                "income1" => 0,
                "income2" => 0,
                "income3" => 0,
                "income4" => 0,
                "income5" => 0,
                "income6" => 0,
            ]);
        }

        return $builder->where('user_id', $user_id)->get()->getRow();
    }
}
