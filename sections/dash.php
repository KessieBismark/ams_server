<?php


if($action == "view_topDash"){
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    $where = "";
    if($branch !=0){
        $where =  " and branch='$branch'";
    }
    $cmd = "SELECT (SELECT COUNT(*) from employee where cid='$cid' $where) as employee, 
    (SELECT COUNT(*) FROM attendance WHERE in_time >= '08:00:00' and cid = '$cid'  $where) 
    as early, (SELECT COUNT(*) FROM attendance WHERE in_time < '08:00:00' and cid = '$cid'  $where) as late

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


if($action == "view_table"){
    $cid = $_POST['cid'];
    $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    $where = "";
    if($branch !=0){
        $where =  " and branch='$branch'";
    }

    $cmd = "SELECT (SELECT COUNT(*) from employee where cid='') as employee, 
    (SELECT COUNT(*) FROM attendance WHERE in_time >= '08:00:00' and cid = '$cid') 
    as early, (SELECT COUNT(*) FROM attendance WHERE in_time < '08:00:00' and cid = '$cid') as late

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



if ($action == "view_att_summary"){

    try{
        $duration = $_POST['duration'];
        $cid = $_POST['cid'];
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $where = "WHERE e.cid = '$cid' and e.Active =1 or e.Resigned >= CURRENT_DATE ";
        $whereTwo = " and e.cid='$cid' "; 
        if($branch !=0){
            $where = $where . " and e.branch='$branch'";
            $whereTwo = $whereTwo. " and e.branch='$branch'";
        }
        if($duration == "Week"){
            $cmd ="SELECT e.Surname,e.Middle_name,e.first_name,COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = e.Staff_ID and 
            In_Time < '8:00:00' $whereTwo AND YEARWEEK(Date) = 
            YEARWEEK(NOW())),0)as early, COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = 
            e.Staff_ID and In_Time > '8:00:00' $whereTwo AND YEARWEEK(Date) = 
            YEARWEEK(NOW())),0)as late FROM employee e 
            -- INNER JOIN attendance a on 
            -- e.Staff_ID = a.Staff_ID 
            $where  GROUP BY e.Staff_ID ORDER by late DESC LIMIT 10
            ";
        }else if ($duration == "Day"){
                $cmd = "SELECT e.Surname,e.Middle_name,e.first_name,COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = e.Staff_ID 
                and In_Time < '8:00:00' $whereTwo AND Date = 
                CURRENT_DATE),0)as early, COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = 
                e.Staff_ID and In_Time > '8:00:00' $whereTwo AND Date = 
                CURRENT_DATE),0)as late FROM employee e
                --  INNER JOIN attendance a on 
                -- e.Staff_ID = a.Staff_ID
                $where
                GROUP BY e.Staff_ID ORDER by late DESC LIMIT 10
                ";
        }else if ($duration == "Month"){
                $cmd = "SELECT e.Surname,e.Middle_name,e.first_name,COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = e.Staff_ID 
                and In_Time < '8:00:00' $whereTwo AND MONTH(Date) = 
                MONTH(NOW())),0)as early, COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = 
                e.Staff_ID and In_Time > '8:00:00' $whereTwo AND MONTH(Date) = 
                MONTH(NOW())),0)as late FROM employee e
                --  INNER JOIN attendance a on 
                -- e.Staff_ID = a.Staff_ID
                $where
                GROUP BY e.Staff_ID ORDER by late DESC LIMIT 10
                ";
        }else if ($duration == "Year"){
            $cmd = "SELECT e.Surname,e.Middle_name,e.first_name,COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = e.Staff_ID 
            and In_Time < '8:00:00' $whereTwo AND YEAR(Date) = 
            YEAR(NOW())),0)as early, COALESCE((SELECT COUNT(*) FROM attendance WHERE Staff_ID = 
            e.Staff_ID and In_Time > '8:00:00' $whereTwo AND YEAR(Date) = 
            YEAR(NOW())),0)as late FROM employee e 
            -- INNER JOIN attendance a on 
            -- e.Staff_ID = a.Staff_ID 
            $where
            GROUP BY e.Staff_ID ORDER by late DESC LIMIT 10
            
            ";
        }
        $query = mysqli_query($conn,$cmd);
        $rows = mysqli_num_rows($query);
           if ($rows > 0 ){
               while($view = mysqli_fetch_assoc($query)){
                   $db_data[] = $view;
                }
                echo json_encode($db_data);
           }else{
               echo json_encode("false");
           }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}
?>