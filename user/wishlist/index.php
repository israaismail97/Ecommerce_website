<?php

    include '../../Admin/helpers/db.php';
    include '../../Admin/helpers/functions.php';
    include '../checkLogin.php';


    $sql= "SELECT products.*, product_images.id as images_id, product_images.image, product_images.product_id from products JOIN product_images on products.id= product_images.product_id JOIN wishlist on products.id= wishlist.product_id where wishlist.user_id=".$_SESSION['data']['id']; 
    $op  = mysqli_query($con,$sql);
    
    //print_r($data); exit;
    
    // if($op){
    //     $Message['dataResult'] = "added to cart";
    //     $_SESSION['Message']= $Message;
    //     header("Location: index.php");
    // }else{
    //     $Message['dataResult'] = 'Error Try Again';
    // }


    include '../../BEAUTYstore/header.php';
?>

<div class="wrapper row3">
  
  <main class="hoc container clear"> 
    <!-- main body -->
    <h6 id="heading6">MY WISHLIST</h6>
    <ul class="nospace group overview">
      <?php
    
        while($data = mysqli_fetch_assoc($op)){

          $images = explode('+',$data['image']);
          //fetch brand and category queries
          $sql_brand= "select * from brands where id=".$data['brand_id'];
          $sql_category= "select * from categories where id=".$data['category_id'];
          $op_brand  = mysqli_query($con,$sql_brand);
          $op_category  = mysqli_query($con,$sql_category);
          $data_brand = mysqli_fetch_assoc($op_brand);
          $data_category = mysqli_fetch_assoc($op_category);   
      ?>     
      <li class="one_third">
        <article><a href="product.php?id=<?php echo $data['id'];?>"><img src="../../Admin/Products/productImages/<?php echo $images[1];?>" alt=""></a>
          <h6 class="heading"><?php echo $data['name'];?></h6>
          <ul class="nospace meta">
            <li> <a href="brand.php?id=<?php echo $data_brand['id'];?>"><?php echo $data_brand['name'];?></a></li>
            <li> <a href="category.php?id=<?php echo $data_category['id'];?>"><?php echo $data_category['name'];?></a></li>
          </ul>
          <p>EGP<?php echo $data['price'];?></p>
          <footer class="nospace"><a class="btn" href="product.php?id=<?php echo $data['id'];?>">VIEW PRODUCT &raquo;</a>
          <br> <br> <a class="avatar" href="delete.php?id=<?php echo $data['id'];?>" > REMOVE FROM CART</a>
        </footer>
        </article>
      </li>
      <?php } ?>
    </ul>
</main>
</div>

  
<?php include '../../BEAUTYstore/footer.php'; ?>