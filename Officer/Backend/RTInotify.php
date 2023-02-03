<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $reqNo = $_POST['reqNo'];
    $req = $conn->prepare("SELECT * FROM tblrequest WHERE request_no = ?");
    $req->bindParam(1, $reqNo);
    $req->execute();
    $reqRow = $req->fetch(PDO::FETCH_ASSOC);
    // print_r($reqRow);
    if ($req->rowCount() > 0) {
        $officers = explode(',', $reqRow['request_current_handler']);
        $emails = array();
        $officerIDs = array();
        foreach ($officers as $officer) {
            $offSql = $conn->prepare("SELECT * FROM tbldepartment d, tblofficer o WHERE officer_department_id = department_id AND officer_id = ?");
            $offSql->bindParam(1, $officer);
            $offSql->execute();
            $offRow = $offSql->fetch(PDO::FETCH_ASSOC);
            // array_push($emails, $offRow['officer_email']);
            array_push($officerIDs, $offRow['officer_id']);
            array_push($emails, $offRow['officer_id']);
        }
        echo json_encode($officerIDs);
        // echo json_encode($emails);
        // print_r($emails);
    } else {
        echo "<script>window.alert(`Something went wrong!`)</script>";
        echo "<script>window.open('../login.php','_self')</script>";
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
