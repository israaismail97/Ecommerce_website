<?php

    include '../../Admin/helpers/db.php';
    include '../../Admin/helpers/functions.php';
    include '../checkLogin.php';


    $data = $_SESSION['product'];
    //print_r($data); exit;
    $sql= "insert into cart (product_id,user_id) values ('".$data['id']."','".$_SESSION['data']['id']."')";
    $op= mysqli_query($con,$sql);
    
    if($op){
        $Message['dataResult'] = "added to cart";
        $_SESSION['Message']= $Message;
        header("Location: index.php");
    }else{
        $Message['dataResult'] = 'Error Try Again';
    }


    include '../../BEAUTYstore/header.php';
?>


  
<?php include '../../BEAUTYstore/footer.php'; ?>