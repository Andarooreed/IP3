<?php
include_once './functions.inc.php';

$target_dir = "../../Backend/WhatsInThePhotoAPI/TemporaryImages/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$postFileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
$modelName = $_POST['select'];
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
  echo "File is an image - " . $check["mime"] . ".";
  $uploadOk = 1;
  } else {
  echo "File is not an image.";
  $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "<div class='fileuploadwarning'>Sorry, file already exists.</div>";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 9900000) {
  echo "<div class='fileuploadwarning'>Sorry, file is too large</div>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "<div class='fileuploadwarning'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<div class='fileuploadwarning'>Sorry, your file was not uploaded.</div>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

  postImageForPrediction("$postFileName", "$modelName");

  } else {
  echo "<div class='fileuploadwarning'>Sorry, there was an error uploading your file.</div>";
  }
}

?>