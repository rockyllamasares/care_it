<?php
	if(isset($_POST['cmdSave'])) {
		
		if(isset($_POST['class_id'])) {
			$ssql = "UPDATE tbldoctors_schedule SET `schedule_date` = '".$_POST['schedule_date']."', `schedule_from_time` = '".$_POST['schedule_from_time']."', `schedule_to_time` = '".$_POST['schedule_to_time']."', `patient_count` = '".$_POST['patient_count']."', `clinic_id` = '".$_POST['clinic_id']."' WHERE id = '".$_POST['class_id']."'";
			$data_result->executeSQL($ssql,"icare");
		} else {			
			$ssql = "INSERT INTO `tbldoctors_schedule`(`doctors_id`, `schedule_date`, `schedule_from_time`, `schedule_to_time`, `patient_count`, `clinic_id`) VALUES ('".$_SESSION['user_id']."', '".$_POST['schedule_date']."', '".$_POST['schedule_from_time']."', '".$_POST['schedule_to_time']."', '".$_POST['patient_count']."', '".$_POST['clinic_id']."')";
			$data_result->executeSQL($ssql,"icare");
		}
		
		echo "<script>self.location = '?menu_id=2&sub_menu_id=2';</script>";
	}
	
	if(isset($_POST['cmdRemove'])) {
		$ssql = "DELETE FROM `tbldoctors_schedule` WHERE `id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		echo "<script>self.location = '?menu_id=2&sub_menu_id=2';</script>";
	}
	
	if(isset($_POST['cmdCancel'])) {
		$ssql = "UPDATE `tbldoctors_schedule` SET status = '1' WHERE `id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		echo "<script>self.location = '?menu_id=2&sub_menu_id=2';</script>";
	}
?>

<div class="box-header with-border">
	<h3 class="box-title">Schedules</h3>
	<button type="button" class="btn btn-xs btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><small><b><i class="fa fa-plus"></i> ADD</b></small></button>
