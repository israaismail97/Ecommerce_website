<?php

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';

    //inner join
    $sql= "SELECT products.*, product_images.id as images_id, product_images.image, product_images.product_id from products LEFT JOIN product_images on products.id= product_images.product_id order by products.id desc"; 
    $op  = mysqli_query($con,$sql);


    include '../header.php';
?>
  
  <body class="sb-nav-fixed">      
    
<?php 
    include '../nav.php';
?>  

        <div id="layoutSidenav">                 
         
<?php 
    include '../sideNav.php';
?>  

          
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">

                            <?php 
                                if(isset($_SESSION['messages'])){

                                    foreach($_SESSION['messages'] as $key =>  $data){
                                        echo '* '.$key.' : '.$data.'<br>';
                                    }
                                    unset($_SESSION['messages']);
                                }else{
                            ?>
                            <li class="breadcrumb-item"><a href="<?php echo url('website','Admin','index.php'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products</li>
                            <?php } ?>
               
                        </ol>
    
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Description</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Images</th>
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
            
                                        <tbody>
                                       
                                            <?php
                                                $j = 1;    
                                                while($data = mysqli_fetch_assoc($op)){
                                                    
                                                    //fetch brand and category queries
                                                    $sql_brand= "select * from brands where id=".$data['brand_id'];
                                                    $sql_category= "select * from categories where id=".$data['category_id'];
                                                    $op_brand  = mysqli_query($con,$sql_brand);
                                                    $op_category  = mysqli_query($con,$sql_category);
                                                    $data_brand = mysqli_fetch_assoc($op_brand);
                                                    $data_category = mysqli_fetch_assoc($op_category);
                                            ?>      

                                            <tr>
                                                <td> <?php echo $data['id'];?></td>
                                                <td style="max-width: 150px;"> <?php echo $data['name'];?></td>
                                                <td> <?php echo $data['price'];?></td>
                                                <td style="max-width: 150px;"> <?php 
                                                    echo substr($data['description'],0,50).'...'; ?>

                                                    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $j;?>"> Show More </a>
                                                   
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal<?php echo $j;?>" role="dialog">
                                                        <div class="modal-dialog">
                                                        
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Description</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <P> <?php echo $data['description'];?> </p>
                                              
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td> <?php echo $data_brand['name'];?></td>
                                                <td> <?php echo $data_category['name'];?></td>
                                                <td> <?php 
                                                    if (count(explode('+',$data['image'])) > 1) {
                                                        $images = explode('+',$data['image']); 
                                                        echo '<img src="productImages/'.$images[1].'" width="150" height="150"> <br>';
                                                        
                                                    }
                                                    ?>
                                                    
                                                    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $j.$j;?>"> Show More </a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal<?php echo $j.$j;?>" role="dialog">
                                                        <div class="modal-dialog">
                                                        
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Images</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                    if (count(explode('+',$data['image'])) > 1) {
                                                                        $images = explode('+',$data['image']); 
                                                                        for ($i=1; $i < count($images); $i++) { 
                                                                            echo '<img src="productImages/'.$images[$i].'" width="150" height="150">';
                                                                        }
                                                                    }else {
                                                                        echo '<img src="productImages/'.$data['image'].'" width="150" height="150"> <br>';
                                                                    }
                                                                ?>
                                                            
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href='delete.php?id=<?php echo $data['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>
                                                    <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary m-r-1em'>Edit</a>  
                                                </td>
                                  
                                            </tr>
                                            <?php $j++; } ?>             
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

           
<?php 
    include '../footer.php';
?>  

    <!-- Latest compiled and minified Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> -->
