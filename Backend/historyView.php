<?php
session_start();
include '../connection.php';
if (!isset($_POST['viewHistory'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    $reqMobile = "%".$_POST['reqMobile'];
    // echo $reqMobile;
    $reqEmail = $_POST['reqEmail'];
    $sql = $conn->prepare("SELECT tblrequest.request_no, tblrequest.request_current_handler, tblrequest.request_status 
    FROM tblapplicant 
    INNER JOIN tblrequest
    ON tblapplicant.applicant_id = tblrequest.request_applicant_id
    WHERE tblapplicant.applicant_email = ? AND tblapplicant.applicant_mobile LIKE ?;");
    $sql->bindParam(1, $reqEmail);
    $sql->bindParam(2, $reqMobile);
    $sql->execute();
    $reqs = array();
    if ($sql->rowCount() > 0) {
        while($key = $sql->fetch(PDO::FETCH_ASSOC)){
            array_push($reqs, $key['request_no']);
        }    
        $_SESSION['reqs'] = $reqs;
        echo '<script>window.open("../viewHistory.php","_self")</script>'; 
    } else {
        unset($_POST['viewStatus']);
        echo '<script>alert("Wrong Details!");</script>';
        // echo '<script>window.open("../viewStatus.php","_self")</script>';
    }
}

?>