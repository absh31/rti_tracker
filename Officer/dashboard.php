<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    echo '<br>absh <br>';
    $sql = $conn->prepare('SELECT * FROM `tblrole` WHERE `role_id` = ?');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    echo $_SESSION['auth'].'.'.$key['role_name'];
    echo '<br/><a href="../logout.php" >Log Out</a>';
?>
<body>
    
</body>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>