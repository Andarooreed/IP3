<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheets/main-sheet.css" />
    <link rel="stylesheet" type="text/css" href="stylesheets/modal.css" />

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,300italic,700,700italic">

    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">

    <!-- Milligram CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">

    <title>Image identifier - Login</title>
</head>

<body>
    <nav>
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                if (isset($_SESSION["userid"])) { ?>
                    <li><a href="includes/logout.inc.php"><button>Logout</button></a></li>
                <?php } else {
                ?>
                    <li><button onclick="document.getElementById('loginmodal').style.display='block'">Login</button></li>
                    <li><button onclick="document.getElementById('signupmodal').style.display='block'">Sign Up</button></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </nav>