<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "admin") {

        if (isset($_POST['officer_id'])) {
            $officer_id = $_POST['officer_id'];

            $deleteDeptSql = $conn->prepare("UPDATE tblofficer SET is_active = 0 WHERE officer_id = ?");
            $deleteDeptSql->bindParam(1, $officer_id);
            if ($deleteDeptSql->execute()) {
                echo "<script>window.alert(`Officer Deleted Successfully`)</script>";
                echo "<script>window.open('../officer.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
