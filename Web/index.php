<?php
include_once 'header.php';
include_once 'modals/login.modal.php';
include_once 'modals/signup.modal.php';
include_once 'modals/addmodel.modal.php';
include_once 'modals/deletemodel.modal.php';
include_once 'modals/runmodel.modal.php';
include_once 'modals/about.modal.php';
include_once 'notifications/auth.notifications.php';
include_once 'includes/functions.inc.php';
?>

<?php
if (isset($_SESSION["user_id"])) { ?>
    <div class="leftside-nav" id="leftside-nav">
        <a href="javascript:void(0)" class="closebtn" id="closebtn" style="display: none;" onclick="closeNav()">&times;</a>
        <div class="title">
            <h3><strong><i class="fas fa-box-open" id="open-nav" onclick="openNav()"></i> &nbsp;&nbsp;&nbsp; What's in the photo?</strong></h3>
        </div>
        <div class="left-nav-items">
            <a href="index.php?page=home"><i class="fas fa-home"></i></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;Home</span></a>
            <a href="index.php?page=models"><i class="fas fa-images"></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;Models</span></a>
        </div>
        <div class="leftside-nav-footer">
            <a onclick="document.getElementById('aboutmodal').style.display='block'"><i class="fas fa-info-circle"></i></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;About</span></a>
        </div>
    </div>
    <div id="main">
        <?php
        if ($_GET["page"] == "login-none") {
            include_once './content/home.php';
        } else if ($_GET["page"] == "home") {
            include_once './content/home.php';
        } else if ($_GET["page"] == "models") {
            include_once './content/models.php';
        } else if ($_GET["page"] == "runuploadsuccess") {
            include_once './content/models.php';
        } else if ($_GET["page"] == "runuploadfailure") {
            include_once './content/models.php';
        }
        ?>
    </div>
<?php } else {
?>
    <div class="wrapper">
        <div class="title-center">
            <h1><strong>What's in the photo?</strong></h1>
        </div>
    </div>
<?php
}
?>
<?php
include_once 'footer.php';
?>