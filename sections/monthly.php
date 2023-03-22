<?php

if($action == 'by_date'){
    try{

        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate));

    // $shop = $_POST['shop'];
    // $emp = $_POST['employee'];
    // $sdate =$_POST['sdate'];
    // $edate = $_POST['edate'];
    // $sdate =  date("Y-m-d", strtotime($sdate . ' -1 day'));
    // $edate =  date("Y-m-d", strtotime($edate));
       $whereClause = "WHERE e.cid = '$cid' AND e.active = 1 and e.resigned >= CURRENT_DATE  and a.date between '$sDate' and '$eDate' ";
       if($branch != 0){
           $whereClause = $whereClause . " AND a.branch='$branch' ";
       }
       if($dep !=0){
           $whereClause = $whereClause . " AND e.department='$dep' ";
       }
       if($staff !=0){
           $whereClause = $whereClause . "AND a.`staff_id` = '$staff' ";
       }
         $cmd = "SELECT a.staff_id, e.Surname,e.Middle_name,e.first_name, s.name as department ,a.in_time,a.out_time,a.overtime,a.date,a.hours,b.name as branch
          from attendance a INNER join employee e INNER join department s inner join branches b on b.id=e.branch and a.staff_id = e.staff_id and 
          e.department = s.id $whereClause order by e.staff_id,a.date ASC"; 
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

if($action == 'by_time'){
    try{

        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $sDate =  mysqli_real_escape_string($conn, $_POST['sdate']);
        $sDate =  date("Y-m-d", strtotime($sDate));
        $eDate =  mysqli_real_escape_string($conn, $_POST['edate']);
        $eDate =  date("Y-m-d", strtotime($eDate));
        $period = $_POST['period'];
        $time = $_POST['time'];
        $time = date("H:i:s", strtotime($time));
        $report = $_POST['report'];


        $whereClause = "WHERE e.cid = '$cid' AND (e.Active = 1 OR e.Resigned >= $eDate)
         and a.date between '$sDate' and '$eDate'";
       if($branch != 0){
           $whereClause = $whereClause . " AND e.branch='$branch' ";
       }
       if($dep !=0){
           $whereClause = $whereClause . " AND e.department='$dep' ";
       }
       if($staff !=0){
           $whereClause = $whereClause . "AND a.`staff_id` = '$staff' ";
       }
       
  
        if ($period == "1" ){
            if($report == 'Summary'){
                $cmd = "SELECT a.Staff_ID,e.Surname,e.Middle_name,e.first_name, s.name as department, count(*) 
                as Count, GROUP_CONCAT(a.In_Time) as 'Time',b.name as branch, 
                GROUP_CONCAT(a.`Date`) as 'Dates',s.name as department FROM `attendance` a inner join employee 
                e inner join department s inner join branches b on b.id=e.branch and  a.staff_id = e.staff_id 
                and e.department = s.id  $whereClause and a.`In_Time`
                 >= '$time' group by a.`Staff_ID` order by Count DESC";
             }else{
                   $cmd = "SELECT a.staff_id, e.Surname,e.Middle_name,e.first_name, s.name as department ,a.in_time,a.out_time,a.overtime,a.date,a.hours,b.name as branch
                  from attendance a INNER join employee e INNER join department s inner join branches b on b.id=e.branch and a.staff_id = e.staff_id and 
                  e.department = s.id $whereClause and a.`In_Time`
                     >= '$time' order by e.staff_id,a.date ASC"; 
             }
        }else  {
             if($report == 'Summary'){
                    $cmd = "SELECT a.Staff_ID,e.Surname,e.Middle_name,e.first_name, s.name as department, 
                    count(*) as Count, GROUP_CONCAT(a.In_Time) as 'Time' ,b.name as branch,
                    GROUP_CONCAT(a.`Date`) as 'Dates',s.name as department FROM `attendance` a inner join employee
                     e inner join department s inner join branches b on b.id=e.branch and a.staff_id = 
                     e.staff_id and e.department = s.id  $whereClause and a.`Out_Time` 
                     >= '$time' group by a.`Staff_ID` order by Count DESC";
             } else{
                   $cmd = "SELECT a.staff_id, e.Surname,e.Middle_name,e.first_name, s.name as department ,a.in_time,a.out_time,a.overtime,a.date,a.hours,b.name as branch
                  from attendance a INNER join employee e INNER join department s inner join branches b on b.id=e.branch and a.staff_id = e.staff_id and 
                  e.department = s.id $whereClause and a.`Out_Time` 
             >= '$time' order by e.staff_id,a.date ASC"; 
             }
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