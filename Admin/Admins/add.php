<?php 
    
    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';
    include '../helpers/checkPerm.php';

    $sql = "select * from adminrole";
    $op  = mysqli_query($con,$sql);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // LOGIC ...
        $name  = cleanInput(Sanitize($_POST['name'],2));
        $email = cleanInput($_POST['email']);
        $password = $_POST['password'];
        $role_id  = Sanitize($_POST['role_id'],1);

        $Message = [];
        # Check Validation ... 
        if(!Validator($name,1)){
            $Message['name'] = "Name Field Required";
        }
        
        if(!Validator($name,2)){
            $Message['NameLength'] = "Title length must be > 3";
        }
    
        if(!Validator($password,2,6)){
            $Message['password'] = "Password length must be >= 6";
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

        if(count($Message) > 0){
            $_SESSION['messages'] = $Message;       
        }else{

            # DB OPERATION .... 
            $password = sha1($password);
            $insertSql = "insert into admins (name,email,password,role_id) values ('$name','$email','$password',$role_id)";
            $InsertOp  = mysqli_query($con,$insertSql);

            if($InsertOp){
                $Message['Result'] = "Data inserted.";
            }else{
                $Message['Result']  = "Error Try Again.";
            }
            $_SESSION['messages'] = $Message;

            header('Location: index.php');
        }
    }


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
                        
                            <li class="breadcrumb-item active">Add Admin</li>
                            <?php } ?>
                      
                        </ol>

                      
 <div class="container">

 <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
 
 <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text"  name="name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>

  <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
        <label for="exampleInputPassword1"> Password</label>
        <input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
 
  <div class="form-group">
        <label for="exampleInput"> Role type </label>
        <select name="role_id" class="form-control"> 
        <?php 
            while($data = mysqli_fetch_assoc($op)){
        ?>
        <option value="<?php echo $data['id'];?>"><?php echo $data['title'];?></option>
        <?php } ?>
        </select>  
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

                       
                </div>
                </main>
                 
                
<?php 
    include '../footer.php';
?>  