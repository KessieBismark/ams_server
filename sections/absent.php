<?php

if($action == 'absentees'){
    try{
        $branch =$_POST['branch'];
        $cid = $_POST['cid'];
        $dep =  $_POST['department'];
        $staff = $_POST['staff_id'];
        $date =  mysqli_real_escape_string($conn, $_POST['date']);
        $date =  date("Y-m-d", strtotime($date));

    $whereClause = " WHERE e.cid = '$cid' AND (e.Active = 1 OR e.Resigned >= '$date')";
    $otherClause = " WHERE Start_Date <= '$date' and End_Date >= '$date' AND cid = '$cid'";
    $atClause = " where Date = '$date' and cid = '$cid'";
   if($branch != 0){
   // $atClause =$atClause . " AND branch= '$branch'";
   // $otherClause= $otherClause. " and branch= '$branch' ";
    $whereClause = $whereClause . " AND e.branch='$branch' ";
   }
   if($dep !=0){
    $whereClause = $whereClause . " and e.Department = '$dep' ";
   }
   if($staff !=0){
    $atClause =$atClause . " and Staff_ID= '$staff' ";
    $otherClause= $otherClause. "  and Staff_ID= '$staff' ";
    $whereClause = $whereClause . " and e.Staff_ID='$staff' ";
   }
         $cmd = "SELECT e.staff_id, e.Surname,e.Middle_name,e.first_name,s.name as department,b.name as branch
          FROM `employee` e inner join branches b inner join
         department s on e.department = s.id and b.id = e.branch $whereClause 
       and e.staff_id  not in (SELECT `Staff_ID` from attendance $atClause)
        and e.`staff_id` not in (select `Staff_ID` from onleave $otherClause and Type IS NOT NULL )  
          order by s.name";

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