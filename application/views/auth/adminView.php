
<?php if($this->session->flashdata('status')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('status') ?>
                </div>


            <?php endif;?>

<h1>Welcome to Art of living Internanal Center</h1>
This is Art Of living Internamnal center,
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <div class="card">


                    <div class="card-header">
                        <h5>Admin Page</h5>
                    </div>
                    <div class="card-body">
                    <h6> You are in User Admin page </h6>
                    <div class="card-body">
                    <h6> You are in User Admin page </h6>
                     <h5>First Name :<?= $this ->session->userdata('auth_user')['first_name']; ?></h5>
                     <h5>Last Name : <?= $this ->session->userdata('auth_user')['last_name']; ?></h5>
                     <h5>Last Name : <?= $this ->session->userdata('auth_user')['email']; ?></h5>
                    </div>


                    </div>
                     
                    </div>


                    </div>


                </div>
            </div>
        </div>
    </div>
</div>