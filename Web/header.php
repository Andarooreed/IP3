<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./stylesheets/main-sheet.css">
    <link rel="stylesheet" type="text/css" href="./stylesheets/modal.css">
    <link rel="stylesheet" type="text/css" href="./stylesheets/notifications.css">
    <link rel="stylesheet" type="text/css" href="./stylesheets/model-nav.css">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,300italic,700,700italic">

    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">

    <!-- Milligram CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">

    <!-- Fontawesome script -->
    <script src="https://kit.fontawesome.com/a07d05399.js"></script>

    <!-- JQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <title>What's in the box?</title>
</head>

<body>
    <nav>
        <div class="wrapper">
            <ul>
                <div class="nav-title">
                    <li><a href="index.php">
                            <h3><strong><i class="fas fa-box-open"></i> &nbsp;&nbsp;&nbsp; What's in the box?</strong></h3>
                        </a></li>
                </div>
                <?php
                if (isset($_SESSION["userid"])) {; ?>
                    <div class="nav-right">
                        <div class="welcome-message">
                            <li>
                                <h4>Welcome <?php echo $_SESSION["useruid"] ?></h4>
                            </li>
                        </div>
                        <li><a href="includes/logout.inc.php"><button class="button-one">Logout</button></a></li>
                    </div>
                    <div class="leftside-nav" id="leftside-nav">
                        <a href="javascript:void(0)" class="closebtn" id="closebtn" style="display: none;" onclick="closeNav()">&times;</a>
                        <div class="title">
                            <h3><strong><i class="fas fa-box-open" id="open-nav" onclick="openNav()"></i> &nbsp;&nbsp;&nbsp; What's in the box?</strong></h3>
                        </div>
                        <div class="left-nav-items">
                            <a href="#"><i class="fas fa-columns"></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;Dashboard</span></a>
                            <a href="#"><i class="fas fa-images"></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;Models</span></a>
                            <a href="#"><i class="fas fa-cogs"></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;Settings</span></a>
                        </div>
                        <div class="leftside-nav-footer">
                        <a href="#" onclick="document.getElementById('infomodal').style.display='block'"><i class="fas fa-info-circle"></i></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;About</span></a>
                        </div>
                    </div>
                    <div id="main">
                    <?php
                        include_once './Tabs/models.php';
                    ?>
                    </div>

                <?php } else {
                ?>
                    <div class="nav-right">
                        <li><button onclick="document.getElementById('loginmodal').style.display='block'" class="button-one">Login</button></li>
                        <li><button onclick="document.getElementById('signupmodal').style.display='block'" class="button-one">Sign Up</button></li>
                    </div>
                <?php
                }
                ?>
            </ul>
        </div>
    </nav>