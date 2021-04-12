<?php

require_once "connection.inc.php";
require_once 'functions.inc.php';

if (isset($_POST["submit"])) {

  // Get images
  $count_imagula = count($_FILES['file']['name']);

  // Build target directory
  $model_name = $_POST["model_name"];
  $user_name =  "TestIcle" ;//$_SESSION["user_id"];
  $user_id =   "666" ;//$_SESSION["username"];

  $target_dir = "../../Backend/WhatsInThePhotoAPI/UserUploads/" . strval($user_id) . "-" . $user_name . "-" . $model_name . "/" ;
  mkdir($target_dir, 0777, true);

  // Get some other shit
  $image_group_id = 1;

    echo "hello<br/>";
    echo "COUNT: " . $count_imagula;

  // Loop through the images and upload them
  for ($loopie_boi = 0; $loopie_boi < $count_imagula; $loopie_boi++){
    echo '<br/> ' . $loopie_boi;
    // Do Stuff
    $target_file = $target_dir . basename($_FILES["file"]["name"][$loopie_boi]);
    echo '<br/> ' . $target_file;
    $postFileName = htmlspecialchars( basename( $_FILES["file"]["name"][$loopie_boi]));
    echo '<br/> ' . $postFileName;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    echo '<br/>' . $imageFileType;
    echo '<Br/> file name: ' . $_FILES["file"]["name"][$loopie_boi];

    // Upload File  (Gets shoved to a temp location so need to reference it as tmp_name, still saves as expected because it's defined in target_file)
    // Max uploads has been changed in the xamp\php\php.ini file - see the discord snip for reference
    move_uploaded_file($_FILES["file"]["tmp_name"][$loopie_boi], $target_file);

  }

  //addModel($conn, $userId, $imageGroupId, $name, $location);
  postImagesForTraining($target_dir);


  header("location: ../index.php?page=models");
  exit();

}