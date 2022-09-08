<?php
include '../connection.php';
session_start();
if (!isset($_POST['requestRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
    $email = $_SESSION['email'];
    $sql = $conn->prepare('SELECT * FROM `tblapplicant` WHERE `applicant_email` = ?');
    $sql->bindParam(1, $email);
    $sql->execute();
    $id = $sql->fetch(PDO::FETCH_ASSOC);
    $appId = $id['applicant_id'];
    $deptId = $_POST['department'];
    $isBPL = $_POST['isBPL'];
    $bplCard = $_POST['bplCard'];
    $YOI = $_POST['YOI'];
    $issueAuth = $_POST['issueAuth'];
    $docBPL = $_FILES['docBPL']['name'];
    $allowed_doc = array('jpe', 'png', 'jpeg', 'jpg', 'pdf', 'xls', 'csv');
    $ext1 = strtolower(substr($docBPL, strpos($docBPL, ".") + 1, strlen($docBPL)));
    if (!in_array($ext1, $allowed_doc)) {
        echo '<script>alert("File is not allowed.");</script>';
        echo '<script>window.open("../index.php","_self")</script>';
    }
    $ext = pathinfo($_FILES['docBPL']['name'], PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed_doc)) {
        echo '<script>alert("File is not allowed.");</script>';
        echo '<script>window.open("../index.php","_self")</script>';
    }
    if (!file_exists('../bplFiles')) {
        mkdir('../bplFiles', 0777, true);
    }
    $uploadDir = '../bplFiles/';
    $bplName = uniqid() . '_bpl.' . $ext;
    ob_clean();
    $bpl = $uploadDir . $bplName;
    $requestNo = '';
    $reqMode = 'Online';
    $reqBase = '20';
    $reqIsBase = 0;
    $reqCurr = 'user';
    $reqIsAppeal = 0;
    $reqStatus = 'Requested';
    $reqComplete = 0;
    $text = $_POST['reqText'];
    $reqAddress = $_SESSION['address'];
    $reqPincode = $_SESSION['pincode'];
    $reqCountry = $_SESSION['country'];
    $reqState = $_SESSION['state'];
    $reqPlaceType = $_SESSION['status'];
    
    $sql = $conn->prepare("INSERT INTO `tblrequest` (`request_applicant_id`, `request_department_id`, `request_no`, `request_from_bpl`, `request_bpl_no`, `request_bpl_yoi`, `request_bpl_ia`, `request_bpl_file`, `request_address`, `request_pincode`, `request_country`, `request_state`, `request_place_type`, `request_text`, `request_mode`, `request_base_pay`, `request_is_base_pay`, `request_current_handler`, `request_is_appealed`, `request_status`, `request_completed`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bindParam(1, $appId);
    $sql->bindParam(2, $deptId);
    $sql->bindParam(3, $requestNo);
    $sql->bindParam(4, $isBPL);
    $sql->bindParam(5, $bplCard);
    $sql->bindParam(6, $YOI);
    $sql->bindParam(7, $issueAuth);
    $sql->bindParam(8, $bplName);
    $sql->bindParam(9, $reqAddress);
    $sql->bindParam(10, $reqPincode);
    $sql->bindParam(11, $reqCountry);
    $sql->bindParam(12, $reqState);
    $sql->bindParam(13, $reqPlaceType);
    $sql->bindParam(14, $text);
    $sql->bindParam(15, $reqMode);
    $sql->bindParam(16, $reqBase);
    $sql->bindParam(17, $reqIsBase);
    $sql->bindParam(18, $reqCurr);
    $sql->bindParam(19, $reqIsAppeal);
    $sql->bindParam(20, $reqStatus);
    $sql->bindParam(21, $reqComplete);
    if (move_uploaded_file($_FILES['docBPL']['tmp_name'], $bpl)) {
        if ($sql->execute()) {
            echo "<script>alert('Your request is filed successfully!')</script>";
            echo '<script>window.open("../index.php","_self")</script>';
        }
    } else {
        echo "<script>alert('Something went wrong!')</script>";
        // echo '<script>window.open("../submitRequest.php","_self")</script>';
    }
}
