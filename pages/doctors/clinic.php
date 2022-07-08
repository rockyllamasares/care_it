<?php
	if(isset($_POST['cmdSave'])) {
		
		if(isset($_POST['class_id'])) {
			$ssql = "UPDATE tblclinic SET `clinic_name` = '".$_POST['clinic_name']."', `contact_no` = '".$_POST['contact_no']."', `email_address` = '".$_POST['email_address']."', `street` = '".$_POST['street']."', `barangay` = '".$_POST['barangay']."', `city_municipality` = '".$_POST['city_municipality']."', `province` = '".$_POST['province']."', `postal_code` = '".$_POST['postal_code']."' WHERE clinic_id = '".$_POST['class_id']."'";
			$data_result->executeSQL($ssql,"icare");
		} else {
			$clinic_id = "";
			$ssql = "SELECT `clinic_id` FROM `tblclinic` ORDER BY `clinic_id` DESC";
			$inn = $data_result->executeSQL($ssql,"icare");
			$rs = mysqli_fetch_array($inn);
			if($rs!=0) {
				$clinic_id = right($rs['clinic_id'],5);
				$clinic_id = $clinic_id + 1;
				$clinic_id = 'C'.date('md').$clinic_id;
			} else {
				$clinic_id = 'C'.date('md')."10001";
			}
			
			$ssql = "INSERT INTO `tblclinic`(`clinic_id`, `clinic_name`, `contact_no`, `email_address`, `street`, `barangay`, `city_municipality`, `province`, `postal_code`, `added_by`) VALUES ('".$clinic_id."', '".$_POST['clinic_name']."', '".$_POST['contact_no']."', '".$_POST['email_address']."', '".$_POST['street']."', '".$_POST['barangay']."', '".$_POST['city_municipality']."', '".$_POST['province']."', '".$_POST['postal_code']."', '".$_SESSION['user_id']."')";
			$data_result->executeSQL($ssql,"icare");
		}
		
		echo "<script>self.location = '?menu_id=2&sub_menu_id=1';</script>";
	}
	
	if(isset($_POST['cmdRemove'])) {
		$ssql = "DELETE FROM `tblclinic` WHERE `clinic_id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		echo "<script>self.location = '?menu_id=2&sub_menu_id=1';</script>";
	}
?>

<div class="box-header with-border">
	<h3 class="box-title">Clinic</h3>
	<button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><b><i class="fa fa-plus"></i> ADD</b></button>
</div>
<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center; width:5%;">Count</th>
				<th style="text-align:center;">Clinic ID</th>
				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">Address</th>
				<th style="text-align:center;">Contact No</th>
				<th style="text-align:center;">Email Address</th>
				<th style="text-align:center;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$cc = 0;
				$ssql = "SELECT `clinic_id`, `clinic_name`, `contact_no`, `email_address`, `street`, `barangay`, `city_municipality`, `province`, postal_code FROM `tblclinic` WHERE added_by = '".$_SESSION['user_id']."' ORDER BY `clinic_id` DESC";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{ 
					$cc = $cc + 1;
					?>
						<tr>
							<td style="center"><?php echo number_format($cc,0)?></td>
							<td><?php echo strtoupper($row['clinic_id'])?></td>
							<td><?php echo strtoupper($row['clinic_name'])?></td>
							<td><?php echo strtoupper($row['street'].', '.$row['barangay'].' '.$row['city_municipality'].', '.$row['province'].' '.$row['postal_code'])?></td>
							<td><?php echo strtoupper($row['contact_no'])?></td>
							<td><?php echo strtoupper($row['email_address'])?></td>
							<td style="text-align:center;">
								<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo strtoupper($row['clinic_id'])?>"><small><b><i class="fa fa-pencil"></i> Edit</b></small></button>
								<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalRemove<?php echo strtoupper($row['clinic_id'])?>"><small><b><i class="fa fa-times"></i> Remove</b></small></button>
							</td>
						</tr>
						<div class="modal fade" id="modalEdit<?php echo strtoupper($row['clinic_id'])?>">
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
												<input type="hidden" class="form-control" name="class_id" required="true" value="<?php echo strtoupper($row['clinic_id'])?>">
												<div class="col-xs-12">
													<div class="col-xs-12" style="padding:2px;">
														<small><b>Clinic Name</b></small>
														<input type="text" class="form-control" name="clinic_name" required="true" value="<?php echo strtoupper($row['clinic_name'])?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<span style="float:left; width:100%; padding:5px; text-align:center;">Permanent Address</span>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Street</b></small>
														<input type="text" class="form-control" name="street" required="true" value="<?php echo strtoupper($row['street'])?>">
													</div>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Barangay</b></small>
														<input type="text" class="form-control" name="barangay" required="true" value="<?php echo strtoupper($row['barangay'])?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-4"style="padding:2px;">
														<small><b>City / Municipality</b></small>
														<input type="text" class="form-control" name="city_municipality" required="true" value="<?php echo strtoupper($row['city_municipality'])?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Province</b></small>
														<input type="text" class="form-control" name="province" required="true" value="<?php echo strtoupper($row['province'])?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Postal Code</b></small>
														<input type="text" class="form-control" name="postal_code" required="true" value="<?php echo strtoupper($row['postal_code'])?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-8" style="padding:2px;">
														<small><b>Email Address</b></small>
														<input type="text" class="form-control" name="email_address" required="true" value="<?php echo strtoupper($row['email_address'])?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Contact No</b></small>
														<input type="text" class="form-control" name="contact_no" required="true" value="<?php echo strtoupper($row['contact_no'])?>">
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
						
						<div class="modal modal-danger fade" id="modalRemove<?php echo strtoupper($row['clinic_id'])?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"></h4>
									</div>
									<form method="POST">
										<div class="modal-body">
											<input type="hidden" class="form-control" name="class_id" required="true" value="<?php echo strtoupper($row['clinic_id'])?>">
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
							<div class="col-xs-12" style="padding:2px;">
								<small><b>Clinic Name</b></small>
								<input type="text" class="form-control" name="clinic_name" required="true">
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