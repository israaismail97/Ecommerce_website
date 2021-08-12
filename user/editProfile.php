<?php 

    include '../Admin/helpers/db.php';
    include '../Admin/helpers/functions.php';
    require "checkLogin.php";

   $id = $_GET['id'];
   $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
   $message = "";

   if(!filter_var($id,FILTER_VALIDATE_INT)){
        $_SESSION['message'] = "Invalid Id";
        header("Locattion: index.php");
    }
    // Fetch single Row of Data .... 
    $sql = "select * from users where id = $id";
    $op = mysqli_query($con,$sql); 
    $data = mysqli_fetch_assoc($op);

    $sql_info = "select * from user_information where user_id = $id";
    $op_info = mysqli_query($con,$sql_info); 
    $data_info = mysqli_fetch_assoc($op_info);

    $errorMessages = array();
    if($_SERVER['REQUEST_METHOD'] == "POST" ){

        $firstName= cleanInput($_POST['Fname']);
        $lastName= cleanInput($_POST['Lname']);
        $email= cleanInput($_POST['email']);
        $phone= cleanInput($_POST['phone']);

        // Name Validation ...
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

        // Email Validation ... 
        if(!empty($email)){
           if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errorMessages['email'] = "Invalid Email";
            }else {
                if ($email!=$data['email']) {    //there are changes in email
                    $sql= "SELECT COUNT(id) FROM `users` WHERE email='$email'";
                    $op= mysqli_query($con,$sql);
                    $email_repeat= mysqli_fetch_assoc($op);
                    if ($email_repeat['COUNT(id)']>= 1) {
                        $errorMessages['email'] = "email already exists";
                    }
                }
            }
        }else{
            $errorMessages['email'] = "Required";
        }

        //phone validation
        if (! Validator($phone,7,11)) {
            $errorMessages['phone'] = "11 characters required";
        }

        //data updating
        if(count($errorMessages) == 0){
            // DB CODE... 
            $sql  = "update users set first_name='$firstName' , last_name='$lastName' , email ='$email' where id =$id ";
            $op   =  mysqli_query($con,$sql);
            $sql1  = "update user_information set phone='$phone' where user_id =$id ";
            $op1   =  mysqli_query($con,$sql1);

            if($op and $op1){
                $_SESSION['message'] = "profile Updated successfully";
                $_SESSION['data']['first_name'] = $firstName;
                $_SESSION['data']['last_name'] = $lastName;
                $_SESSION['data']['email'] = $email;
                $_SESSION['data']['phone'] = $phone;
                header("Location: index.php");
            }else{
                $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
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
  <h2>Edit profile </h2>
  <form  method="post"  action="editProfile.php?id=<?php echo $data['id'];?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
        <input type="text"  name="Fname"   value="<?php echo $data['first_name'];?>"   class="form-control borderedbox" id="exampleInputName" aria-describedby="" placeholder="First Name">
  </div>

  <div class="form-group">
        <input type="text"  name="Lname"   value="<?php echo $data['last_name'];?>"   class="form-control borderedbox" id="exampleInputName1" aria-describedby="" placeholder="Last Name">
  </div>

  <div class="form-group">
        <input type="email" name="email"  value="<?php echo $data['email'];?>" class="form-control borderedbox" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email">
  </div>

  <div class="form-group">
        <input type="tel" name="phone"  value="<?php if (strlen($data_info['phone']) > 1) {echo $data_info['phone'];}?>" class="form-control borderedbox" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Phone Number">
  </div>

  <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
  </div>
</form>
</div>

<?php
  require '../BEAUTYstore/footer.php';
?>