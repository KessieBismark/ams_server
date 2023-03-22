<?php

if($action == 'add_user'){
    try {
    $vcode =mysqli_real_escape_string($conn, $_POST['vCode']);
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $contact =mysqli_real_escape_string($conn, $_POST['contact']);
    $role =mysqli_real_escape_string($conn, $_POST['role']);
    $code =mysqli_real_escape_string($conn, $_POST['code']);
     $branch =mysqli_real_escape_string($conn, $_POST['branch']);
    $access =mysqli_real_escape_string($conn,$_POST['access']);
    $cid = $_POST['cid'];

    $cmd2 = "select * from users where email = '$email' and cid='$cid'";
    $q = mysqli_query($conn,$cmd2);

    $row = mysqli_num_rows($q);
    if($row < 1){
        $cmd =  "insert into users(contact,email,verify_code,role,access,branch,cid) 
        values ('$contact','$email','$code','$role','$access','$branch','$cid')";
        // $cmd =  "insert into users(name,contact,email,verify_code,role,access) 
        // values ('$name','$contact','$email','$code','$role','$access')";
        $querry  = mysqli_query($conn,$cmd);
        if($querry ){
            echo $true;
        }
    }else{
        echo json_encode("duplicate");
    }
} catch (Exception $e) {
    mysqli_close($conn);
    echo 'Exception error: ',  $e->getMessage(), "\n";
}
}





if($action == 'view_users'){
    try{
        $cid = $_POST['cid'];
        $branch =mysqli_real_escape_string($conn, $_POST['branch']);
        $where = "WHERE cid='$cid' ";
        if($branch != 0){
            $where = $where . " AND branch='$branch'";
        }

    $cmd = "SELECT `id`, `name`, `email`,`role`,`access` FROM `users` $where ";
    $query = mysqli_query($conn,$cmd);
    mysqli_close($conn);
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

if($action == 'delete_user'){
    try{
    $id = $_POST['id'];
    $cmd =  "delete from users  where id='$id'";
    $querry  = mysqli_query($conn,$cmd);
    mysqli_close($conn);
    if($querry ){
        echo json_encode("true");
    }
} catch (Exception $e) {
    mysqli_close($conn);
    echo 'Exception error: ',  $e->getMessage(), "\n";
}
}


if($action == 'forgot'){
    try{
    $reset = $_POST['reset'];
    $email =mysqli_real_escape_string($conn,$_POST['email']);
    $rcode = $_POST['rcode'];
    $name = $_POST['name'];
    $cmd =  "update users set reset_password = '$reset',reset = 1 where email='$email'";
    $querry  = mysqli_query($conn,$cmd);
    mysqli_close($conn);
    if($querry ){
        echo json_encode("true");
    }
} catch (Exception $e) {
    mysqli_close($conn);
    echo 'Exception error: ',  $e->getMessage(), "\n";
}
}


if($action == 'get_contact'){
    try{
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $cmd = "select * from users where email='$email'";
    $query = mysqli_query($conn,$cmd);
    mysqli_close($conn);
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

if($action == 'verify'){
    try{
    $name =mysqli_real_escape_string($conn, $_POST['name']);
    $password =mysqli_real_escape_string($conn, $_POST['password']);
    $email =mysqli_real_escape_string($conn,$_POST['email']);
    $cmd =  "update users set name = '$name', password='$password',verify_email = 0 where email='$email'";
    $querry  = mysqli_query($conn,$cmd);
    mysqli_close($conn);
    if($querry ){
        echo json_encode("true");
    }
} catch (Exception $e) {
    mysqli_close($conn);
    echo 'Exception error: ',  $e->getMessage(), "\n";
}
}

if($action == 'update_user'){
    try{
        $id = $_POST['id'];
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $password =mysqli_real_escape_string($conn, $_POST['password']);
        $cmd =  "update users set password='$password',reset = 0 where email='$email' and id= '$id'";
        $querry  = mysqli_query($conn,$cmd);
        mysqli_close($conn);
        if($querry ){
            echo json_encode("true");
        }
  
} catch (Exception $e) {
    mysqli_close($conn);
    echo 'Exception error: ',  $e->getMessage(), "\n";
}
}

if($action == 'change_password'){
    try{
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $code =$_POST['code'];
    $cmd2 = "select * from users where email ='$email' and reset_password = '$code'";
    $q2 = mysqli_query($conn,$cmd2);
   // mysqli_close($con);
    $rr = mysqli_num_rows($q2);
    if ($rr > 0 ){
        $cmd =  "update users set password='$password',reset = 0 where email='$email'";
        $querry  = mysqli_query($conn,$cmd);
        mysqli_close($conn);
        if($querry ){
            echo json_encode("true");
        }
    }else{
        mysqli_close($conn);
        echo json_encode("wrong");
    }
} catch (Exception $e) {
    mysqli_close($conn);
    echo 'Exception error: ',  $e->getMessage(), "\n";
}
}


if($action == 'change_role'){
    try{
    $id = $_POST['id'];
    $role =  $_POST['role'];
    $access =$_POST['access'];
    //if(!empty($access)){
        $cmd =  "update  users set role = '$role', access ='$access' where id='$id'";
    // }else{
    // $cmd =  "update  users set role = '$role' where id='$id'";
    // }
    $querry  = mysqli_query($conn,$cmd);
    mysqli_close($conn);
    if($querry ){
        echo json_encode("true");
    }else{
          echo json_encode("false");
    }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


if($action == "login"){
    try{
    $username =mysqli_real_escape_string($conn, $_POST['email']);
    $password =mysqli_real_escape_string($conn, $_POST['password']);
  
    $cmd = "select * from users where email='$username' and (password = '$password' or verify_code = '$password')";

    $querry = mysqli_query($conn,$cmd);
    mysqli_close($conn);
    $row =mysqli_num_rows($querry);
    if($row > 0 ){
        $view = mysqli_fetch_assoc($querry);
        if($view['verify_email']== 1){
            echo json_encode("verify");
        }elseif($view['reset']== 1){
            echo json_encode("reset");
        }else{
            //  echo json_encode("true");
          //  while($views = mysqli_fetch_assoc($querry)){
                $db_data[] = $view;       
          //  }
             echo json_encode($db_data);
        }
    }else{
            echo json_encode( "false");  
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        echo 'Exception error: ',  $e->getMessage(), "\n";
    }
}


?>