<?php

    include '../Admin/helpers/db.php';
    include '../Admin/helpers/functions.php';

    $errorMessages = array();

    if ($_SERVER['REQUEST_METHOD'] =='POST') {
        $firstName= cleanInput($_POST['Fname']);
        $lastName= cleanInput($_POST['Lname']);
        $email= cleanInput($_POST['email']);
        $password= cleanInput($_POST['password']);
        $confirm_password= cleanInput($_POST['CFMpassword']);

        //name validation
        if(!empty($firstName)){
                if(strlen($firstName) < 3){
                $errorMessages['firstName'] = "Name Length must be > 2 "; 
                }
        }else{
            $errorMessages['firstName'] = "Required";
        }

        if(!empty($lastName)){
            if(strlen($lastName) < 3){
            $errorMessages['lastName'] = "Name Length must be > 2 "; 
            }
        }else{
            $errorMessages['lastName'] = "Required";
        }

        // Email Validation 
        if(!empty($email)){
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errorMessages['email'] = "Invalid Email";
            }else {
                $sql= "SELECT COUNT(id) FROM `users` WHERE email='$email'";
                $op= mysqli_query($con,$sql);
                $email_repeat= mysqli_fetch_assoc($op);
                if ($email_repeat['COUNT(id)']>= 1) {
                    $errorMessages['email'] = "email already exists";
                }
            }
        }else{
            $errorMessages['email'] = "Required";
        }

        // Password Validation  
        if(!empty($password)){
            if(strlen($password) < 6){
                $errorMessages['Password'] = "password shouldnt be less than 6 characters"; 
            }
        }else{
           $errorMessages['Password'] = "Required";
        }
        
        // confirm Password Validation
        if(!empty($confirm_password)){
            if(strlen($password) < 6){
                $errorMessages['confirm_password'] = "password shouldnt be less than 6 characters"; 
            }
            else {
                if ($confirm_password != $password) {
                    $errorMessages['confirm_password'] = "not matched";
                }
            }
        }else{
           $errorMessages['confirm_password'] = "Required";
        }

        //data inserting
        if (count($errorMessages)==0) {

            $password = sha1($password);   //password hashing
            $sql= "insert into users (first_name,last_name,email,password) values ('$firstName','$lastName','$email','$password')";
            $op= mysqli_query($con,$sql);
            if($op){
                $_SESSION['message']= "Account created successfully";
                //$sql1= "select * from users where email= '$email' ";
                $sql1= "select * from users order by id desc limit 1";
                $op1= mysqli_query($con,$sql1);
                $data= mysqli_fetch_assoc($op1);
                $_SESSION['data']= $data;
                header("Location: index.php");
            }else{
                echo 'Error Try Again';
            }
        }else{
            // print error messages 
            foreach($errorMessages as $key => $value){
                echo '* '.$key.' : '.$value.'<br>';
            }
        }
    }


    require '../BEAUTYstore/header.php';
?>


<div class="container borderedbox" id="login">
  <h2>Create an account</h2>
  <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
 
    <div class="form-group">
        <input type="text"  name="Fname" class="form-control borderedbox" id="exampleInputName" aria-describedby="" placeholder="First Name">
    </div>

    <div class="form-group">
        <input type="text"  name="Lname" class="form-control borderedbox" id="exampleInputName1" aria-describedby="" placeholder="Last Name">
    </div>

    <div class="form-group">
        <input type="text" name="email" class="form-control borderedbox" id="exampleInputEmail1" aria-describedby="" placeholder="email">
    </div>

    <div class="form-group">
        <input type="password"  name="password" class="form-control borderedbox" id="exampleInputPassword" placeholder="password">
    </div>

    <div class="form-group">
        <input type="password"  name="CFMpassword" class="form-control borderedbox" id="exampleInputPassword1" placeholder="confirm your password">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">SIGN UP</button>
    </div>
    </form>
    <br>
    <p> Already have an account? </p>
    <div class="form-group">
        <div> <a href='login.php' class='btn btn-danger m-r-1em'>LOG IN</a> </div>
    </div>
</div>

<?php
  require '../BEAUTYstore/footer.php';
?>