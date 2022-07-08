<?php
	require_once("../functions/connections/connection.php");
    if (!isset($_SESSION)){ session_start(); }
    error_reporting(E_ALL ^ E_ALL);
	
	date_default_timezone_set('Asia/Manila');
	
	if($_SESSION['user_id'] == NULL || $_SESSION['user_id'] == "") { 
		header("location: ../"); 
	}
	
	function left($str, $length) { return substr($str, 0, $length); }
	function right($str, $length) { return substr($str, -$length); }
	
	//$photo_path = "";
	//if($_SESSION['user_type']== '1' ) {
	//	$photo_path = "../images/user/".$_SESSION['photo_path'];
	//} elseif($_SESSION['user_type']== '2' ) {
	//	$photo_path = "../images/doctors/".$_SESSION['photo_path'];
	//} else {
		$photo_path = "../images/users.png";
	//}
	
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>CARE-it</title>
		<link rel="icon" type="image/png" href=""/>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="../templates/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../templates/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../templates/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="../templates/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="../templates/AdminLTE/bower_components/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="../templates/AdminLTE/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="../templates/AdminLTE/dist/css/skins/_all-skins.min.css">
		<link href="../images/logo.png" rel="icon">
		<script src="../scripts/plugins/jquery.min.js"></script>
		<style>
			th,td { font-size:11px !important;}
			.treeview-menu li a { font-size:10px !important; }
			.treeview a span { font-size:10px !important; }
		</style>
	</head>
	<body class="hold-transition skin-blue layout-top-nav">
		<div class="wrapper">
			<header class="main-header">
				<nav class="navbar navbar-static-top">
					<div class="container">
						<div class="navbar-header">
							<a href="" class="navbar-brand"><img src="../images/banner.png" style="width:150px;"></a>
							<!--a href="" class="navbar-brand"><b>CARE</b>-it</a-->
						</div>
						<div class="navbar-custom-menu">
							<ul class="nav navbar-nav">
								<li class="dropdown user user-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo $photo_path?>" class="user-image" alt="User Image">
										<span class="hidden-xs"><?php echo $_SESSION['fullname']?></span>
									</a>
									<ul class="dropdown-menu">
										<li class="user-header">
											<img src="<?php echo $photo_path?>" class="img-circle" alt="User Image">
											<p>
												<?php echo $_SESSION['fullname']?>
												<small>User Type : 
													<?php 
														if($_SESSION['user_type']== '1' ) {
															echo "User";
														} elseif($_SESSION['user_type']== '2' ) {
															echo "Doctors";
														} else {
															echo "Admin";
														}
													?>
												</small>
											</p>
										</li>
										<li class="user-footer">
											<div class="pull-left">
												<a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalChangePassword">Change Pass.</a>
											</div>
											<div class="pull-right">
											    <?php
											        if($_SESSION['user_type']== '1' ) {
														?>
												            <a href="../functions/json/logout.php?id=1" class="btn btn-default btn-flat">Sign out</a>
														<?php
													} elseif($_SESSION['user_type']== '2' ) {
														?>
												            <a href="../functions/json/logout.php?id=2" class="btn btn-default btn-flat">Sign out</a>
														<?php
													} else {
														?>
												            <a href="../functions/json/logout.php" class="btn btn-default btn-flat">Sign out</a>
														<?php
													}
											    ?>
											</div>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</header>
			<div class="content-wrapper">
				<div class="container">
					<?php
						if($_SESSION['user_type']== '1' ) {
							include "users/index.php";
						} elseif($_SESSION['user_type']== '2' ) {
							include "doctors/index.php";
						} else {
							include "admin/index.php";
						}
					?>
				</div>
			</div>
			<footer class="main-footer">
				<div class="container">
					<div class="pull-right hidden-xs">
						<b>Copyright &copy; 2021</b> CARE-it
					</div>
					<strong>.</strong>
				</div>
			</footer>
		</div>
		<div class="modal fade" id="modalChangePassword">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Change Password</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<span>Current Password</span>
								<input type="password" class="form-control" id="current_password" style="text-align:center;">
							</div>
							<div class="col-xs-12 col-md-12">
								<span>New Password</span>
								<input type="password" class="form-control" id="new_password" style="text-align:center;">
							</div>
							<div class="col-xs-12 col-md-12">
								<span>Confirm New Password</span>
								<input type="password" class="form-control" id="confirm_new_password" style="text-align:center;">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" OnClick="cmdChangePassword()">Save</button>
					</div>
				</div>
			</div>
		</div>
		<script src="../templates/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="../templates/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="../templates/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="../templates/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="../templates/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="../templates/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../templates/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
		<script src="../templates/AdminLTE/dist/js/adminlte.min.js"></script>
		<script src="../templates/AdminLTE/dist/js/demo.js"></script>
		<script>
			$(document).keydown(function(e){
			  var key = e.charCode || e.keyCode;
				if (key == 222) { 
					return false;
				}   
			});
		
			$(function () {
				$('.select2').select2()
				$('#userrightlist').DataTable()
				
				$('#example2').DataTable({
				  'paging'      : true,
				  'lengthChange': false,
				  'searching'   : false,
				  'ordering'    : true,
				  'info'        : true,
				  'autoWidth'   : false
				})
				
				$('#example1').DataTable({
				  'paging'      : true,
				  'lengthChange': false,
				  'searching'   : true,
				  'ordering'    : true,
				  'info'        : false,
				  'autoWidth'   : true,
				  "lengthMenu": [[100]],
				  "order": [[ 0, "asc" ]]
				})
			})
			
			function cmdChangePassword() {
				if($('#current_password').val() == "") {
					alert('Please fill up current password!');
					document.getElementById('current_password').focus();
					exit;
				}
				
				if($('#new_password').val() == "") {
					alert('Please fill up new password!');
					document.getElementById('new_password').focus();
					exit;
				}
				
				if($('#confirm_new_password').val() == "") {
					alert('Please fill up confirm new password!');
					document.getElementById('confirm_new_password').focus();
					exit;
				}
				
				$.getJSON('../functions/json/functions_json.php?data=1&new_password='+$('#current_password').val(),function(result)
				{
					if(Number(result) == 0) {
						alert("Incorrect current password!");
						document.getElementById('current_password').focus();
						exit;
					} else {
						if($('#confirm_new_password').val() != $('#new_password').val()) {
							alert('New password And Confirm New Password doest not match!');
							$('#new_password').val("");
							$('#confirm_new_password').val("");
							document.getElementById('new_password').focus();
							exit;
						} else {
							$.getJSON('../functions/json/functions_json.php?data=2&new_password='+$('#new_password').val(),function(result)
							{
								alert('Password have been successfully changed!\nPlease relogin.');
								self.location = '../';
							});
						}
					}
				});
			}
		</script>
	</body>
</html>
