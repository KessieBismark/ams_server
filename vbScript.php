<?php
header("Access-Control-Allow-Origin: *");
require_once 'db_config/config.php';

$db_data = array();

$action = $_POST['action'];

if($action == "emp_list"){ 
     try{
       $cid = $_POST['cid'];
    $branch = $_POST['branch'];
        $cmd = "SELECT e.`Staff_ID`,e.Surname,e.Middle_name,e.first_name, d.Name as 
        `Department`, e.`finger` as Finger FROM `employee` e INNER JOIN department d
        on d.ID= e.`Department` and  e.cid='$cid' and e.branch= '$branch' and sync= 1 ";
   $query =mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
} catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}
if($action == "show_data"){ 
     try{
    $sql = $_POST['query'];
    $query =mysqli_query($conn,$sql);
  if(!$query){
        echo $failed;
    }else{
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
} catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}

if($action == "record_count"){ 
     try{
    $sql = $_POST['query'];
    $query =mysqli_query($conn,$sql);
 if(!$query){
     echo 0;
 }else{
    $rows = mysqli_num_rows($query);
    echo $rows;
 }
} catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}

if($action == "get_value"){ 
     try{
    $sql = $_POST['query'];
    $query =mysqli_query($conn,$sql);
 if(!$query){
     echo 0;
 }else{
    $data = mysqli_fetch_assoc($query);
    echo $data['date'];
 }
} catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
    
}

if($action == "save_enroll_finger"){ 
    $query = $_POST['query'];
     $sql = new mysqli($server,$username,$password,$database);
    $sql->begin_transaction();
     $queryList = explode(";",$query);
    forEach($queryList as $queryList){
        $sql->query($queryList);
    }
    $sql->commit();
    echo "Transaction committed";
    // Close the connection
    $sql->close();
}

if($action == "save_attendance"){ 
    $query = $_POST['query'];
     $sql = new mysqli($server,$username,$password,$database);
    $sql->begin_transaction();
     $queryList = explode(";",$query);
    forEach($queryList as $queryList){
        $sql->query($queryList);
    }
    $sql->commit();
    echo "Transaction committed";
    // Close the connection
    $sql->close();

}

if($action == "get_import_details"){ 
     try{
       $cid = $_POST['cid'];
        $branch = $_POST['branch'];
        $cmd = "select e.Staff_ID,d.Name as Department,d.week_start,d.Weekdays,d.weekend_start,d.Weekend, 
        (Select TIMEDIFF((SELECT `weekdays` from department where id = e.Department and e.cid='$cid'
        and e.branch= '$branch'),(SELECT `week_start` from department where id = e.Department and
        e.cid='$cid' and e.branch= '$branch')) ) as Week_duration, (Select TIMEDIFF((SELECT `weekend` 
        from department where id = e.Department and e.cid='$cid' and e.branch= '$branch')
        ,(SELECT `weekend_start` from department where id = e.Department and e.cid='$cid' and
        e.branch= '$branch')) ) as Weekend_duration from employee e inner join department d on 
        e.Department = d.ID where  e.cid='$cid' and e.branch= '$branch'";
   $query =mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{ 
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
} catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == 'delete_attendance'){
    try{
        $query = $_POST['query'];
            $querry  = mysqli_query($conn,$query);
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
?>