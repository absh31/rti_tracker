<?php
include './header.php';
include './nav.php';
if (!isset($_POST['otp_verified'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {

?>
    <?php

}
    ?>