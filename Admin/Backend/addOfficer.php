<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    if(isset($_POST['addOfficer'])){
        $officerName = $_POST['officerName'];
        $officerEmail= $_POST['officerEmail'];
        $officerMobile= $_POST['officerMobile'];
        $officerUsername= $_POST['officerUsername'];
        $officerPassword= md5($_POST['officerPassword']);
        $officerDept= $_POST['officerDept'];
        $officerRole= $_POST['officerRole'];
        $officerOther = "";
        $isActive = 1;
        $_POST['officerOthers'] != "" ? $officerOther = $_POST['officerOthers'] : $officerOther = $officerOther; 

        $addDeptSql = $conn->prepare("INSERT INTO tblofficer (officer_department_id, officer_role_id, officer_username, officer_password, officer_name, officer_email, officer_mobile, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $addDeptSql->bindParam(1, $officerDept);
        $addDeptSql->bindParam(2, $officerRole);
        $addDeptSql->bindParam(3, $officerUsername);
        $addDeptSql->bindParam(4, $officerPassword);
        $addDeptSql->bindParam(5, $officerName);
        $addDeptSql->bindParam(6, $officerEmail);
        $addDeptSql->bindParam(7, $officerMobile);
        $addDeptSql->bindParam(8, $isActive);
        if($addDeptSql->execute()){
            echo "<script>window.alert(`Officer Added Successfully`)</script>";
            echo "<script>window.open('../officer.php','_self')</script>";
        }

    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>