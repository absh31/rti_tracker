<?php
session_start();
include '../connection.php';
if ( ( isset($_SESSION['username']) && isset($_SESSION['auth']) ) && ($_SESSION['auth'] == 'Admin') ) {
    echo '<br>absh Admin<br>';
    echo '<br/><a href="../logout.php" >Log Out</a>';
} else {
    echo "<script>alert('Don't peep!')</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
