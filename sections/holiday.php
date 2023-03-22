<?php


if($action == 'add_holiday'){
    try{
        $date =mysqli_real_escape_string($conn, $_POST['date']);
        $des = mysqli_real_escape_string($conn,$_POST['des']);
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $date =  date("Y-m-d", strtotime($date));
        $cid = $_POST['cid'];
        $cmd2 = "SELECT * FROM `holidays` WHERE date = '$date' and cid = 
        '$cid' and branch='$branch'";
        $row = mysqli_num_rows(mysqli_query($conn,$cmd2));
        if ($row < 1){
            $cmd = "INSERT INTO `holidays`( `date`, `description`, `cid`, `branch`)  
            VALUES ('$date','$des','$cid','$branch')";
            $querry  = mysqli_query($conn,$cmd);
            mysqli_close($conn);
            if($querry){
                echo $true;
            }else{
                echo $false;  
            }
        }else{
            mysqli_close($conn);
            echo json_encode("duplicate");
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }

}



if($action == 'update_holiday'){
    try{
        $id =  $_POST['id'];
        $date =mysqli_real_escape_string($conn, $_POST['date']);
        $des = mysqli_real_escape_string($conn,$_POST['des']);
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $date =  date("Y-m-d", strtotime($date));
        $cid = $_POST['cid'];
         $cmd = "UPDATE `holidays` SET `date`='$date'
         ,`description`='$des',`cid`='$cid',`branch`='$branch' WHERE `id`='$id'";
        $querry  = mysqli_query($conn,$cmd);
        mysqli_close($conn);
        if($querry){
            echo $true;
        }else{
            echo $false;  
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
    
}


if($action == "delete_holiday"){
    $id =mysqli_real_escape_string($conn, $_POST['id']);
    //$cid = $_POST['cid'];
    $cmd = "delete from `holidays` WHERE id ='$id' ;";
    $query = mysqli_query($conn,$cmd);    
    if(!$query){
        echo $failed;
    }else{        
        echo $true;
    }      
}



if($action == "view_holiday"){
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    $where = "WHERE cid = '$cid'";
    if($branch !=0){
        $where = $where . " and branch='$branch'";
    }
    $cmd = "SELECT h.id,h.date,h.description,h.cid,b.name as branch FROM holidays h INNER JOIN
    branches b on b.id = h.branch  $where
   ";
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