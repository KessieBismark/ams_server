<?php
$server = 'localhost';
$username = 'royalfo5_shop';
$password = '2dL^7.j~#.2Y';
$database = 'royalfo5_rf_ams';
$conn = mysqli_connect($server,$username,$password,$database) or die("cannot connect to database".mysqli_error($conn));
 
$failed =  json_encode("Sql statement failed");
$true = json_encode("true");
$false = json_encode("false");
$duplicate = json_encode("duplicate");
function generateRandomString($length = 6) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function sanitize($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

function checkSunday($date){
        $date = date("Y-m-d", strtotime($date));
        $timestamp = strtotime($date);
    $weekday= date("l", $timestamp );
    $normalized_weekday = strtolower($weekday);
    if ( ($normalized_weekday == "sunday")) {
        return true;
    } else {
        return false;
    }
}
?>