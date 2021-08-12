<?php 

    include '../helpers/db.php';
    include '../helpers/functions.php';
    include '../helpers/checkLogin.php';
    
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
        $name = cleanInput($_POST['name']);
        $id    = Sanitize($_POST['id'],1);

        $Message = [];
        # Check Validation ... 
        if(!Validator($name,1)){
            $Message['name'] = "Category Name Field Required";
        }
  
        $length = 3;
        if(!Validator($name,2,$length)){
            $Message['NameLength'] = "Category Name length shouldnt be < ".$length;
        }

        if(!Validator($id,3)){
            $Message['id'] = "Invalid id";
        }

        if(count($Message) > 0){
            $_SESSION['messages'] = $Message;      
        }else{

            # DB OPERATION .... 
            $sql = "update categories set name='$name' where id = ".$id;
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
    $sql  = "select * from categories where id = ".$id;
    $op   = mysqli_query($con,$sql);
    $FetchedData = mysqli_fetch_assoc($op);


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
                            
                            <li class="breadcrumb-item active">Edit Category</li>
                            <?php } ?>
         
                        </ol>
              

 <div class="container">

 <form  method="post"  action="edit.php?id=<?php echo $FetchedData['id'];?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text"  name="name" value="<?php echo $FetchedData['name'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Category Name">
  </div>

   <input type="hidden" name="id" value="<?php echo $FetchedData['id'];?>">
  
  <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
</div>


                       
                </div>
                </main>
               
    
                
<?php 
    include '../footer.php';
?>  