<?php
namespace App\Controllers\Partner;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;


 
class PartnerKycController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'partner.kyc.', 
        'title'=>'Profile', 
        'table_name'=>'users',
        'page_title'=>'Profile',
        "folder_name"=>'partner/kyc',
        "upload_path"=>'upload/kyc/',
        "page_name"=>'kyc.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
      }

    public function index()
    {
        $session = session()->get('user');
        $user_id = $id = $session['id'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'index'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $db = $this->db;
        $mainData = $this->mainData;

        $kyc = $this->db->table('kyc')->where(["user_id"=>$user_id,])->orderBy('id','desc')->get()->getFirstRow();


        $partner_specializations = [];
        $partner_specialization = $this->db->table("partner_specialization")->where(["user_id"=>$user_id,])->get()->getResultObject();
        foreach ($partner_specialization as $key => $value) {
            $partner_specializations[] = $value->sp_id;
        }


        $partner_services = [];
        $partner_service = $this->db->table("partner_service")->where(["user_id"=>$user_id,])->get()->getResultObject();
        foreach ($partner_service as $key => $value) {
            $partner_services[] = $value->s_id;
        }


        $partner_expertises = [];
        $partner_expertise = $this->db->table("partner_expertise")->where(["user_id"=>$user_id,])->get()->getResultObject();
        foreach ($partner_expertise as $key => $value) {
            $partner_expertises[] = $value->e_id;
        }


        $partner_certifications = [];
        $partner_certification = $this->db->table("partner_certification")->where(["user_id"=>$user_id,])->get()->getResultObject();
        foreach ($partner_certification as $key => $value) {
            $partner_certifications[] = $value->c_id;
        }


        $partner_educations = [];
        $partner_education = $this->db->table("partner_education")->where(["user_id"=>$user_id,])->get()->getResultObject();
        foreach ($partner_education as $key => $value) {
            $partner_educations[] = $value->ed_id;
        }

        return view($this->arr_values['folder_name'].'/form',compact('data','row','db','mainData','kyc','partner_specializations','partner_services','partner_expertises','partner_certifications','partner_educations','partner_education'));
    }
    public function update()
    {        
        $session = session()->get('user');
        $add_by = $session['id'];
        $id = $add_by;
        $user_id = $add_by;

        $lastKyc = $this->db->table('kyc')->where(["user_id"=>$user_id,])->orderBy('id','desc')->get()->getFirstRow();
        $user = $this->db->table('users')->where(["id"=>$user_id,])->orderBy('id','desc')->get()->getFirstRow();

        
        
        $data = [];
        $data['user_id'] = $user_id;
        $data['bank_holder_name'] = $this->request->getPost('bank_holder_name');
        $data['nomani'] = $this->request->getPost('nomani');
        $data['bank_name'] = $this->request->getPost('bank_name');
        $data['account_number'] = $this->request->getPost('account_number');
        $data['account_type'] = $this->request->getPost('account_type');
        $data['ifsc'] = $this->request->getPost('ifsc');
        $data['pan'] = $this->request->getPost('pan');
        $data['rg_mobile'] = $this->request->getPost('rg_mobile');
        $data['rg_email'] = $this->request->getPost('rg_email');
        $data['address'] = $this->request->getPost('address');

        $data['bar_number'] = $this->request->getPost('bar_number');
        $data['enrollment_year'] = $this->request->getPost('enrollment_year');
        $data['practicing_court'] = $this->request->getPost('practicing_court');
        $data['membership_number'] = $this->request->getPost('membership_number');
        $data['firm_name'] = $this->request->getPost('address');
        $data['appointment_amount'] = $this->request->getPost('appointment_amount');
        $data['experience'] = $this->request->getPost('experience');


        // $data->kyc_message = $request->kyc_message;
        $data['status'] = 0;            


        // if($user->name!=$request->bank_holder_name)
        // {
        //     $responseCode = 400;
        //     $result['status'] = $responseCode;
        //     $result['message'] = 'Your Kyc Name and Profile Name Not Match!';
        //     $result['action'] = 'reload';
        //     $result['data'] = [];
        //     return $this->response->setStatusCode($responseCode)->setJSON($result); 
        // }
        

        if($user->kyc_step==2)
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Your Kyc Is Under Review';
            $result['action'] = 'reload';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result); 
        }
            

        $data['add_by'] = $add_by;
        $data['is_delete'] = 0;


        
        if($this->db->table('kyc')->insert($data))
        {
            $insertID = $this->db->insertID();
            


            $inTable = 'partner_specialization';
            $specialization = $this->request->getPost('specialization');
            $specializationDelete = $this->db->table($inTable)->where(["user_id"=>$user_id,]);
            if(!empty($specialization)) $specializationDelete->whereNotIn("sp_id", $specialization);
            $specializationDelete->delete();
            if(!empty($specialization))
            {
                foreach ($specialization as $key => $value) {
                    $InData = ["user_id"=>$user_id,"sp_id"=>$value,];
                    if(empty($this->db->table($inTable)->where($InData)->get()->getFirstRow()))
                        $this->db->table($inTable)->insert($InData);
                }                
            }




            $inTable = 'partner_service';
            $service = $this->request->getPost('service');
            $serviceDelete = $this->db->table($inTable)->where(["user_id"=>$user_id,]);
            if(!empty($service)) $serviceDelete->whereNotIn("s_id", $service);
            $serviceDelete->delete();
            if(!empty($service))
            {
                foreach ($service as $key => $value) {
                    $InData = ["user_id"=>$user_id,"s_id"=>$value,];
                    if(empty($this->db->table($inTable)->where($InData)->get()->getFirstRow()))
                        $this->db->table($inTable)->insert($InData);
                }                
            }


            $inTable = 'partner_expertise';
            $expertise = $this->request->getPost('expertise');
            $expertiseDelete = $this->db->table($inTable)->where(["user_id"=>$user_id,]);
            if(!empty($expertise)) $expertiseDelete->whereNotIn("e_id", $expertise);
            $expertiseDelete->delete();
            if(!empty($expertise))
            {
                foreach ($expertise as $key => $value) {
                    $InData = ["user_id"=>$user_id,"e_id"=>$value,];
                    if(empty($this->db->table($inTable)->where($InData)->get()->getFirstRow()))
                        $this->db->table($inTable)->insert($InData);
                }                
            }


            $inTable = 'partner_certification';
            $certification = $this->request->getPost('certification');
            $certificationDelete = $this->db->table($inTable)->where(["user_id"=>$user_id,]);
            if(!empty($certification)) $certificationDelete->whereNotIn("c_id", $certification);
            $certificationDelete->delete();
            if(!empty($certification))
            {
                foreach ($certification as $key => $value) {
                    $InData = ["user_id"=>$user_id,"c_id"=>$value,];
                    if(empty($this->db->table($inTable)->where($InData)->get()->getFirstRow()))
                        $this->db->table($inTable)->insert($InData);
                }                
            }

            


            $inTable = 'partner_education';
            $education = $this->request->getPost('education');
            $collage = $this->request->getPost('collage');
            $year_complete = $this->request->getPost('year_complete');
            $educationDelete = $this->db->table($inTable)->where(["user_id"=>$user_id,]);
            if(!empty($education)) $educationDelete->whereNotIn("ed_id", $education);
            $educationDelete->delete();
            if(!empty($education))
            {
                foreach ($education as $key => $value) {
                    $InData = ["user_id"=>$user_id,"ed_id"=>$value,"collage"=>$collage[$key],"year_complete"=>$year_complete[$key],];
                    if(empty($this->db->table($inTable)->where($InData)->get()->getFirstRow()))
                        $this->db->table($inTable)->insert($InData);
                }                
            }

          


            $update_data['specialization'] = json_encode($specialization);
            $update_data['service'] = json_encode($service);
            $update_data['expertise'] = json_encode($expertise);
            $update_data['certification'] = json_encode($certification);
            $update_data['education'] = json_encode($education);



            $ImageModel = new ImageModel();

            $all_image_column_names = ['passbook_image','pancard_image','aadharfront_image','aadharback_image','license','certificate'];
            $return_image_array = $ImageModel->upload_multiple_image($all_image_column_names,$this->arr_values['table_name'],$id,$this->request,$this->arr_values['upload_path']);
            if(!empty($return_image_array))
            {
                foreach ($return_image_array as $key => $value)
                {
                    if(!empty($value)) $update_data[$key] = $value;
                }
            }
            else
            {
                foreach ($all_image_column_names as $key => $value)
                {
                    $update_data[$value] = json_encode([]);
                }
            }
            if(!empty($update_data))
            $this->db->table('kyc')->where('id',$insertID)->update($update_data);

            $this->db->table('users')->where('id',$user_id)->update(["kyc_step"=>2,"about"=>$this->request->getPost('about'),]);

            $action = 'reload';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Success';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result); 
        }
        else
        {
            $action = 'add';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }
    

}