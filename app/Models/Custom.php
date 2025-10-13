<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;
class Custom extends Model
{
    const CREATED_AT = 'add_date_time';
    const UPDATED_AT = 'update_date_time';
    protected $table = 'setting';

    

    public static function employee_auto_transfer($id, $status, $date)
    {
        $db = Database::connect();

        $lead_id = $id;

        $year = date("Y", strtotime($date));
        $month = date("m", strtotime($date));
        $day = date("d", strtotime($date));

        $partner_ids = [];
        $employee_enquiry_lead_count = [];

        // Get the lead
        $lead = $db->table('enquiry_lead')->where('id', $id)->get()->getRow();
        if (!$lead) return;

        

        // Step 1: Get enquiry_lead count grouped by employee
        $builder = $db->table('employee_lead')
            ->select('employee_lead.employee_id, COUNT(*) as total')
            ->join('users', 'users.id = employee_lead.employee_id', 'left')
            ->where('employee_lead.status', 1)
            ->where('employee_lead.employee_id IS NOT NULL', null, false)
            ->where('employee_lead.employee_id !=', 0)
            ->where('YEAR(employee_lead.add_date_time)', $year)
            ->where('MONTH(employee_lead.add_date_time)', $month)
            ->where('DAY(employee_lead.add_date_time)', $day)
            ->groupBy('employee_lead.employee_id')
            ->orderBy('total', 'asc');

        $builder->where("users.state", $lead->state);
        $builder->where('users.role', 6);
        

        $enquiry_lead_count_by_user = $builder->get()->getResult();



        foreach ($enquiry_lead_count_by_user as $value) {
            $employee_ids[] = $value->employee_id;
            $employee_enquiry_lead_count[] = [
                "employee_id" => $value->employee_id,
                "total"      => $value->total,
            ];
        }

        // Step 2: Add employees with zero enquiry_lead
        $builder2 = $db->table('users')
            ->select('id');
        $builder2->where("users.state", $lead->state);        
        $builder2->where('users.role', 6);
        
            

        if (!empty($employee_ids)) {
            $builder2->whereNotIn('id', $employee_ids);
        }

       

        $enquiry_lead_count_by_user2 = $builder2->get()->getResult();

        foreach ($enquiry_lead_count_by_user2 as $value) {
            $employee_enquiry_lead_count[] = [
                "employee_id" => $value->id,
                "total"       => 0,
            ];
        }

        // Step 3: Assign to employee with minimum total
        if (!empty($employee_enquiry_lead_count)) {
            usort($employee_enquiry_lead_count, function ($a, $b) {
                return $a['total'] <=> $b['total'];
            });

            $employee_id = $employee_enquiry_lead_count[0]['employee_id'];
            self::employee_transfer($lead_id,$employee_id);
        }

    }

    public static function employee_transfer($lead_id, $employee_id)
    {
        $db = Database::connect();

        $session = session()->get('user');
        $user_id = @$session['id'];
        $role = @$session['role'];


        $date_time = date("Y-m-d H:i:s");

        $data['add_date_time'] = $date_time;
        $data['update_date_time'] = $date_time;
        $data['employee_id'] = $employee_id;
        $data['lead_id'] = $lead_id;
        $data['status'] = 1;
        $data['is_view'] = 0;
        $data['add_by'] = 1;
        
        $db->table("employee_lead")->insert($data);
        $inID = $insertId = $db->insertID();



        $oldLead = $db->table("employee_lead_transfers")->orderBy('id','desc')->where(["lead_id"=>$lead_id,])->get()->getFirstRow();

        $lead_transfers_data['add_date_time'] = $date_time;
        $lead_transfers_data['update_date_time'] = $date_time;
        $lead_transfers_data['from_employee_id'] = @$oldLead->to_employee_id?$oldLead->to_employee_id:0;
        $lead_transfers_data['to_employee_id'] = $employee_id;
        $lead_transfers_data['lead_id'] = $lead_id;
        $lead_transfers_data['status'] = 1;
        $lead_transfers_data['add_by'] = 1;
        $db->table("employee_lead_transfers")->insert($lead_transfers_data);

        if(@$oldLead->to_employee_id>0)
        {
            $db->table("enquiry_lead")->where(["id"=>$lead_id,])->update(["is_assign"=>1,]);
            $db->table("employee_lead")->where(["lead_id"=>$lead_id,"employee_id"=>@$oldLead->to_employee_id,])->update(["status"=>2,]);
        }

        return $inID;
    }


