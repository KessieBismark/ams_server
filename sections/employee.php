<?php


if($action == "add_employee"){
    try{
        $staffID =mysqli_real_escape_string($conn, $_POST['staffID']);
        $lname =mysqli_real_escape_string($conn, $_POST['surname']);
        $gender =mysqli_real_escape_string($conn, $_POST['gender']);
        $department =mysqli_real_escape_string($conn, $_POST['department']);
        $wh =mysqli_real_escape_string($conn, $_POST['hour']);
        $dob =mysqli_real_escape_string($conn, $_POST['dob']);
        $residence =mysqli_real_escape_string($conn, $_POST['residence']);
        $contact =mysqli_real_escape_string($conn, $_POST['contact']);
        $eContact =mysqli_real_escape_string($conn, $_POST['econtact']);
        $Hired_Date =mysqli_real_escape_string($conn, $_POST['hdate']);
        $Active =mysqli_real_escape_string($conn, $_POST['active']);
        $Resigned =mysqli_real_escape_string($conn, $_POST['resigned']);
        $bank =mysqli_real_escape_string($conn, $_POST['bank']);
        $ssnit =mysqli_real_escape_string($conn, $_POST['ssnit']);
        $fname =mysqli_real_escape_string($conn, $_POST['firstname']);
        $mname =mysqli_real_escape_string($conn, $_POST['middlename']);
        $accountNo =mysqli_real_escape_string($conn, $_POST['account']);
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $Hired_Date = date("Y-m-d", strtotime($Hired_Date));
        $Resigned = date("Y-m-d", strtotime($Resigned));
        $dob = date("Y-m-d", strtotime($dob));
        $cid = $_POST['cid'];
        $cmd2 = "select * from employee where surname='$lname' and first_name='$fname'  and cid='$cid' and branch ='$branch'";
        $query = mysqli_query($conn,$cmd2);
        $rows = mysqli_num_rows($query);

            if($rows >0){
                echo $duplicate;
            }else{     
            
                if($branch ==0){
                    $cmd = "INSERT INTO `employee`(`Staff_ID`, `Surname`, `first_name`,
                    `Middle_name`, `Gender`, `Department`, `Working_Hours`, `DOB`, `bank`,
                     `accountNo`, `ssnit`, `Residence`, `Contact`, `Emergency_Contact`, 
                     `Hired_Date`, `Active`, `Resigned`,cid, branch) VALUES ('$staffID','$lname',
                     '$fname','$mname','$gender','$department',
                      '$wh','$dob','$bank','$accountNo','$ssnit','$residence','$contact','$eContact'
                     ,'$Hired_Date','$Active','$Resigned','$cid','$branch');";
                }else{
                    $cmd = "INSERT INTO `employee`(`Staff_ID`, `Surname`, `first_name`,
                    `Middle_name`, `Gender`, `Department`, `Working_Hours`, `DOB`, `bank`,
                     `accountNo`, `ssnit`, `Residence`, `Contact`, `Emergency_Contact`, 
                     `Hired_Date`, `Active`, `Resigned`,cid, branch) VALUES ('$staffID','$lname',
                     '$fname','$mname','$gender','$department' ,
                      '$wh','$dob'
                     ,'$bank','$accountNo','$ssnit','$residence','$contact','$eContact'
                     ,'$Hired_Date','$Active','$Resigned','$cid','$branch');";
                }
                 
                    $query3 = mysqli_query($conn,$cmd);
                    if(!($query3)){
                        echo $failed;
                    }else{
                        echo $true;
                    }    
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == "update_employee"){
    try{
        $staffID =mysqli_real_escape_string($conn, $_POST['staffID']);
        $lname =mysqli_real_escape_string($conn, $_POST['surname']);
        $gender =mysqli_real_escape_string($conn, $_POST['gender']);
        $department =mysqli_real_escape_string($conn, $_POST['department']);
        $wh =mysqli_real_escape_string($conn, $_POST['hour']);
        $dob =mysqli_real_escape_string($conn, $_POST['dob']);
        $residence =mysqli_real_escape_string($conn, $_POST['residence']);
        $contact =mysqli_real_escape_string($conn, $_POST['contact']);
        $eContact =mysqli_real_escape_string($conn, $_POST['econtact']);
        $Hired_Date =mysqli_real_escape_string($conn, $_POST['hdate']);
        $Active =mysqli_real_escape_string($conn, $_POST['active']);
        $Resigned =mysqli_real_escape_string($conn, $_POST['resigned']);
        $bank =mysqli_real_escape_string($conn, $_POST['bank']);
        $ssnit =mysqli_real_escape_string($conn, $_POST['ssnit']);
        $fname =mysqli_real_escape_string($conn, $_POST['firstname']);
        $mname =mysqli_real_escape_string($conn, $_POST['middlename']);
        $accountNo =mysqli_real_escape_string($conn, $_POST['account']);
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $Hired_Date = date("Y-m-d", strtotime($Hired_Date));
        $Resigned = date("Y-m-d", strtotime($Resigned));
        $dob = date("Y-m-d", strtotime($dob));
      
          
            $cid = $_POST['cid'];
            if($branch==0){
                $cmd =   "UPDATE `employee` SET `Surname`='$lname',`Middle_name`='$mname', branch='$branch',
                `first_name`='$fname',`Gender`='$gender',`Department`='$department',
                `ssnit`='$ssnit',`accountNo`='$accountNo',`bank`='$bank',
                `Working_Hours`='$wh',`DOB`='$dob',`Residence`='$residence'
                ,`Contact`='$contact',`Emergency_Contact`='$eContact',
                `Hired_Date`='$Hired_Date',`Active`='$Active',`Resigned`='$Resigned'
                 WHERE Staff_ID='$staffID' and cid= '$cid' ";
            }else{
                $cmd =   "UPDATE `employee` SET `Surname`='$lname',`Middle_name`='$mname', branch='$branch',
                `first_name`='$fname',`Gender`='$gender',`Department`='$department',
                `ssnit`='$ssnit',`accountNo`='$accountNo',`bank`='$bank',
                `Working_Hours`='$wh',`DOB`='$dob',`Residence`='$residence'
                ,`Contact`='$contact',`Emergency_Contact`='$eContact',
                `Hired_Date`='$Hired_Date',`Active`='$Active',`Resigned`='$Resigned'
                 WHERE Staff_ID='$staffID' and cid= '$cid'   ";
            }
        
                    $query = mysqli_query($conn, $cmd);
                    if(!$query){
                        echo $failed;
                    }else{
                          echo $true;
                    }     
                
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == "delete_employee"){
    $id =mysqli_real_escape_string($conn, $_POST['id']);
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    $cid = $_POST['cid'];
if($branch ==0){
    $cmd = "delete from `employee` WHERE Staff_ID ='$id' and cid='$cid' and branch=(select id from branches where name='$branch')  ;";

}else{
    $cmd = "delete from `employee` WHERE Staff_ID ='$id' and cid='$cid'  and branch='$branch';";

}
            $query = mysqli_query($conn,$cmd);
            
            if(!$query){
                echo $failed;
            }else{
              
                echo $true;
            }      
}
if($action == "emp_list"){ 
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    if($branch ==0){
        $cmd = "SELECT e.`Staff_ID`, e.`Surname`,
        e.`Middle_name`, e.`first_name`,e.`Gender`,d.Name as Department
       , e.`ssnit`, e.`accountNo`,
       e.`bank`, e.`Working_Hours`, e.`DOB`,
       e.`Residence`, e.`Contact`,
       e.`Emergency_Contact`, e.`Hired_Date`,e.`Department` as did,e.branch as bid,
       e.`Active`, e.`Resigned`
              , e.`finger`,b.name as branch
               FROM `employee` e INNER JOIN department d INNER JOIN branches b
                on d.ID = e.Department and b.id = e.branch where e.cid = '$cid'  ";
    }else{
        $cmd = "SELECT e.`Staff_ID`, e.`Surname`,
        e.`Middle_name`, e.`first_name`, e.`Gender`,d.Name as Department
       , e.`ssnit`, e.`accountNo`,
       e.`bank`, e.`Working_Hours`, e.`DOB`,
       e.`Residence`, e.`Contact`,
       e.`Emergency_Contact`, e.`Hired_Date`,e.`Department` as did,e.branch as bid,
       e.`Active`, e.`Resigned`
              , e.`finger`,b.name as branch
               FROM `employee` e INNER JOIN department d INNER JOIN branches b
                on d.ID = e.Department and b.id = e.branch where e.cid = '$cid'  
                and e.branch='$branch' ";
    }
  
   $query =mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{
       
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
}



if($action == "emp_list_by_parm"){ 
    $cid = $_POST['cid'];
    $department = $_POST['department'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);

       $whereClause = "WHERE e.cid = '$cid' and (e.Active = 1 OR e.Resigned > CURRENT_DATE) ";
        if($branch != 0){
            $whereClause = $whereClause . " AND e.branch ='$branch' ";
        }
        if($department !=0){
            $whereClause = $whereClause . " AND d.ID ='$department' ";
        }
        $cmd = "SELECT e.`Staff_ID`, e.`Surname`,e.`Middle_name`, e.`first_name`, e.`Gender`,d.Name as Department
        , e.`ssnit`, e.`accountNo`,e.`bank`, e.`Working_Hours`, e.`DOB`,
        e.`Residence`, e.`Contact`,e.`Emergency_Contact`, e.`Hired_Date`,
        e.`Active`, e.`Resigned`, e.`finger`,b.name as branch
        FROM `employee` e INNER JOIN department d INNER JOIN branches b
        on d.ID = e.department and b.id = e.branch  $whereClause ";
   $query =mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{
       
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
    }
}

if($action == "get_max_id"){ 
    $cid = $_POST['cid'];
        $cmd = "SELECT (MAX(Staff_ID)+1) as id FROM `employee` WHERE cid = '$cid'";
   $query =mysqli_query($conn,$cmd);
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