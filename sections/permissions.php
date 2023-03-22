<?php


if($action == 'insert_permissions'){
    try{
        $dep = mysqli_real_escape_string($conn, $_POST['dep']);
        $name =  mysqli_real_escape_string($conn, $_POST['empName']);
        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $reason =mysqli_real_escape_string($conn, $_POST['reason']);
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate));
        $cid = $_POST['cid'];
        $type = $_POST['type'];
        $hour =$_POST['hour'];
        $days =$_POST['days'];

        $staffID = explode(',',$name);

        forEach($staffID as $staffID){
            $cmd = "INSERT INTO `onleave`( `staff_id`, `start_date`, `end_date`, `days`,
            `leave_hours`,`type`,`cid`,`branch`,`reason`)
            VALUES ('$staffID','$sDate','$eDate','$days','$hour','$type','$cid','$branch','$reason');";
             $querry  = mysqli_query($conn,$cmd);
        }
       
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

if($action == 'insert_perm'){
    try{
        $dep = mysqli_real_escape_string($conn, $_POST['dep']);
        $name =  mysqli_real_escape_string($conn, $_POST['empName']);
        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $reason =mysqli_real_escape_string($conn, $_POST['reason']);
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate));
        $cid = $_POST['cid'];
        $type = $_POST['type'];
        $hour =$_POST['hour'];
        $days =$_POST['days'];

        $staffID = explode(',',$name);

        forEach($staffID as $staffID){
            $cmd = "INSERT INTO `onleave`( `staff_id`, `start_date`, `end_date`, `days`,
            `leave_hours`,`type`,`cid`,`branch`,`reason`)
            VALUES ('$staffID','$sDate','$eDate','$days','$hour','$type','$cid','$branch','$reason');";
             $querry  = mysqli_query($conn,$cmd);
        }
       
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
if($action == 'search_permission'){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate));

        $whereClause = "WHERE o.start_date >= '$sDate' AND o.end_date <= '$eDate' 
         AND  e.cid = '$cid' ";
        if($branch != 0){
            $whereClause = $whereClause . " AND o.branch='$branch' ";
        }
        if($dep !=0){
            $whereClause = $whereClause . " AND o.ID='$dep' ";
        }
        if($staff !=0){
            $whereClause = $whereClause . "AND o.`staff_id` = '$staff' ";
        }
            $cmd = "SELECT o.id,e.staff_id, e.Surname,e.Middle_name,e.first_name, 
            s.name as department, o.`start_date`, o.`end_date`,o.`days`,o.`leave_hours`
            ,o.`date`,o.`type`,o.reason,b.name as branch FROM `onleave` o inner join employee e inner join branches b INNER join 
            department s on o.`staff_id` = e.staff_id and e.department = s.id and b.id=e.branch $whereClause 
            order by date DESC ";
    
        $query = mysqli_query($conn,$cmd);
        $rows = mysqli_num_rows($query);
        if ($rows > 0 ){
            while($view = mysqli_fetch_assoc($query)){
                $db_data[] = $view;
            }
            echo json_encode($db_data);
        }else{
            echo $false;
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == 'get_duration'){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $whereClause = "WHERE cid= '$cid' and branch='$branch'";
        $dep = $_POST['department'];
        if($dep != 0){
          $whereClause= $whereClause ." and    ID= '$dep'";
        }
        $cmd = "SELECT SUBTIME(`weekdays`,`week_start`) as weekHour,
        SUBTIME(`weekend`,`weekend_start`) as wknH FROM `department` $whereClause
        ";
        $query = mysqli_query($conn,$cmd);
        $rows = mysqli_num_rows($query);
        if ($rows > 0 ){
            while($view = mysqli_fetch_assoc($query)){
                $db_data[] = $view;
            }
            echo json_encode($db_data);
        }else{
            echo $false;
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}

if($action == 'delete_permissions'){
    try{
    $id = $_POST['id'];
    $cid = $_POST['cid'];
    $cmd =  "delete from `onleave` where id= '$id' and cid='$cid'";
    $querry  = mysqli_query($conn,$cmd);
    if($querry ){
        echo json_encode("true");
    }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == 'view_permissions'){
    try{
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $cid = $_POST['cid'];
        if($branch== 0){
            $cmd = "SELECT o.id,e.staff_id, e.Surname,e.Middle_name,e.first_name, 
            s.name as department, o.`start_date`, o.`end_date`,o.`days`,o.`leave_hours`
            ,o.`date`,o.`type`,b.name as branch FROM `onleave` o inner join employee e inner join branches b INNER join 
            department s on o.`staff_id` = e.staff_id and e.department = s.id  and b.id=e.branch WHERE o.cid = '$cid' and MONTH(o.date) = MONTH(CURRENT_DATE)
            order by date DESC LIMIT 20";
        }else{
            $cmd = "SELECT o.id,e.staff_id, e.Surname,e.Middle_name,e.first_name, 
            s.name as department, o.`start_date`, o.`end_date`,o.`days`,o.`leave_hours`
            ,o.`date`,o.`type`,o.reason,b.name as branch FROM `onleave` o inner join employee e inner join branches b INNER join 
            department s on o.`staff_id` = e.staff_id and e.department = s.id and and MONTH(o.date) = MONTH(CURRENT_DATE) b.id=e.branch WHERE o.cid = '$cid'
            and o.branch='$branch' order by date DESC  LIMIT 20";
        }
        $query = mysqli_query($conn,$cmd);
        $rows = mysqli_num_rows($query);
        if ($rows > 0 ){
            while(   $view = mysqli_fetch_assoc($query)){
                $db_data[] = $view;
            }
            echo json_encode($db_data);
        }else{
            echo $false;
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }

}
?>