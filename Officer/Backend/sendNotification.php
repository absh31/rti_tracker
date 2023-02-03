<?php
session_start();
include '../../connection.php';
if (!isset($_POST['notifyOfficers'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../dashboard.php","_self")</script>';
} else {
    if (isset($_POST['notifyOfficers'])) {
        $from = "Nodal Officer";
        // print_r($_POST);
        $text = $_POST['msg'];
        $reqNo = $_POST['reqNo'];
        $ids = explode(',', $_POST['ids']);
        foreach ($ids as $id) {
            $sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
            $sql->bindParam(1, $id);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $notify = $conn->prepare("INSERT INTO tblnotifications (`from`, `to`, `msg`, `request_no`) VALUES (?,?,?,?)");
            $notify->bindParam(1, $from);
            $notify->bindParam(2, $id);
            $notify->bindParam(3, $text);
            $notify->bindParam(4, $reqNo);
            if ($notify->execute()) {
                $to = $row['officer_email'];
                $subject = "ALERT :: Message from Nodal Officer";
                $msg =
                    "<!DOCTYPE html>
                <html>  
                    <head>
                    </head>
                    <body>
                    <h3>Dear Departmental Officer, you have a new message from Nodal Officer, please open the portal and check it.</h3>
                    </body>
                    </html>
                    ";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                if (mail($to, $subject, $msg, $headers)) {
                    echo '<script>alert("Notification sent succesfully!");</script>';
                    echo '<script>window.open("../activeRTI.php","_self")</script>';
                } else {
                    echo '<script>alert("Something went wrong!");</script>';
                    echo '<script>window.open("../activeRTI.php","_self")</script>';
                }
            } else {
                echo '<script>alert("Something went wrong!");</script>';
                echo '<script>window.open("../activeRTI.php","_self")</script>';
            }
        }
    }
}
