<?php

if (isset($_POST["submit"])) {

  $name = $_POST["model_name"];

  require_once "connection.inc.php";
  require_once 'functions.inc.php';


  deleteModel($conn, $name);

  header("location: ../index.php?page=models");
    exit();

}