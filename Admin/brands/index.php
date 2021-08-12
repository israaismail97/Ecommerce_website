<?php
    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';
  
    $sql = "select * from brands order by id desc";
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

                            foreach($_SESSION['messages'] as $key =>  $value){

                                echo '* '.$key.' : '.$value.'<br>';
                            }

                                unset($_SESSION['messages']);
                            }else{
                        ?>
                    
                        <li class="breadcrumb-item"><a href="<?php echo url('website','Admin','index.php'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Brands</li>
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
                                                <th>Brand Name</th>
                                                <th>Description</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                  
                                        <tbody>
                                       
                                        <?php 
                                            $i = 1;
                                            while($data = mysqli_fetch_assoc($op)){
                                        ?>  

                                        <tr>
                                            <td><?php echo $data['id'];?></td>
                                            <td><?php echo $data['name'];?></td>
                                            <td style="max-width: 150px;"> <?php 
                                                echo substr($data['description'],0,100).'...'; ?>
                                                <a href="#" data-toggle="modal" data-target="#myModal<?php echo $i;?>"> Show More </a>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal<?php echo $i;?>" role="dialog">
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
                                                    
                                                </div>
                                            </td>
                                            <td> <?php echo '<img src="brandsImages/'.$data['brandImage'].'" width="150" height="150">'; ?> </td>
                                            <td>

                                            <a href='delete.php?id=<?php echo $data['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>
                                            <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary m-r-1em'>Edit</a>  
                                            </td>
                                        </tr>
                                        <?php $i++; } ?>             
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
                