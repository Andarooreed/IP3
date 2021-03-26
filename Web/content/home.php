<?php
$arrContextOptions = array(
	"ssl" => array(
		"verify_peer" => false,
		"verify_peer_name" => false,
	),
);

$response = file_get_contents("https://localhost:44317/api/MachineModel", false, stream_context_create($arrContextOptions));

$json_array = json_decode($response, true);



function display_array_recursive($json_rec){
	if($json_rec){
		foreach($json_rec as $key=> $value){
			if(is_array($value)){
				display_array_recursive($value);
				echo '<br>';
			}else{
				$output =$key.': '.$value.'<br>';
				echo $output;
			}	
		}	
	}
}

?>
<div class=model-info-test-display>
    <form action="POST">
	<?php
    foreach ($json_array as $model) {
        // echo $model['name'] . "<br />";
        ?><input type="radio" name="model" value="<?php $model['name'] ?>">
        <label for="<?php $model['name'] ?>"><?php echo $model['name'] ?></label>
        <?php
    }
	?>
    </form>
</div>

<div class="model-list">

</div>

<div class="model-info">
    <form action="POST">
    <input type="file" id="myFile" name="filename">
        <br>
        <button id="predict">Predict</button>
    </form>
</div>