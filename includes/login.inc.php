<?php

if (isset($_POST["submit"])) {
    
    $uname = $_POST['username'];
    $password = $_POST['pwd'];

    require_once 'connection.inc.php';
    require_once 'functions.inc.php';

    
    loginUser($conn, $uname, $password);

} else {
    header("location: ../index.php");
    exit();
}