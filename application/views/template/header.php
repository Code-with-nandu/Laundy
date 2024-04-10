<?php date_default_timezone_set('Asia/Kolkata'); // LAUNDRY
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- //bootstapmin.css add -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">



	<title>Loundry</title>
	<!-- <title><?= $data['title'] ?></title> -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	

	<!-- partial:index.partial.html -->
	<title>MenuBar</title>

	<!--META TAG-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!--EXTERNAL CSS-->
	<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css') ;?>">

	<!--GOOGLE FONTS-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400&display=swap" rel="stylesheet">

	<!--FONT AWESOME-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

</head>

<body>
	<div class="background-div">
		<header>
			<div class="banner">
				<span class="section-left">
					<a href="emailto:">info@vvmvp.org</a>
					<a href="tel:">+(91)-80 67262626</a>
				</span>
				<span class="section-right">
					<a href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
					<a href="#" title="Instagram"><i class="fa fa-instagram"></i></a>
					<a href="#" title="Twitter"><i class="fa fa-twitter"></i></a>
				</span>
			</div>

			<div class="logo parallelogram">
				<span class="skew-fix"><img src='<?php echo  base_url(); ?>/assets/img/logo.png' alt='Art of Living Logo' style='width:120px; height:60px;' /></span>>
			</div>
			<?php  include('navbar.php') ;?>