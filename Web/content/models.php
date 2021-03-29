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
    <form action="POST">
	<?php
    foreach ($json_array as $model) {
        ?>
		<div class="display-models">
		<input style="display: none;" type="radio" id="<?php echo $model['name'] ?>" name="select" value="1">
		<label for="<?php echo $model['name'] ?>" class="model-selector"><?php echo $model['name'] ?></label>
		</div>
        <?php
    }
	?>
    </form>


<div class="model-info">
<button onclick="document.getElementById('addmodelmodal').style.display='block'" class="button-one">Add model</button>
    <form action="POST">
    <input type="file" id="myFile" name="filename">
        <br>
        
    </form>
</div>
<button id="predict" class="button-one">Predict</button>
</div>