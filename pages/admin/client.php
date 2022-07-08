<?php 
	if(isset($_POST['cmdSave'])) {
		$patient_id = "";
		if(isset($_POST['class_id'])) {
			$patient_id = $_POST['class_id'];
		} else {
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
		}

		$ssql = "DELETE FROM `tblpatient` WHERE `patient_id` = '".$patient_id."'";
		$data_result->executeSQL($ssql,"icare");
		
		$ssql = "DELETE FROM `tblusers` WHERE `user_id` = '".$patient_id."'";
		$data_result->executeSQL($ssql,"icare");

		$fullname = $_POST['lname'].', '.$_POST['fname'].' '.$_POST['mname'];
		
		$ssql = "INSERT INTO `tblpatient`(`patient_id`, `fullname`, `fname`, `mname`, `lname`, `contact_no`, `email_address`, `street`, `barangay`, `city_municipality`, `province`, postal_code) VALUES ('".$patient_id."', '".$fullname."', '".$_POST['fname']."', '".$_POST['mname']."', '".$_POST['lname']."', '".$_POST['contact_no']."', '".$_POST['email_address']."', '".$_POST['street']."', '".$_POST['barangay']."', '".$_POST['city_municipality']."', '".$_POST['province']."', '".$_POST['postal_code']."')";
		$data_result->executeSQL($ssql,"icare");
		
		$ssql = "INSERT INTO `tblusers`(`user_id`, `username`, `password`, `user_type`) VALUES ('".$patient_id."', '".$_POST['email_address']."', '".$_POST['password']."', '1')";
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
			move_uploaded_file($file_tmp,"../../images/user/".$file_name);
			 
			$ssql = "UPDATE `tblpatient` SET `photo_path`='".$file_name."' WHERE `patient_id` = '".$patient_id."'";
			$data_result->executeSQL($ssql,"icare");

			}else{
			 print_r($errors);
			}
		}
		echo "<script>self.location = '?menu_id=0&sub_menu_id=1';</script>";
	}


	if(isset($_POST['cmdRemove'])) {
		$ssql = "DELETE FROM `tblpatient` WHERE `patient_id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		
		$ssql = "DELETE FROM `tblusers` WHERE `user_id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		
		echo "<script>self.location = '?menu_id=0&sub_menu_id=1';</script>";
	}
?>
<div class="box-header with-border">
	<h3 class="box-title">Client</h3>
	<button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><b><i class="fa fa-plus"></i> ADD</b></button>
</div>
<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center; width:5%;">Count</th>
				<th style="text-align:center;">Patient ID</th>
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
				$ssql = "SELECT `patient_id`, `fullname`, fname, mname, lname, `contact_no`, `email_address`, `photo_path`, `street`, `barangay`, `city_municipality`, `province`, `postal_code` FROM `tblpatient` ORDER BY `patient_id` ASC";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{ 
					$cc = $cc + 1;
					?>
						<tr>
							<td style="center"><?php echo number_format($cc,0)?></td>
							<td><?php echo strtoupper($row['patient_id'])?></td>
							<td><?php echo strtoupper($row['fullname'])?></td>
							<td><?php echo strtoupper($row['street'].', '.$row['barangay'].' '.$row['city_municipality'].', '.$row['province'].' '.$row['postal_code'])?></td>
							<td><?php echo strtoupper($row['contact_no'])?></td>
							<td><?php echo strtoupper($row['email_address'])?></td>
							<td>
								<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo strtoupper($row['patient_id'])?>"><small><b><i class="fa fa-pencil"></i> </b></small></button>
								<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalRemove<?php echo strtoupper($row['patient_id'])?>"><small><b><i class="fa fa-times"></i> </b></small></button>
							</td>
						</tr>
						<div class="modal fade" id="modalEdit<?php echo strtoupper($row['patient_id'])?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="create_user_title">Update</h4>
									</div>
									<form method="POST">
										<div class="modal-body">
											<div class="row">
												<div class="col-xs-12">
													<input type="hidden" class="form-control" name="class_id" required="true" value="<?php echo strtoupper($row['patient_id'])?>">
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>First Name</b></small>
														<input type="text" class="form-control" name="fname" required="true" value="<?php echo $row['fname']?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Middle Initial</b></small>
														<input type="text" class="form-control" name="mname" required="true" value="<?php echo $row['mname']?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Last Name</b></small>
														<input type="text" class="form-control" name="lname" required="true" value="<?php echo $row['lname']?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													
													<span style="float:left; width:100%; padding:5px; text-align:center;">Permanent Address</span>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Street</b></small>
														<input type="text" class="form-control" name="street" required="true" value="<?php echo $row['street']?>">
													</div>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Barangay</b></small>
														<input type="text" class="form-control" name="barangay" required="true" value="<?php echo $row['barangay']?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-4"style="padding:2px;">
														<small><b>City / Municipality</b></small>
														<input type="text" class="form-control" name="city_municipality" required="true" value="<?php echo $row['city_municipality']?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Province</b></small>
														<input type="text" class="form-control" name="province" required="true" value="<?php echo $row['province']?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Postal Code</b></small>
														<input type="text" class="form-control" name="postal_code" required="true" value="<?php echo $row['postal_code']?>">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-8" style="padding:2px;">
														<small><b>Email Address</b></small>
														<input type="text" class="form-control" name="email_address" required="true" value="<?php echo $row['email_address']?>">
													</div>
													<div class="col-xs-4" style="padding:2px;">
														<small><b>Contact No</b></small>
														<input type="text" class="form-control" name="contact_no" required="true" value="<?php echo $row['contact_no']?>">
													</div>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Password</b></small>
														<input type="password" class="form-control" name="password" required="true">
													</div>
													<div class="col-xs-6" style="padding:2px;">
														<small><b>Re-enter Password</b></small>
														<input type="password" class="form-control" name="" required="true" >
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
													<div class="col-xs-12" style="padding:2px;">
														<small><b>Upload Photo</b></small>
														<input type="file" name="image" class="form-control" required="true">
													</div>
													<span style="float:left; width:100%; padding:5px;"></span>
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
						<div class="modal modal-danger fade" id="modalRemove<?php echo strtoupper($row['patient_id'])?>">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"></h4>
									</div>
									<form method="POST">
										<div class="modal-body">
											<input type="hidden" class="form-control" name="class_id" required="true" value="<?php echo strtoupper($row['patient_id'])?>">
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="cmdSave">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>