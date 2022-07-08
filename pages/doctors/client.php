<?php
	$date_from = "";
	if(isset($_GET['date_sched'])) {
		$date_from = $_GET['date_sched'];
	} else {
		$date_from = date('Y-m-d');
	}
	
	if(isset($_POST['cmdDiagnosis'])) {
		$ssql = "INSERT INTO `tblpatient_diagnose`( `ps_id`, `finding`, `prescription`) VALUES ('".$_POST['ps_id']."', '".$_POST['finding']."', '".$_POST['prescription']."')";
		$data_result->executeSQL($ssql,"icare");
		
		echo "<script>self.location = '?menu_id=2&sub_menu_id=3&date_sched=".$_GET['date_sched']."';</script>";
	}
	
	if(isset($_GET['id'])) {
		$ssql = "DELETE FROM `tblpatient_diagnose` WHERE `id` = '".$_GET['id']."'";
		$data_result->executeSQL($ssql,"icare");
		
		
		echo "<script>self.location = '?menu_id=2&sub_menu_id=3&date_sched=".$_GET['date_sched']."';</script>";
	}
?>

<div class="box-header with-border">
	<h3 class="box-title">Client</h3>
	<form method="GET">
		<input type="hidden" name="menu_id" value="<?php echo $_GET['menu_id']?>">
		<input type="hidden" name="sub_menu_id" value="<?php echo $_GET['sub_menu_id']?>">
		<div class="col-xs-3 pull-right">
			<input type="date" class="form-control" name="date_sched" value="<?php echo $date_from?>" OnChange='this.form.submit()'>
		</div>
	</form>
</div>
<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center; width:5%;">Count</th>
				<th style="text-align:center;">Clinic</th>
				<th style="text-align:center;">Client Name</th>
				<th style="text-align:center;">Notes / Remarks</th>
				<th style="text-align:center;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$cc = 0;
				$ssql = "SELECT tbldoctors_schedule.id, tblclinic.clinic_name FROM `tbldoctors_schedule` LEFT JOIN tblclinic ON tbldoctors_schedule.clinic_id = tblclinic.clinic_id WHERE `schedule_date` = '".$date_from."' AND tbldoctors_schedule.doctors_id = '".$_SESSION['user_id']."'";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{ 
					$ssql = "SELECT tblpatient_schedule.id, tblpatient.fullname, `patient_descriptions`, `status` FROM `tblpatient_schedule` LEFT JOIN tblpatient ON tblpatient_schedule.patient_id = tblpatient.patient_id WHERE `doctors_schedule_id` = '".$row['id']."'";
					$rsresult = $data_result->executeSQL($ssql,"icare");
					while($rs = mysqli_fetch_array($rsresult))
					{
						$cc = $cc + 1;
						?>
							<tr>
								<td style="center"><?php echo number_format($cc,0)?></td>
								<td><?php echo strtoupper($row['clinic_name'])?></td>
								<td><?php echo strtoupper($rs['fullname'])?></td>
								<td><?php echo strtoupper($rs['patient_descriptions'])?></td>
								<td style="text-align:center;">
									<?php 
										if($rs['status'] == '1') {
											?>
												<i style="color:red;">Cancelled</i>
											<?php
										} else {
											?>
												<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalDiagnosis<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-plus"></i> Diagnosis</b></small></button>
											<?php
										}
									?>
								</td>
							</tr>
							
							<?php
								$count = 0;
								
								$ssql = "SELECT COUNT(`id`) as cc FROM `tblpatient_diagnose` WHERE `ps_id` = '".$rs['id']."'";
								$inn_1 = $data_result->executeSQL($ssql,"icare");
								$rs_1 = mysqli_fetch_array($inn_1);
								if($rs_1!=0) { 
									$count = $rs_1['cc'];
								}
							
								$ssql = "SELECT `id`, `finding`, `prescription` FROM `tblpatient_diagnose` WHERE `ps_id` = '".$rs['id']."'";
								$rsresult_0 = $data_result->executeSQL($ssql,"icare");
								while($rs_0 = mysqli_fetch_array($rsresult_0))
								{
									$count = $count - 1;
									?>
										<tr>
											<td style="text-align:center; <?php if($count==0) {?> border-bottom:1px solid #000; <?php } ?>"><a href="?menu_id=2&sub_menu_id=3&id=<?php echo $rs_0['id']?>&date_sched=<?php echo $_GET['date_sched']?>"><i class="fa fa-times"></i></td>
											<td colspan="2" style="<?php if($count==0) {?>border-bottom:1px solid #000;<?php } ?>"><?php echo strtoupper($rs_0['finding'])?></td>
											<td colspan="2" style="<?php if($count==0) {?>border-bottom:1px solid #000;<?php } ?>"><?php echo strtoupper($rs_0['prescription'])?></td>
										</tr>
									<?php
								}
							?>
							
							
							<div class="modal fade" id="modalDiagnosis<?php echo strtoupper($row['id'])?>">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="create_user_title">Diagnosis</h4>
										</div>
										<form method="POST">
											<div class="modal-body">
												<div class="row">
													<div class="col-xs-12">
														<input type="hidden" name="ps_id" value="<?php echo $rs['id']?>">
														<div class="col-xs-12" style="padding:2px;">
															<small><b>Findings</b></small>
															<textarea class="form-control" style="height:150px;" required="true" name="finding"></textarea>
														</div>
														<div class="col-xs-12" style="padding:2px;">
															<small><b>Prescription</b></small>
															<textarea class="form-control" style="height:150px;" required="true" name="prescription"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary" name="cmdDiagnosis">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="6"></th>
			</tr>
		</tfoot>
	</table>
</div>