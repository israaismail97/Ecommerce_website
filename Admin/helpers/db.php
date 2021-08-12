<?php

    $server="localhost";
    $dbName="website";
    $dbUser="root";
    $dbPassword="";
    $con= mysqli_connect($server,$dbUser,$dbPassword,$dbName);
    if (!$con) {
        die('Error message: '.mysqli_connect_error());
    }
?>