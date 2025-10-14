<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;

class AdminCertificateController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'certificate.', 
        'title'=>'Certificate', 
        'table_name'=>'certificate',
        'page_title'=>'Certificate',
        "folder_name"=>'backend/admin/certificate',
        "upload_path"=>'upload/',
        "page_name"=>'single-certificate.php',
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
    public function load_data()
    {
        $limit = $this->request->getVar('limit');
        $status = $this->request->getVar('status');
        $order_by = $this->request->getVar('order_by');
        $filter_search_value = $this->request->getVar('filter_search_value');
        $page = $this->request->getVar('page') ?: 1; 
        $offset = ($page - 1) * $limit;

        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));   

        $data_list = $this->db->table($this->arr_values['table_name'])
        ->join('users', 'users.id = ' . $this->arr_values['table_name'] . '.user_id', 'left')        
        ->select("
            {$this->arr_values['table_name']}.*,
            users.name as name,
            users.email as email,
            users.phone as phone,
            users.image as image,
            users.user_id as user_idd
            "
        )

        ->where([$this->arr_values['table_name'] . '.status' => $status]);
        

        if(!empty($filter_search_value))
        {
            $data_list->groupStart()
                ->like($this->arr_values['table_name'] . '.name', $filter_search_value)
            ->groupEnd();
        }
        
        $data_list = $data_list->orderBy($this->arr_values['table_name'] . '.id', $order_by)->limit($limit, $offset)->get()->getResult();


        $total = $this->db->table($this->arr_values['table_name'])->countAll();
        $data['pager'] = $this->pager->makeLinks($page, $limit, $total);
        $data['totalData'] = $total;
        $data['startData'] = $offset+1;
        $data['endData'] = ($offset + $limit > $total) ? $total : ($offset + $limit);
          

        

        $view = view($this->arr_values['folder_name'].'/table',compact('data_list','data'),[],true);
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = 'Success';
        $result['action'] = 'view';
        $result['data'] = ["list"=>$view,];
        return $this->response->setStatusCode($responseCode)->setJSON($result);
    }
    public function add()
    {
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Add ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));    
        $data['pagenation'] = array($this->arr_values['title']);
        $row = [];
        $db=$this->db;
        return view($this->arr_values['folder_name'].'/form',compact('data','row','db'));
    }
    public function edit($id=null)
    {   
        $id = decript($id);
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Edit ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));           
        $data['pagenation'] = array($this->arr_values['title']);

        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        if(!empty($row))
        {
            $db=$this->db;
            return view($this->arr_values['folder_name'].'/form',compact('data','row','db'));
        }
        else
        {
            return view('admin/404',compact('data'));            
        }
    }
    public function view($id=null)
    {   
        $id = decript($id);
        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "View ".$this->arr_values['page_title'];
        $data['table_name'] = $this->arr_values['table_name'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'list'));           
        $data['pagenation'] = array($this->arr_values['title']);

        $row = $this->db->table($this->arr_values['table_name'])
        ->join('users', 'users.id = ' . $this->arr_values['table_name'] . '.user_id', 'left')        
        ->select("
            {$this->arr_values['table_name']}.*,
            users.name as name,
            users.email as email,
            users.phone as phone,
            users.image as image,
            users.user_id as user_idd,
            users.user_id as reg_no,            
            "
        )
        ->where([$this->arr_values['table_name'].".id"=>$id,])->get()->getFirstRow();
        if(!empty($row))
        {
            $db=$this->db;




            // Now you can proceed to embed the generated QR code image into your certificate
            $return_name = str_replace(" ","-" ,$row->name).'-'.str_replace(' ','-',$row->user_idd).'.jpg';
            $outputPath = FCPATH.'certificate/'.$return_name;
            
            $imgPath = FCPATH.'certificate/'.'certificate.png';
            $fontRelativePath = FCPATH.'certificate/fonts/'.'Arial_Italic.ttf';
            
            $angle = 0;
            $image = imagecreatefrompng($imgPath);
            $textColor = imagecolorallocate($image, 4, 47, 224);
            
            if (!$image) {
                die('Failed to load image.');
            }
            
            $fontPath = realpath($fontRelativePath);
            if (!$fontPath) {
                die('Invalid font path: ' . $fontRelativePath);
            }
            
            if (!file_exists($fontPath)) {
                die('Font file does not exist: ' . $fontPath);
            }
            
            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);
            

            // Add Text for Reg. Id.
            $text = strtoupper($row->reg_no);
            $fontSize = 18;
            $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $x = 935;
            $y = 145;
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


            // Add Text for Name
            $text = strtoupper($row->name);
            $fontSize = 40;
            $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $x = ($imageWidth - $textWidth) / 2+50;
            $y = 480;
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


            // Add Text for Performance
            $text = strtoupper($row->performance);
            $fontSize = 35;
            $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $x = ($imageWidth - $textWidth) / 2+50;
            $y = 790;
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);

            // Add Text for Issue Day
            $text = strtoupper(date("d", strtotime($row->issue_date)));
            $fontSize = 25;
            $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $x = 520;
            $y = 1350;
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


            // Add Text for Month year
            $text = strtoupper(date("M. Y", strtotime($row->issue_date)));
            $fontSize = 25;
            $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $x = 750;
            $y = 1350;
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


            // Add Text for Grade
            $text = '('.strtoupper($row->grade).')';
            $fontSize = 30;
            $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $x = 610;
            $y = 1500;
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);
            
            
          
            // ✅ Add user image
            $userImagePath = FCPATH . 'upload/' . $row->image;

            if (file_exists($userImagePath)) {
                $userImageInfo = getimagesize($userImagePath);
                $userImage = null;

                switch ($userImageInfo['mime']) {
                    case 'image/jpeg':
                        $userImage = imagecreatefromjpeg($userImagePath);
                        break;

                    case 'image/png':
                        $userImage = imagecreatefrompng($userImagePath);
                        break;

                    case 'image/gif':
                        $userImage = imagecreatefromgif($userImagePath);
                        break;

                    case 'image/webp':
                        // 🟢 WebP support check
                        if (function_exists('imagecreatefromwebp')) {
                            $userImage = imagecreatefromwebp($userImagePath);
                        } else {
                            // 🔄 Convert WebP → PNG if GD doesn’t support it
                            $tempPng = FCPATH . 'upload/temp_' . uniqid() . '.png';
                            @exec("dwebp " . escapeshellarg($userImagePath) . " -o " . escapeshellarg($tempPng));

                            if (file_exists($tempPng)) {
                                $userImage = imagecreatefrompng($tempPng);
                                @unlink($tempPng); // cleanup
                            } else {
                                die('WebP image could not be converted. Please enable GD WebP support or install WebP tools.');
                            }
                        }
                        break;

                    default:
                        die('Unsupported image type: ' . $userImageInfo['mime']);
                }

                if (!$userImage) {
                    die('Failed to load user image.');
                }

                // 🧩 Image placement and size
                $usrX = 1010;
                $usrY = 155;
                $userWidth = 125;
                $userHeight = 155;

                // 🖼️ Resize and overlay
                $resizedUserImage = imagescale($userImage, $userWidth, $userHeight);
                imagecopy($image, $resizedUserImage, $usrX, $usrY, 0, 0, imagesx($resizedUserImage), imagesy($resizedUserImage));

                // 🧹 Free up memory
                imagedestroy($userImage);
                imagedestroy($resizedUserImage);

            } else {
                die('User image not found: ' . $userImagePath);
            }


            // imagejpeg($image, $outputPath);
            // imagedestroy($image);

            ob_start();
            imagejpeg($image);
            $imageData = ob_get_contents();
            ob_end_clean();
            imagedestroy($image);
            $base64 = 'data:image/jpeg;base64,' . base64_encode($imageData);
            $data['img_base64'] = $base64;
            
            
            $data['status'] = "200";
            $data['url'] = base_url('certificate/').$return_name;


            return view($this->arr_values['folder_name'].'/view',compact('data','row','db'));
        }
        else
        {
            return view('admin/404',compact('data'));            
        }
    }

    public function update()
    {
        $id = decript($this->request->getPost('id'));

        $session = session()->get('user');
        $add_by = $session['id'];

        

        $data = [
            "user_id"=>$this->request->getPost('user_id'),
            "performance"=>$this->request->getPost('performance'),
            "issue_date"=>$this->request->getPost('issue_date'),
            "grade"=>$this->request->getPost('grade'),
            
            "status"=>$this->request->getPost('status'),
            "is_delete"=>0,
        ];

        $entryStatus = false;
        if(empty($id))
        {
            $data['add_by'] = $add_by;
            $data['add_date_time'] = date("Y-m-d H:i:s");
            $data['update_date_time'] = date("Y-m-d H:i:s");
            if($this->db->table($this->arr_values['table_name'])->insert($data)) $entryStatus = true;
            else $entryStatus = false;
            $id = $insertId = $this->db->insertID();
        }
        else
        {
            $data['update_date_time'] = date("Y-m-d H:i:s");
            if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
            else $entryStatus = false;
        }


        if($entryStatus)
        {
            $action = 'add';
            if(empty($insertId)) $action = 'edit';
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
    public function block_unblock($id)
    {
        $id = decript($id);
        $status = $this->request->getPost('status');

        if($status==1) $status = 0;
        else $status = 1;

        $data = [
            "status"=>$status,
        ];
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data))
        {
            $action = 'statusChange';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Successfuly';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $action = 'statusChange';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }
    public function delete($id)
    {
        $id = decript($id);
        $data = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $slug = $data->slug;
        if($this->db->table($this->arr_values['table_name'])->where("id", $id)->delete())
        {
            $this->db->table('slugs')->where(["slug"=>$slug,"table_name"=>$this->arr_values['table_name'],])->delete();
            $this->db->table("meta_tags")->where("slug", $slug)->delete();
            $action = 'delete';
            $responseCode = 200;
            $result['status'] = $responseCode;
            $result['message'] = 'Delete Successfuly';
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
        else
        {
            $action = 'delete';
            $responseCode = 400;
            $result['status'] = $responseCode;
            $result['message'] = $this->db->error()['message'];
            $result['action'] = $action;
            $result['data'] = [];
            return $this->response->setStatusCode($responseCode)->setJSON($result);
        }
    }

}