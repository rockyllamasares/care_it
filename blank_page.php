<?php
	require_once("functions/connections/connection.php");
    if (!isset($_SESSION)){ session_start(); }
    error_reporting(E_ALL ^ E_ALL);
	
	$_SESSION['user_id'] = NULL;
	$_SESSION['fullname'] = NULL;
	$_SESSION['user_type'] = NULL;
	$_SESSION['photo_path'] = NULL;
	
	if(isset($_POST['cmdSignIn'])) {
		$ssql = "SELECT `user_id`, `user_type`, username FROM `tblusers` WHERE `user_id` = '".$_POST['ver_code']."' and verified = '0'";
		$inn = $data_result->executeSQL($ssql,"icare");
		$rs = mysqli_fetch_array($inn);
		if($rs!=0) { 
			$_SESSION['user_id'] = $rs['user_id'];
			$_SESSION['user_type'] = $rs['user_type'];
			
			$ssql = "UPDATE `tblusers` SET `verified`=1 WHERE `user_id` = '".$_POST['ver_code']."'";
			$data_result->executeSQL($ssql,"icare");
			
			echo "<script>self.location = 'pages/?menu_id=".$_SESSION['user_type']."&sub_menu_id=1';</script>";
		} else {
			echo '<script>alert("Incorrect verification code!");</script>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>iCare</title>
		<link rel="icon" type="image/png" href=""/>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="templates/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/plugins/iCheck/square/blue.css">
		
		<link href="images/logo.png" rel="icon">
		<!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"-->
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo"><a href="index.html"><b>i</b>Care</a></div>
			<div class="login-box-body">
				<p class="login-box-msg">Enter your verification code</p>
				<form action="" method="POST">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="" name="ver_code">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat" name="cmdSignIn">Verify</button>
						</div>
					</div>
				</form>
				<!--
				<div class="social-auth-links text-center">
					<p>- OR -</p>
					<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
					<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
				</div>
				<a href="#">I forgot my password</a><br>
				<a href="register.html" class="text-center">Register a new membership</a>
				--->
			</div>
		</div>
		<script src="templates/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="templates/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="templates/AdminLTE/plugins/iCheck/icheck.min.js"></script>
		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' /* optional */
				});
			});
		</script>
	</body>
</html>