</div>
<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center; width:5%;">Count</th>
				<th style="text-align:center;">Clinic</th>
				<th style="text-align:center;">Schedule</th>
				<th style="text-align:center;">Client Count</th>
				<th style="text-align:center;">Appoint Client</th>
				<th style="text-align:center;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$cc = 0;
				$ssql = "SELECT `id`, `doctors_id`, `schedule_date`, `schedule_from_time`, `schedule_to_time`, `patient_count`, `clinic_id`, `status` FROM `tbldoctors_schedule` ORDER BY `schedule_date` DESC";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{ 
					$cc = $cc + 1;
					?>
						<tr>
							<td style="center"><?php echo number_format($cc,0)?></td>
							<td>
								<?php
									$ssql = "SELECT `clinic_name` FROM `tblclinic` WHERE `clinic_id` = '".$row['clinic_id']."'";
									$inn = $data_result->executeSQL($ssql,"icare");
									$rs = mysqli_fetch_array($inn);
									if($rs!=0) {
										echo strtoupper($rs['clinic_name']);
									}
								?>
							</td>
							<td><?php echo strtoupper($row['schedule_date'].' FROM : '.date('h:i A',strtotime($row['schedule_from_time'])).' - TO : '.date('h:i A',strtotime($row['schedule_to_time'])))?></td>
							<td><?php echo number_format($row['patient_count'],0)?></td>
							<td>
								<?php
									$c_counter = 0;
									$ssql = "SELECT COUNT(`id`) as cc_count FROM `tblpatient_schedule` WHERE `doctors_schedule_id` = '".$row['cc_count']."'";
									$inn = $data_result->executeSQL($ssql,"icare");
									$rs = mysqli_fetch_array($inn);
									if($rs!=0) {
										echo $rs['cc_count'];
										$c_counter = $rs['cc_count'];
									}
								?>
							</td>
							<td style="text-align:center;">
								<?php 
									if($c_counter == 0 && $row['status'] == 0) { 
										?>
											<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-pencil"></i> Edit</b></small></button>
											<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalRemove<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-times"></i> Remove</b></small></button>
										<?php
									} else {
										if($row['status'] == 1) {
											?>
												<i style="color:red;">Cancelled</i>
											<?php 
										} else {
											?>
												<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalCancel<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-minus"></i> Cancel</b></small></button>
											<?php
										}
									}
								?>
							</td>
						</tr>
						<div class="modal fade" id="modalEdit<?php echo strtoupper($row['id'])?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="create_user_title">Edit</h4>
									</div>
									<form method="POST">
										<div class="modal-body">
											<div class="row">
												<div class="col-xs-12">
													<input type="hidden" value="<?php echo strtoupper($row['id'])?>" name="class_id">
													<div class="col-xs-9" style="padding:2px;">
														<small><b>Clinic</b></small>
														<select class="form-control select2" name="clinic_id" required="true" style="width:100%;">
															<?php
																$ssql = "SELECT `clinic_id`, `clinic_name` FROM `tblclinic` WHERE `clinic_id` = '".$row['clinic_id']."'";
																$inn = $data_result->executeSQL($ssql,"icare");
																$rs = mysqli_fetch_array($inn);
																if($rs!=0) {
																	?>
																		<option value="<?php echo strtoupper($rs['clinic_id'])?>"><?php echo strtoupper($rs['clinic_name'])?></option>
																	<?php
																}
															
																$ssql = "SELECT `clinic_id`, `clinic_name` FROM `tblclinic`  WHERE `clinic_id` != '".$row['clinic_id']."' ORDER BY `clinic_name` DESC";
																$rsresult = $data_result->executeSQL($ssql,"icare");
																while($rs = mysqli_fetch_array($rsresult))
																{ 
																	?>
																		<option value="<?php echo strtoupper($rs['clinic_id'])?>"><?php echo strtoupper($rs['clinic_name'])?></option>
																	<?php
																}
															?>
														</select>
													</div>
													<div class="col-xs-3" style="padding:2px;">
														<small><b>Client Count</b></small>
														<input type="number" min="0" class="form-control" name="patient_count" required="true" value="<?php echo strtoupper($row['patient_count'])?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Date</b></small>
														<input type="date" class="form-control" name="schedule_date" required="true" value="<?php echo strtoupper($row['schedule_date'])?>">
													</div>
													<div class="col-xs-3" style="padding:2px;">
														<small><b>From Time</b></small>
														<input type="time" class="form-control" name="schedule_from_time" required="true" value="<?php echo strtoupper($row['schedule_from_time'])?>">
													</div>
													<div class="col-xs-3"style="padding:2px;">
														<small><b>To Time</b></small>
														<input type="time" class="form-control" name="schedule_to_time" required="true" value="<?php echo strtoupper($row['schedule_to_time'])?>">
													</div>
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
											<h4 style="text-align:center;">Are you sure to delete this record?</h4>
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
						<div class="modal modal-danger fade" id="modalCancel<?php echo strtoupper($row['id'])?>">
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
											<h4 style="text-align:center;">Are you sure to cancel this schedule?</h4>
										</div>
										<div class="modal-footer">
											<center>
												<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
												<button type="submit" class="btn btn-success"  name="cmdCancel"><i class="fa fa-check"></i> Yes</button>
											</center>
										</div>
									</form>
								</div>
							</div>
						</div>
					<?php
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
				<h4 class="modal-title" id="create_user_title">ADD</h4>
			</div>
			<form method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-9" style="padding:2px;">
								<small><b>Clinic</b></small>
								<select class="form-control select2" name="clinic_id" required="true" style="width:100%;">
									<option value="">Select</option>
									<?php
										$ssql = "SELECT `clinic_id`, `clinic_name` FROM `tblclinic` ORDER BY `clinic_name` DESC";
										$rsresult = $data_result->executeSQL($ssql,"icare");
										while($rs = mysqli_fetch_array($rsresult))
										{ 
											?>
												<option value="<?php echo strtoupper($rs['clinic_id'])?>"><?php echo strtoupper($rs['clinic_name'])?></option>
											<?php
										}
									?>
								</select>
							</div>
							<div class="col-xs-3" style="padding:2px;">
								<small><b>Client Count</b></small>
								<input type="number" min="0" class="form-control" name="patient_count" required="true">
							</div>
							<span style="float:left; width:100%; padding:5px;"></span>
							<div class="col-xs-6" style="padding:2px;">
								<small><b>Date</b></small>
								<input type="date" class="form-control" name="schedule_date" required="true" value="<?php echo date('Y-m-d')?>">
							</div>
							<div class="col-xs-3" style="padding:2px;">
								<small><b>From Time</b></small>
								<input type="time" class="form-control" name="schedule_from_time" required="true">
							</div>
							<div class="col-xs-3"style="padding:2px;">
								<small><b>To Time</b></small>
								<input type="time" class="form-control" name="schedule_to_time" required="true">
							</div>
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