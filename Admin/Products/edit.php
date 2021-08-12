<?php 

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';

    //$id= '';
    //if($_SERVER['REQUEST_METHOD'] == "GET"){

        $id  = Sanitize($_GET['id'],1);
        $message=[];

        if(!Validator($id,3)){
            $Message['id'] = "Invalid ID";
            $_SESSION['messages'] = $Message;
            header("Location: index.php");
        }
        //var_dump($id); exit;
    //}

    
    // Fetch single Row of Data .... 
    $sql = "select * from products where id =". $id;
    $op = mysqli_query($con,$sql); 
    $data = mysqli_fetch_assoc($op);

    $sql2 = "select * from product_images where product_id =". $id;
    $op2 = mysqli_query($con,$sql2); 
    $data_image = mysqli_fetch_assoc($op2);

    // Fetch brands and categories Query .... 
    $sql_brand  = "select * from brands";
    $op_brand   = mysqli_query($con,$sql_brand); 
    $sql_category  = "select * from categories";
    $op_category   = mysqli_query($con,$sql_category); 


    if($_SERVER['REQUEST_METHOD'] == "POST" ){
        $product_name = cleanInput(Sanitize($_POST['name'],2));
        $price        = cleanInput($_POST['price']);
        $description  = cleanInput(Sanitize($_POST['description'],2));
        $brand_id     = Sanitize($_POST['brand_id'],1);
        $category_id  = Sanitize($_POST['category_id'],1);
        $image        = $data_image['image']; //to not remove the image if there is no update on it
        //$id    = Sanitize($_POST['id'],1);

        $Message = [];
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

        //data updating
        if (count($Message) > 0) {
            $_SESSION['messages'] = $Message;
        }else{
            $sql  = "update products set name='$product_name' , price='$price' , description ='$description' , brand_id ='$brand_id' , category_id ='$category_id' where id =$id ";
            $op   =  mysqli_query($con,$sql);
        }

        //image validation
        $count   = count($_FILES['image']['name']);
        $count1 = strlen($_FILES['image']['name'][0]);
        
        if ($count1 > 0) {
            $image = NULL;
            for ($i=0; $i < $count; $i++) { 
                $tmp_path= $_FILES['image']['tmp_name'][$i];
                $fileName= $_FILES['image']['name'][$i];
                //$fileSize= $_FILES['image']['size'][$i];
                //$fileType= $_FILES['image']['type'][$i];
    
                $nameArray= explode('.',$fileName);
                $fileExtension= strtolower($nameArray[1]);
                $finalName= rand(). time(). '.'. $fileExtension; //to avoid identical file names
                
                //image extension validation
                if(!Validator($fileExtension,5)){
                    $Message['imageExtension'] = "Invalid Image Extension";
                }
    
                if (count($Message) > 0) {
                    $_SESSION['messages'] = $Message;
                }else {
                    //uploading file from temp path to the server(destination path)
                    $destinationFolder= './productImages/';
                    $destinationPath= $destinationFolder. $finalName;
                    if (move_uploaded_file($tmp_path, $destinationPath)){
                        $image= $image.'+'. $finalName;
                        
                    }else{
                        $Message['image'] = "failed to upload the image, please try again";
                    }
        
                    $_SESSION['messages'] = $Message;
                }
            }
            //image updating
            $sql1 = "update product_images set image='$image' where product_id= $id ";
            $op1 = mysqli_query($con,$sql1);
            if($op and $op1){
                $Message['Result'] = "product Updated successfully";
                $_SESSION['messages'] = $Message;
                header("Location: index.php");
            }else{
                $Message['Result'] = "Error in updating data please try again !!";
            }
            
        }

        if (count($Message) > 0) {
            $_SESSION['messages'] = $Message;
        }else {
            $_SESSION['messages'] = $Message;
            header("Location: index.php");
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
                            <li class="breadcrumb-item active">Edit Product</li>
                            <?php } ?>
                        
                        </ol>

                      
<div class="container">

    <form  method="post"  action="edit.php?id=<?php echo $data['id'];?>"  enctype ="multipart/form-data">
                                    
        <div class="form-group">
            <label for="exampleInputEmail1">Product Name</label>
            <input type="text"  name="name" value="<?php echo $data['name'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Price</label>
            <input type="text"  name="price" value="<?php echo $data['price'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <textarea name="description" class="form-control" id="exampleInputEmail1"> <?php echo $data['description'];?> </textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Category</label>
            <select  name="category_id" class="form-control" >
                <?php 
                    while($data_category = mysqli_fetch_assoc($op_category)){ 
                ?>
                <option value="<?php echo $data_category['id'];?>" <?php if ($data_category['id']==$data['category_id']) { echo 'selected'; } ?> ><?php echo $data_category['name'];?></option> 
                <?php } ?>
    
            </select>
        </div>
    
        <div class="form-group">
            <label for="exampleInputPassword1">Brand</label>
            <select  name="brand_id" class="form-control" >
                <?php 
                    while($data_brand = mysqli_fetch_assoc($op_brand)){ 
                ?>
                <option value="<?php echo $data_brand['id'];?>" <?php if ($data_brand['id']==$data['brand_id']) { echo 'selected'; } ?> ><?php echo $data_brand['name'];?></option> 
                <?php } ?>
        
            </select>
        </div>
    

        <div class="form-group">
            <label for="exampleInputPassword1">Image</label> <br>
            <input type="file"  name="image[]" value="<?php echo $data_image['image'];?>" multiple="multiple" id="exampleInputPassword1">
            <br> <br>
            <?php 
                $imageArray = explode('+',$data_image['image']);
                for ($i=1; $i < count(explode('+',$data_image['image'])); $i++) { 
                    echo '<img src="./productImages/'.$imageArray[$i].'" width="100" height="100" >' ;
                }
            ?>
        </div>

        <!-- <input type="hidden" name="id" value="<?php //echo $data['id'];?>"> -->
    
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
                       
                </div>
                </main>
                          
<?php 
    include '../footer.php';
?> 
