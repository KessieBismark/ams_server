<?php

if($action == "add_sms"){
try{
     $rc =mysqli_real_escape_string($conn, $_POST['receiver']);
    $meg =mysqli_real_escape_string($conn, $_POST['meg']);
    $branch =$_POST['branch'];
    $cid = $_POST['cid'];
    $dep =  $_POST['department'];
    $staff = $_POST['staff_id'];
    if($rc =='Staff'){
        if($dep == 0 && $staff == 0){
            $cmd = "INSERT INTO `sms`( `reciever`, `message`,cid,branch) 
            VALUES ('All staff','$meg','$cid','$branch');";
        }elseif($dep ==0 && $staff !=0){
            $cmd = "INSERT INTO `sms`( `receiver`, `message`,cid,branch) 
            VALUES ((SELECT Surname FROM employee where Staff_ID ='$staff'),'$meg','$cid','$branch');";
        }elseif($dep !=0 && $staff ==0){
            $cmd = "INSERT INTO `sms`( `reciever`, `message`,cid,branch) 
            VALUES ((SELECT Name FROM department where ID ='$dep'),'$meg','$cid','$branch');";
        }else{
            $cmd = "INSERT INTO `sms`( `reciever`, `message`,cid,branch) 
            VALUES ((SELECT Surname FROM employee  where Staff_ID ='$staff') ,'$meg','$cid','$branch');";
        }
    }else{
        $cmd = "INSERT INTO `sms`( `receiver`, `message`,cid,branch) 
        VALUES ('$rc','$meg','$cid','$branch');";
    }
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

if($action == "get_contacts"){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $whereClause = "WHERE e.cid = '$cid'  AND e.contact !='' 
        AND (e.Active = 1 OR e.Resigned > CURRENT_DATE) ";
       if($branch != 0){
           $whereClause = $whereClause . " AND b.id='$branch' ";
       }
       if($dep !=0){
           $whereClause = $whereClause . " AND d.ID ='$dep' ";
       }
       if($staff !=0){
           $whereClause = $whereClause . " AND e.`Staff_ID` = '$staff' ";
       }
             $cmd2 = "SELECT e.`Staff_ID`, e.`Surname`,e.`Middle_name`, e.`first_name`, e.`Gender`,d.Name as Department
             , e.`ssnit`, e.`accountNo`,e.`bank`, e.`Working_Hours`, e.`DOB`,
             e.`Residence`, e.`Contact`,e.`Emergency_Contact`, e.`Hired_Date`,
             e.`Active`, e.`Resigned`, e.`finger`,b.name as branch
             FROM `employee` e INNER JOIN Department d INNER JOIN branches b
             on d.ID = e.Department and b.id = e.branch $whereClause ";
             $q2 = mysqli_query($conn,$cmd2);
             $view = mysqli_fetch_assoc($q2);
             $query = mysqli_query($conn,$cmd2);
             if(! $query ){
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


if($action == "view_sms"){
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    $where = "WHERE cid = '$cid'";
    if($branch !=0){
        $where = $where . " and branch='$branch'";
    }

    $cmd = "SELECT * FROM `sms` $where;";
    $query = mysqli_query($conn,$cmd);
    if(! $query ){
        echo $failed;
    }else{  
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
}

?>