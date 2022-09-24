<?php
session_start();
include './connection.php';
include './header.php';
include './nav.php';
if (!isset($_SESSION['requestNo'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
    ?>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <br><br>
                <h5 style="font-weight: 500;">You request is filed successfully! Your request reference number is <span class="text-danger" style="font-weight: 800;"><?= $_SESSION['requestNo'];?></span></h5>
                <a href="./index.php">Click Here</a> to go back to the home page...
            </div>
        </div>
    </div>
    <?php
}
// sleep(5);
// session_destroy();
// echo '<script>window.open("./index.php","_self")</script>';