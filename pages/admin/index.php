<section class="content-header">
	<div class="row">
		<div class="col-lg-2 col-xs-6">
			<div class="small-box bg-aqua">
				<a class="btn btn-lg btn-block btn-social btn-primary" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=1">
					<i class="fa fa-users"></i> 
					<?php
						$ssql = "SELECT COUNT(`patient_id`) as cc_count FROM `tblpatient`";
						$inn = $data_result->executeSQL($ssql,"icare");
						$rs = mysqli_fetch_array($inn);
						if($rs!=0) { 
							echo number_format($rs['cc_count'],0);
						}
					?>
					Client
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<a class="btn btn-lg btn-block btn-social btn-success" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=3">
					<i class="fa fa-user-md"></i> 
					<?php
						$ssql = "SELECT COUNT(`doc_id`) as cc_count FROM `tbldoctors`";
						$inn = $data_result->executeSQL($ssql,"icare");
						$rs = mysqli_fetch_array($inn);
						if($rs!=0) { 
							echo number_format($rs['cc_count'],0);
						}
					?>
					Doctors
				</a>
			</div>
		</div>
		<div class="col-lg-2 col-xs-6">
			<div class="small-box bg-red">
				<a class="btn btn-lg btn-block btn-social btn-danger" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=2">
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
				<a class="btn btn-lg btn-block btn-social btn-info" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=5">
					<i class="fa fa-book"></i> 
					<?php
						$ssql = "SELECT COUNT(`id`) as cc_count FROM `tblspecialist`";
						$inn = $data_result->executeSQL($ssql,"icare");
						$rs = mysqli_fetch_array($inn);
						if($rs!=0) { 
							echo number_format($rs['cc_count'],0);
						}
					?>
					Specialist
				</a>
			</div>
		</div>
		<div class="col-lg-2 col-xs-6">
			<div class="small-box bg-green">
				<a class="btn btn-lg btn-block btn-social btn-warning" href="?menu_id=<?php echo $_GET['menu_id']?>&sub_menu_id=4">
					<i class="fa fa-user"></i> 
					<?php
						$ssql = "SELECT COUNT(`id`) as cc_count FROM `tblusers`";
						$inn = $data_result->executeSQL($ssql,"icare");
						$rs = mysqli_fetch_array($inn);
						if($rs!=0) { 
							echo number_format($rs['cc_count'],0);
						}
					?>
					Users
				</a>
			</div>
		</div>
	</div>
</section>
<section class="content" style="margin-top:-20px;">
	<div class="box box-primary">
		<?php
			if($_GET['sub_menu_id'] == 1) { include "client.php"; }
			if($_GET['sub_menu_id'] == 2) { include "clinic.php"; }
			if($_GET['sub_menu_id'] == 3) { include "doctors.php"; }
			if($_GET['sub_menu_id'] == 4) { include "users.php"; }
			if($_GET['sub_menu_id'] == 5) { include "specialist.php"; }
		?>
	</div>
</section>