<?php
function lastLogin($type, $uname, $pass)
{
    include '../connection.php';
    date_default_timezone_set("Asia/Calcutta");
    $time = time();
    $date = date('Y-m-d H-i-s', $time);
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql = $conn->prepare('UPDATE `tblofficer` SET `officer_last_login` = ? , `officer_last_ip` = ?  WHERE `officer_username` = ? AND `officer_password` = ? AND `officer_role_id` = ?');
    $sql->bindParam(1, $date);
    $sql->bindParam(2, $ip);
    $sql->bindParam(3, $uname);
    $sql->bindParam(4, $pass);
    $sql->bindParam(5, $type);
    if ($type != '1'){
        if ($sql->execute()) {
            echo "<script>window.open('../Officer/dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again later.')</script>";
            echo "<script>window.open('../logout.php','_self')</script>";
        }
    }
    else {
        if ($sql->execute()) {
            echo "<script>window.open('../Admin/dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again later.')</script>";
            echo "<script>window.open('../logout.php','_self')</script>";
        }
    }
}
