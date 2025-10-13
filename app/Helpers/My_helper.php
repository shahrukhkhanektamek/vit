<?php

use CodeIgniter\Database\BaseConnection;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH. 'Libraries/phpmailer/Exception.php';
require APPPATH. 'Libraries/phpmailer/PHPMailer.php';
require APPPATH. 'Libraries/phpmailer/SMTP.php';


// namespace App\Helper;

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;


  function slug($text)
  {
    $divider = '-';
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = trim($text, $divider);
    $text = strtolower($text);
    if (empty($text)) {
      return 'n-a';
    }
    return $text;
  }
  function decodeSlug($slug)
  {
      $text = str_replace('-', ' ', $slug); // Replace dashes with spaces
      $text = ucwords($text); // Capitalize each word

      return $text;
  }
  function encript($data)
  {
    $key = hash('sha256', env('encryption.key'), true); // Generate a 256-bit key
    $iv = substr(hash('sha256', env('encryption.key')), 0, 16); // Generate a 16-byte IV
    return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv));
  }
  function decript($encryptedData)
  {
    $key = hash('sha256', env('encryption.key'), true);
    $iv = substr(hash('sha256', env('encryption.key')), 0, 16);
    return openssl_decrypt(base64_decode($encryptedData), 'AES-256-CBC', $key, 0, $iv);
  }

  function insert_slug($slug, $p_id, $table_name, $page_name = '')
  {
      $db = \Config\Database::connect();

      $data = [
          "slug"       => $slug,
          "table_name" => $table_name,
          "p_id"       => $p_id,
          "page_name"  => $page_name,
      ];

      // Delete existing slug for this table and ID
      $db->table("slugs")->where(["table_name" => $table_name, "p_id" => $p_id])->delete();

      // Check if the slug already exists
      $existingSlug = $db->table("slugs")->where("slug", $slug)->get()->getRow();

      if (!$existingSlug) {
          // If slug does not exist, insert it
          $db->table("slugs")->insert($data);
      } else {
          // Generate unique slug
          $i = 1;
          while ($i <= 10) {
              $slug2 = $slug . '-' . $i;
              $get_data = $db->table("slugs")->where("slug", $slug2)->get()->getRow();

              if (!$get_data) {
                  $data['slug'] = $slug2;
                  $slug = $slug2;
                  $db->table("slugs")->insert($data);
                  break;
              }
              $i++;
          }
      }

      // Update the slug in the main table
      $db->table($table_name)->where("id", $p_id)->update(["slug" => $slug]);

      return $slug;
  }

  function insert_meta_tag($slug, $name)
  {
      $db = \Config\Database::connect();
      $request = \Config\Services::request();
      $meta_data = [
          "page_name"        => $name,
          "meta_title"       => $name,
          "slug"             => $slug,
          "meta_author"      => $request->getPost('meta_author') ?? '',
          "meta_keywords"    => $request->getPost('meta_keywords') ?? '',
          "meta_description" => $request->getPost('meta_description') ?? '',
          "status"           => 1,
      ];

      try {
          $db->table("meta_tags")->where("slug", $slug)->delete();
          if ($db->table("meta_tags")->insert($meta_data)) {
              return "Meta tag inserted successfully.";
          } else {
              return "Failed to insert meta tag.";
          }
      } catch (\Exception $e) {
          return "Error: " . $e->getMessage();
      }
  }
  function load_meta_tags($url='' ,$stateCity='')
  {
        $html = '';
        
        $db = \Config\Database::connect();
        $request = \Config\Services::request();

        if(empty($url)) $url = $request->getUri()->getSegment(1);
        
        if (empty($url)) {
            $url = 'home';
        }

        $meta_select = "page_name, meta_title, meta_keywords, meta_description, meta_author";
        $meta_data = $db->table("meta_tags")->select($meta_select)->where("slug", $url)->get()->getResultObject();
        $meta_title = '';
        $meta_keyword = '';
        $meta_description = '';
        $meta_auther = '';
        if (!empty($meta_data)) {
            $meta_data = $meta_data[0];
            $meta_title = $meta_data->meta_title;
            $meta_keyword = $meta_data->meta_keywords;
            $meta_description = $meta_data->meta_description;
            $meta_auther = $meta_data->meta_author;
        } else {
            $meta_data = $db->table("meta_tags")->select($meta_select)->where(["slug" => 'home', "is_delete" => 0, "status" => 1])->limit(1)->get()->getResultObject();
            if (!empty($meta_data)) {
                $meta_data = $meta_data[0];
                $meta_title = $meta_data->meta_title;
                $meta_keyword = $meta_data->meta_keywords;
                $meta_description = $meta_data->meta_description;
                $meta_auther = $meta_data->meta_author;
            }
        }

        return $view = view('web/include/meta',compact('meta_data'),[],true);
        

        // $html = '
        //     <title>' . esc($meta_title.' In '.$stateCity) . '</title>
        //     <meta name="keywords" content="' . esc($meta_keyword.' In '.$stateCity) . '">
        //     <meta name="description" content="' . esc($meta_description.' In '.$stateCity) . '"> 
        //     <meta name="author" content="' . esc($meta_auther.' In '.$stateCity) . '">
        // ';

    }

  function lead_status($value='')
  {
    $arr = array(
      "0"=>'New',
      "1"=>'Collowup',
      "2"=>'Not Interested',
      "3"=>'Transfer',
    );
    if($value=='')
    {
      return $arr;
    }
    else
    {
      if(!empty($arr[$value]))
        return '<span class="badge btn btn-dark" style="margin: 0 auto;">'.$arr[$value].'</span>';
      else
        return null;        
    }    
  }



  function status_get($value,$type='')
  {

    $class = 'badge bg-success';
    $status = 'Active';
    if(empty($type))
    {
      if($value==1)
      {
        $status = 'Active';
        $class = 'badge bg-success';
      }
      else if($value==0)
      {
        $status = 'Inactive';
        $class = 'badge bg-danger';
      }
    }
    $html = '<span class="badge '.$class.'" style="margin: 0 auto;">'.$status.'</span>';
    return $html;
  }



  
  function get_user()
  {    
    $session = session()->get('user');
    if(!empty($session))
    {
      $user_id = $session['id'];
      $db = db_connect();
      return $user = $db->table('users')->where('users.id', $user_id)
      ->join('countries', 'countries.id = ' . 'users.country', 'left')
      ->join('states', 'states.id = ' . 'users.state', 'left')
      ->select("users.*, countries.name as country_name, states.name as state_name ")
      ->get()->getRow();
    }
    else return false;
  }
  function get_role_by_id($role_id)
  {
    $db = db_connect();
    $data = $db->table("role")->orderBy("name","asc")->where(["id"=>$role_id,])->get()->getRow();
    return $data;
  }
 

  function create_importent_columns($table_name)
  {
      $db = \Config\Database::connect();
      $forge = \Config\Database::forge();

      // List existing columns in the table
      $fields = $db->getFieldNames($table_name);

      $columnsToAdd = [];

      if (!in_array('add_by', $fields)) {
          $columnsToAdd['add_by'] = ['type' => 'INT', 'constraint' => 11, 'null' => true];
      }
      if (!in_array('add_date_time', $fields)) {
          $columnsToAdd['add_date_time'] = ['type' => 'DATETIME', 'null' => true];
      }
      if (!in_array('update_date_time', $fields)) {
          $columnsToAdd['update_date_time'] = ['type' => 'DATETIME', 'null' => true];
      }
      if (!in_array('update_history', $fields)) {
          $columnsToAdd['update_history'] = ['type' => 'TEXT', 'null' => true];
      }
      if (!in_array('slug', $fields)) {
          $columnsToAdd['slug'] = ['type' => 'TEXT', 'null' => true];
      }
      if (!in_array('is_delete', $fields)) {
          $columnsToAdd['is_delete'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0];
      }
      if (!in_array('status', $fields)) {
          $columnsToAdd['status'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1];
      }

      if (!empty($columnsToAdd)) {
          $forge->addColumn($table_name, $columnsToAdd);
      }
  }
  function check_column_and_ceate($column_name,$table_name)
  {
    $db = \Config\Database::connect();
    $forge = \Config\Database::forge();
    $fields = $db->getFieldNames($table_name);

    $columnsToAdd = [];

    if (!in_array($column_name, $fields)) {
        $columnsToAdd[$column_name] = ['type' => 'TEXT', 'null' => true];
    }
    if (!empty($columnsToAdd)) {
        $forge->addColumn($table_name, $columnsToAdd);
    }
  }



  function randID() { 
    $length = 10;
      $vowels = 'AEUY'; 
      $consonants = '0123456789BCDFddadADDASAFS786GHJKLMNPQRSTVWXZ'; 
      $idnumber = ''; 
      $alt = time() % 2; 
      for ($i = 0;$i < $length;$i++) { 
          if ($alt == 1) { 
              $idnumber.= $consonants[(rand() % strlen($consonants)) ]; 
              $alt = 0; 
          } else { 
              $idnumber.= $vowels[(rand() % strlen($vowels)) ]; 
              $alt = 1; 
          } 
      }     
      return $idnumber; 
  }  

  function currency_simble()
  {
    return '₹';
  }

  function price_formate($price)
  {
    return '₹ '.number_format($price,2);
  }
  function rating_amount($rating)
  { 
    return $rating;
  }
  function rating_amount_total($rating)
  { 
    return $rating;
  }
  function rating_count($user_id)
  { 
    return 5;
  }




  function a_to_z()
  {
    return array(
      "A",
      "B",
      "C",
      "D",
      "E",
      "F",
      "G",
      "H",
      "I",
      "J",
      "K",
      "L",
      "M",
      "N",
      "O",
      "P",
      "Q",
      "R",
      "S",
      "T",
      "U",
      "V",
      "W",
      "X",
      "Y",
      "Z",
    );
  }


  function randomPassword($length,$count, $characters)
  {
      $symbols = array();
      $passwords = array();
      $used_symbols = '';
      $pass = '';
   

      $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
      $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $symbols["numbers"] = '1234567890';
      $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
   
      $characters = explode(",",$characters); // get characters types to be used for the passsword
      foreach ($characters as $key=>$value) {
          $used_symbols .= $symbols[$value]; // build a string with all characters
      }
      $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
       
      for ($p = 0; $p < $count; $p++) {
          $pass = '';
          for ($i = 0; $i < $length; $i++) {
              $n = rand(0, $symbols_length); // get a random character from the string with all characters
              $pass .= $used_symbols[$n]; // add the character to the password string
          }
          $passwords[] = $pass;
      }
       
      return $passwords; // return the generated password
  }



  function image_check($path,$default='')
  {
      if(empty($default)) $image = base_url('upload/default.jpg');
      else $image = base_url('upload/'.$default);

      $decoded = json_decode($path);
      if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded))) {          
          $decodedImages = $decoded;
          if(!empty($decodedImages[0]->image_path))
          $image = base_url('upload/'.$decodedImages[0]->image_path);
      }
      else
      {
        $filePath = FCPATH.'upload/'.$path;      
        if (file_exists($filePath) && !empty($path))
        {
          $image = base_url('upload/'.$path);
        }
      }


      return $image;
  }

  function image_check_front($path,$default='')
  {
      if(empty($default)) $image = base_url('upload/default.jpg');
      else $image = base_url('upload/'.$default);
      $filePath = FCPATH.'upload/'.$path;      
      if (file_exists($filePath) && !empty($path))
      {
        $image = base_url('upload/'.$path);
      }
      return $image;
  }

  function count_review($partner_id)
  {
      $db = \Config\Database::connect();
      $reviewSummary = $db->table('review')
      ->select('COUNT(*) as total_reviews, AVG(rating) as average_rating')
      ->where([
          'partner_id' => $partner_id,
          'is_delete' => 0,
          'status' => 1,
      ])
      ->get()
      ->getRow();

      return ["total"=>$reviewSummary->total_reviews,"average_rating"=>number_format($reviewSummary->average_rating, 2),];
  }

  function gender($value='')
  {
      $arr = array(
        "1"=>'Male',
        "2"=>'Female',
        "3"=>'Other',
      );
      if(empty($value))
        return $arr;
      return $arr[$value];
  }

  function months($value='')
  {
      $arr = array(
        "01"=>'Jan',
        "02"=>'Feb',
        "03"=>'Mar',
        "04"=>'Apr',
        "05"=>'May',
        "06"=>'Jun',
        "07"=>'Jul',
        "08"=>'Aug',
        "09"=>'Sep',
        "10"=>'Oct',
        "11"=>'Nov',
        "12"=>'Dec',
      );
      if(empty($value))
        return $arr;
      return $arr[$value];
  }
  function days($value='')
  {
      $arr = array(
        "01"=>'1',
        "02"=>'2',
        "03"=>'3',
        "04"=>'4',
        "05"=>'5',
        "06"=>'6',
        "07"=>'7',
        "08"=>'8',
        "09"=>'9',
        "10"=>'10',
        "11"=>'11',
        "12"=>'12',
        "13"=>'13',
        "14"=>'14',
        "15"=>'15',
        "16"=>'16',
        "17"=>'17',
        "18"=>'18',
        "19"=>'19',
        "20"=>'20',
        "21"=>'21',
        "22"=>'22',
        "23"=>'23',
        "24"=>'24',
        "25"=>'25',
        "26"=>'26',
        "27"=>'27',
        "28"=>'28',
        "29"=>'29',
        "30"=>'30',
        "31"=>'31',
      );
      if(empty($value))
        return $arr;
      return $arr[$value];
  }
  function years($value='')
  {
      $arr = array('2024','2025','2026');
      if(empty($value))
        return $arr;
      return $arr[$value];
  }


    function my_plans($vendor_id)
    {
        $db = \Config\Database::connect();
        return $db->table('vendor_package')
                  ->where('vendor_id', $vendor_id)
                  ->orderBy('id', 'DESC')
                  ->get()
                  ->getResult();
    }
    function plan_status($vendor_id, $plans_id)
    {
        $db = \Config\Database::connect();
        $today = date("Y-m-d H:i:s");

        $plan = $db->table('vendor_package')
                   ->where(['vendor_id' => $vendor_id, 'id' => $plans_id])
                   ->get()
                   ->getRow();

        $status = false;
        $is_unlimited = false;

        if (!empty($plan)) {
            if ($plan->is_unlimited == 1) {
                $is_unlimited = true;
            }

            if ($today <= $plan->plan_end_date_time || $plan->is_unlimited == 1) {
                $status = true;
            }

            
        }

        return [
            "status" => $status,
            "is_unlimited" => $is_unlimited,
        ];
    }
    function check_any_active_plan($vendor_id)
    {
        $db = \Config\Database::connect();
        $today = date("Y-m-d H:i:s");

        $plan_id = 0;
        $available_class = 0;
        $plan_table_id = 0;
        $status = 0;
        $is_unlimited = false;

        // First: check non-unlimited active plan with available classes
        $builder = $db->table('vendor_package');
        $plan = $builder->where('vendor_id', $vendor_id)
                        ->where('available_class >', 0)
                        ->where('plan_end_date_time >=', $today)
                        ->get()
                        ->getRow();

        if (empty($plan)) {
            // Second: check unlimited plans
            $plan = $builder->where('vendor_id', $vendor_id)
                            ->where('is_unlimited', 1)
                            ->where('plan_end_date_time >=', $today)
                            ->get()
                            ->getRow();

            if (!empty($plan)) {
                $is_unlimited = true;
            }
        }

        if (!empty($plan)) {
            $plan_id = $plan->id;
            $plan_table_id = $plan->plan_id;
            $available_class = $plan->available_class;

            if ($today <= $plan->plan_end_date_time || $plan->is_unlimited == 1) {
                $status = 1;
            }
        }

        return [
            "status" => $status,
            "plan_id" => $plan_id,
            "plan_table_id" => $plan_table_id,
            "available_class" => $available_class,
            "is_unlimited" => $is_unlimited,
        ];
    }


      function sendMail($details=[])
      {
          $body = $details['body'];
          $subject = $details['subject'];
          $to = $details['to'];


          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
          $mail->SMTPAuth   = true;
          $mail->Username   = env('MAIL_USERNAME'); // your@gmail.com
          $mail->Password   = env('MAIL_PASSWORD'); // app-specific password
          $mail->SMTPSecure =  env("SMTPCrypto");
          $mail->Port       = env('MAIL_PORT', 587);
          $mail->SMTPDebug  = 0;
          $mail->Debugoutput = 'html';

          $mail->setFrom(env('MAIL_FROM_ADDRESS'), env("APP_NAME"));
          $mail->addAddress($to);
          $mail->isHTML(true);
          $mail->Subject = $subject;
          $mail->Body    = $body;

          if($mail->send())
            return 1;
          else
            return 0;


          // echo 'Message has been sent';
      
          // echo "Mailer Error: " . $mail->ErrorInfo;
         

      }
