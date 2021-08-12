<?php 

    if($_SESSION['User']['role_id'] == 4){     //if Admin
        header("Location: ".url('website','Admin','index.php'));
    }

?>