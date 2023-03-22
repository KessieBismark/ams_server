<?php

if($action == "add_api"){
try{
    $api =mysqli_real_escape_string($conn, $_POST['api']);
    $header =mysqli_real_escape_string($conn, $_POST['header']);

    
    $cid = $_POST['cid'];
    // $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    // $where = "WHERE cid = '$cid'";
    // if($branch !=0){
    //     $where = $where . " and branch='$branch'";
    // }
    $cmd2 = "delete  FROM `sms_api` $where ";
    $query = mysqli_query($conn,$cmd2);
       
                $cmd = "INSERT INTO `sms_api`( `api`, `header`,cid) 
                VALUES ('$api','$header','$cid');";
                $query3 = mysqli_query($conn,$cmd);
                if(!($query3)){
                    echo $failed;
                }else{
                    echo $true;
                }   
   
 } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == "view_api"){

    $cid = $_POST['cid'];
    // $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    // $where = "WHERE cid = '$cid'";
    // if($branch !=0){
    //     $where = $where . " and branch='$branch'";
    // }

    $cmd = "SELECT * FROM `sms_api` where cid='$cid';";
    $query = mysqli_query($conn,$cmd);
    $row = mysqli_num_rows($query);
    if(! $query ){
        echo $failed;
    }else{  
        if($row > 0){
            while($view = mysqli_fetch_assoc($query)){
                $db_data[] = $view;
            }
            echo json_encode($db_data);
        }else{
            echo $false;
        }
      
    }
}

?>