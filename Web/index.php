<?php
include_once 'header.php';
include_once 'modals/login.modal.php';
include_once 'modals/signup.modal.php';
include_once 'notifications/auth.notifications.php';
?>

<?php
if (isset($_SESSION["user_id"])) { ?>
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
                        <a href="#"><i class="fas fa-info-circle"></i></i><span class="leftside-nav-wording" style="display: none;">&nbsp;&nbsp;&nbsp;About</span></a>
                        </div>
                    </div>
                    <div id="main">
                    <?php
                        include_once './Tabs/models.php';
                    ?>
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