<?php

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';

    # Fetch brands and categories Query .... 
    $sql_brand  = "select * from brands";
    $op_brand   = mysqli_query($con,$sql_brand); 
    $sql_category  = "select * from categories";
    $op_category   = mysqli_query($con,$sql_category); 

    $Message = array();

    if ($_SERVER['REQUEST_METHOD'] =='POST') {
        $product_name = cleanInput(Sanitize($_POST['name'],2));
        $price        = cleanInput($_POST['price']);
        $description  = cleanInput(Sanitize($_POST['description'],2));
        $brand_id     = Sanitize($_POST['brand_id'],1);
        $category_id  = Sanitize($_POST['category_id'],1);
        $image  =  NULL;


        //name validation
        if(!Validator($product_name,1)){
            $Message['name'] = "Name Field Required";
        }
        
        if(!Validator($product_name,2)){
            $Message['NameLength'] = "Name length must be > 2";
        }

        //price validation
        if(!Validator($price,1)){
            $Message['price'] = "price Field Required";
        }
        if(!Validator($price,6)){
            $Message['price'] = "Invalid price";
        }

        //brand_id & category_id validation
        if(!Validator($brand_id,3)){
            $Message['brand'] = "Invalid Brand ";
        }
        if(!Validator($category_id,3)){
            $Message['category'] = "Invalid Category ";
        }

        if (count($Message) == 0) {
            # DB OPERATION .... 
            $sql= "insert into products (name,price,description,brand_id,category_id) values ('$product_name','$price','$description','$brand_id','$category_id')";
            $op= mysqli_query($con,$sql);
            
            if($op){
                //get id of the product
                $sql_id= "select id from products order by id desc limit 1";
                $op_id= mysqli_query($con,$sql_id);
                $data_id= mysqli_fetch_assoc($op_id);
            }else{
                $Message['dataResult'] = 'Error Try Again';
            }
        }
        //var_dump($op); exit;

        //image validation
        $count   = count($_FILES['image']['name']);
        $count1 = strlen($_FILES['image']['name'][0]); //check if there is image or not
        
        if ($count1 > 0) {
            for ($i=0; $i < $count; $i++) { 
                $tmp_path= $_FILES['image']['tmp_name'][$i];
                $fileName= $_FILES['image']['name'][$i];
                //$fileSize= $_FILES['image']['size'][$i];
                //$fileType= $_FILES['image']['type'][$i];
    
                // if(!Validator($fileName,1)){
                //     $Message['image'] = "image Field Required";
                // }else {
                    $nameArray= explode('.',$fileName);
                    $fileExtension= strtolower($nameArray[1]);
                    $finalName= rand(). time(). '.'. $fileExtension; //to avoid identical file names

                    //image extension validation
                    if(!Validator($fileExtension,5)){
                        $Message['imageExtension'] = "Invalid Image Extension";
                    }
                //}
    
                if (count($Message) > 0) {
                    $_SESSION['messages'] = $Message;
                }else {
                    //uploading file from temp path to the server(destination path)
                    $destinationFolder= './productImages/';
                    $destinationPath= $destinationFolder. $finalName;
                    if (move_uploaded_file($tmp_path, $destinationPath)){
                        $image= $image.'+'. $finalName;
                        //print_r(explode('+',$image));  exit;
                    }else{
                        $Message['image'] = "failed to upload the image, please try again";
                    }
        
                    $_SESSION['messages'] = $Message;
                }
            }
            //inserting image of product
            $sql1= "insert into product_images (image,product_id) values ('$image',".$data_id['id'].")";
            $op1= mysqli_query($con,$sql1);
            if ($op1) {
                $Message['Result'] = "Data inserted.";
            }else {
                $Message['Result'] = 'error in uploading the image ';
            }

        }else {
            $Message['image'] = "image Field Required";
        }

        if (count($Message) > 0) {
            $_SESSION['messages'] = $Message;
        }else {
            $_SESSION['messages'] = $Message;
            header("Location: index.php");
        }
     
        //print error messages 
        // foreach($Message as $key => $value){
        //     echo '* '.$key.' : '.$value.'<br>';
        // }
        
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
                        
                            <li class="breadcrumb-item active">Add Product</li>
                            <?php } ?>
                      
                        </ol>

                      
 <div class="container">

 <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
 
    <div class="form-group">
        <label for="exampleInputEmail1">Product Name</label>
        <input type="text"  name="name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Price</label>
        <input type="text"  name="price" class="form-control" id="exampleInputName" aria-describedby="" placeholder="">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Description</label>
        <textarea name="description" class="form-control" id="exampleInputEmail1"> </textarea>
    </div>

    <div class="form-group">
        <label for="exampleInput">Category</label>
        <select  name="category_id" class="form-control" >
            <?php 
                while( $data = mysqli_fetch_assoc($op_category)){ 
            ?>
            <option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option> 
            <?php } ?>
  
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Brand</label>
        <select  name="brand_id" class="form-control" >
            <?php 
                while( $data = mysqli_fetch_assoc($op_brand)){ 
            ?>
            <option value="<?php echo $data['id'];?>" ><?php echo $data['name'];?></option> 
            <?php } ?>
    
        </select>
    </div>
 
    <div class="form-group">
        <label for="exampleInputPassword1">Image</label> <br>
        <input type="file"  name="image[]" id="exampleInputPassword1" multiple="multiple">
    </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

                       
                </div>
                </main>
                 
                
<?php 
    include '../footer.php';
?>  
