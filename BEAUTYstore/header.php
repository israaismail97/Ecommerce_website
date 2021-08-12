<?php

  $sql_brand = "select * from brands";
  $op_brand = mysqli_query($con,$sql_brand);
  $sql_category = "select * from categories";
  $op_category = mysqli_query($con,$sql_category);

?>

<!DOCTYPE html>
<!--
Template Name: Skaxis
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms
-->
<html lang="en">
<!-- To declare your language - read more here: https://www.w3.org/International/questions/qa-html-language-declarations -->
<head>
<title>BEAUTY STORE</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="<?php echo url('website','BEAUTYstore','layout/styles/layout.css') ?>" rel="stylesheet" type="text/css" media="all">
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body id="top">
  <!-- ################################################################################################ -->
  <!-- Top Background Image Wrapper -->
<div class="bgded overlay light" style="background-image:url('images/demo/backgrounds/03.jpg');"> 
  
  <div class="wrapper row1 hoc">
    <nav id="cornernav" class="fl_right">
      <ul class="clear">
        <li><a href="<?php 
          if (isset($_SESSION['data'])) {
            echo url('website','user','index.php');
          }else {
            echo url('website','user','login.php');
          }
        ?>">My Account</a></li>
        <li><a href="<?php echo url('website','user/wishlist','index.php'); ?>">Wishlist</a></li>
        <li><a href="<?php echo url('website','user/cart','index.php'); ?>"><i class="fas fa-shopping-cart"></i></a></li>
        <li><a href="#"><i class="fas fa-search"></i></a></li>
      </ul>
    </nav>

  </div>
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      
      <div id="logo">
        <h1><a href="<?php echo url('website','BEAUTYstore','index.php'); ?>">BEAUTY STORE</a></h1>
      </div> 
      <nav id="mainav" class="fl_right">
        <ul class="clear">
          <li class="active"><a href="<?php echo url('website','BEAUTYstore','index.php'); ?>">Home</a></li>
          <li><a class="drop" href="#">BRANDS</a>
            <ul>
              <!-- <li><a href="pages/gallery.html">View all Brands</a></li> -->
              <?php
                while ($data_brand = mysqli_fetch_assoc($op_brand)) {
              ?>
              <li><a href="<?php echo url('website','BEAUTYstore','brand.php?id='.$data_brand['id']); ?>"> <?php echo $data_brand['name']; ?> </a></li>
              <!-- <li><a href="pages/sidebar-left.html">Sidebar Left</a></li>
              <li><a href="pages/sidebar-right.html">Sidebar Right</a></li>
              <li><a href="pages/basic-grid.html">Basic Grid</a></li> -->
              <?php } ?>
            </ul>
          </li>

          <?php 
            while ($data_category = mysqli_fetch_assoc($op_category)) { 
          ?>
          <li><a class="drop" href="#"> <?php echo $data_category['name']; ?> </a>
            <ul>
              <li><a href="pages/gallery.html">View all</a></li>
              <?php
                //while ($data = mysqli_fetch_assoc($op_brand)) {
              ?>
              <!-- <li><a href="pages/full-width.html"> <?php //echo $data['name']; ?> </a></li> -->
              <li><a href="pages/sidebar-left.html">Sidebar Left</a></li>
              <li><a href="pages/sidebar-right.html">Sidebar Right</a></li>
              <li><a href="pages/basic-grid.html">Basic Grid</a></li>
              <?php //} ?>
            </ul>
          </li>
          <?php } ?>



          <li><a class="drop" href="#">Dropdown</a>
            <ul>
              <li><a href="#">Level 2</a></li>
              <li><a class="drop" href="#">Level 2 + Drop</a>
                <ul>
                  <li><a href="#">Level 3</a></li>
                  <li><a href="#">Level 3</a></li>
                  <li><a href="#">Level 3</a></li>
                </ul>
              </li>
              <li><a href="#">Level 2</a></li>
            </ul>
          </li>
          <li><a href="#">Link Text</a></li>
          <li><a href="#">Link Text</a></li>
        </ul>
      </nav>
      <!-- ################################################################################################ -->
    </header>
  </div>
