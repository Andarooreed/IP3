<?php

if (isset($_POST["submit"])) {

    $uname = $_POST["username"];
    $email = $_POST["emailadd"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdrepeat"];

    require_once 'connection.inc.php';
    require_once 'functions.inc.php';

    if (invalidUsername($uname) !== false) {
        header("location: ../index.php?error=invalidusername");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../index.php?error=invalidemail");
        exit();
    }
    if (passwordMatch($password, $passwordRepeat) !== false) {
        header("location: ../index.php?error=passwordunmatched");
        exit();
    }
    if (userExists($conn, $username, $email) !== false) {
        header("location: ../index.php?error=userExists");
        exit();
    }

    createUser($conn, $uname, $email, $password);
} else {
    header("location: ../index.php");
    exit();
}
