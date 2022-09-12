<?php
include './connection.php';
include './header.php';
include './nav.php';
session_start();
if (!isset($_SESSION['requestNo'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    ?>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h5>You request is filed successfully! Your request reference number is <?= $_SESSION['requestNo'];?></h5>
                <a href="./index.php">Click Here</a> to go back to the home page...
            </div>
        </div>
    </div>
    <?php
}
sleep(30);
session_destroy();