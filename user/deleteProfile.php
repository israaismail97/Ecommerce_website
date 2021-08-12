<?php

    include '../Admin/helpers/db.php';
    include '../Admin/helpers/functions.php';

    
    $id= $_GET['id']; //get id from url
    $id= filter_var($id,FILTER_SANITIZE_NUMBER_INT);
    $message='';
    
    if(filter_var($id,FILTER_VALIDATE_INT)){
        $sql = "delete from users where id =".$id;
        $op = mysqli_query($con,$sql);

        if($op){
            $message = "Account Deleted successfully";
        }else{
            $message = "Error Try Again !!!";
        }
    }else{
        $message = "Invalid id";
    }

    $_SESSION['message'] = $message;
    session_start();
    session_destroy();
    //header("Location: index.php");
    header("Location: createAccount.php");
?>