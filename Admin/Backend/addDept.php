<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "admin") {

        if (isset($_POST['addDept'])) {
            $deptName = $_POST['deptName'];
            $deptEmail = $_POST['deptEmail'];
            $deptOther = "";
            $isActive = 1;
            $_POST['deptOthers'] != "" ? $deptOther = $_POST['deptOthers'] : $deptOther = $deptOther;

            $addDeptSql = $conn->prepare("INSERT INTO tbldepartment (department_name, department_email, department_other, is_active) VALUES (?, ?, ?, ?)");
            $addDeptSql->bindParam(1, $deptName);
            $addDeptSql->bindParam(2, $deptEmail);
            $addDeptSql->bindParam(3,  $deptOther);
            $addDeptSql->bindParam(4, $isActive);
            if ($addDeptSql->execute()) {
                echo "<script>window.alert(`Department Added Successfully`)</script>";
                echo "<script>window.open('../department.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>