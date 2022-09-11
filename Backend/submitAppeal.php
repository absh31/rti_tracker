<?php
session_start();
include '../connection.php';
if (!isset($_POST['submitAppeal'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    if (empty($_POST['g-recaptcha-response'])) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('./submitRTI.php','_self')</script>";
    } else {
        $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

        $response_data = json_decode($response);

        if (!$response_data->success) {
            echo "<script>alert('Captcha Error. Try Again')</script>";
            echo "<script>window.open('./submitRTI.php','_self')</script>";
        } else {
            $reqNo = $_SESSION['reqNo'];
            $reqId = $_SESSION['reqId'];
            $appealReason = $_POST['appealReason'];
            $appealComplete = 0;
            $sql = $conn->prepare("INSERT INTO `tblappeal` (`appeal_request_id`, `appeal_request_no`, `appeal_reason`, `appeal_completed`) VALUES (?, ?, ?, ?)");
            $sql->bindParam(1, $reqId);
            $sql->bindParam(2, $reqNo);
            $sql->bindParam(3, $appealReason);
            $sql->bindParam(4, $appealComplete);
            $sql1 = $conn->prepare("UPDATE `tblrequest` SET `request_is_appealed` = 1 WHERE `request_no` = ?");
            $sql1->bindParam(1, $reqNo);
            if ($sql->execute() && $sql1->execute()) {
                echo '<script>alert("Your Appeal is filed succesfully!");</script>';
                echo '<script>window.open("../index.php","_self")</script>';
            } else {
                echo '<script>alert("Something went wrong! Please try again.");</script>';
                unset($_POST['submitAppeal']);
                echo '<script>window.open("../submitAppealForm.php","_self")</script>';
            }
        }
    }
}
