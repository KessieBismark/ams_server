<?php

if($action=='assign_role'){
    try{
        $cid = $_POST['cid'];
        $per = $_POST['permission'];
        $per = $per.trim(',');
        $cmd = "UPDATE `users` SET `access` = '$per' WHERE cid = '$cid'";
        $query = mysqli_query($conn,$cmd);
        if($query ){
            echo json_encode("true");
        }else{
            echo json_encode("false");
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


?>
