<?php

if($action == 'savePerm'){
    try{
        $cid = $_POST['cid'];
        $staff_id = $_POST['staff_id'];
        $date =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $date =  date("Y-m-d", strtotime($date));
        $type = $_POST['type'];
        $reason =mysqli_real_escape_string($conn, $_POST['reason']);
        $hour =$_POST['hour'];
        $days =$_POST['days'];
        $cmd = "INSERT INTO `onleave`(`Staff_ID`, `Start_Date`, `End_Date`, `Days`, `Leave_Hours`, `Type`, `reason`, `cid`, `branch`) VALUES
        ('$staff_id','$date','$date','$days','$hour','$type','$reason','$cid',(select branch from employee where Staff_ID='$staff_id'))";
        $query = mysqli_query($conn,$cmd);
         mysqli_close($conn);
        if($query){
            echo $true;
        }else{
            echo $false;  
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }

}

if($action == 'absent_report'){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $branch =$_POST['branch'];

        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate . "+1 day"));
        $begin = new DateTime($sDate );
        $end = new DateTime($eDate);
        $delete = mysqli_query($conn,"DELETE FROM `absent` WHERE cid= $cid");

        $whereClause = "WHERE e.cid = '$cid' AND e.Active = 1     ";
        $hClause = "WHERE cid = '$cid' ";
       if($branch != 0){
           $whereClause = $whereClause . " AND e.branch='$branch' ";
           $hClause =  $hClause . " AND branch='$branch' ";
       }
       if($dep !=0){
           $whereClause = $whereClause . " AND e.department='$dep' ";
       }
       if($staff !=0){
           $whereClause = $whereClause . " AND e.`staff_id` = '$staff' ";
       }
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $hDays = array();
       $sql= "Select date from holidays $hClause";
       $qe3 = mysqli_query($conn,$sql);
       $rw = mysqli_num_rows($qe3);
       if($rw > 0 ){
        while( $view= mysqli_fetch_assoc($qe3)){
            $hDays[] = $view['date'];
        }
        
       }

        foreach ($period as $dt) {
                $curDate =  $dt->format("Y-m-d");
            if(checkSunday($curDate) == true){
                continue ;
            } else{
                if(in_array($curDate, $hDays)){
                    continue ;
                }else{  
                $qq = mysqli_query($conn,"SELECT e.staff_id,s.name as department FROM `employee` e
                inner join department s inner join branches b on e.department = s.id and e.branch
                 = b.id $whereClause and e.hired_date<= '$curDate' and e.staff_id not in (SELECT `staff_id` from attendance where Date =  '$curDate')");
                        while( $rc = mysqli_fetch_assoc($qq) ) {
                    $staff_id = $rc['staff_id'];
                        $onLeave= mysqli_fetch_assoc(mysqli_query($conn,"select * from onleave where staff_id
                        ='$staff_id' and start_date <= '$curDate' and end_date >= '$curDate' and cid = '$cid'"));
                    
                        $lRows= mysqli_num_rows(mysqli_query($conn,"select * from onleave where staff_id
                        ='$staff_id' and start_date <= '$curDate' and end_date >= '$curDate' and cid = '$cid'"));
                        if($lRows > 0){
                            $leave = $onLeave['Type'];
                            $q1 = mysqli_query($conn,"INSERT INTO `absent`(`Staff_ID`,`Leave_Type`, 
                            `Days`, `Date`,cid,branch) VALUES ('$staff_id','$leave',1,'$curDate','$cid','$branch')");
                        }else{
                            $q1 = mysqli_query($conn,"INSERT INTO `absent`(`Staff_ID`, `Leave_Type`, `Days`, `Date`,cid,branch
                            ) VALUES ('$staff_id','None',1,'$curDate','$cid','$branch')");
                        }
                    }  
                }
            }
        }
        
    $cmd = "SELECT a.Staff_ID,e.Surname,e.Middle_name,e.first_name,d.Name as department,a.Leave_Type,(SELECT COUNT(*)
     from absent where Staff_ID = a.Staff_ID and cid='$cid' and Leave_Type=a.Leave_Type) as 'days',b.name as branch, GROUP_CONCAT(cast( a.date as date) ) as 'date' 
     FROM absent a INNER JOIN employee e INNER JOIN department d INNER JOIN branches b on e.Staff_ID = a.Staff_ID AND
      e.Department = d.ID AND b.id = e.branch  Where a.`Leave_Type` = 'None' group by a.Leave_Type,e.Staff_ID "; 
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