<?php 

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';
    include '../helpers/checkPerm.php';

    if($_SERVER['REQUEST_METHOD'] == "GET"){

     // LOGIC .... 
        $Message = [];
        $id  = Sanitize($_GET['id'],1);
        if(!Validator($id,3)){
            $Message['id'] = "Invalid ID";
        }else{
            // DB Opretaion ... 
            $sql = "delete from admins where id =".$id;
            $op = mysqli_query($con,$sql);
            if($op){
                $Message['Result'] = "deleted done";
            }else{   
                $Message['Result'] = "error in delete operation";
            }
        }
        $_SESSION['messages'] =  $Message;
    
        header("Location: index.php");

    }

?>