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
   $sql= "SELECT products.*, product_images.id as images_id, product_images.image, product_images.product_id from products LEFT JOIN product_images on products.id= product_images.product_id where products.brand_id = ".$id;
    $op   = mysqli_query($con,$sql);


    include 'header.php';
?>


<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->     
    <ul class="nospace group overview">
        <?php
        $j = 1;    
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
      <li class="one_third" >
        <article><a href="product.php?id=<?php echo $data['id'];?>"><img src="../Admin/Products/productImages/<?php echo $images[1];?>" width="150" height="150" alt=""></a>
          <h6 class="heading"><?php echo $data['name'];?></h6>
          <ul class="nospace meta">
            <li> <a href="brand.php?id=<?php echo $data_brand['id'];?>"><?php echo $data_brand['name'];?></a></li>
            <li> <a href="category.php?id=<?php echo $data_category['id'];?>"><?php echo $data_category['name'];?></a></li>
          </ul>
          <p>EGP<?php echo $data['price'];?></p>
          <footer class="nospace"><a class="btn" href="product.php?id=<?php echo $data['id'];?>">VIEW PRODUCT &raquo;</a></footer>
        </article>
      </li>
      <?php } ?>

    </ul>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>


<?php
  require 'footer.php';
?>