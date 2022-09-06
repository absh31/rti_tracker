<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth'])) && ($_SESSION['auth'] == 'Admin')) {
    // echo '<br>absh Admin<br>';
    // echo '<br/><a href="../logout.php" >Log Out</a>';
?>
<body>
    
</body>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>