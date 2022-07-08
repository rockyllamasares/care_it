<?php
	if(isset($_POST['cmdSave'])) {
		$ssql = "INSERT INTO `tblpatient_schedule`(`patient_id`, `patient_descriptions`, `doctors_schedule_id`) VALUES ('".$_SESSION['user_id']."', '".$_POST['patient_descriptions']."', '".$_POST['doctors_schedule_id']."')";
		$data_result->executeSQL($ssql,"icare");
		
		echo "<script>self.location = '?menu_id=1&sub_menu_id=1';</script>";
	}
	
	if(isset($_POST['cmdRemove'])) {
		$ssql = "UPDATE `tblpatient_schedule` SET `status`= '1' WHERE `id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		echo "<script>self.location = '?menu_id=1&sub_menu_id=1';</script>";
	}
?>

<section class="content">
	<div class="row">
		<div class="col-md-3">
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo $photo_path?>" alt="User profile picture">
					<p class="text-muted text-center">Client</p>
					<?php
						$ssql = "SELECT `id`, `patient_id`, `fullname`, `fname`, `mname`, `lname`, `contact_no`, `email_address`, `photo_path`, `street`, `barangay`, `city_municipality`, `province`, `postal_code` FROM `tblpatient` WHERE `patient_id` = '".$_SESSION['user_id']."'";
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
		<div class="col-md-9" >
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><b>Appointment List</b></h3>
					<button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><b><i class="fa fa-plus"></i> Make An Appointment</b></button>
				</div>
				<div class="box-body" style="height:75vh; overflow-y:auto scroll; overflow-x:hidden;">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="text-align:center; width:5%;">Count</th>
								<th style="text-align:center;">Doctor</th>
								<th style="text-align:center;">Clinic</th>
								<th style="text-align:center;">Note / Remarks</th>
								<th style="text-align:center;">Schedule</th>
								<th style="text-align:center;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$cc = 0;
								$ssql = "SELECT id, `doctors_schedule_id`, status FROM `tblpatient_schedule` WHERE `patient_id` = '".$_SESSION['user_id']."'";
								$result = $data_result->executeSQL($ssql,"icare");
								while($row = mysqli_fetch_array($result))
								{ 
									$cc = $cc + 1;
									$ssql = "SELECT tbldoctors.fullname, tbldoctors.specialist_id, tblclinic.clinic_name, tblclinic.street, tblclinic.barangay, tblclinic.city_municipality, tblclinic.province, tblclinic.postal_code, `schedule_date`, `schedule_from_time`, `schedule_to_time`, `patient_count` FROM `tbldoctors_schedule` LEFT JOIN tbldoctors ON tbldoctors_schedule.doctors_id = tbldoctors.doc_id LEFT JOIN tblclinic ON tbldoctors_schedule.clinic_id = tblclinic.clinic_id WHERE tbldoctors_schedule.id = '".$row['doctors_schedule_id']."'";
									$inn = $data_result->executeSQL($ssql,"icare");
									$rs = mysqli_fetch_array($inn);
									if($rs!=0) {
										?>
											<tr>
												<td style="text-align:center;"><?php echo number_format($cc,0)?></td>
												<td><?php echo strtoupper($rs['fullname']).'<br>('.$rs['specialist_id'].')'?></td>
												<td><?php echo strtoupper($rs['clinic_name'])?><br><?php echo strtoupper($rs['street'].', '.$rs['barangay'].' '.$rs['city_municipality'].', '.$rs['province'].' '.$rs['postal_code'])?></td>
												<td><?php echo date('F d, Y',strtotime($rs['schedule_date'])).'<br>FROM : '.date('h:i A',strtotime($rs['schedule_from_time'])).' - TO : '.date('h:i A',strtotime($rs['schedule_to_time']))?></td>
												<td style="text-align:center;">
													<?php
														if($row['status'] == '1') {
															?>
																<i style="color:red;">Cancelled</i>
															<?php
														} else {
															?>
																<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalRemove<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-times"></i> Cancel</b></small></button>
															<?php
														}
													?>
												</td>
											</tr>
											<?php
												$count = 0;
												
												$ssql = "SELECT COUNT(`id`) as cc FROM `tblpatient_diagnose` WHERE `ps_id` = '".$row['id']."'";
												$inn_1 = $data_result->executeSQL($ssql,"icare");
												$rs_1 = mysqli_fetch_array($inn_1);
												if($rs_1!=0) { 
													$count = $rs_1['cc'];
												}
											
												$ssql = "SELECT `id`, `finding`, `prescription` FROM `tblpatient_diagnose` WHERE `ps_id` = '".$row['id']."'";
												$rsresult_0 = $data_result->executeSQL($ssql,"icare");
												while($rs_0 = mysqli_fetch_array($rsresult_0))
												{
													$count = $count - 1;
													?>
														<tr>
															<td style="text-align:center; <?php if($count==0) {?> border-bottom:1px solid #000; <?php } ?>"><i class="fa  fa-question-circle" title="Diagnosis"></td>
															<td colspan="2" style="<?php if($count==0) {?>border-bottom:1px solid #000;<?php } ?>"><?php echo strtoupper($rs_0['finding'])?></td>
															<td colspan="2" style="<?php if($count==0) {?>border-bottom:1px solid #000;<?php } ?>"><?php echo strtoupper($rs_0['prescription'])?></td>
														</tr>
													<?php
												}
											?>
											
											<div class="modal modal-danger fade" id="modalRemove<?php echo strtoupper($row['id'])?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title"></h4>
														</div>
														<form method="POST">
															<div class="modal-body">
																<input type="hidden" class="form-control" name="class_id" required="true" value="<?php echo strtoupper($row['id'])?>">
																<h1 style="text-align:center;"><i class="fa fa-question-circle" style="font-size:50px;"></i></h1>
																<h4 style="text-align:center;">Are you sure to cancel this appointment?</h4>
															</div>
															<div class="modal-footer">
																<center>
																	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
																	<button type="submit" class="btn btn-success"  name="cmdRemove"><i class="fa fa-check"></i> Yes</button>
																</center>
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
				<div class="modal fade" id="modalAdd">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="create_user_title">Make An Appointment</h4>
							</div>
							<form method="POST">
								<div class="modal-body">
									<div class="row">
										<div class="col-xs-12">
											<div class="col-xs-4" style="padding:2px;">
												<small><b>Specialist of</b></small>
												<select class="form-control select2" name="specialist_id" id="specialist_id" OnChange="fGetDoctors()" style="width:100%;">
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
											<div class="col-xs-8" style="padding:2px;">
												<small><b>Doctor</b></small>
												<select class="form-control select2" name="doctors" id="doctors" OnChange="fGetClinic()" style="width:100%;">
													<option value="">Select</option>
												</select>
											</div>
											<span style="float:left; width:100%; padding:5px;"></span>
											<div class="col-xs-12" style="padding:2px;">
												<small><b>Clinic</b></small>
												<select class="form-control select2" name="clinic" id="clinic" OnChange="fGetSchedules()" style="width:100%;">
													<option value="">Select</option>
												</select>
											</div>
											<span style="float:left; width:100%; padding:5px;"></span>
											<div class="col-xs-12" style="padding:2px;">
												<small><b>Schedule</b></small>
												<select class="form-control select2" name="doctors_schedule_id" id="Schedule" style="width:100%;">
													<option value="">Select</option>
												</select>
											</div>
											<span style="float:left; width:100%; padding:5px;"></span>
											<div class="col-xs-12" style="padding:2px;">
												<small><b>Describe how you feel</b></small>
												<textarea class="form-control" style="height:300px;" required="true" name="patient_descriptions"></textarea>
											</div>
											<span style="float:left; width:100%; padding:5px;"><i>Note : Please be in the clinic 30mins before the schedule time</i></span>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="cmdSave">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function fGetDoctors() {
		$('#doctors').empty();
		$.getJSON('../functions/json/functions_json.php?data=3&specialist_id='+$('#specialist_id').val(),function(result)
		{
			$('#doctors').append(result);
		});
	}
	
	function fGetClinic() {
		$('#clinic').empty();
		$.getJSON('../functions/json/functions_json.php?data=4&doctors_id='+$('#doctors').val(),function(result)
		{
			$('#clinic').append(result);
		});
	}
	
	function fGetSchedules() {
		$('#Schedule').empty();
		$.getJSON('../functions/json/functions_json.php?data=5&clinic_id='+$('#clinic').val()+'&doctors_id='+$('#doctors').val(),function(result)
		{
			$('#Schedule').append(result);
		});
	}
</script>
