<?php


if($action == 'add_department'){
    try{
        $name =mysqli_real_escape_string($conn, $_POST['name']);
        $swkd = mysqli_real_escape_string($conn,$_POST['swkd']);
        $swknd = mysqli_real_escape_string($conn,$_POST['swknd']);
        $wkd = mysqli_real_escape_string($conn,$_POST['wkd']);
        $wkn =mysqli_real_escape_string($conn, $_POST['wkn']);
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $wkd = date("H:i:s", strtotime($wkd));
        $wkn = date("H:i:s", strtotime($wkn));
        $swkd = date("H:i:s", strtotime($swkd));
        $swknd = date("H:i:s", strtotime($swknd));
        $cid = $_POST['cid']; 
        $cmd2 = "select * from department where name = '$name' and cid = 
        '$cid' and branch='$branch'";
        $row = mysqli_num_rows(mysqli_query($conn,$cmd2));
        if ($row < 1){
            $cmd = "INSERT INTO `department`( `Name`, `week_start`, `Weekdays`, `weekend_start`, `Weekend`, `cid`,branch)
            VALUES ('$name','$swkd','$wkd','$swknd','$wkn','$cid','$branch')";
            $querry  = mysqli_query($conn,$cmd);
            mysqli_close($conn);
            if($querry){
                echo json_encode("true");
            }else{
                echo json_encode( "false");  
            }
        }else{
            mysqli_close($con);
            echo json_encode("duplicate");
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }

}



if($action == 'update_department'){
    try{
        $id =  $_POST['id'];
        $name =mysqli_real_escape_string($conn, $_POST['name']);
        $swkd = mysqli_real_escape_string($conn,$_POST['swkd']);
        $swknd = mysqli_real_escape_string($conn,$_POST['swknd']);
        $wkd = mysqli_real_escape_string($conn,$_POST['wkd']);
        $wkn =mysqli_real_escape_string($conn, $_POST['wkn']);
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $wkd = date("H:i:s", strtotime($wkd));
        $wkn = date("H:i:s", strtotime($wkn));
        $swkd = date("H:i:s", strtotime($swkd));
        $swknd = date("H:i:s", strtotime($swknd));
        $cid = $_POST['cid'];
         $cmd = "update department set Name='$name', Weekdays= '$wkd',
          Weekend='$wkn', `week_start`= '$swkd', `weekend_start`='$swknd' 
          where ID = '$id' and cid='$cid' ";
        $querry  = mysqli_query($conn,$cmd);
        mysqli_close($conn);
        if($querry){
            echo json_encode("true");
        }else{
            echo json_encode( "false");  
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
    
}


if($action == "delete_department"){
    $id =mysqli_real_escape_string($conn, $_POST['id']);
    $cid = $_POST['cid'];
    $cmd = "delete from `department` WHERE id ='$id' and cid='$cid' ;";
    $query = mysqli_query($conn,$cmd);    
    if(!$query){
        echo $failed;
    }else{        
        echo $true;
    }      
}

if($action == "view_department"){
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    if($branch==0){
        $cmd = "SELECT d.`ID`, d.`Name`, d.`week_start`, d.`Weekdays`, 
        d.`weekend_start`, d.`Weekend`,b.name as branch FROM `department` 
        d INNER JOIN branches b on d.branch = b.id where cid = '$cid' ";

    }else{
        $cmd = "SELECT d.`ID`, d.`Name`, d.`week_start`, d.`Weekdays`,
         d.`weekend_start`, d.`Weekend`,b.name as branch FROM `department`
          d INNER JOIN branches b on d.branch = b.id where cid = '$cid'
           and branch='$branch'";
    }
  $query = mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{  
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
}

if($action == "view_department_by_branch"){
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    if($branch == 0){
        $cmd = "SELECT d.`ID`, d.`Name`, d.`week_start`, d.`Weekdays`,
        d.`weekend_start`, d.`Weekend`,b.name as branch FROM `department`
         d INNER JOIN branches b on d.branch = b.id where cid = '$cid'";
    }else{
        $cmd = "SELECT d.`ID`, d.`Name`, d.`week_start`, d.`Weekdays`,
         d.`weekend_start`, d.`Weekend`,b.name as branch FROM `department`
          d INNER JOIN branches b on d.branch = b.id where cid = '$cid'
           and branch='$branch'";
 }
  $query = mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{  
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
}

?>