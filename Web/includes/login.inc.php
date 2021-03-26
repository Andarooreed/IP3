<?php

if (isset($_POST["submit"])) {

  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];

  require_once "connection.inc.php";
  require_once 'functions.inc.php';

  // Left inputs empty
  if (emptyInputLogin($username, $pwd) === true) {
    header("location: ../index.php?page=emptyinput");
		exit();
  }

  loginUser($conn, $username, $pwd);

} else {
	header("location: ../index.php");
    exit();
}
