<?php

if (isset($_POST["submit"])) {

  $userId = 1;
  $imageGroupId = 1;
  $name = $_POST["model_name"];
  $location = $_POST["model_location"];

  require_once "connection.inc.php";
  require_once 'functions.inc.php';


  addModel($conn, $userId, $imageGroupId, $name, $location);

  header("location: ../index.php?page=dashboard");
    exit();

}