<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "admin") {

        if (isset($_POST['deptId'])) {
            $deptId = $_POST['deptId'];

            $deleteDeptSql = $conn->prepare("UPDATE tbldepartment SET is_active = 0 WHERE department_id = ?");
            $deleteDeptSql->bindParam(1, $deptId);
            if ($deleteDeptSql->execute()) {
                echo "<script>window.alert(`Department Deleted Successfully`)</script>";
                echo "<script>window.open('../department.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
