<div class="topnav" id="myTopnav">
	<a href="#" class="active"></a>
	<a href="#gallery"></a>

	<a href="<?= base_url() ?>">Ekam</a>
	<a class="nav-link" href="<?php echo base_url('userpage'); ?>">User-Page</a>
	<a class="nav-link" href="<?php echo base_url('adminpage'); ?>">Admin Page</a>

	<!-- Register button and log in button does not see -->
	<?php if (!$this->session->has_userdata('authenticated')) { ?>
		<a class="nav-link" href="<?php echo base_url('register'); ?>">Register</a>
		<a class="nav-link " href="<?php echo base_url('login'); ?>">Login</a>
	<?php } ?>

	<!-- For hidden after successfully log in -->
	<?php if ($this->session->has_userdata('authenticated')== TRUE) { ?>
		<!-- User name Create: -->
	<a class="nav-link " href="<?php echo base_url('login'); ?>">User:
		<?= $this->session->userdata('auth_user')['first_name']; ?>
		<?= $this->session->userdata('auth_user')['last_name']; ?>
     </a>

	 <a class="nav-link " href="<?php echo base_url('logout'); ?>">Logout</a>
	<?php } ?>

	<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>