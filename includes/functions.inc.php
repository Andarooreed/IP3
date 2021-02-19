<?php

function invalidUsername($uname) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $uname)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $passwordRepeat) {
    $result;
    if ($password !== $passwordRepeat) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function userExists($conn, $uname, $email) {
    $sql = "SELECT * FROM members WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    } 

    mysqli_stmt_bind_param($stmt, "ss", $uname, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $uname, $email, $password) {
    $sql = "INSERT INTO members (username, email, password) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $uname, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
        exit();
}

// login functions

function loginUser($conn, $uname, $password) {
    $userExists = userExists($conn, $uname, $uname);

    if ($userExists === false) {
        header("location: ../index.php?error=wronglogin");
        exit();
    }

    $hashedPassword = $userExists["password"];
    $checkPwd = password_verify($password, $hashedPassword);

    if ($checkPwd === false) {
        header("location: ../index.php?error=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["id"] = $userExists["id"];
        $_SESSION["username"] = $userExists["userame"];
        header("location: ../index.php");
        exit();
    }
}