<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Database\Database;
use CodeIgniter\Config\Services;
use App\Models\ImageModel;
use App\Models\GeminiModel;

use Smalot\PdfParser\Parser;

class GeminiController extends BaseController
{
     protected $arr_values = array(
        'routename'=>'', 
        'title'=>'Gemini', 
        'table_name'=>'package',
        'page_title'=>'Gemini',
        "folder_name"=>'gemini',
        "upload_path"=>'upload/',
        "page_name"=>'package-single.php',
       );

      public function __construct()
      {
        create_importent_columns($this->arr_values['table_name']);
        $this->db = \Config\Database::connect();
      }

    public function ask_ally()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/ask-ally',compact('data','db','row'));
        else
            return view('backend/gemini/ask-ally',compact('data','db','row'));
    }
    public function action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->getAllyResponse($comment,'');
        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result); 
        
    }




    public function legal_research()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/legal-research/legal_research_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/legal-research',compact('data','db','row'));
        else
            return view('backend/gemini/legal-research',compact('data','db','row'));
    }
    public function legal_research_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $Jurisdiction = $this->request->getPost('Jurisdiction');
        $ResearchType = $this->request->getPost('ResearchType');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];

        $query['query'] = $comment;
        $query['jurisdiction'] = $Jurisdiction;
        $query['type'] = $ResearchType;

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->performLegalResearch($query);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response['responseText'];
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }


    public function legal_drafting()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/legal-drafting/legal_drafting_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/legal-drafting',compact('data','db','row'));
        else
            return view('backend/gemini/legal-drafting',compact('data','db','row'));
    }
    public function legal_drafting_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $Jurisdiction = $this->request->getPost('Jurisdiction');
        $ResearchType = $this->request->getPost('ResearchType');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];

        $query['query'] = $comment;
        $query['jurisdiction'] = $Jurisdiction;
        $query['type'] = $ResearchType;

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->performLegalDrafting($query);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response['responseText'];
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }



    public function translator()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/translator/translator_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/translator',compact('data','db','row'));
        else
            return view('backend/gemini/translator',compact('data','db','row'));
    }
    public function translator_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $language = $this->request->getPost('language');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];

        $query = $comment;
        

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->translateDocument($query, $language);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }




    public function complaint_writer()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/complaint-writer/complaint_writer_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/complaint-writer',compact('data','db','row'));
        else
            return view('backend/gemini/complaint-writer',compact('data','db','row'));
    }
    public function complaint_writer_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];


        $query['policeStation'] = $this->request->getPost('police_station');
        $query['district'] = $this->request->getPost('district');
        $query['state'] = $this->request->getPost('state');
        $query['complainantName'] = $this->request->getPost('complainant_name');
        $query['complainantAddress'] = $this->request->getPost('complainant_address');
        $query['accusedName'] = $this->request->getPost('accused_name');
        $query['accusedAddress'] = $this->request->getPost('accused_address');
        $query['incidentDate'] = $this->request->getPost('date_of_incident');
        $query['incidentLocation'] = $this->request->getPost('location_of_incident');
        $query['incidentDescription'] = $this->request->getPost('description_of_incident');
        

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->generateComplaint($query);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }



    public function document_generator()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/document-generator/document_generator_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/document-generator',compact('data','db','row'));
        else
            return view('backend/gemini/document-generator',compact('data','db','row'));
    }
    public function document_generator_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $document_type = $this->request->getPost('document_type');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];

        $query['query'] = $comment;
        $query['type'] = $document_type;

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->generateLegalDocument($document_type, $comment);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }





    public function document_analyzer()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/document-analyzer/document_analyzer_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/document-analyzer',compact('data','db','row'));
        else
            return view('backend/gemini/document-analyzer',compact('data','db','row'));
    }
    public function document_analyzer_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $Jurisdiction = $this->request->getPost('Jurisdiction');
        $ResearchType = $this->request->getPost('ResearchType');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];    

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->analyzeLegalDocument($comment);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }







    public function law_news()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/law-news/law_news_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/law-news',compact('data','db','row'));
        else
            return view('backend/gemini/law-news',compact('data','db','row'));
    }
    public function law_news_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $Jurisdiction = $this->request->getPost('Jurisdiction');
        $ResearchType = $this->request->getPost('ResearchType');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];    

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->getLegalNews($comment);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }





    public function legal_acts()
    {
        $session = session()->get('user');
        $vendor_id = $session['id'];
        $role = $session['role'];

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "Manage ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);      
        $data['actionUrl'] = $data['route'].'/gemini/legal-acts/legal_acts_action';
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;

        $row = [];

        if(!in_array($role, [1,6]))
            return view($this->arr_values['folder_name'].'/legal-acts',compact('data','db','row'));
        else
            return view('backend/gemini/legal-acts',compact('data','db','row'));
    }
    public function legal_acts_action()
    {
        $session = session()->get('user');
        $user_id = $session['id'];

        $comment = $this->request->getPost('comment');
        $Jurisdiction = $this->request->getPost('Jurisdiction');
        $ResearchType = $this->request->getPost('ResearchType');

        $data['title'] = "".$this->arr_values['title'];
        $data['page_title'] = "AI ".$this->arr_values['page_title'];
        $data['upload_path'] = $this->arr_values['upload_path'];
        $data['route'] = base_url($this->arr_values['routename']);
        $data['pagenation'] = array($this->arr_values['title']);

        $db = $this->db;
        $row = [];    

        $GeminiModel = new GeminiModel();
        $response = $GeminiModel->getLegalNews($comment);

        $responseCode = 200;
        $result['status'] = $responseCode;
        $result['message'] = $response;
        $result['action'] = 'view';
        $result['data'] = [];
        return $this->response->setStatusCode($responseCode)->setJSON($result);         
    }



   
    
    

}