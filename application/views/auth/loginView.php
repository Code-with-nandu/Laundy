
<style>
   
    .background-div {
    width: 100%;
    height: 850px; /* You can adjust the height as needed */
    background: url("https://i.pinimg.com/564x/0e/58/17/0e5817b2f5a8e955103255569de24896.jpg") no-repeat center center;
    background-size: cover; /* This ensures the background image covers the entire div */
  }


</style>

 <!-- storing the data -->
 <?php if ($this->session->flashdata('status')) : ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('status'); ?>
                    </div>


                <?php endif; ?>
</header>
    <div class="background-div">
	<h1 class="text-center" style="color:white; margin-top: 70px; " >Divine Laundry Service AOL BANGALORE</h1>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="form">


                        <center>
                            <img src="https://i.pinimg.com/236x/4d/a8/bb/4da8bb993057c69a85b9b6f2775c9df2.jpg" alt="profile" width="70">
                        </center>


						<center>
							<small> Sign In</small>
						</center>
					
						
						<div class="card-body">
						<form action="<?php echo base_url('login') ;?>" method="post">
                        <div class="form-group">
                            <label for="">Email Address </label>
                            <input type="text" name="email" class="form-control" placeholder="Enter Email Address">
							<small><?php echo form_error('email'); ?></small>

                           
                        </div>


                        <div class="form-group">
                            <label for="">Password </label>
                            <input type="text" name="password" class="form-control" placeholder="Enter password">
							<small><?php echo form_error('password') ?></small>
                       
                        </div>
                        <hr>
                        <div class="form-group" >
                            <button type="submit" class="btn btn-success">Login</button>
							
                        </div>

						
                    </form>
					
                


                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
