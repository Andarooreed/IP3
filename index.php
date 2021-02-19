<?php
include_once 'header.php';
?>

<?php
include_once 'login-modal.php';
include_once 'signup-modal.php';
include_once 'success-modal.php';
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