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
		header("location: ../index.php?page=dashboard");
		exit();
	}

