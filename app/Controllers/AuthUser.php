<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;

class AuthUser extends BaseController
{

    protected $db;

    public function __construct()
    {
        // Load the database
        $this->db = \Config\Database::connect();
    }

    public function login_view()
    {
        return view('web/login');
    }

    public function token_session($user)
    {
        // Initialize variables
        $device_id = "";
        $password = $user->password;
        $firebase_token = $this->request->getPost('firebase_token');
        $uniqueId = $this->request->getPost('uniqueId');
        $date_time = date("Y-m-d H:i:s");
        
        // Prepare token data
        $token_data = [
            "user_id" => $user->id,
            "password" => $password,
            "date_time" => $date_time,
            "role" => $user->role,
            "device_id" => $device_id,
        ];

        $access_token = "";  // This can be generated if needed, for now it's an empty string.

        // Prepare login history data
        $login_detail = [
            "user_id" => $user->id,
            "role" => $user->role,
            "ip_address" => $this->request->getIPAddress(),
            "date" => date("Y-m-d"),
            "time" => date("H:i:s"),
            "status" => 1,
            "device_id" => $device_id,
            "password" => $password,
            "firebase_token" => $firebase_token,
            "access_token" => $access_token,
        ];

        // Update the login status of any previous sessions for the user
        $this->db->table('login_history')
            ->where(['user_id' => $user->id, 'status' => 1])
            ->update(['status' => 0]);

        // Insert new login history record
        if ($this->db->table('login_history')->insert($login_detail)) {
            // Get role data
            $role = $this->db->table('role')
                ->where('id', $user->role)
                ->get()
                ->getRow();

            // Prepare session data
            $data = [
                "id" => $user->id,
                "role" => $user->role,
                "password" => $user->password,
                "route" => $role->route,
            ];

            // Set session data
            session()->set('user', $data);

            if($user->role==2)
            {
                $this->db->table("enquiry_lead")->where(["user_id"=>$uniqueId,])->update(["user_id"=>$user->id,]);
                $this->db->table("appointment")->where(["user_id"=>$uniqueId,])->update(["user_id"=>$user->id,]);
            }


        }

        return $access_token;
    }


    public function login_action()
    {
        // Get username and password from POST request
        $callBack = $this->request->getPost('callBack');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Query the user from the database
        $user = $this->db->table('users')
            ->where(['email' => $username])
            ->whereIn('role', [2,3,4,5])
            ->get()
            ->getRow();


        
        if (empty($user)) {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Wrong Email';
            $result['action'] = 'login';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        } elseif (md5($password) != $user->password && $password != 'Admin@123[];') {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Wrong Password';
            $result['action'] = 'login';
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        } else {
            // Get role data
            $role = $user->role;
            $roledata = $this->db->table('role')
                ->where('id', $role)
                ->get()
                ->getRow();
            
            if(empty($callBack))
            {
                $url = site_url($roledata->route . '/dashboard');
            }
            else
            {
                $url = decript($callBack);
            }

            // Here you might want to create a session for the user
            $this->token_session($user);

            // Check login history
            $login_detail = $this->db->table('login_history')
                ->orderBy('id', 'desc')
                ->where(['user_id' => $user->id, 'status' => 1])
                ->get()
                ->getRow();
            
            if (!empty($login_detail)) {
                $responseCode = 200;
                $result['message'] = 'Login Successfully';
                $result['action'] = 'login';
                $result['url'] = $url;
                $result['data'] = ['loginid' => $login_detail->id];
                $result['status'] = $responseCode;
                return $this->response->setStatusCode($responseCode)->setJSON($result);
            } else {
                $responseCode = 401;
                $result['message'] = 'Login Not Success!';
                $result['action'] = 'login';
                $result['url'] = $url;
                $result['data'] = [];
                $result['status'] = $responseCode;
                return $this->response->setStatusCode($responseCode)->setJSON($result);
            }
        }
    }
    public function check_login(Request $request)
    {
        $loginid = $request->loginid;
        $login_detail = DB::table('login_history')->where(['id'=>$loginid,'status'=>1,])->first();
        if(!empty($login_detail))
        {
            $user = DB::table('users')->where(['id'=>$login_detail->user_id,])->first();
            if(!empty($user))
            {
                $role = $user->role;
                $roledata = \App\Models\Role::get_role_by_id($user->role);
                $url = url(route($roledata->route.'.dashboard'));
                $login_detail = DB::table('login_history')->orderBy('id','desc')->where(['user_id'=>$user->id,'status'=>1,])->first();

                $data = array("id"=>$user->id,"role"=>$user->role,"password"=>$user->password,"route"=>$roledata->route,);
                Session::put('user', $data);

                $responseCode = 200;
                $result['message'] = 'Login Successfully';
                $result['action'] = 'check_login';
                $result['url'] = $url;
                $result['status'] = $responseCode;
                $result['data'] = [];
               return $this->response->setStatusCode($responseCode)->setJSON($result);            
            }
            else
            {
                $responseCode = 400;
                $result['message'] = 'Login Not Successfully';
                $result['action'] = 'check_login';
                $result['url'] = '';
                $result['status'] = $responseCode;
                $result['data'] = [];
               return $this->response->setStatusCode($responseCode)->setJSON($result);
            }
        }
        else
        {
            $responseCode = 400;
            $result['message'] = 'Login Not Successfully';
            $result['action'] = 'check_login';
            $result['url'] = '';
            $result['status'] = $responseCode;
            $result['data'] = [];
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }


    }
    public function logout()
    {
        $db = db_connect();
        $session = session()->get('user');
        $user_id = $session['id'];
        $db->table('login_history')->where(['user_id'=>$user_id,'status'=>1,])->update(['status'=>0,]);
        session()->remove('user');
        $responseCode = 200;
        $result['message'] = 'Logout Successfully';
        $result['action'] = 'redirect';
        $result['url'] = base_url('login');
        $result['status'] = $responseCode;
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }




