<?php
include '../connection.php';
session_start();
if (!isset($_POST['requestAppeal'])) {
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
            $reqNumber = $_POST['reqNo'];
            $reqEmail = $_POST['reqEmail'];
            $sql = $conn->prepare("SELECT tblrequest.request_id, tblapplicant.applicant_email, tblrequest.request_applicant_id, tblrequest.request_no 
    FROM tblapplicant 
    INNER JOIN tblrequest
    ON tblapplicant.applicant_id = tblrequest.request_applicant_id
    WHERE tblrequest.request_no = ? AND tblapplicant.applicant_email = ?;");
            $sql->bindParam(1, $reqNumber);
            $sql->bindParam(2, $reqEmail);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $key = $sql->fetch(PDO::FETCH_ASSOC);
                $sql1 = $conn->prepare("SELECT * FROM `tblappeal` WHERE `appeal_request_no` = ?");
                $sql1->bindParam(1, $reqNumber);
                $sql1->execute();
                if ($sql1->rowCount() > 0) {
                    echo '<script>alert("You have already filed first Appeal!");</script>';
                    unset($_SESSION);
                    unset($_POST);
                    echo '<script>window.open("../index.php","_self")</script>';
                }
                $_SESSION['reqId'] = $key['request_id'];
                $_SESSION['appEmail'] = $key['applicant_email'];
                $_SESSION['reqAppId'] = $key['request_applicant_id'];
                $_SESSION['reqNo'] = $key['request_no'];
                echo '<script>window.open("../submitAppealForm.php","_self")</script>';
            } else {
                echo '<script>alert("Wrong Details");</script>';
                echo '<script>window.open("../index.php","_self")</script>';
            }
        }
    }
}
