<?php

// Check for empty input signup
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat)
{
	$result;
	if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check invalid username
function invalidUid($username)
{
	$result;
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check invalid email
function invalidEmail($email)
{
	$result;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check if passwords matches
function pwdMatch($pwd, $pwdrepeat)
{
	$result;
	if ($pwd !== $pwdrepeat) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check if username is in database, if so then return data
function uidExists($conn, $username)
{
	$sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../index.php?page=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $username);
	mysqli_stmt_execute($stmt);

	// "Get result" returns the results from a prepared statement
	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	} else {
		$result = false;
		return $result;
	}

	mysqli_stmt_close($stmt);
}

// Insert new user into database
function createUser($conn, $name, $email, $username, $pwd)
{
	$sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?);";

	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../index.php?page=stmtfailed");
		exit();
	}

	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	header("location: ../index.php?page=signup-none");
	exit();
}

// Check for empty input login
function emptyInputLogin($username, $pwd)
{
	$result;
	if (empty($username) || empty($pwd)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Log user into website
function loginUser($conn, $username, $pwd)
{
	$uidExists = uidExists($conn, $username);

	if ($uidExists === false) {
		header("location: ../index.php?page=wronglogin");
		exit();
	}

	$pwdHashed = $uidExists["password"];
	$checkPwd = password_verify($pwd, $pwdHashed);

	if ($checkPwd === false) {
		header("location: ../index.php?page=wronglogin");
		exit();
	} elseif ($checkPwd === true) {
		session_start();
		$_SESSION["user_id"] = $uidExists["user_id"];
		$_SESSION["username"] = $uidExists["username"];
		header("location: ../index.php?page=login-none");
		exit();
	}
}

// Add empty model to database
function addModel($conn, $userId, $imageGroupId, $name, $location)
{
	$sql = "INSERT INTO model (user_id, image_group_id, name, location) VALUES (?, ?, ?, ?);";

	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../index.php?page=stmtfailed");
		exit();
	}
	mysqli_stmt_bind_param($stmt, "ssss", $userId, $imageGroupId, $name, $location);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	header("location: ../index.php?page=models");
	exit();
}

function deleteModel($conn, $name) {
	$sql = "DELETE FROM model WHERE name = '$name'";
	
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../index.php?page=stmtfailed");
		exit();
	}
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	header("location: ../index.php?page=models");
	exit();
}

function postImageForPrediction($fileName, $modelName)
{
	$data = array('key1' => 'value1', 'key2' => 'value2');

	$arrContextOptions = array(
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false,
		),
		"http" => array(
			'header'  => "Content-type: application/json; charset=utf-8",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);

	$response = file_get_contents("https://localhost:44317/api/MachineModel/api/MachineModel/Identify?filename=$fileName&modelName=$modelName", false, stream_context_create($arrContextOptions));

	$json_array = json_decode($response, true);
	session_start();
	$_SESSION["predictionLabel"] = $json_array['label'];
	$_SESSION["predictionResult"] = $json_array['percentageResult'];

	header("location: ../index.php?page=runuploadsuccess");
	exit();
}

## Daniel
function postImagesForTraining($folderName)
{
	$data = array('key1' => 'value1', 'key2' => 'value2');

	$arrContextOptions = array(
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false,
		),
		"http" => array(
			'header'  => "Content-type: application/json; charset=utf-8",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);

	$folderName = str_replace("/","XXX",$folderName);
	$folderName = str_replace("\\","XXX",$folderName);
	$response = file_get_contents("https://localhost:44317/api/MachineModel/api/MachineModel/TrainModel?folderName=$folderName", false, stream_context_create($arrContextOptions));

	$json_array = json_decode($response, true);
	session_start();
	
	header("location: ../index.php?page=models");
	exit();
}

function supplimentUserImageSet($simp_query, $simp_vol)
{
	$data = array('key1' => 'value1', 'key2' => 'value2');

	$arrContextOptions = array(
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false,
		),
		"http" => array(
			'header'  => "Content-type: application/json; charset=utf-8",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);

	// Stick the search term in quotes
	$simp_query = "\"" . $simp_query . "\"";

	$response = file_get_contents("https://localhost:44317/api/MachineModel/api/MachineModel/DownloadImage?imageDownloadQuery=$simp_query&imageAmount=$simp_vol", false, stream_context_create($arrContextOptions));

	$json_array = json_decode($response, true);
	session_start();
	
}

