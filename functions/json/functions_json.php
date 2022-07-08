<?php
	require_once("../connections/connection.php");
	if (!isset($_SESSION)){ session_start(); }
	error_reporting(E_ALL ^ E_ALL);
	function left($str, $length) { return substr($str, 0, $length); }
	function right($str, $length) { return substr($str, -$length); }
	date_default_timezone_set('Asia/Manila');
	
	switch ($_GET['data']) {
		case 1:
				$status = 0;
				$pass = $_GET['new_password'];
				
				$ssql = "SELECT `id` FROM `tblusers` WHERE `user_id` = '".$_SESSION['user_id']."' AND `password` = '".$pass."'";
				$inn = $data_result->executeSQL($ssql,"icare");
				$rs = mysqli_fetch_array($inn);
				if($rs!=0) { 
					$status = 1;
				}
				
				echo json_encode($status);
			break;
		case 2:
				$pass = "";
				$pass = $_GET['new_password'];
		
				$ssql = "UPDATE `tblusers` SET `password`='".$pass."' WHERE `user_id`='".$_SESSION['user_id']."'";
				$data_result->executeSQL($ssql,"icare");
				
				echo json_encode("");
			break;
		case 3:
				$results = "";
				$results .='<option value="">Select</option>';
				$ssql = "SELECT `doc_id`, `fullname` FROM `tbldoctors` WHERE `specialist_id` = '".$_GET['specialist_id']."'";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{
					$results .='<option value="'.$row['doc_id'].'">'.$row['fullname'].'</option>';
				}
				
				echo json_encode($results);
			break;
		case 4:
				$results = "";
				$results .='<option value="">Select</option>';
				$ssql = "SELECT `clinic_id` FROM `tbldoctors_schedule` WHERE `doctors_id`  = '".$_GET['doctors_id']."' GROUP BY `clinic_id`";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{
					$clinic_name = "";
					$ssql = "SELECT `clinic_name` FROM `tblclinic` WHERE `clinic_id` = '".$row['clinic_id']."'";
					$inn = $data_result->executeSQL($ssql,"icare");
					$rs = mysqli_fetch_array($inn);
					if($rs!=0) {
						$clinic_name = strtoupper($rs['clinic_name']);
					}
					
					$results .='<option value="'.$row['clinic_id'].'">'.$clinic_name.'</option>';
				}
				
				echo json_encode($results);
			break;
		case 5:
				$results = "";
				$results .='<option value="">Select</option>';
				$ssql = "SELECT `id`, `schedule_date`, `schedule_from_time`, `schedule_to_time` FROM `tbldoctors_schedule` WHERE `doctors_id` = '".$_GET['doctors_id']."' AND `clinic_id` = '".$_GET['clinic_id']."' AND `schedule_date` > '".date('Y-m-d')."' ORDER BY `schedule_date` ASC";
				$result = $data_result->executeSQL($ssql,"icare");
				while($row = mysqli_fetch_array($result))
				{
					$schedule = date('Y-m-d',strtotime($row['schedule_date'])).' (From : '.date('h:i A',strtotime($row['schedule_from_time'])).' - To : '.date('h:i A',strtotime($row['schedule_to_time'])).')';
					
					$results .='<option value="'.$row['id'].'">'.$schedule.'</option>';
				}
				
				echo json_encode($results);
			break;
		default:
			break;
	}
	
	
?>
