<?php
include_once 'header.php';
include_once 'modals/login.modal.php';
include_once 'modals/signup.modal.php';
include_once 'notifications/auth.notifications.php';
?>

<?php
if (isset($_SESSION["userid"])) { ?>
    <div class="dashboard">
        <div class="model-nav" id="model-nav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="title">
                <h3><strong>What's in the box?</strong></h3>
            </div>
            <a href="#">Models</a>
            <a href="#">Models</a>
            <a href="#">Models</a>
            <a href="#">Models</a>
        </div>
        <div id="main">
            <button class="button-one" onclick="openNav()">open</button>
        </div>
    </div>
<?php } else {
?>
    <div class="wrapper">
        <div class="title-center">
            <h1><strong>What's in the box?</strong></h1>
        </div>
    </div>
<?php
}
?>
<?php
include_once 'footer.php';
?>