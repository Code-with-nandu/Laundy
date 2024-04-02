<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class UserController extends CI_Controller {


    
    
    public function index()
    {
        $this->load->view('template/header.php');
        $this->load->view('auth/userpageView.php');
        $this->load->view('template/footer.php');
    }
    
}
