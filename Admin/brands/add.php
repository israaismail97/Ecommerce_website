<?php

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
    
        $name = cleanInput($_POST['name']);
        $description  = cleanInput(Sanitize($_POST['description'],2));
        $image  =  NULL;

        $Message = [];
        # Check Validation ... 

        //name validation
        if(!Validator($name,1)){
            $Message['name'] = "Category name Field Required";
        }else {
            $length = 3;
            if(!Validator($name,2,$length)){
                $Message['nameLength'] = "Category name length shouldnt be < ".$length;    
            }
        }

        //description validation
        if(!Validator($description,1)){
            $Message['description'] = "Description Field Required";
        }

        //image validation
        //if (!empty($_FILES['image']['name'])) {
            $tmp_path= $_FILES['image']['tmp_name'];
            $fileName= $_FILES['image']['name'];
            // $fileSize= $_FILES['image']['size'];
            // $fileType= $_FILES['image']['type'];

            if(!Validator($fileName,1)){
                $Message['image'] = "image Field Required";
            }else {
                $nameArray= explode('.',$fileName);
                $fileExtension= $nameArray[1];
                $finalName= rand(). time(). '.'. $fileExtension; //to avoid identical file names

                //image extension validation
                if(!Validator($fileExtension,5)){
                    $Message['imageExtension'] = "Invalid Image Extension";
                }
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

        //}

        if(count($Message) > 0){
            $_SESSION['messages'] = $Message;      
        }else{
         # DB OPERATION .... 
            $sql = "insert into brands (name,description,brandImage) values ('$name','$description','$image')";
            $op  = mysqli_query($con,$sql);
        
            if($op){
                $Message['Result'] = "Data inserted successfully.";
            }else{
                $Message['Result']  = "Error Try Again.";
            }
            $_SESSION['messages'] = $Message;
            
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
                        
                            <li class="breadcrumb-item active">Add Brand</li>
                            <?php } ?>
                        </ol>

                        <div class="container">

                            <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand Name</label>
                                <input type="text"  name="name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea name="description" class="form-control" id="exampleInputEmail1"> </textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Image</label> <br>
                                <input type="file"  name="image" id="exampleInputPassword1">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </main>
                
<?php
    include '../footer.php';
?>
                