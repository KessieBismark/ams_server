<?php

if($action == 'overtime'){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate ));

    // $sdate =  date("Y-m-d", strtotime($sdate . ' -1 day'));
    // $edate =  date("Y-m-d", strtotime($edate));
    $whereClause = "WHERE  a.date between '$sDate' and '$eDate'
    AND  e.cid = '$cid' AND (e.Active = 1 OR e.Resigned >= $eDate )";
   if($branch != 0){
       $whereClause = $whereClause . " AND a.branch='$branch' ";
   }
   if($dep !=0){
       $whereClause = $whereClause . " AND s.ID='$dep' ";
   }
   if($staff !=0){
       $whereClause = $whereClause . "AND a.staff_id = '$staff' ";
   }
    $cmd = "SELECT a.`staff_id`, e.Surname,e.Middle_name,e.first_name,s.name as department,b.name as branch,
     sum(TRIM( SUBSTRING_INDEX(a.`overtime`,'~',1))) 
         AS total_seconds FROM `attendance` a inner join employee e inner join branches b inner join
          department s on a.`staff_id`= e.`staff_id` and e.`department`= s.id and b.id = a.branch 
          $whereClause
            GROUP by a.`staff_id`";

    $query = mysqli_query($conn,$cmd);
    mysqli_close($conn);
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