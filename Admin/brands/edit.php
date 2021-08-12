<?php 

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';
    

    $Message = [];
    //id validation
    $id  = Sanitize($_GET['id'],1);
    
    if(!Validator($id,3)){
        $Message['id'] = "Invalid ID";
        $_SESSION['messages'] = $Message;
        header("Location: index.php");
    }


    # Fetch Data to id . 
    $sql  = "select * from brands where id = ".$id;
    $op   = mysqli_query($con,$sql);
    $FetchedData = mysqli_fetch_assoc($op);


    if($_SERVER['REQUEST_METHOD'] == "POST"){   
        // LOGIC ... 
        $name = cleanInput($_POST['name']);
        $description  = cleanInput(Sanitize($_POST['description'],2));
        $image  =  $FetchedData['brandImage'];

        $Message = [];
        # Check Validation ... 
        //name validation
        if(!Validator($name,1)){
            $Message['name'] = "Brand name Field Required";
        }else {
            $length = 3;
            if(!Validator($name,2,$length)){
                $Message['nameLength'] = "Brand name length shouldnt be < ".$length;    
            }
        }
  
        //description validation
        if(!Validator($description,1)){
            $Message['description'] = "Description Field Required";
        }

        //image validation
        $tmp_path= $_FILES['image']['tmp_name'];
        $fileName= $_FILES['image']['name'];
        // $fileSize= $_FILES['image']['size'];
        // $fileType= $_FILES['image']['type'];

        if(Validator($fileName,1)){                //if not empty
            $nameArray= explode('.',$fileName);
            $fileExtension= $nameArray[1];
            $finalName= rand(). time(). '.'. $fileExtension; //to avoid identical file names

            //image extension validation
            if(!Validator($fileExtension,5)){
                $Message['imageExtension'] = "Invalid Image Extension";
            }

            if (count($Message) > 0) {
                $_SESSION['messages'] = $Message;
            }else {
                //uploading file from temp path to the server(destination path)
                $destinationFolder= './brandsImages/';
                $destinationPath= $destinationFolder. $finalName;
                if (move_uploaded_file($tmp_path, $destinationPath)){
                    $image = $finalName;
                }else{
                    $Message['image'] = "failed to upload the image, please try again";
                }
    
                $_SESSION['messages'] = $Message;
            }
        }


        if(count($Message) > 0){
            $_SESSION['messages'] = $Message;      
        }else{

            # DB OPERATION .... 
            $sql = "update brands set name='$name' , description='$description' , brandImage='$image' where id = ".$id;
            $op  = mysqli_query($con,$sql);
            //echo mysqli_error($con); exit;

            if($op){
                $Message['Result'] = "Data updated.";
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

                                foreach($_SESSION['messages'] as $key =>  $value){
                                        echo '* '.$key.' : '.$value.'<br>';
                                    }
                                    unset($_SESSION['messages']);
                                }else{
                            ?>
                            
                            <li class="breadcrumb-item active">Edit Brand</li>
                            <?php } ?>
         
                        </ol>
              

 <div class="container">

 <form  method="post"  action="edit.php?id=<?php echo $FetchedData['id'];?>"  enctype ="multipart/form-data">

    <div class="form-group">
        <label for="exampleInputEmail1">Brand Name</label>
        <input type="text"  name="name" value="<?php echo $FetchedData['name'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Description</label>
        <textarea name="description" class="form-control" id="exampleInputEmail1"> <?php echo $FetchedData['description'];?> </textarea>
    </div>
    
    <div class="form-group">
        <label for="exampleInputPassword1">Image</label> <br>
        <input type="file"  name="image" id="exampleInputPassword1">
        <br> <?php echo '<img src="./brandsImages/'.$FetchedData['brandImage'].'" width="100" height="100" >' ; ?>
    </div>

  
  <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
</div>


                       
                </div>
                </main>
               
    
                
<?php 
    include '../footer.php';
?>  