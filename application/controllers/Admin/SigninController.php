<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller {

   public function __construct()
   {
      session_start();
      parent::__construct();
      /*
      $this->load->library('user_agent');
      if (!$this->agent->is_browser('Firefox'))
      {
         // echo '<h1>You are using '.$this->agent->browser(). " <hr> ONLY Firefox browser is allowed!</h1>";
         // die();
      }
      */

   }

   public function index($msg="")
     {
     
  
     
      if ( isset($_SESSION['username']) &&  isset($_SESSION['public'])  )  
        {   // Public user already logged in
           redirect('public/user'); 
        }
      else if ( isset($_SESSION['username']) &&  isset($_SESSION['department'])  ) 
        {   // ASHRAM user already logged in
          /*
            if($_SESSION['department']=="housing")
            {
              redirect('housing/visitor/search'); 
            }
            else
              */
           redirect($_SESSION['department'].'/user'); 
        }
 

      $this->load->library('form_validation');
      $this->form_validation->set_rules('email_address', 'Email Address', 'valid_email|required');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
      $this->form_validation->set_rules('ashram', 'Ashram', 'required|min_length[4]|numeric');


      if(!isset($_SESSION['failedattempts'])) 
        $_SESSION['failedattempts']=0;

      if($_SESSION['failedattempts']<=9)
      {

      if ( $this->form_validation->run() !== false ) {
         // then validation passed. Get from db          die("@28");
         
         $this->load->model('login_model');
        
         $res = $this
                  ->login_model
                  ->verify_user(
                     $this->input->post('email_address'),
                     $this->input->post('password'),
                     $this->input->post('ashram')
                  );

          //echo "<pre> 64"; print_r($res);die();

         if ( $res !== false ) 
         {
            $_SESSION['username'] = $this->input->post('email_address');
            $_SESSION["type"] 	  = $res['type']; //USER TYPE
            $_SESSION["rights"]   	= $res['rights']; //USER RIGHTS
            $_SESSION["first_name"] 	= $res['first_name']; //USER First Name
            $_SESSION["last_name"]	= $res['last_name']; //USER Last Name
            $_SESSION["userid"]   = $res['id']; //USER ID
            $_SESSION["m_ashram_id"]   = $res['m_ashram_id']; //ASHRAM ID
            $_SESSION["mobile"]   = $res['mobile']; //mobile number

          
             if($res['status'] == "active")
             {
                  $_SESSION["department"] = $res['department'];
                  $_SESSION["ashram"] = $this->input->post('ashram');
 
              	//print_r($_SESSION); die();
                  /*
                  
                    if($_SESSION['department']=="housing") 
                        redirect('housing/visitor/search'); 
                    else
                      */
            	          redirect($_SESSION['department'].'/user'); 
               }
          	else {
          	$msg  = "Your Account is not active. Please contact your supervisor";
          	      session_destroy();
          	}

         } // valid results
         else 
          {
            $_SESSION['failedattempts']++;
            $msg  = "Incorrect Credential. # ".$_SESSION['failedattempts'];
            
          }

      }// form validation
      
    }
    else 
    {
          $msg  = "Too many failed attempts. Try after few hours.";

    }
      
      
      //$this->load->model('ashram_model');
      //$ashramlist = $this->ashram_model->getList();
      //$data['ashramlist'] = $ashramlist;
      $data['msg'] = $msg; 
           
      

      $this->load->view('/v_signin',$data);
   }

   public function signout()
   {
      session_destroy();
      //$this->load->view('login_view');
            redirect('signin');
   }
   public function logout()
   {
      session_destroy();
      //$this->load->view('login_view');
            redirect('signin');
   }
}