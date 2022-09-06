<?php
function lastlogin($type, $uname, $pass)
{
    include '../connection.php';
    date_default_timezone_set("Asia/Calcutta");
    $time = time();
    $date = date('Y-m-d H-i-s', $time);
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($type == 'Admin') {
        $sql = $conn->prepare('UPDATE `tbladmin` SET `admin_last_login` = ? , `admin_last_ip` = ?  WHERE `admin_username` = ? AND `admin_password` = ?');
        $sql->bindParam(1, $date);
        $sql->bindParam(2, $ip);
        $sql->bindParam(3, $uname);
        $sql->bindParam(4, $pass);
        if ($sql->execute()) {
            echo "<script>window.open('../Admin/dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again later.')</script>";
            echo "<script>window.open('../logout.php','_self')</script>";
        }
    } elseif ($type == 'Nodal Officer') {
        $sql = $conn->prepare('UPDATE `tblnodal` SET `nodal_last_login` = ? , `nodal_last_ip` = ?  WHERE `nodal_username` = ? AND `nodal_password` = ?');
        $sql->bindParam(1, $date);
        $sql->bindParam(2, $ip);
        $sql->bindParam(3, $uname);
        $sql->bindParam(4, $pass);
        if ($sql->execute()) {
            echo "<script>window.open('../Nodal/dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again later.')</script>";
            echo "<script>window.open('../logout.php','_self')</script>";
        }
    } elseif ($type == 'Department Officer') {
        $sql = $conn->prepare('UPDATE `tblofficer` SET `officer_last_login` = ? , `officer_last_ip` = ?  WHERE `officer_username` = ? AND `officer_password` = ?');
        $sql->bindParam(1, $date);
        $sql->bindParam(2, $ip);
        $sql->bindParam(3, $uname);
        $sql->bindParam(4, $pass);
        if ($sql->execute()) {
            echo "<script>window.open('../Department/dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again later.')</script>";
            echo "<script>window.open('../logout.php','_self')</script>";
        }
    } elseif ($type == 'Appellate Officer') {
        $sql = $conn->prepare('UPDATE `tblappellate` SET `appellate_last_login` = ? , `appellate_last_ip` = ?  WHERE `appellate_username` = ? AND `appellate_password` = ?');
        $sql->bindParam(1, $date);
        $sql->bindParam(2, $ip);
        $sql->bindParam(3, $uname);
        $sql->bindParam(4, $pass);
        if ($sql->execute()) {
            echo "<script>window.open('../Appellate/dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again later.')</script>";
            echo "<script>window.open('../logout.php','_self')</script>";
        }
    } else {
        echo "<script>alert('Something went wrong! Please try again later.')</script>";
        echo "<script>window.open('../logout.php','_self')</script>";
    }
}
