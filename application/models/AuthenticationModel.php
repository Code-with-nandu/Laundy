<?php
defined('BASEPATH') OR exit ('No Direct script Access Allowed ');
class AuthenticationModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->has_userdata('authenticated'))
        {
            if($this->session->userdata('authenticated') == '1')
            {
                // echo "you are user";
            }


        }
        else
        {
            $this->session->set_flashdata('stataus','Login First');
            redirect(base_url('login'));
        }
    }
}


?>
