<?php
namespace App\Controllers\Partner;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
 
class PartnerProfileController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'partner.profile.', 
        'title'=>'Profile', 
        'table_name'=>'users',
        'page_title'=>'Profile',
        "folder_name"=>'partner/profile',
        "upload_path"=>'upload/',
        "page_name"=>'profile.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
      }

    public function index()
    {
        $session = session()->get('user');
        $id = $session['id'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url(route_to($this->arr_values['routename'].'index'));      
        $data['pagenation'] = array($this->arr_values['title']);
        $row = $this->db->table($this->arr_values['table_name'])->where(["id"=>$id,])->get()->getFirstRow();
        $db = $this->db;
        $mainData = $this->mainData;
        return view($this->arr_values['folder_name'].'/form',compact('data','row','db','mainData'));
    }
    public function update()
    {
        
        $session = session()->get('user');
        $add_by = $session['id'];
        $id = $add_by;

        $data = [
            "name"=>$this->request->getPost('name'),
            "phone"=>$this->request->getPost('phone'),
            "email"=>$this->request->getPost('email'),
            "gender"=>$this->request->getPost('gender'),
            "dob"=>$this->request->getPost('dob'),
            "address"=>$this->request->getPost('address'),
            "country"=>$this->request->getPost('country'),
            "state"=>$this->request->getPost('state'),
            "city"=>$this->request->getPost('city'),
            "pincode"=>$this->request->getPost('pincode'),
            "status"=>1,
        ];

        $entryStatus = false;
        
        if($this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data)) $entryStatus = true;
        else $entryStatus = false;        


        if($entryStatus)
        {
            $action = 'edit';
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
    public function update_profile_image()
    {
        $session = session()->get('user');
        $add_by = $session['id'];
        $id = $add_by;

        $data = [
            "status"=>1,
        ];

        $image = $this->request->getFile('croppedImage');

        if ($image && $image->isValid() && !$image->hasMoved()) {

            $uploadPath = FCPATH.$this->arr_values['upload_path'];

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Unique file name
            $fileName = time() . '-' . uniqid() . '.jpg';

            if ($image->move($uploadPath, $fileName)) {
                
                // Success response (add your response here)
                $data['image'] = $fileName;
                $this->db->table($this->arr_values['table_name'])->where('id', $id)->update($data);
                

                return $this->response->setJSON([
                    'status' => 200,
                    'message' => 'Image uploaded successfully.',
                    'path' => $uploadPath . $fileName,
                    'action' => 'reload',
                    'data' => [],
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 200,
                    'message' => 'Failed to save image.',
                    'action' => 'reload',
                    'data' => [],
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'No image file uploaded or invalid.',
                'action' => 'reload',
                'data' => [],
            ]);
        }
    }

}