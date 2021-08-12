<?php

    include '../Admin/helpers/db.php';
    include '../Admin/helpers/functions.php';
    require "checkLogin.php";

    
    require '../BEAUTYstore/header.php';
?>

<div class="wrapper">
  <main class="hoc container clear"> 
    <!-- main body -->

    <div class="sidebar one_quarter first"> 

      <nav class="sdb_holder">
            <ul>
                <li><a href="<?php echo url('website','user','index.php'); ?>">Dashboard</a></li>
                <li><a href="#">Saved Addresses</a></li>
                <li><a href="#">My Orders</a></li>
                <li><a href="<?php echo url('website','user/wishlist','index.php'); ?>">My Wishlist</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
      </nav>
    </div>


    <!-- container -->
    <!-- <div class="container hoc" > -->

        <div class="page-header header5">
            <h1 id="userDash">Dashboard</h1>

        <?php 
        
            if(isset($_SESSION['message'])){
                echo '* '.$_SESSION['message'];
            }
            unset($_SESSION['message']);
        ?>
        </div>

        <!-- PHP code to read records will be here -->

        <table class='table table-hover table-responsive table-bordered' id="table1">
            <!-- creating our table heading -->
            <tr>
                <th id="profile"> <h1>My Profile</h1> </th>
                
            </tr>

            <tr>
                <th>First Name</th>
                <td> <?php echo $_SESSION['data']['first_name'];?></td>
            </tr>

           <tr>
                <th>Last Name</th>
                <td> <?php echo $_SESSION['data']['last_name'];?></td>  
           </tr> 

           <tr>
                <th>Email</th>
                <td> <?php echo $_SESSION['data']['email'];?></td>
           </tr>

           <tr>
                <th>Action</th>
                <td>
                <a href='deleteProfile.php?id=<?php echo $_SESSION['data']['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>
                <a href='editProfile.php?id=<?php echo $_SESSION['data']['id'];?>' class='btn btn-primary m-r-1em'>Edit Profile</a>     
                </td>
           </tr>

            <!-- end table -->
        </table>

    <!-- </div> -->

</main>
</div>

    
    <!-- end .container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!-- confirm delete record will be here -->
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<?php
  require '../BEAUTYstore/footer.php';
?>