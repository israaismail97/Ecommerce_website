<?php 

    include './helpers/functions.php';

    session_destroy();
    if (isset($_COOKIE['user'])) {
        setcookie("user",$_SESSION['User']['email'],(time()-60*60*5),'/');
    }
    header("Location: ".url('website','Admin','login.php'));

?>