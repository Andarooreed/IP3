<?php
include_once 'header.php';
?>

<?php
include_once 'modals/login-modal.php';
include_once 'modals/signup-modal.php';
include_once 'modals/success-modal.php';
?>

<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            ?><script>document.getElementById('successModal').style.display='block'</script><?php
        }
    }
?>
<script src="scripts/modal-close.js"></script>
<?php
include_once 'footer.php';
?>