<?php
session_start();
include '../connection.php';
if (!isset($_POST['viewStatus'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    $reqNo = $_POST['reqNo'];
    $reqEmail = $_POST['reqEmail'];
    $sql = $conn->prepare("SELECT tblapplicant.applicant_email, tblrequest.request_no, tblrequest.request_current_handler, tblrequest.request_status 
    FROM tblapplicant 
    INNER JOIN tblrequest
    ON tblapplicant.applicant_id = tblrequest.request_applicant_id
    WHERE tblrequest.request_no = ? AND tblapplicant.applicant_email = ?;");
    $sql->bindParam(1, $reqNo);
    $sql->bindParam(2, $reqEmail);
    $sql->execute();
    if ($sql->rowCount() > 0) {
        $key = $sql->fetch(PDO::FETCH_ASSOC);
        $_SESSION['appEmail'] = $key['applicant_email'];
        $_SESSION['reqNo'] = $key['request_no'];
        $_SESSION['reqCurr'] = $key['request_current_handler'];
        $_SESSION['reqStatus'] = $key['request_status'];
        echo '<script>window.open("../viewStatus.php","_self")</script>'; 
    } else {
        unset($_POST['viewStatus']);
        session_unset();
        echo '<script>alert("Wrong Details!");</script>';
        echo '<script>window.open("../viewStatus.php","_self")</script>';
    }
}
