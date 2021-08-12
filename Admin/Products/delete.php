<?php

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';

    if($_SERVER['REQUEST_METHOD'] == "GET"){  //get id from url

        $id  = Sanitize($_GET['id'],1);
        $message=[];

        if(!Validator($id,3)){
            $Message['id'] = "Invalid ID";
        }else{
            // DB Opretaion ... 
            //deleting images
            $sql_image  = "select image from product_images where product_id =".$id;
            $op_image   = mysqli_query($con,$sql_image);
            $data_image = mysqli_fetch_assoc($op_image);

            //if (count(explode('+',$data_image['image'])) > 1) {
                $imageArray = explode('+',$data_image['image']);

                for ($i=1; $i < count($imageArray); $i++) { 
                    if (file_exists("./productImages/".$imageArray[$i])) {
                        unlink("./productImages/".$imageArray[$i]);
                    }
                }
            //}
            
            

            //deleting product
            $sql = "delete from products where id =".$id;
            $op  = mysqli_query($con,$sql);

            if($op){
                $message['Result'] = "Product Deleted successfully";
            }else{
                $message['Result'] = "Error Try Again !!!";
            }
        }
        $_SESSION['messages'] =  $Message;

        header("Location: index.php");
    }
    
    

?>