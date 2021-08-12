<?php 

  include '../Admin/helpers/db.php';
  include '../Admin/helpers/functions.php';

  function CleanInputs($input){
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
  $errorMessages = array();
  if($_SERVER['REQUEST_METHOD'] == "POST" ){
    $email = CleanInputs($_POST['email']);
    $password = CleanInputs($_POST['password']); 

    // Email Validation 
    if(!empty($email)){
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errorMessages['email'] = "Invalid Email";
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

    if(count($errorMessages) == 0){
      $password = sha1($password);
      $sql = "select * from users where email = '$email' and password = '$password'";
      $op  = mysqli_query($con,$sql);
      if(mysqli_num_rows($op) == 1){
        $data = mysqli_fetch_assoc($op);
        $_SESSION['data'] = $data;
        header("Location: index.php");
      }else{
        $errorMessages['Result'] = 'Error in Login try again ';
      }
    }
  }



  require '../BEAUTYstore/header.php';
?>


<div class="container borderedbox"  id="login">
  <?php
    if(count($errorMessages) > 0){
      // print error messages 
      foreach($errorMessages as $key => $value){ ?>
        <p style="color: red;"> <?php echo '* '.$key.' : '.$value.'<br>'; ?> </p>
      <?php }
    }
  ?>

  <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
    <input type="email" name="email" class="form-control borderedbox" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
    <input type="password"  name="password" class="form-control borderedbox" id="exampleInputPassword1" placeholder="Password">
  </div>
 
  <div class="form-group">
    <button type="submit" class="btn btn-primary">Login</button>
  </div>
  </form> <br> <br>
  <p> Don't have an account? </p>
  <div> <a href='createAccount.php' class='btn btn-danger m-r-1em'>Create an account</a> </div>
</div>

<?php
  require '../BEAUTYstore/footer.php';
?>