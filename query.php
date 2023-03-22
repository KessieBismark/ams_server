<?php
header("Access-Control-Allow-Origin: *");
require_once 'db_config/config.php';

$db_data = array();

$action = $_POST['action'];
include_once 'sections/employee.php';
include_once 'sections/department.php';
include_once 'sections/branches.php';
include_once 'sections/sms/api.php';
include_once 'sections/sms/sms.php';
include_once 'sections/permissions.php';
include_once 'sections/dailly_attendance.php';
include_once 'sections/overtime.php';
include_once 'sections/absent-report.php';
include_once 'sections/absent.php';
include_once 'sections/monthly.php';
include_once 'sections/holiday.php';
include_once 'sections/accounts/role.php';
include_once 'sections/accounts/users.php';
include_once 'sections/sms/api.php';
include_once 'sections/sms/sms.php';
include_once 'sections/company/company.php';
include_once 'sections/dash.php';
?>