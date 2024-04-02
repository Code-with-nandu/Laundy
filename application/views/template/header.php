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
	<style>
		*,
		html {
			scroll-behavior: smooth;
		}

		*,
		*:after,
		*:before {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}

		:root {
			scrollbar-color: rgb(210, 210, 210) rgb(46, 54, 69) !important;
			scrollbar-width: thin !important;
		}

		::-webkit-scrollbar {
			height: 12px;
			width: 8px;
			background: #000;
		}

		::-webkit-scrollbar-thumb {
			background: gray;
			-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
		}

		::-webkit-scrollbar-corner {
			background: #000;
		}



		@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap");

		* {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
			font-family: "Poppins", sans-serif;
			text-decoration: none;
			font-weight: bold;
			color: #363636;
		}

		::-webkit-scrollbar {
			display: none;
		}

		::selection {
			background: 0;
		}

		*/

		/*DEFAULT*/
		body {
			margin: 0;
			overflow-x: hidden;
			font-family: 'Source Sans Pro', sans-serif;
		}

		a {
			text-decoration: none;
			transition: 0.5s;
		}








		/*ANIMATION*/
		@-webkit-keyframes slideIn {
			from {
				bottom: -300px;
				opacity: 0
			}

			to {
				bottom: -140px;
				opacity: 1
			}
		}

		@keyframes slideIn {
			from {
				bottom: -300px;
				opacity: 0
			}

			to {
				bottom: -140px;
				opacity: 1
			}
		}

		@-webkit-keyframes fadeIn {
			from {
				opacity: 0
			}

			to {
				opacity: 1
			}
		}

		@keyframes fadeIn {
			from {
				opacity: 0
			}

			to {
				opacity: 1
			}
		}



		.animate {
			-webkit-animation: animatezoom 0.6s;
			animation: animatezoom 0.6s
		}

		@-webkit-keyframes animatezoom {
			from {
				-webkit-transform: scale(0)
			}

			to {
				-webkit-transform: scale(1)
			}
		}

		@keyframes animatezoom {
			from {
				transform: scale(0)
			}

			to {
				transform: scale(1)
			}
		}


		.banner {

			/* background-color: skyblue; */

			background-color: #f1c40f;
			width: 100%;
			padding: 10px 0;
		}

		.banner .section-right {
			float: right;


		}

		.banner a {
			margin: 0 10px;
			color: #000;
		}



		.logo {
			background: #f1c40f;
			color: #000;
			padding: 25px;
			width: 230px;
			position: absolute;
			left: -20px;
			top: 30px;

			max-width: 100%;
			height: auto;
		}

		.logo img {
			width: 180px;
			height: 25px;
		}

		.parallelogram {
			transform: skew(-20deg);
		}

		.skew-fix {
			width: 60%;
			display: inline-block;
			transform: skew(20deg);
		}


		@media (max-width:820px) {
			.banner .section-right {
				float: none;
				width: 100%;
			}

			.banner .section-left {
				display: none;
				float: left;
				font-size: medium;

			}
		}


		@media (max-width:820px) {
			.parallelogram {
				transform: skew(-20deg);
				/* display: none; */
				/* float: left; */
				float: none;
			}
		}

		/*NAVIGATION*/
		.topnav {
			overflow: hidden;
			background-color: #000;
			/* height: 100%; */
		}

		.topnav a {
			float: left;
			display: block;
			color: #f2f2f2;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			font-size: 17px;
		}

		.active {
			color: #f1c40f;
			margin-left: 250px;
		}

		.topnav .icon {
			display: none;
			outline: none !important;
		}

		.dropdown {
			float: left;
			/* overflow: hidden; */
		}

		.dropdown .dropbtn {
			font-size: 17px;
			border: none;
			outline: none;
			color: white;
			padding: 14px 16px;
			background-color: inherit;
			font-family: inherit;
			margin: 0;
		}

		.dropdown-content {
			overflow: hidden;
			display: none;
			position: absolute;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			border-top: 2px solid #f1c40f;
			z-index: 1;
			-webkit-animation-name: slideIn;
			-webkit-animation-duration: 1s;
			animation-name: slideIn;
			animation-duration: 1s;
		}

		.dropdown-content a {
			float: none;
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
			text-align: left;
		}

		.topnav a:hover,
		.dropdown:hover .dropbtn {
			color: #f1c40f;
		}

		.dropdown-content a:hover {
			background-color: #ddd;
			color: black;
		}

		.dropdown:hover .dropdown-content {
			display: block;
		}

		@media screen and (max-width: 820px) {
			.dropdown-content {
				-webkit-animation-name: none;
				-webkit-animation-duration: 1s;
				animation-name: none;
				animation-duration: 1s;
			}

			.topnav a,
			.dropdown .dropbtn {
				display: none;
			}

			.topnav a.icon {
				float: right;
				display: block;
			}
		}

		@media screen and (max-width: 820px) {
			.active {
				margin-left: 0;
			}

			.topnav {
				height: 50px;
				width: 100%;
				transition: 0.5s;
			}

			.topnav.responsive {
				position: relative;
				height: 70vh;
				overflow-y: auto;
			}

			.topnav.responsive .icon {
				position: absolute;
				right: 0;
				top: 0;
			}

			.topnav.responsive a {
				float: none;
				display: block;
				text-align: left;
			}

			.topnav.responsive .dropdown {
				float: none;
			}

			.topnav.responsive .dropdown-content {
				position: relative;
			}

			.topnav.responsive .dropdown .dropbtn {
				display: block;
				width: 100%;
				text-align: left;
			}
		}






		* {
			box-sizing: border-box;
		}

		body {
			font-family: "Lato", sans-serif;
			line-height: 1.25;
			background-color: #f4f4f4;
			color: #2a2a2a;
			font-weight: 500;
		}



		h1 {
			text-align: center;
		}

		button {
			font-size: 1rem;
			padding: 0.35em 0.75em;
			line-height: 1;
			background-color: transparent;
			border: 0.125rem solid #2a2a2a;
			border-radius: 2rem;
			cursor: pointer;
			transition: 0.1s;
			outline: 0;
		}

		button:hover {
			background-color: #2a2a2a;
			color: #fff;
		}

		button .fa {
			font-size: 0.75em;
			margin-left: 0.5em;
		}

		button.btn--primary {
			border-color: #042A4F;
			color: #042A4F;
		}

		button.btn--primary:hover {
			background-color: #042A4F;
			color: #fff;
		}

		button.btn--accent {
			border-color: #E65891;
			color: #E65891;
		}

		button.btn--accent:hover {
			background-color: #E65891;
			color: #fff;
		}

		.posts {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-gap: 2.5rem;
		}

		@media (max-width: 1140px) {
			.posts {
				grid-template-columns: repeat(2, 1fr);
			}
		}

		@media (max-width: 768px) {
			.posts {
				grid-template-columns: repeat(1, 1fr);
			}
		}

		.post__image {
			width: 100%;
			height: 240px;
			position: relative;
			overflow: hidden;
		}

		.post__image:before,
		.post__image:after {
			content: "";
			display: block;
			position: absolute;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			width: 100%;
			height: 100%;
		}

		.post__image:before {
			background-size: cover;
			background-position: center center;
			transform: scale(1);
			filter: blur(0);
			transition: 2s cubic-bezier(0, 0.6, 0.2, 1);
		}

		.post__image:after {
			background: linear-gradient(30deg, #042A4F 0%, #E65891 100%);
			background-size: 100% 300%;
			background-position: bottom left;
			opacity: 0.15;
			transition: 2s cubic-bezier(0, 0.6, 0.2, 1);
		}

		.post__image--1:before {
			background-image: url("https://images.unsplash.com/photo-1510951459752-aac634df6e86?h=240&ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=50bdf8b5068e794a82c849cc7e269ed3");
		}

		.post__image--2:before {
			background-image: url("https://images.unsplash.com/photo-1529392960549-df4af50eac23?h=240&ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=b482040f9d3a25a5e5352948f68f3a0e");
		}

		.post__image--3:before {
			background-image: url("https://images.unsplash.com/photo-1506258998-82810ddc75a3?h=240&ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=68da264c24bc024a0b2ff92c349e89ed");
		}

		.post__image--4:before {
			background-image: url("https://images.unsplash.com/photo-1520875777965-f99b03dc86e8?h=240&ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=34ff37a297e7e9e7be972356103b6750");
		}

		.post__image--5:before {
			background-image: url("https://images.unsplash.com/photo-1527664557558-a2b352fcf203?h=240&ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=d06ac80d600822cb010987a6af4ff02a");
		}

		.post__image--6:before {
			background-image: url("https://images.unsplash.com/photo-1507679799987-c73779587ccf?h=240&ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=f982b6bf45d8a72d038b60a010e16767");
		}

		.post__content {
			margin: -3rem 1.5rem 0;
			padding: 1.5rem;
			background-color: #fff;
			border-radius: 3px;
			box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
			transition: margin 0.2s ease-in-out;
			position: relative;
			z-index: 1;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		.post__inside {
			overflow: hidden;
			height: 4.85rem;
			transition: height 0.2s ease-in-out;
		}

		.post__title {
			font-size: 1.35rem;
			line-height: 1;
			margin: 0 0 1rem;
			font-weight: 300;
			color: #042A4F;
		}

		.post__excerpt {
			overflow: hidden;
			margin: 0;
			max-height: 6.25rem;
			position: relative;
		}

		.post__button {
			margin-top: 1rem;
		}

		/* ====== HOVER ====== */
		.post:hover .post__content {
			margin-top: -9.8rem;
		}

		.post:hover .post__inside {
			height: 11.65rem;
		}

		.post:hover .post__image:after {
			opacity: 0.5;
		}

		.post:hover .post__image:before {
			transform: scale(1.1);
			filter: blur(10px);
		}




		#image_div_id {
			height: 320px;
		}



		body {
			margin: 0px;
			padding: 0px;
			/* width: 100%; */
			/* min-height: 450px; */
			/* height: 100vh; */
			/* overflow: scroll; */
			/* background: url("https://i.pinimg.com/564x/0e/58/17/0e5817b2f5a8e955103255569de24896.jpg") no-repeat center center;
			background-size: cover;
			backdrop-filter: blur(7px);
			display: grid; */
			/* place-content: center; */
		}

	



		.footer {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 65px;
			/* Set a fixed height */
			background-color: #f1c40f;
			color: #000;
			border-top: 1px solid #ddd;
			padding: 10px;
			text-align: center;
		}


		.footer p {
			font-size: medium;
			color: black;
			text-align: center;
			padding: 10px;
			border-bottom: #000;


		}





		.container {
			width: 100%;
			/* min-height: 320px; */
			display: flex;
			justify-content: center;
			align-items: center;
			/* height: 100vh; */
			margin-top: 150px;
			/* margin: auto; */
			padding: 60px;



		}





		@media (max-width: 820px) {
			.container {
				width: auto;
				display: flex;
				float: none;
				margin-top: 94px;
				justify-content: center;

			}
		}

		@media (max-width: 640px) {
			.container {
				width: auto;
				width: 100%;
				display: flex;
				justify-content: center;
				height: 76vh;

				padding: 80px 0px;
			}
		}

		.form {
			max-height: 420px;
			height: 100%;
			width: 100%;

			/* margin: 50%; */
			background: #fff;
			/* display: flex; */
			flex-direction: column;
			align-items: center;
			justify-content: center;
			border-radius: 30px;
			padding: 20px 20px;
			background-color: #f8f9fa;
			position: relative;
		}



		.form img {
			pointer-events: none;
			align-items: center;
			justify-content: center;
			margin: 45px 0 20px;
			height: 70px;
			border-radius: 50%;
			box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
		}

		.container {
			width: 100%;
			padding: 0 20px;
			/* Add some horizontal padding */
		}

		.form {
			max-width: 400px;
			/* Limit the width of the form */
			margin: auto;
			/* Center the form horizontally */
			padding: 20px;
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		.form img {
			margin-bottom: 20px;
		}

		form p {
			margin-bottom: 20px;
			/* Add some vertical spacing between inputs */
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

		button[type="submit"] {
			width: 100%;
			padding: 10px;
			border: none;
			border-radius: 5px;
			background-color: #1663be;
			color: #fff;
			cursor: pointer;
		}
	</style>


	<!-- partial:index.partial.html -->
	<title>MenuBar</title>

	<!--META TAG-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!--EXTERNAL CSS-->
	<link rel="stylesheet" href="css/style.css">

	<link rel="stylesheet" href="css/style.css">

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