    public static function partner_auto_transfer($id, $status, $date)
    {
        $db = Database::connect();


        $year = date("Y", strtotime($date));
        $month = date("m", strtotime($date));
        $day = date("d", strtotime($date));

        $partner_ids = [];
        $employee_enquiry_lead_count = [];

        // Get the lead
        $lead = $db->table('enquiry_lead')->where('id', $id)->get()->getRow();
        if (!$lead) return;

        

        // Step 1: Get enquiry_lead count grouped by employee
        $builder = $db->table('enquiry_lead')
            ->select('enquiry_lead.partner_id, COUNT(*) as total')
            ->join('users', 'users.id = enquiry_lead.partner_id', 'left')
            ->where('enquiry_lead.status', 1)
            ->where('enquiry_lead.partner_id IS NOT NULL', null, false)
            ->where('enquiry_lead.partner_id !=', 0)
            ->where('YEAR(enquiry_lead.add_date_time)', $year)
            ->where('MONTH(enquiry_lead.add_date_time)', $month)
            ->where('DAY(enquiry_lead.add_date_time)', $day)
            ->groupBy('enquiry_lead.partner_id')
            ->orderBy('total', 'asc');

        $builder->where("users.state", $lead->state);


        if ($lead->service_type==1) {
            // ca
            $builder->where('users.role', 4);
        }
        if ($lead->service_type==2) {
            // advocate
            $builder->where('users.role', 3);
        }
        if ($lead->service_type==3) {
            // adviser
            $builder->where('users.role', 5);
        }

        $enquiry_lead_count_by_user = $builder->get()->getResult();
        foreach ($enquiry_lead_count_by_user as $value) {
            $partner_ids[] = $value->partner_id;
            $employee_enquiry_lead_count[] = [
                "partner_id" => $value->partner_id,
                "total"      => $value->total,
            ];
        }

        // Step 2: Add employees with zero enquiry_lead
        $builder2 = $db->table('users')
            ->select('id');
        $builder2->where("users.state", $lead->state);
        if ($lead->service_type==1) {
            // ca
            $builder2->where('users.role', 4);
        }
        if ($lead->service_type==2) {
            // advocate
            $builder2->where('users.role', 3);
        }
        if ($lead->service_type==3) {
            // adviser
            $builder2->where('users.role', 5);
        }
            

        if (!empty($partner_ids)) {
            $builder2->whereNotIn('id', $partner_ids);
        }

       

        $enquiry_lead_count_by_user2 = $builder2->get()->getResult();

        foreach ($enquiry_lead_count_by_user2 as $value) {
            $employee_enquiry_lead_count[] = [
                "partner_id" => $value->id,
                "total"       => 0,
            ];
        }

        // Step 3: Assign to employee with minimum total
        if (!empty($employee_enquiry_lead_count)) {
            usort($employee_enquiry_lead_count, function ($a, $b) {
                return $a['total'] <=> $b['total'];
            });

            $partner_id = $employee_enquiry_lead_count[0]['partner_id'];

            $db->table('enquiry_lead')->where('id', $id)->update(['partner_id' => $partner_id]);
        }

    }
    public static function transfer($lead_id, $partner_id)
    {
        $db = Database::connect();

        $session = session()->get('user');
        $user_id = @$session['id'];
        $role = @$session['role'];


        $date_time = date("Y-m-d H:i:s");

        $data['add_date_time'] = $date_time;
        $data['update_date_time'] = $date_time;
        $data['partner_id'] = $partner_id;
        $data['lead_id'] = $lead_id;
        $data['status'] = 1;
        $data['is_view'] = 0;
        $data['add_by'] = $user_id;
        
        $db->table("partner_lead")->insert($data);
        $inID = $insertId = $db->insertID();



        $oldLead = $db->table("lead_transfers")->orderBy('id','desc')->where(["lead_id"=>$lead_id,])->get()->getFirstRow();

        $lead_transfers_data['add_date_time'] = $date_time;
        $lead_transfers_data['update_date_time'] = $date_time;
        $lead_transfers_data['from_partner_id'] = @$oldLead->to_partner_id?$oldLead->to_partner_id:0;
        $lead_transfers_data['to_partner_id'] = $partner_id;
        $lead_transfers_data['lead_id'] = $lead_id;
        $lead_transfers_data['status'] = 1;
        $lead_transfers_data['add_by'] = $user_id;
        $db->table("lead_transfers")->insert($lead_transfers_data);

        if(@$oldLead->to_partner_id!=1)
        {
            $db->table("enquiry_lead")->where(["id"=>$lead_id,])->update(["is_transfer"=>1,"followup_status"=>3,]);
            $db->table("partner_lead")->where(["lead_id"=>$lead_id,"partner_id"=>@$oldLead->to_partner_id,])->update(["status"=>2,]);
        }

        return $inID;
    }


    
}
