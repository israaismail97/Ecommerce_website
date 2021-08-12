<?php

  include '../Admin/helpers/db.php';
  include '../Admin/helpers/functions.php';

  $sql= "SELECT products.*, product_images.id as images_id, product_images.image, product_images.product_id from products LEFT JOIN product_images on products.id= product_images.product_id order by products.id desc"; 
  $op  = mysqli_query($con,$sql);

  require 'header.php';

?>


  <!-- ################################################################################################ -->
  <div id="pageintro" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="flexslider basicslider">
      <ul class="slides">
        <li>
          <article>
            <p>Condimentum</p>
            <h3 class="heading">Ligula at fermentum</h3>
            <p>Sodales sapien donec porttitor dolor nec elit</p>
            <footer><a class="btn" href="#">Luctus suscipit in</a></footer>
          </article>
        </li>
        <li>
          <article>
            <p>Laoreet</p>
            <h3 class="heading">Iaculis interdum</h3>
            <p>Nulla scelerisque posuere convallis</p>
            <footer>
              <form class="group" method="post" action="#">
                <fieldset>
                  <legend>Sign-Up:</legend>
                  <input type="email" value="" placeholder="Email Here&hellip;">
                  <button class="fa fa-sign-in" type="submit" title="Submit"><em>Submit</em></button>
                </fieldset>
              </form>
            </footer>
          </article>
        </li>
        <li>
          <article>
            <p>Phasellus</p>
            <h3 class="heading">Bibendum blandit</h3>
            <p>Lacus non tincidunt class aptent taciti sociosqu</p>
            <footer><a class="btn inverse" href="#">Litora torquent</a></footer>
          </article>
        </li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->

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
      <li class="one_third">
        <article><a href="product.php?id=<?php echo $data['id'];?>"><img src="../Admin/Products/productImages/<?php echo $images[1];?>" alt=""></a>
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

      
      <li class="one_third">
        <article><a href="#"><img src="images/demo/320x240.png" alt=""></a>
          <h6 class="heading">Lobortis enim placerat</h6>
          <ul class="nospace meta">
            <li><i class="fa fa-user"></i> <a href="#">Admin</a></li>
            <li><i class="fa fa-tag"></i> <a href="#">Tag Name</a></li>
          </ul>
          <p>Est consequat non vestibulum quis tortor nulla cras a condimentum dolor nulla porttitor dolor id feugiat quisque&hellip;</p>
          <footer class="nospace"><a class="btn" href="#">Full Story &raquo;</a></footer>
        </article>
      </li>
    </ul>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper bgded overlay coloured" style="background-image:url('images/demo/backgrounds/02.png');">
  <article class="hoc cta clear"> 
    <!-- ################################################################################################ -->
    <h6 class="three_quarter first">Quis orci neque praesent posuere venenatis tempor</h6>
    <footer class="one_quarter"><a class="btn" href="#">Mauris sit rhoncus &raquo;</a></footer>
    <!-- ################################################################################################ -->
  </article>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->




<?php
  require 'footer.php';
?>