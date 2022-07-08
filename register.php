<?php
	require_once("functions/connections/connection.php");
    if (!isset($_SESSION)){ session_start(); }
    error_reporting(E_ALL ^ E_ALL);
	function right($str, $length) { return substr($str, -$length); }
	
	if(isset($_POST['cmdSignUp'])) {
		$fullname = $_POST['lname'].', '.$_POST['fname'].' '.$_POST['mname'];
		$ver_code = "";
		
		if($_POST['account_type'] == "1") {
			$patient_id = "";
			
			$ssql = "SELECT `patient_id` FROM `tblpatient` ORDER BY `patient_id` DESC";
			$inn = $data_result->executeSQL($ssql,"icare");
			$rs = mysqli_fetch_array($inn);
			if($rs!=0) {
				$patient_id = right($rs['patient_id'],5);
				$patient_id = $patient_id + 1;
				$patient_id = 'U'.date('md').$patient_id;
			} else {
				$patient_id = 'U'.date('md')."10001";
			}
			
			$ssql = "INSERT INTO `tblpatient`(`patient_id`, `fullname`, `fname`, `mname`, `lname`, `contact_no`, `email_address`, `street`, `barangay`, `city_municipality`, `province`, postal_code) VALUES ('".$patient_id."', '".$fullname."', '".$_POST['fname']."', '".$_POST['mname']."', '".$_POST['lname']."', '".$_POST['contact_no']."', '".$_POST['email_address']."', '".$_POST['street']."', '".$_POST['barangay']."', '".$_POST['city_municipality']."', '".$_POST['province']."', '".$_POST['postal_code']."')";
			$data_result->executeSQL($ssql,"icare");
			
			$ssql = "INSERT INTO `tblusers`(`user_id`, `username`, `password`, `user_type`) VALUES ('".$patient_id."', '".$_POST['email_address']."', '".$_POST['password']."', '".$_POST['account_type']."')";
			$data_result->executeSQL($ssql,"icare");
			
			if(isset($_FILES['image'])){
				$errors= array();
				$file_name = $_FILES['image']['name'];
				$file_size = $_FILES['image']['size'];
				$file_tmp = $_FILES['image']['tmp_name'];
				$file_type = $_FILES['image']['type'];
				$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

				$extensions= array("jpeg","jpg","png");

				if(in_array($file_ext,$extensions)=== false){
				 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
				}

				if($file_size > 2097152){
				 $errors[]='File size must be excately 2 MB';
				}

				if(empty($errors)==true){  
				move_uploaded_file($file_tmp,"/images/user/".$file_name);
				 
				$ssql = "UPDATE `tblpatient` SET `photo_path`='".$file_name."' WHERE `patient_id` = '".$patient_id."'";
				$data_result->executeSQL($ssql,"icare");

				}else{
				 print_r($errors);
				}
			}
			$ver_code = $patient_id;
		} else {
			$doc_id = "";
			
			$ssql = "SELECT `doc_id` FROM `tbldoctors` ORDER BY `doc_id` DESC";
			$inn = $data_result->executeSQL($ssql,"icare");
			$rs = mysqli_fetch_array($inn);
			if($rs!=0) {
				$doc_id = right($rs['doc_id'],5);
				$doc_id = $doc_id + 1;
				$doc_id = 'D'.date('md').$doc_id;
			} else {
				$doc_id = 'D'.date('md')."10001";
			}
			
			$ssql = "INSERT INTO `tbldoctors`(`doc_id`, `fullname`, `fname`, `mname`, `lname`, `contact_no`, `email_address`, `street`, `barangay`, `city_municipality`, `province`, postal_code, specialist_id) VALUES ('".$doc_id."', '".$fullname."', '".$_POST['fname']."', '".$_POST['mname']."', '".$_POST['lname']."', '".$_POST['contact_no']."', '".$_POST['email_address']."', '".$_POST['street']."', '".$_POST['barangay']."', '".$_POST['city_municipality']."', '".$_POST['province']."', '".$_POST['postal_code']."', '".$_POST['specialist_id']."')";
			//echo $ssql;
			$data_result->executeSQL($ssql,"icare");
			
			$ssql = "INSERT INTO `tblusers`(`user_id`, `username`, `password`, `user_type`) VALUES ('".$doc_id."', '".$_POST['email_address']."', '".$_POST['password']."', '".$_POST['account_type']."')";
			//echo $ssql;
			$data_result->executeSQL($ssql,"icare");
			
			if(isset($_FILES['image'])){
				$errors= array();
				$file_name = $_FILES['image']['name'];
				$file_size = $_FILES['image']['size'];
				$file_tmp = $_FILES['image']['tmp_name'];
				$file_type = $_FILES['image']['type'];
				$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

				$extensions= array("jpeg","jpg","png");

				// if(in_array($file_ext,$extensions)=== false){
				 // $errors[]="extension not allowed, please choose a JPEG or PNG file.";
				// }

				// if($file_size > 2097152){
				 // $errors[]='File size must be excately 2 MB';
				// }

				// if(empty($errors)==true){  
				move_uploaded_file($file_tmp,"/images/doctors/".$file_name);
				 
				$ssql = "UPDATE `tbldoctors` SET `photo_path`='".$file_name."' WHERE `doc_id` = '".$doc_id."'";
				$data_result->executeSQL($ssql,"icare");

				// }else{
				 // print_r($errors);
				// }
			}
			$ver_code = $doc_id;
		}
		
		
		echo '<script>alert("Success!");</script>';
		echo "<script>self.location = 'sendemail/send_email.php?email_address=".$_POST['email_address']."&verification_code=".$ver_code."';</script>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>CARE-it</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="templates/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="templates/AdminLTE/plugins/iCheck/square/blue.css">
		
		<link href="images/logo.png" rel="icon">
	</head>
	<body class="hold-transition register-page">
		<div class="register-box" style="width:700px !important;">
			<div class="register-logo"><a href="index.php"><img src="images/banner.png"></a></div>

		  <div class="register-box-body">
			<p class="login-box-msg">Sign Up for new membership</p>

			<form method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-xs-12">
						<div class="col-xs-4" style="padding:2px;">
							<small><b>Account Type</b></small>
							<select class="form-control" required="true" id="account_type" name = "account_type" OnChange="fChangerChoice()">
								<?php if($_GET['id'] == 1) { ?><option value="1">Patient</option> <?php } ?>
								<?php if($_GET['id'] == 2) { ?><option value="2">Doctor</option> <?php } ?>
							</select>
						</div>
						<div class="col-xs-8" style="padding:2px;" id="doctorList" <?php if($_GET['id'] == 1) { ?> hidden <?php } ?>>
							<small><b>Specialist of</b></small>
							<select class="form-control" name="specialist_id">
								<option value="">Select</option>
								<?php 
									$ssql = "SELECT `specialist_name` FROM `tblspecialist` ORDER BY `specialist_name` ASC";
									$result = $data_result->executeSQL($ssql,"icare");
									while($row = mysqli_fetch_array($result))
									{
										?>
											<option value="<?php echo $row['specialist_name']?>"><?php echo strtoupper($row['specialist_name'])?></option>
										<?php
									}
								?>
							</select>
						</div>
						<span style="float:left; width:100%; padding:5px;"></span>
						<div class="col-xs-4" style="padding:2px;">
							<small><b>First Name</b></small>
							<input type="text" class="form-control" name="fname" required="true">
						</div>
						<div class="col-xs-4" style="padding:2px;">
							<small><b>Middle Initial</b></small>
							<input type="text" class="form-control" name="mname" required="true">
						</div>
						<div class="col-xs-4" style="padding:2px;">
							<small><b>Last Name</b></small>
							<input type="text" class="form-control" name="lname" required="true">
						</div>
						<span style="float:left; width:100%; padding:5px;"></span>
						
						<span style="float:left; width:100%; padding:5px; text-align:center;">Permanent Address</span>
						<div class="col-xs-6" style="padding:2px;">
							<small><b>Street</b></small>
							<input type="text" class="form-control" name="street" required="true">
						</div>
						<div class="col-xs-6" style="padding:2px;">
							<small><b>Barangay</b></small>
							<input type="text" class="form-control" name="barangay" required="true">
						</div>
						<span style="float:left; width:100%; padding:5px;"></span>
						<div class="col-xs-4"style="padding:2px;">
							<small><b>City / Municipality</b></small>
							<input type="text" class="form-control" name="city_municipality" required="true">
						</div>
						<div class="col-xs-4" style="padding:2px;">
							<small><b>Province</b></small>
							<input type="text" class="form-control" name="province" required="true">
						</div>
						<div class="col-xs-4" style="padding:2px;">
							<small><b>Postal Code</b></small>
							<input type="text" class="form-control" name="postal_code" required="true">
						</div>
						<span style="float:left; width:100%; padding:5px;"></span>
						<div class="col-xs-8" style="padding:2px;">
							<small><b>Email Address</b></small>
							<input type="text" class="form-control" name="email_address" required="true">
						</div>
						<div class="col-xs-4" style="padding:2px;">
							<small><b>Contact No</b></small>
							<input type="text" class="form-control" name="contact_no" required="true">
						</div>
						<div class="col-xs-6" style="padding:2px;">
							<small><b>Password</b></small>
							<input type="password" class="form-control" name="password" required="true">
						</div>
						<div class="col-xs-6" style="padding:2px;">
							<small><b>Re-enter Password</b></small>
							<input type="password" class="form-control" name="" required="true">
						</div>
						<span style="float:left; width:100%; padding:5px;"></span>
						<div class="col-xs-12" style="padding:2px;">
							<small><b>Upload Photo</b></small>
							<input type="file" name="image" class="form-control" required="true">
						</div>
						<span style="float:left; width:100%; padding:5px;"></span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
							  <input type="checkbox"> I agree to the <a href="#">terms</a>
							</label>
						</div>
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat" name="cmdSignUp">Sign Up</button>
					</div>
				</div>
			</form>

			<center>
				<?php
					if($_GET['id'] == "1") {
						?><a href="login.php?id=1" class="text-center">I already have an account?</a><?php
					} else {
						?><a href="login.php?id=2" class="text-center">I already have an account?</a><?php
					}
				?>
			</center>
		  </div>
		  <!-- /.form-box -->
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
			  
			function fChangerChoice() {
				if($('#account_type').val() == "1") {
					$('#userList').show();
					$('#doctorList').hide();
				} else {
					$('#userList').hide();
					$('#doctorList').show();
				}
			}
		</script>
	</body>
</html>
