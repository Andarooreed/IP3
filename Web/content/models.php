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
	<?php 
	display_array_recursive($json_array) ;
	?>
</div>