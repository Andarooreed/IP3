<?php
session_start();

if (isset($_POST["submit"])) {

  $name = $_POST["model_name"];
  $userId = $_SESSION["user_id"];

  require_once "connection.inc.php";
  require_once 'functions.inc.php';


  deleteModel($conn, $name, $userId);

  header("location: ../index.php?page=models");
  exit();

}