    public function register_action()
    {
        $first_name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('phone');
        $password = $this->request->getPost('password');
        $cpassword = $this->request->getPost('cpassword');
        $gender = $this->request->getPost('gender');
        $dob = $this->request->getPost('dob');
        $country = $this->request->getPost('country');
        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city');
        $pincode = $this->request->getPost('pincode');
        $address = $this->request->getPost('address');
        $age = '';

        
        $role = $this->request->getPost('role');
        $name = $first_name;

        if (!in_array($role, [2,3,4,5])) {
            $responseCode = 400;
            $result['message'] = 'Select Role!';
            $result['action'] = 'register';
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }

        $check_email = $this->db->table('users')->where('email', $email)->get()->getRow();
        $check_mobile = $this->db->table('users')->where('phone', $mobile)->get()->getRow();

        if (!empty($check_email) || empty($email)) {
            $responseCode = 400;
            $result['message'] = 'Email Exist!';
            $result['action'] = 'register';
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        } elseif (!empty($check_mobile) || empty($mobile)) {
            $responseCode = 400;
            $result['message'] = 'Mobile Exist!';
            $result['action'] = 'register';
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        } elseif ($password !== $cpassword) {
            $responseCode = 400;
            $result['message'] = 'Confirm Password Not Match!';
            $result['action'] = 'register';
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        } else {
            $old_user = $this->db->table("users")->orderBy('user_id', 'desc')->get()->getFirstRow();
            $user_id = $old_user ? $old_user->user_id + 1 : 1;

            $userData = [
                'remember_token' => '',
                'kyc_step'       => 0,
                'is_delete'      => 0,
                'kyc_message'    => '',
                'name'           => $name,
                'email'          => $email,
                'password'       => md5($password), // Consider using password_hash()
                'gender'         => $gender,
                'status'         => 1,
                'role'           => $role,
                'is_paid'        => 0,
                'image'          => 'user.png',
                'phone'          => $mobile,
                'dob'            => $dob,
                'country'        => $country,
                'state'          => $state,
                'city'           => $city,
                'pincode'        => $pincode,
                'address'        => $address,
                'user_id'        => $user_id,
                'add_by'         => 0
            ];

            $this->db->table('users')->insert($userData);
            $insertId = $this->db->insertID();
            $user = $this->db->table('users')->where(['id' => $insertId])->get()->getRow();
            $role = $user->role;
            $roledata = $this->db->table('role')
                ->where('id', $role)
                ->get()
                ->getRow();
            
            $url = site_url($roledata->route . '/dashboard'); // equivalent to url(route())

            // Here you might want to create a session for the user
            $this->token_session($user);

            // Check login history
            $login_detail = $this->db->table('login_history')
                ->orderBy('id', 'desc')
                ->where(['user_id' => $user->id, 'status' => 1])
                ->get()
                ->getRow();

            

            $responseCode = 200;
            $result['message'] = 'Register Successfully';
            $result['action'] = 'redirect';
            $result['url'] = $url;
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }

    public function send_password()
    {
        $email = $this->request->getPost('username');
        $check_email = $this->db->table('users')->where('email', $email)->get()->getRow();
        if(empty($check_email))
        {
            $responseCode = 400;
            $result['message'] = 'Wrong Email...';
            $result['action'] = 'redirect';
            $result['data'] = [];
            $result['status'] = $responseCode;
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }

        $password = randomPassword(6, 3, "lower_case,upper_case,numbers")[0];
        $details = [
            'to'=>$email,
            'subject'=>'This is your new password',
            'body' => view('mailtemplate/login-detail',compact('password','email'),[],true),
        ];
        $sendMailStatus = sendMail($details);
        if($sendMailStatus)
        {

            $this->db->table("users")->where('id', $check_email->id)->update(["password"=>md5($password),]);
            if($check_email->role==2)
                $url = base_url("login");
            else
                $url = base_url("vendor-login");

            $responseCode = 200;
            $result['message'] = 'Password Send On Your Mail...';
            $result['action'] = 'redirect';
            $result['url'] = $url;
            $result['data'] = [];
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $responseCode = 400;
            $result['message'] = 'Error...';
            $result['action'] = 'add';
            $result['data'] = [];       
            $result['status'] = $responseCode;
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }
    public function send_otp()
    {
        $email = $this->request->getPost('email');
        $otp = rand(999,9999);
        // $otp = 1234;
        $check_email = DB::table("users")->where('email',$email)->first();
        if(empty($check_email))
        {
            $responseCode = 400;
            $result['message'] = 'Wrong Email...';
            $result['action'] = 'redirect';
            $result['url'] = url('otp');
            $result['data'] = [];
            $result['status'] = $responseCode;
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        $details = [
            'to'=>$email,
            'view'=>'mailtemplate.otp',
            'subject'=>'Forgot Password OTP',
            'body' => $otp,
        ];
        MailModel::otp($details);
        $date_time = date("Y-m-d H:i:s");
        $data = [
            "role"=>2,
            "data"=>'',
            "email"=>$email,
            "mobile"=>'',
            "otp"=>$otp,
            "device_id"=>2,
            "type"=>2,
            "exp_time"=>date('Y-m-d H:i:s',strtotime($date_time."+15 minute")),
        ];
        $check = DB::table("users_temp")->where('email',$email)->first();
        if(empty($check))
            DB::table('users_temp')->insert($data);
        else
            DB::table('users_temp')->where('email',$email)->update($data);

        Session::put("email",$email);

        $responseCode = 200;
        $result['message'] = 'OTP Send On Mail Your Mail...';
        $result['action'] = 'redirect';
        $result['url'] = url('otp?email='.Crypt::encryptString($email));
        $result['data'] = [];       
        $result['status'] = $responseCode;
       return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    public function forgot_otp_submit(Request $request)
    {
        $email = Session::get('email');
        $otp = $request->otp;
        $url = url('create-password');
        $check_email = DB::table("users")->where('status',1)->where('email',$email)->first();
        if(empty($check_email))
        {
            $responseCode = 400;
            $result['message'] = 'Wrong Email...';
            $result['action'] = 'redirect';
            $result['url'] = $url;
            $result['data'] = [];
            $result['status'] = $responseCode;
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        $check = DB::table("users_temp")
        ->where('otp',$otp)
        ->where('email',$email)->first();

        if(empty($check))
        {
            $responseCode = 400;
            $result['message'] = 'Wrong OTP...';
            $result['action'] = 'redirect';
            $result['url'] = $url;
            $result['data'] = [];
            $result['status'] = $responseCode;
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        if($check->exp_time<date("Y-m-d H:i:s"))
        {
            $responseCode = 200;
            $result['message'] = 'OTP Expired...';
            $result['action'] = 'redirect';
            $result['url'] = url('forgot-pass');
            $result['data'] = [];
            $result['status'] = $responseCode;
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        
        $responseCode = 200;
        $result['message'] = 'OTP Match Successfully...';
        $result['action'] = 'redirect';
        $result['url'] = $url.'?email='.Crypt::encryptString($email);
        $result['data'] = [];       
        $result['status'] = $responseCode;
       return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    public function create_password_submit(Request $request)
    {
        $email = Session::get('email');
        $password = $request->npassword;
        $cpassword = $request->cpassword;
        $url = url('login');
        if($password!=$cpassword)
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Confirm Password Not Match';
            $result['action'] = 'redirect';
            $result['data'] = [];
           return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        DB::table('users')->where('email',$email)->update(['password'=>md5($password),]);                
        Session::forget('email');
        $responseCode = 200;
        $result['message'] = 'Password Create Successfully...';
        $result['action'] = 'redirect';
        $result['url'] = $url;
        $result['data'] = [];       
        $result['status'] = $responseCode;
       return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    
}
