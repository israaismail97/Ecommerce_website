<?php 
    
    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';
    include '../helpers/checkPerm.php';

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

   if($_SERVER['REQUEST_METHOD'] == "POST"){  
        // LOGIC ... 
        $name  = cleanInput($_POST['name']);
        $email = cleanInput($_POST['email']);
        $role_id    = Sanitize($_POST['role_id'],1);
        $id         = Sanitize($_POST['id'],1);
  
        $Message = [];
        # Check Validation ... 
        if(!Validator($name,1)){
            $Message['name'] = "Name Field Required";
        }
        
        if(!Validator($name,2)){
            $Message['NameLength'] = "Title length must be > 3";
        }

        if(!Validator($role_id,3)){
        $Message['Role'] = "Invalid Role ";
        }


        if(!Validator($email,1)){
            $Message['emailRequird'] = "Email Field Required";
        }

        if(!Validator($email,4)){
            $Message['email'] = "Invalid Email";
        }

        if(!Validator($id,3)){
            $Message['id'] = "Invalid id";
        }


        if(count($Message) > 0){
            $_SESSION['messages'] = $Message;
             
        }else{

            # DB OPERATION .... 
            $sql = "update admins set name='$name' , email= '$email' , role_id=$role_id  where id = ".$id;
            $op  = mysqli_query($con,$sql);

            if($op){
                $Message['Result'] = "Data updated.";
            }else{
                $Message['Result']  = "Error Try Again.";
            }
            $_SESSION['messages'] = $Message;
            header('Location: index.php');
        }

    }

    # Fetch Data to id . 
    $sql  = "select * from admins where id = ".$id;
    $op   = mysqli_query($con,$sql);
    $FetchedData = mysqli_fetch_assoc($op);

    # Fetch Admin roles ..  
    $sql = "select * from adminrole";
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">

                            <?php 
                                if(isset($_SESSION['messages'])){
                                foreach($_SESSION['messages'] as $key =>  $data){
                                        echo '* '.$key.' : '.$data.'<br>';
                                    }
                                    unset($_SESSION['messages']);
                                }else{
                            ?>
                            <li class="breadcrumb-item active">Edit Admin</li>
                            <?php } ?>
                        
                        </ol>

                      
 <div class="container">

 <form  method="post"  action="edit.php?id=<?php echo $FetchedData['id'];?>"  enctype ="multipart/form-data">
 
 <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text"  name="name" value="<?php echo $FetchedData['name'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" value="<?php echo $FetchedData['email'];?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <!-- <div class="form-group">
    <label for="exampleInputPassword1"> Password</label>
    <input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div> -->
 
  <div class="form-group">
        <label for="exampleInput"> Role type </label>
        <select name="role_id" class="form-control"> 
            <?php 
                while($data = mysqli_fetch_assoc($op)){
            ?>
            <option value="<?php echo $data['id'];?>"    <?php if($data['id'] == $FetchedData['role_id'] ){ echo 'selected';}?>    ><?php echo $data['title'];?></option>
            <?php } ?>
        </select>  
  </div>

   <input type="hidden" name="id" value="<?php echo $FetchedData['id'];?>">
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
                       
                </div>
                </main>
               
              
<?php 
    include '../footer.php';
?> 