<div class="box-header with-border">
	<h3 class="box-title">Users</h3>
</div>
<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center; width:5%;">Count</th>
				<th style="text-align:center;">User ID</th>
				<th style="text-align:center;">Username</th>
				<th style="text-align:center;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$cc = 0;
				$ssql = "SELECT `user_id`, `username`, `user_type` FROM `tblusers`";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{ 
					$cc = $cc + 1;
					?>
						<tr>
							<td style="center"><?php echo number_format($cc,0)?></td>
							<td><?php echo strtoupper($row['user_id'])?></td>
							<td><?php echo strtoupper($row['username'])?></td>
							<td>
								<?php 
									if($row['user_type'] == 1) { echo "Client"; } 
									elseif($row['user_type'] == 2) { echo "Doctors"; }
									else { echo "Admin"; }
								?>
							</td>
						</tr>
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