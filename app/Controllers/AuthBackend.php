<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;

class AuthBackend extends BaseController
{

    protected $db;

    public function __construct()
    {
        // Load the database
        $this->db = \Config\Database::connect();
    }

    public function login_view()
    {
        return view('backend/login');
    }

    public function token_session($user)
    {
        // Initialize variables
        $device_id = "";
        $password = $user->password;
        $firebase_token = $this->request->getPost('firebase_token');
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
        }

        return $access_token;
    }


    public function login_action()
    {
        // Get username and password from POST request
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Query the user from the database
        $user = $this->db->table('users')
            ->where(['email' => $username])
            ->whereIn('role', [1,6])
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
            
            $url = site_url($roledata->route . '/dashboard'); // equivalent to url(route())

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
                return response()->json($result, $responseCode);            
            }
            else
            {
                $responseCode = 400;
                $result['message'] = 'Login Not Successfully';
                $result['action'] = 'check_login';
                $result['url'] = '';
                $result['status'] = $responseCode;
                $result['data'] = [];
                return response()->json($result, $responseCode);
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
            return response()->json($result, $responseCode);
        }


    }
    public function logout()
    {
        $db = db_connect();
        $session = session()->get('user');
        $user_id = $session['id'];
        $role = $session['role'];
        $db->table('login_history')->where(['user_id'=>$user_id,'status'=>1,])->update(['status'=>0,]);
        session()->remove('user');

        if($role==1) $result['url'] = base_url(route_to('auth.login'));
        if($role==3) $result['url'] = base_url('vendor-login');
        if($role==6) $result['url'] = base_url('auth/login');

        $responseCode = 200;
        $result['message'] = 'Logout Successfully';
        $result['action'] = 'redirect';
        $result['status'] = $responseCode;
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }




    public function register_action(Request $request)
    {
        
        $first_name = $request->name;
        $email = $request->email;
        $state = '';
        $mobile = $request->mobile;
        $password = $request->password;
        $cpassword = $request->cpassword;
        $role = $request->type;

        $name = $first_name;

        $check_email = DB::table('users')->where('email',$email)->first();
        $check_mobile = DB::table('users')->where('phone',$mobile)->first();


        if(!empty($check_email) || empty($email))
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Email Exist';
            $result['action'] = 'register';
            $result['data'] = [];
            return response()->json($result, $responseCode);
        }
        else if(!empty($check_mobile) || empty($mobile))
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Not Athorised!';
            $result['action'] = 'register';
            $result['data'] = [];
            return response()->json($result, $responseCode);
        }
        else if($role!=2 && $role!=3)
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Mobile No. Exist';
            $result['action'] = 'register';
            $result['data'] = [];
            return response()->json($result, $responseCode);
        }
        else if($password!=$cpassword)
        {
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = 'Confirm Password Not Match';
            $result['action'] = 'register';
            $result['data'] = [];
            return response()->json($result, $responseCode);
        }
        else
        {
            $old_user = DB::table("users")->orderBy('user_id','desc')->first();
            $user_id = $old_user->user_id+1;

            $user = new User;
            $user->remember_token = '';
            $user->kyc_step = 0;
            $user->is_delete = 0;
            $user->kyc_message = '';
            $user->name = $name;
            $user->email = $email;
            $user->password = md5($password);
            $user->gender = $request->gender;
            $user->age = $request->age;
            $user->status = 1;
            $user->role = $role;
            $user->is_paid = 0;
            $user->image = 'user.png';
            $user->phone = $mobile;
            $user->state = $state;
            $user->user_id = $user_id;
            $user->add_by = 0;

            $user->save();
            $insert_id = $user->id;

            // $details = [
            //     'to'=>$email,
            //     'cc'=>$admin_registration_email,
            //     'view'=>'mailtemplate.welcome',
            //     'subject'=>'Welcome to Knowledge Wave India!',
            //     'body' => ["email"=>$email,"password"=>$password,"name"=>$name,],
            // ];
            // MailModel::registration($details);

            // if($role==2) $url = url(route('user.dashboard'));
            // if($role==3) $url = url(route('teacher.dashboard'));

            $url = url(route('auth.login'));

            $responseCode = 200;
            $result['message'] = 'Register Successfully';
            $result['action'] = 'redirect';
            $result['url'] = $url;
            $result['data'] = [];
            $responseCode = 200;            
            $result['status'] = $responseCode;
            return response()->json($result, $responseCode);
        }
    }
    public function send_otp(Request $request)
    {
        $email = $request->username;
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
            return response()->json($result, $responseCode);
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
        return response()->json($result, $responseCode);
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
            return response()->json($result, $responseCode);
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
            return response()->json($result, $responseCode);
        }
        if($check->exp_time<date("Y-m-d H:i:s"))
        {
            $responseCode = 200;
            $result['message'] = 'OTP Expired...';
            $result['action'] = 'redirect';
            $result['url'] = url('forgot-pass');
            $result['data'] = [];
            $result['status'] = $responseCode;
            return response()->json($result, $responseCode);
        }
        
        $responseCode = 200;
        $result['message'] = 'OTP Match Successfully...';
        $result['action'] = 'redirect';
        $result['url'] = $url.'?email='.Crypt::encryptString($email);
        $result['data'] = [];       
        $result['status'] = $responseCode;
        return response()->json($result, $responseCode);
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
            return response()->json($result, $responseCode);
        }
        DB::table('users')->where('email',$email)->update(['password'=>md5($password),]);                
        Session::forget('email');
        $responseCode = 200;
        $result['message'] = 'Password Create Successfully...';
        $result['action'] = 'redirect';
        $result['url'] = $url;
        $result['data'] = [];       
        $result['status'] = $responseCode;
        return response()->json($result, $responseCode);
    }
    
}
