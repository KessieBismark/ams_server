<?php


if($action == 'daily_attendance'){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $date =  mysqli_real_escape_string($conn, $_POST['date']);
        $date =  date("Y-m-d", strtotime($date));
        
        $whereClause = "WHERE a.`date`= '$date' AND  e.cid = '$cid' ";
        if($branch != 0){
            $whereClause = $whereClause . " AND a.branch='$branch' ";
        }
        if($dep !=0){
            $whereClause = $whereClause . " AND s.ID='$dep' ";
        }
        if($staff !=0){
            $whereClause = $whereClause . "AND a.`staff_id` = '$staff' ";
        }
    

       $cmd = "SELECT a.`staff_id`, e.Surname,e.first_name, e.Middle_name, s.name as department,a.`in_time`,a.`out_time`,a.`overtime`,a.`date`,a.`hours`,b.name as branch
       FROM `attendance` a inner join employee e INNER join department s inner join branches b on b.id= a.branch and   a.`staff_id` = e.staff_id and e.`department` = s.id
      $whereClause order by a.in_time ASC";

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

?>