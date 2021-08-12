<?php 

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';


    if($_SERVER['REQUEST_METHOD'] == "GET"){

        // LOGIC .... 
        $Message = [];
        $id  = Sanitize($_GET['id'],1);

        if(!Validator($id,3)){
            $Message['id'] = "Invalid ID";
        }else{
            // DB Opretaion ... 
            $sql_image  = "select brandImage from brands where id =".$id; 
            $op_image   = mysqli_query($con,$sql_image);
            $data_image = mysqli_fetch_assoc($op_image);

            if (file_exists("./brandsImages/".$data_image['brandImage'])) {
                unlink("./brandsImages/".$data_image['brandImage']);
            }

            $sql = "delete from brands where id =".$id;
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