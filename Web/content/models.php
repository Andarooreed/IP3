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
    <h3 id="model-nav-title"><strong>Models</strong></h3>
    <?php
    // When building the list of all available models, gather the first 3 image locations of each, encode the resultant array and pop it in a cookie
    // Can then reference that cookie in Js to pull out the required locations... Hopefully
    $key_path = [];
    $root_path = "..\\Backend\\WhatsInThePhotoAPI\\UserUploads\\";
    foreach ($json_array as $model) {
        $source_folder = $model['modelId'] . "-" . $_SESSION["username"] . "-" . $model['name'];

        if (isset($source_folder)) {

            // GLOB
            $files = glob($root_path . $source_folder . "\\*");
            $image_paths = [];
            $cnt = 0;
            foreach ($files as $curr_file) {
                if ($cnt++ > 2) {
                    break;
                }
                // array_push($key_path, [$model['modelId'], $curr_file]);
                array_push($image_paths, $curr_file);
            }
            $key_path[$model['modelId']] = $image_paths;
        }

    ?>
        <div class="display-models">
            <input style="display: none;" type="radio" id="<?php echo $model['modelId'] ?>" name="select" value="<?php echo $model['name'] ?>">
            <label for="<?php echo $model['modelId'] ?>" class="model-selector"><?php echo $model['name'] ?></label>
        </div>
    <?php
    }

    // encode and push the cookie.
    $model_cookie = json_encode($key_path, JSON_PRETTY_PRINT);
    $tmp_model_array = $key_path;
    ?>

    <div class="model-info">
        <button onclick="document.getElementById('addmodelmodal').style.display='block'" id="create-model-btn" class="button-one">Create & Train a Model!</button>
    </div>
</div>

<div class="middle-box" style="display:none;">

    <div class="image-placeholder"></div>
    <h3 id="model-title">Select a model from the side menu</h3>
    <p id="model_image_array" hidden> <?php echo $model_cookie; ?> </p>
    <div class="model-contents-placeholder">
        <div class="content-image-placeholder">
            <img id="user_model_img_1" src="" style="height:124px; width:150px; border-radius:4px">
        </div>
        <div class="content-image-placeholder">
            <img id="user_model_img_2" src="" style="height:124px; width:150px; border-radius:4px">
        </div>
        <div class="content-image-placeholder">
            <img id="user_model_img_3" src="" style="height:124px; width:150px; border-radius:4px">
        </div>


    </div>
    <button onclick="document.getElementById('deletemodelmodal').style.display='block'" id="delete-model-btn" class="button-one">Delete Model</button>
    <button onclick="document.getElementById('runmodelmodal').style.display='block'" id="run-model-btn" class="button-one">Run Model</button>

    <div class="information">
        <p>A model is a representation of an object!<br>
            Click on the 'Create and train a model!' button on the left hand side to make your own unique model.<br><br>
            <strong>Hover over elements to learn a little about them.</strong>
        </p>
    </div>
</div>



<div class="prediction-outcome">

    <?php

    if (isset($_SESSION["predictionLabel"])) {

        if ($_SESSION["predictionResult"] == 100) {
            $predictionsResultOutput = "This image " . $_SESSION["predictionResult"] . "% is a " . $_SESSION["predictionLabel"];
        } else {
            $predictionsResultOutput = "This image is " . $_SESSION["predictionResult"] . "% like a " . $_SESSION["predictionLabel"];
        }
        if ($_SESSION["predictionLabel"] == "Cup" || $_SESSION["predictionLabel"] == "cup") {
            $predictionsResultOutput = $predictionsResultOutput . " ☕";
        }

    ?>
        <h2>Your latest run:</h2>
    <?php
        echo $predictionsResultOutput;
    }

    ?>
</div>