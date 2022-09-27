<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    if (isset($_POST['forwardRTI'])) {
        $reqNo = $_POST['reqNo'];
        $fromOfficerName = $_SESSION['officer_name'];
        $toOfficerName = $_POST['officerName'];
        $remarks = $_POST['forwardRemarks'];
        $status = 'Forwarded to Departmental Officer '.$toOfficerName ;
        $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status) VALUES (?,?,?,?,?)");
        $sql->bindParam(1, $reqNo);
        $sql->bindParam(2, $fromOfficerName);
        $sql->bindParam(3, $toOfficerName);
        $sql->bindParam(4, $remarks);
        $sql->bindParam(5, $status);
        if ($sql->execute()) {
            $toOfficerName = "Departmental Officer - " . $toOfficerName;
            $updateSql = $conn->prepare("UPDATE tblrequest SET request_current_handler = ? WHERE request_no = ?");
            $updateSql->bindParam(1, $toOfficerName);
            $updateSql->bindParam(2, $reqNo);
            if ($updateSql->execute()) {
                echo "<script>window.alert(`Forwarded to " . $toOfficerName . " successfully!`)</script>";
                echo "<script>window.open('../pendingRTI.php','_self')</script>";
            }else{
                echo "<script>window.alert(`Something went wrong!`)</script>";
                echo "<script>window.open('../pendingRTI.php','_self')</script>";
            }
        }else{
            echo "<script>window.alert(`Something went wrong!`)</script>";
            echo "<script>window.open('../pendingRTI.php','_self')</script>";
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
