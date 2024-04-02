<?php  date_default_timezone_set('Asia/Kolkata');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 header("Cache-Control: no-cache");
 header("Pragma: no-cache");

/*
if($_SERVER['REMOTE_ADDR']!="115.248.178.34")
	{
   // die("<Center><h1><br><br><br>Ashram Network Missing</h1></center>");
	}
	*/

  $CI =& get_instance();
  // require_once '/var/www/html/ekam/Mobile_Detect.php';$detect = new Mobile_Detect;
  $CI->load->library('Mobile_Detect');

  $detect = new Mobile_Detect();
  if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) 
  {
    //die("<Center><h1><br><br><br><h1 style='color:red;'><p>Mobiles and Tablets are not enabled on this site.</p></h3></h1></center>");
  } 
        

 ?><!DOCTYPE html>
<html lang="en">
  <head>
    	<meta charset="utf-8">
    	<link rel="apple-touch-icon" sizes="57x57" href="<? echo base_url(); ?>ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<? echo base_url(); ?>ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<? echo base_url(); ?>ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<? echo base_url(); ?>ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<? echo base_url(); ?>ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<? echo base_url(); ?>ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<? echo base_url(); ?>ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<? echo base_url(); ?>ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<? echo base_url(); ?>ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<? echo base_url(); ?>ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<? echo base_url(); ?>ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<? echo base_url(); ?>ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<? echo base_url(); ?>ico/favicon-16x16.png">
	<link rel="manifest" href="<? echo base_url(); ?>ico/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<? echo base_url(); ?>ico/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	    <link rel="shortcut icon" href="<? echo base_url(); ?>ico/favicon-96x96.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<?php
//$title = " Art of Living Initiative";
//$bkcolor = "lightblue";
?>
    <title>Ekam - <?=$title?></title>

    <!-- Bootstrap core CSS -->
    <link href="<? echo  base_url();?>css/bootstrap-orange.min.css" rel="stylesheet">
 
 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<? echo base_url(); ?>js/html5shiv.js"></script>
      <script src="<? echo base_url(); ?>js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    	body {
	  padding-top: 60px;
	  padding-bottom: 40px;
	  background-color: <?=$bkcolor?>;
	}
    </style>
<? /*
	  <!--Start of Tawk.to Script-->
	  <script type="text/javascript">
	  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	  (function(){
	  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	  s1.async=true;
	  s1.src='https://embed.tawk.to/5778595f933846b0261606db/default';
	  s1.charset='UTF-8';
	  s1.setAttribute('crossorigin','*');
	  s0.parentNode.insertBefore(s1,s0);
	  })();
	  </script>
	  <!--End of Tawk.to Script-->
	  */ ?>
    