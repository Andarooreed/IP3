<?php session_start();

require_once "connection.inc.php";
require_once 'functions.inc.php';

if (isset($_POST["submit"])) {

  // Get images
  $count_imagula = count($_FILES['file']['name']);

  // Build target directory
  $model_name = str_replace(" ","_",$_POST["model_name"]);
  $user_name =  $_SESSION["username"];
  $user_id =   $_SESSION["user_id"]; // I think this is actually supposed to be a model id or something, I forget.

  // Set db entry
  $model_id = addModel($conn, $user_id, $model_name);

  $target_dir = "../../Backend/WhatsInThePhotoAPI/UserUploads/" . strval($model_id) . "-" . $user_name . "-" . $model_name . "/" ;
  mkdir($target_dir, 0777, true);

  // Get some other shit
  $image_group_id = 1;
  $simp_vol = $_POST["simp_vol"];

  // Get any suplimentary images and add them to the users stuff
  if ($simp_vol > 0){
    // Get images
    //supplimentUserImageSet($model_name, $simp_vol);
    supplimentUserImageSet($model_name, $simp_vol);

    // Open the save location and move each file to the target dir
    $source_folder = "../../Backend/WhatsInThePhotoAPI/UserUploads/simple_images/" . $model_name;
    // Make sure this variable is set or it will move your entire root directory... don't ask
    if (isset($source_folder)){
      // GLOB
      $files = glob($source_folder . "/*");
      foreach ($files as $curr_file){
        $new_path = $target_dir . pathinfo($curr_file, PATHINFO_BASENAME);
        rename($curr_file, $new_path);
      }
    }
  }

  // Loop through the images and upload them
  for ($loopie_boi = 0; $loopie_boi < $count_imagula; $loopie_boi++){
    // Do Stuff
    $target_file = $target_dir . basename($_FILES["file"]["name"][$loopie_boi]);
    $postFileName = htmlspecialchars( basename( $_FILES["file"]["name"][$loopie_boi]));
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Upload File  (Gets shoved to a temp location so need to reference it as tmp_name, still saves as expected because it's defined in target_file)
    // Max uploads has been changed in the xamp\php\php.ini file - see the discord snip for reference
    move_uploaded_file($_FILES["file"]["tmp_name"][$loopie_boi], $target_file);

  }

  postImagesForTraining($target_dir);
   
  header("location: ../index.php?page=models");
  
  exit();

}
