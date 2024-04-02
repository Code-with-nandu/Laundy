<?php
defined('BASEPATH') or exit('No direct script access allowed');


class LoginController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('UserModel');
    }

    public function index()
    {
        $this->load->view('template/header.php');
        $this->load->view('auth/loginView.php');
        $this->load->view('template/footer.php');
    }
    public function login()
    {
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) 
        {
            $this->index();
        } 


        else {
            $data = [
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            ];
            $user = new UserModel;
            $result = $user->loginUser($data);


            // if ($result != FALSE) {
            //     echo $result->first_name;
            if ($result != FALSE) {
                
                $auth_userdetils =[
                    'first_name'=> $result->first_name,
                    'last_name'=> $result->last_name,
                    'email'=> $result->email,
                ];
                $this->session->set_userdata('authenticated','1');
                $this->session->set_userdata('auth_user',$auth_userdetils);
                $this->session->set_flashdata('status', 'You are Logged in sucessfully');
                redirect(base_url('userpage'));
           
            } else {
                $this->session->set_flashdata('status', 'Invalid Email ID or password');
                redirect(base_url('login'));
            }
          
        }
        public function git ()
        {
            
        }

    }








}


