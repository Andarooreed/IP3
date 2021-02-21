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
    header("location: ../index.php?error=emptyinput");
		exit();
  }

  if (invalidUid($uid) !== false) {
    header("location: ../index.php?error=invaliduid");
		exit();
  }

  if (invalidEmail($email) !== false) {
    header("location: ../index.php?error=invalidemail");
		exit();
  }

  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header("location: ../index.php?error=passwordsdontmatch");
		exit();
  }

  if (uidExists($conn, $username) !== false) {
    header("location: ../index.php?error=usernametaken");
		exit();
  }

  createUser($conn, $name, $email, $username, $pwd);

} else {
	header("location: ../index.php");
    exit();
}
