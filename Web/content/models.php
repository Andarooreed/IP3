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
    <form method="POST" action="./includes/upload.inc.php" enctype="multipart/form-data">
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
        <button class="button-one">Predict</button>
    </form>

    <div class="model-info">
        <button onclick="document.getElementById('addmodelmodal').style.display='block'" class="button-one">Add model</button>
    </div>
</div>

<div class="middle-box">
    
    <div class="image-placeholder"></div>
    <h3 id="model-title">Model Name</h3>
    <h4>Description of models function</h4>
    <div class="model-contents-placeholder">
        <div class="content-image-placeholder"></div>
        <div class="content-image-placeholder"></div>
        <div class="content-image-placeholder"></div>
    </div>
    <button class="button-one">Delete Model</button>
    <button class="button-one">Edit Model</button>
    <button class="button-one">Run Model</button>
</div>

<div class="prediction-outcome">

    <?php

    if (isset($_SESSION["predictionLabel"])) {
        $predictionsResultOutput = "This image is " . $_SESSION["predictionResult"] . "% like a " . $_SESSION["predictionLabel"];

        if ($_SESSION["predictionLabel"] == "Cup" || $_SESSION["predictionLabel"] == "cup") {
            $predictionsResultOutput = $predictionsResultOutput . " ☕";
        }

        echo $predictionsResultOutput;
    }

    ?>

</div>

<script>
   $('input[name="select"]').on('change', function(){   
        $("#model-title").text($(this).val());
});
</script>