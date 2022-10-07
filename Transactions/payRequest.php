<?php
session_start();
include '../connection.php';
if (!isset($_GET['requestNo'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
    if(isset($_GET['requestNo']) && $_GET['payType'] == "base"){
        $requestNo = $_GET['requestNo'];
        $sql = $conn->prepare("UPDATE `tblrequest` SET `request_is_base_pay` = 1 WHERE `request_no` = ?");
        $sql->bindParam(1, $requestNo);
        if ($sql->execute()) {
            echo '<script>alert("Payment Successful!")</script>';
            $_SESSION['requestPaid'] = 1;
            echo '<script>window.open("../responseRTI.php","_self")</script>';
        } else {
            echo '<script>alert("Something Went Wrong! Please try again Later!");</script>';
            echo '<script>window.open("./responseRTI.php","_self")</script>';
        }
    } else if(isset($_GET['requestNo']) && $_GET['payType'] == "add"){
        $requestNo = $_GET['requestNo'];
        $sql = $conn->prepare("UPDATE `tblrequest` SET `request_is_add_pay` = 1 WHERE `request_no` = ?");
        $sql->bindParam(1, $requestNo);
        if ($sql->execute()) {
            echo '<script>alert("Payment Successful!")</script>';
            $_SESSION['requestPaid'] = 1;
            echo '<script>window.open("../viewStatus.php","_self")</script>';
        } else {
            echo '<script>alert("Something Went Wrong! Please try again Later!");</script>';
            echo '<script>window.open("./responseRTI.php","_self")</script>';
        }
    }
}
