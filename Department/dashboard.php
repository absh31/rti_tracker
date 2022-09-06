<?php
session_start();
if ( ( isset($_SESSION['username']) && isset($_SESSION['auth']) ) && ($_SESSION['auth'] == 'Department Officer') ) {
    echo 'absh Officer';
    echo '<br/><a href="../logout.php" >Log Out</a>';
} else {
    echo "<script>alert('Don't peep!')</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
