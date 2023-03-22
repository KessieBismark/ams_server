<?php
if($action == "add_branches"){
    try{
        $name =mysqli_real_escape_string($conn, $_POST['name']);
        $cmd2 = "SELECT * FROM `branches` WHERE  name='$name'";
        $query = mysqli_query($conn,$cmd2);
        $rows = mysqli_num_rows($query);
            if($rows >0){
                echo $duplicate;
            }else{         
                    $cmd = "INSERT INTO `branches`( `name`) VALUES ('$name');";
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

if($action =="update_branches"){
    try{
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);

        $cmd = "UPDATE `branches` SET `name`='$name'WHERE `id`='$id';";
        $query = mysqli_query($conn,$cmd);
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


if($action =="delete_branches" ){
    try{
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $cmd = "delete from `branches` WHERE `id`='$id';";
        $query = mysqli_query($conn,$cmd);
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

if($action == "view_branches"){
    $cmd = "SELECT * FROM `branches`";
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


if($action == "get_bid"){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $cmd = "SELECT * FROM `branches` WHERE name= '$name'";
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