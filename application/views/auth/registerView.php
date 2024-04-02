
<style>
        /* CSS for the error page */
       .card-body{
            background-image: url('<?php echo base_url("assets/img/background.jpg"); ?>');
            background-size:cover;
            background-position: center;
            font-family: Arial, sans-serif;
       background-repeat: no-repeat;
            text-align: center;
        }
        label,h1{
            color: white;
        }
        
    </style>
<h1 class="text-center" style="margin-top: 70px;" >Divine Laundry Service AOL BANGALORE</h1>
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