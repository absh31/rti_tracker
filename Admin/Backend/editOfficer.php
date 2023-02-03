<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "admin") {

        if (isset($_POST['editOfficer'])) {
            $officerId = $_POST['officerId'];
            $officerUName = $_POST['officerUName'];
            $officerName = $_POST['officerName'];
            $officerMobile = $_POST['officerMobile'];
            $officerEmail = $_POST['officerEmail'];
            $officerDept = $_POST['officerDept'];
            $officerOther = "";
            $isActive = 1;
            $_POST['officerOther'] != "" ? $officerOther = $_POST['officerOther'] : $officerOther = $officerOther;

            if($_POST['officerPass'] == ''){
                $editOfficerSql = $conn->prepare("UPDATE tblofficer SET officer_name = ?, officer_email = ?, officer_other = ?, officer_department_id = ?, officer_username = ? WHERE officer_id = ?");
                $editOfficerSql->bindParam(1, $officerName);
                $editOfficerSql->bindParam(2, $officerEmail);
                $editOfficerSql->bindParam(3, $officerOther);
                $editOfficerSql->bindParam(4, $officerDept);
                $editOfficerSql->bindParam(5, $officerUName);
                $editOfficerSql->bindParam(6, $officerId);
            }else {
                $officerPass = md5($_POST['officerPass']);
                $editOfficerSql = $conn->prepare("UPDATE tblofficer SET officer_name = ?, officer_email = ?, officer_other = ?, officer_department_id = ?, officer_username = ?, officer_password = ? WHERE officer_id = ?");
                $editOfficerSql->bindParam(1, $officerName);
                $editOfficerSql->bindParam(2, $officerEmail);
                $editOfficerSql->bindParam(3, $officerOther);
                $editOfficerSql->bindParam(4, $officerDept);
                $editOfficerSql->bindParam(5, $officerUName);
                $editOfficerSql->bindParam(6, $officerPass);
                $editOfficerSql->bindParam(7, $officerId);
            }
            if ($editOfficerSql->execute()) {
                echo "<script>window.alert(`Data Edited Successfully`)</script>";
                echo "<script>window.open('../officer.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>