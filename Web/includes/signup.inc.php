<?php

if (isset($_POST["submit"])) {

  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdrepeat"];


  require_once "connection.inc.php";
  require_once 'functions.inc.php';

  if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
    header("location: ../index.php?page=emptyinput");
		exit();
  }

  if (invalidUid($uid) !== false) {
    header("location: ../index.php?page=invaliduid");
		exit();
  }

  if (invalidEmail($email) !== false) {
    header("location: ../index.php?page=invalidemail");
		exit();
  }

  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header("location: ../index.php?page=passwordsdontmatch");
		exit();
  }

  if (uidExists($conn, $username) !== false) {
    header("location: ../index.php?page=usernametaken");
		exit();
  }

  createUser($conn, $name, $email, $username, $pwd);

} else {
	header("location: ../index.php");
    exit();
}
