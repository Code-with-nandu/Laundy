Step:1.01
1. Codeigniter 3  nin Xampp
2. Rename the Folder name Laundry
3. Run the page  


http://localhost/2_Ashram/Laundry/










Create Page :1 (Data Insert In Table ) Reference Video (Part-17)





Create this page
 http://localhost/2_Ashram/Laundry/
http://localhost/2_Ashram/Laundry_2nd/















Step : 1.02
Route Create
 $route['register']['GET'] = 'Auth/RegisterController/index';






Step:1.03
Create Auth folder 
Create RegisterController.php


<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class RegisterController extends CI_Controller
{
    public function index()
    {
        $this->load->view('template/header.php');
        $this->load->view('auth/registerView.php');
        $this->load->view('template/footer.php');




    }
}
?>


    






Step:1:04
Create a template folder in View 
Create Header.php in the template folder
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- //bootstapmin.css add -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ;?>">
    <title>Laundry</title>
</head>
<body>




Create footer.php 


   <!-- bootstrap_min.js add -->
   
   <script src="<?php echo base_url('assets/js/bootstrap.min.js') ; ?>"></script>
   
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</body>
</html>






registerView.php created in the auth folder.
<h1>Welcome to Art Of Living International Center </h1>


Step:1.05
Run the page 
http://localhost/2_Ashram/Laundry/index.php/register
http://localhost/2_Ashram/Laundry_2nd/index.php/register









Step :1.06
Error Check: and Create task 👍

base_url problem
Index.php remove.
An uncaught Exception was encountered
Type: Error
Message: Call to undefined function base_url()
Filename: C:\xampp\htdocs\2_Ashram\Laundry\application\views\template\header.php
Line Number: 7
Backtrace:
File: C:\xampp\htdocs\2_Ashram\Laundry\application\controllers\Auth\RegisterController.php
Line: 9
Function: view
File: C:\xampp\htdocs\2_Ashram\Laundry\index.php
Line: 315
Function: require_once


Step:1.07
Base _url problem 
C:\xampp\htdocs\2_Ashram\Laundry\application\config\config.php
$config['base_url'] = 'http://localhost/2_Ashram/Laundry/';










Index.php remove from url 

(create.htacess in root)

.htaccess
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .* index.php/$0 [PT,L]








Run the page again 
http://localhost/2_Ashram/Laundry/register
http://localhost/2_Ashram/Laundry_2nd/register



Step 1.08
Error 
An uncaught Exception was encountered
Type: Error
Message: Call to undefined function base_url()
Filename: C:\xampp\htdocs\2_Ashram\Laundry\application\views\template\header.php
Line Number: 7
Backtrace:
File: C:\xampp\htdocs\2_Ashram\Laundry\application\controllers\Auth\RegisterController.php
Line: 9
Function: view
File: C:\xampp\htdocs\2_Ashram\Laundry\index.php
Line: 315
Function: require_once


Step :1.09
Call the chat Gpt


Q:The error "Call to undefined function base_url()" typically occurs in CodeIgniter 3
Ans: Or you can autoload it by modifying application/config/autoload.php:
$autoload['helper'] = array('url');




C:\xampp\htdocs\2_Ashram\Laundry\application\config\autoload.php


   $autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = array('url');




Step:1.10
Call the page again
http://localhost/2_Ashram/Laundry/register
http://localhost/2_Ashram/Laundry_2nd/register



Step:1.11
Registerview.php
<h1 class="text-center">Art Of Living Laundry Section</h1>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center">Regiter online by Gurudeb</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('register'); ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="<?= set_value('first_name')?>">
                                        <small><?= form_error('first_name'); ?></small>
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="<?= set_value('last_name') ?>" >
                                        <small><?= form_error('last_name'); ?></small>
                                    </div>
                                </div>




                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Email Address </label>
                                        <input type="text" name="email" class="form-control"  value="<?= set_value('email') ?>" >
                                        <small><?= form_error('email'); ?></small>
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="text" name="password" class="form-control">
                                        <small><?= form_error('password'); ?></small>
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Confirm Password</label>
                                        <input type="text" name="cpassword" class="form-control">
                                        <small><?= form_error('cpassword') ;?></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary px-5">Register Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







