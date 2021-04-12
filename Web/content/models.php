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

    <div class="model-info">
        <button onclick="document.getElementById('addmodelmodal').style.display='block'" class="button-one">HIDY HO MOTHER FUCKER</button>
    </div>
</div>

<div class="middle-box" style="display:none;">

    <div class="image-placeholder"></div>
    <h3 id="model-title">Select a model from the side menu</h3>
    <h4 id="model-description">Description of models function</h4>
    <div class="model-contents-placeholder">
        <div class="content-image-placeholder"></div>
        <div class="content-image-placeholder"></div>
        <div class="content-image-placeholder"></div>
    </div>
    <button class="button-one">Delete Model</button>
    <button onclick="document.getElementById('runmodelmodal').style.display='block'" class="button-one">Run Model</button>


</div>
<div class="prediction-outcome">

    <?php

    if (isset($_SESSION["predictionLabel"])) {

        if($_SESSION["predictionResult"] == 100) {
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


<script>
    $('input[name="select"]').on('change', function() {
        $(".middle-box").show();
        $(".prediction-outcome").hide();
        $("#model-title").text($(this).val());
        $("#model-modal-input-name").val($(this).val());
        $("#model-description").text("You selected something");
    });


    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>