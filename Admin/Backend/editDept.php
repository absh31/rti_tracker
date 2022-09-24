<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['addDept'])){
        $deptId = $_POST['deptId'];
        $deptName = $_POST['deptName'];
        $deptEmail = $_POST['deptEmail'];
        $deptOther = "";
        $isActive = 1;
        $_POST['deptOthers'] != "" ? $deptOther = $_POST['deptOthers'] : $deptOther = $deptOther; 

        $addDeptSql = $conn->prepare("UPDATE tbldepartment SET department_name = ?, department_email = ?, department_other = ? WHERE department_id = ?");
        $addDeptSql->bindParam(1, $deptName);
        $addDeptSql->bindParam(2, $deptEmail);
        $addDeptSql->bindParam(3, $deptOther);
        $addDeptSql->bindParam(4, $deptId);
        if($addDeptSql->execute()){
            echo "<script>window.alert(`Data Edited Successfully`)</script>";
            echo "<script>window.open('../department.php','_self')</script>";
        }

    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>