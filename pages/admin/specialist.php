<?php
	if(isset($_POST['cmdSave'])) {
		if(isset($_POST['class_id'])) {
			$ssql = "DELETE FROM `tblspecialist` WHERE `id` = '".$_POST['class_id']."'";
			$data_result->executeSQL($ssql,"icare");
		}
		
		$ssql = "INSERT INTO `tblspecialist`(`specialist_name`) VALUES ('".$_POST['specialist_name']."')";
		$data_result->executeSQL($ssql,"icare");

		echo "<script>self.location = '?menu_id=0&sub_menu_id=5';</script>";
	}


	if(isset($_POST['cmdRemove'])) {
		$ssql = "DELETE FROM `tblspecialist` WHERE `id` = '".$_POST['class_id']."'";
		$data_result->executeSQL($ssql,"icare");
		
		echo "<script>self.location = '?menu_id=0&sub_menu_id=5';</script>";
	}
?>
<div class="box-header with-border">
	<h3 class="box-title">Specialist</h3>
	<button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><b><i class="fa fa-plus"></i> ADD</b></button>
</div>
<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center; width:5%;">Count</th>
				<th style="text-align:center;">Specialist</th>
				<th style="text-align:center;"></th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				$cc = 0;
				$ssql = "SELECT `id`, `specialist_name` FROM `tblspecialist`";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{ 
					$cc = $cc + 1;
					?>
						<tr>
							<td style="center"><?php echo number_format($cc,0)?></td>
							<td><?php echo strtoupper($row['specialist_name'])?></td>
							<td>
								<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-pencil"></i> </b></small></button>
								<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalRemove<?php echo strtoupper($row['id'])?>"><small><b><i class="fa fa-times"></i> </b></small></button>
							</td>
						</tr>
						<div class="modal fade" id="modalEdit<?php echo strtoupper($row['id'])?>">
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
													<input type="hidden" class="form-control" name="class_id" required="true" value="<?php echo strtoupper($row['id'])?>">
													<div class="col-xs-12" style="padding:2px;">
														<small><b>Specialist</b></small>
														<input type="text" class="form-control" name="specialist_name" required="true" value="<?php echo $row['specialist_name']?>">
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
								<small><b>Specialist</b></small>
								<input type="text" class="form-control" name="specialist_name" required="true" value="">
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