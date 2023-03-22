<?php

if($action == "add_company"){
try{
    $name =mysqli_real_escape_string($conn, $_POST['name']);
    $contact =mysqli_real_escape_string($conn, $_POST['contact']);
    $address =mysqli_real_escape_string($conn, $_POST['address']);
    $slogan =mysqli_real_escape_string($conn, $_POST['slogan']);
    $website =mysqli_real_escape_string($conn, $_POST['website']);
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $gps =mysqli_real_escape_string($conn, $_POST['gps']);
    

    $cmd2 = "delete from company where 1";
    $q2 = mysqli_query($conn,$cmd2);
         
                $cmd = "INSERT INTO `company`( `name`, `contact`, `address`,
                 `gps`, `slogan`, `website`, `email`) VALUES 
                 ('$name','$contact','$address','$gps',
                 '$slogan','$website','$email');";
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



if($action == "view_company"){
    $cmd = "SELECT * FROM `company` WHERE 1;";
    $query = mysqli_query($conn,$cmd);
    if(!$query){
        echo $failed;
    }else{    
        $row = mysqli_num_rows($query);
        if($row> 0){
        while($view = mysqli_fetch_assoc($query)){
            $db_data[] = $view;
        }
        echo json_encode($db_data);
        }
    }
}

?>