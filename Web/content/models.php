<?php
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$response = file_get_contents("https://localhost:44317/api/MachineModel", false, stream_context_create($arrContextOptions));

$json_array = json_decode($response, true);

?>
<div class="leftside-modelnav">
    <h3><strong>Models</strong></h3>
    <form method="POST" enctype="multipart/form-data">
        <?php
        foreach ($json_array as $model) {
        ?>
            <div class="display-models">
                <input style="display: none;" type="radio" id="<?php echo $model['name'] ?>" name="select" value="<?php echo $model['name'] ?>">
                <label for="<?php echo $model['name'] ?>" class="model-selector"><?php echo $model['name'] ?></label>
            </div>
        <?php
        }
        ?>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br>
        <button type="submit" name="submit" id="predict" class="button-one">Predict</button>
    </form>

    <div class="model-info">
        <button onclick="document.getElementById('addmodelmodal').style.display='block'" class="button-one">Add model</button>
        <form action="POST">

        </form>
    </div>
</div>


<?php
$target_dir = "../Backend/WhatsInThePhotoAPI/TemporaryImages/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>