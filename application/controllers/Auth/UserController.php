<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class UserController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthenticationModel');
    }

    
    
    public function index()
    {
        $this->load->view('template/header.php');
        $this->load->view('auth/userpageView.php');
        $this->load->view('template/footer.php');
    }
    public function search()
    {
        $output = '';
        $query = '';
        $this->load->model('ajaxsearch_model');
        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
        $data = $this->ajaxsearch_model->fetch_data($query);
        $output .= '
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Country</th>
                </tr>
        ';
        if($data->num_rows() > 0)
        {
            foreach($data->result() as $row)
            {
                $output .= '
                <tr>
                    <td>'.$row->CustomerName.'</td>
                    <td>'.$row->Address.'</td>
                    <td>'.$row->City.'</td>
                    <td>'.$row->PostalCode.'</td>
                    <td>'.$row->Country.'</td>
                </tr>
                ';
            }
        }
        else
        {
            $output .= '<tr>
                            <td colspan="5">No Data Found</td>
                        </tr>';
        }
        $output .= '</table>';
        // $this->load->view('ajaxsearch');
        echo $output;
    }

}

    

