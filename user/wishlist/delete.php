<?php

    include '../../Admin/helpers/db.php';
    include '../../Admin/helpers/functions.php';
    include '../checkLogin.php';

    
    $id= $_GET['id']; //get id from url
    $id= filter_var($id,FILTER_SANITIZE_NUMBER_INT);
    $message='';
    
    if(filter_var($id,FILTER_VALIDATE_INT)){
        $sql = "delete from wishlist where product_id =".$id;
        $op = mysqli_query($con,$sql);

        if($op){
            $message = "product removed from wishlist";
        }else{
            $message = "Error Try Again !!!";
        }
    }else{
        $message = "Invalid id";
    }

    $_SESSION['message'] = $message;
    session_start();
    session_unset('product');
    header("Location: index.php");
?>