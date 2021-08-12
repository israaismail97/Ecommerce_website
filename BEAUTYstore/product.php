<?php 

    include '../Admin/helpers/db.php';
    include '../Admin/helpers/functions.php';
    
    $id = '';
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        // LOGIC .... 
        $Message = [];
        $id  = Sanitize($_GET['id'],1);
        
        if(!Validator($id,3)){
            $Message['id'] = "Invalid ID";
            $_SESSION['messages'] = $Message;
            header("Location: index.php");
        }
    }


   # Fetch Data to id .
   $sql= "SELECT products.*, product_images.id as images_id, product_images.image, product_images.product_id from products LEFT JOIN product_images on products.id= product_images.product_id where products.id = ".$id;
    $op   = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($op);

    $_SESSION['product'] = $data;


    include 'header.php';
?>


<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->  
    <?php

        $images = explode('+',$data['image']);   
        //fetch brand and category queries
        $sql_brand= "select * from brands where id=".$data['brand_id'];
        $sql_category= "select * from categories where id=".$data['category_id'];
        $op_brand  = mysqli_query($con,$sql_brand);
        $op_category  = mysqli_query($con,$sql_category);
        $data_brand = mysqli_fetch_assoc($op_brand);
        $data_category = mysqli_fetch_assoc($op_category);

        $_SESSION['product']['brand_name'] = $data_brand['name'];
        $_SESSION['product']['category_name'] = $data_category['name'];
    ?>

    <article class="group btmspace-80">
      <div class="one_half first"><img class="inspace-10" src="../Admin/Products/productImages/<?php echo $images[1];?>" alt="" ></div>
      <div class="one_half" style="position: relative;">
        <h6 class="heading"><?php echo $data['name'];?></h6> 
        <a class="avatar" href="<?php echo url('website','user/wishlist','add.php?id='.$data['id']); ?>" style="position: absolute; top: 40px; right: 15%; font-size: 20px;"> <i class="far fa-heart"></i></a>
        <ul class="nospace meta">
            <li> <a href="brand.php?id=<?php echo $data_brand['id'];?>"><?php echo $data_brand['name'];?></a></li>
            <li> <a href="category.php?id=<?php echo $data_category['id'];?>"><?php echo $data_category['name'];?></a></li>
        </ul>
        <p>EGP<?php echo $data['price'];?> </p>
        <p class="btmspace-30"><?php echo $data['description']; ?></p>
        <footer class="nospace"><a class="btn" href="<?php echo url('website','user/cart','add.php'); ?>">ADD TO CART &raquo;</a></footer>
      </div>
    </article>   

    <div class="clear"></div>
  </main>
</div>


<?php
  require 'footer.php';
?>