
<section class="content">
	<div class="row">
		<div class="col-md-3">
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo $photo_path?>" alt="User profile picture">
					<p class="text-muted text-center">Doctor</p>
					<?php
						$ssql = "SELECT `id`, `doc_id`, `fullname`, `fname`, `mname`, `lname`, `specialist_id`, `photo_path`, `street`, `barangay`, `city_municipality`, `province`, `postal_code`, `contact_no`, `email_address` FROM `tbldoctors` WHERE doc_id = '".$_SESSION['user_id']."'";
						$inn = $data_result->executeSQL($ssql,"icare");
						$rs = mysqli_fetch_array($inn);
						if($rs!=0) { 
							?>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
									  <b>F.Name :</b><br><?php echo strtoupper($rs['fname'])?></a>
									</li>
									<li class="list-group-item">
									  <b>M.Name</b><br><?php echo strtoupper($rs['mname'])?></a>
									</li>
									<li class="list-group-item">
									  <b>L.Name</b><br><?php echo strtoupper($rs['lname'])?></a>
									</li>
									<li class="list-group-item">
									  <b>Contact No : </b><br><?php echo strtoupper($rs['contact_no'])?></a>
									</li>
									<li class="list-group-item">
									  <b>Email :</b><br><?php echo strtoupper($rs['email_address'])?></a>
									</li>
								</ul>
							<?php 
						}
					?>
					<a href="#" class="btn btn-primary btn-sm btn-flat pull-left" data-toggle="modal" data-target="#modalChangePassword" title="Change Password"><i class="fa fa-exchange"></i></a>
					<a href="../functions/json/logout.php" class="btn btn-sm  btn-success btn-flat pull-right" title="sign_out"><i class="fa fa-sign-out"></i></a>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<a class="btn btn-lg btn-block btn-social btn-info" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=3">
						<i class="fa fa-users"></i> 
						<?php
							$cc_count = 0;
							$ssql = "SELECT `id` FROM `tbldoctors_schedule` WHERE `schedule_date` = '".date('Y-m-d')."' AND `doctors_id` = '".$_SESSION['user_id']."'";
							$rsresult = $data_result->executeSQL($ssql,"icare");
							while($rs_id = mysqli_fetch_array($rsresult))
							{
								$ssql = "SELECT COUNT(`id`) as cc_count FROM `tblpatient_schedule` WHERE `doctors_schedule_id` = '".$rs_id['id']."'";
								$inn = $data_result->executeSQL($ssql,"icare");
								$rs = mysqli_fetch_array($inn);
								if($rs!=0) { 
									$cc_count = $cc_count + $rs['cc_count'];
								}
							}
							
							echo $cc_count;
						?>
						Appoint Client
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<a class="btn btn-lg btn-block btn-social btn-danger" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=1">
						<i class="fa fa-medkit"></i> 
						<?php
							$ssql = "SELECT COUNT(`clinic_id`) as cc_count FROM `tblclinic`";
							$inn = $data_result->executeSQL($ssql,"icare");
							$rs = mysqli_fetch_array($inn);
							if($rs!=0) { 
								echo number_format($rs['cc_count'],0);
							}
						?>
						Clinic
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<a class="btn btn-lg btn-block btn-social btn-success" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=2">
						<i class="fa fa-calendar"></i>
						Schedules
					</a>
				</div>
			</div>
			<div class="col-md-9" >
				
				<div class="box box-primary">
					<div class="box-header with-border">
						
					<div class="box-body" style="height:75vh; overflow-y:auto scroll; overflow-x:hidden;">
						<?php
							if($_GET['sub_menu_id'] == 1) { include "clinic.php"; }
							if($_GET['sub_menu_id'] == 2) { include "schedules.php"; }
							if($_GET['sub_menu_id'] == 3) { include "client.php"; }
						?>
					</div>
					</div>
				</div>
			</div>
	</div>
</section>