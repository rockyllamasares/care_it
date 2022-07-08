<?php 
	switch ($_GET['menu_id']) {
		case 0:
				if(isset($_GET['sub_menu_id'])) {
					if($_GET['sub_menu_id'] == 1) { include 'dashboard/truck_requested.php'; }
					if($_GET['sub_menu_id'] == 2) { include 'dashboard/fuel_balance.php'; }
					if($_GET['sub_menu_id'] == 3) { include 'dashboard/employee_bday.php'; }
					if($_GET['sub_menu_id'] == 4) { include 'dashboard/employee_on_leave.php'; }
					if($_GET['sub_menu_id'] == 5) { include 'dashboard/record_logs.php'; }
				} else {
					include 'dashboard/dashboard.php';
				}
			break;
		case 2:
				
			break;
		case 3:
				
		default:
			break;
	}
?>