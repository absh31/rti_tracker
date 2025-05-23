<?php
session_start();
include '../../connection.php';
// print_r($_POST);
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    if (isset($_POST['forwardRTI'])) {
        $actId = $_POST['actId'];
        $reqNo = $_POST['reqNo'];

        $updateSql = $conn->prepare("UPDATE tblactivity SET activity_completed = 1 WHERE activity_request_no = ?");
        $updateSql->bindParam(1, $reqNo);
        if ($updateSql->execute())
            echo "<script> alert('Confirmed')</script>";

        $activityType = "Forwarded";
        $fromOfficerName = $_SESSION['officer_name'];
        $toOfficerName = $_POST['officerName'];
        $remarks = $_POST['forwardRemarks'];
        $count = count($toOfficerName);
        $docs = "";
        $status = "YES";

        $total = isset($_FILES["attachments"]) ? count($_FILES["attachments"]["name"]) : 0;
        if ($_FILES["attachments"]["name"][0] == '')
            $total = 0;
        echo $total;
        if ($_FILES["attachments"]["size"][0] > 0) {
            for ($i = 0; $i < $total; $i++) {
                echo $i . " // " . $total;
                if (!file_exists('../../uploads')) {
                    mkdir('../../uploads', 0777, true);
                }
                $doc_name = $_FILES["attachments"]["name"][$i];
                $doc_type = $_FILES['attachments']['type'][$i];
                $doc_size = $_FILES['attachments']['size'][$i];
                $doc_tmp = $_FILES['attachments']['tmp_name'][$i];
                /* Figure out the MIME type | Check in array */
                $known_mime_types = array(
                    "application/pdf",
                    "image/png",
                    "image/jpg",
                    "image/jpeg"
                );
                if (!in_array($doc_type, $known_mime_types)) {
                    echo "<script> alert('File format not supported!')</script>";
                    echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                } else if ($doc_size >= "2097152") {
                    echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                    echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                } else {
                    $pos = strrpos($doc_name, '.');
                    if ($pos === false) {
                        // file has no extension; do something special?
                        $ext = "";
                    } else {
                        // includes the period in the extension; do $pos + 1 if you don't want it
                        $ext = substr($doc_name, $pos);
                    }
                    $doc = md5($reqNo) . '_attachment' . $i + 1 . $ext;
                    $doc_path = "../../uploads/" . $doc;

                    $check_upload = move_uploaded_file($doc_tmp, $doc_path);

                    if (!$check_upload) {
                        $upload_status = false;
                        echo '<script>alert("File is not uploaded.");</script>';
                        echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                    } else {
                        $upload_status = true;
                        $doc_type = "attachment";
                        $doc_sql = $conn->prepare("INSERT INTO tbldocument (document_request_id, document_title, document_path, document_type) VALUES(?,?,?,?)");
                        $doc_sql->bindParam(1, $reqNo);
                        $doc_sql->bindParam(2, $doc);
                        $doc_sql->bindParam(3, $doc_path);
                        $doc_sql->bindParam(4, $doc_type);
                        $doc_sql->execute();
                    }
                }
            }
        }
        for ($j = 0; $j < $count; $j++) {
            if ($total > 0) {
                $total = (int)$total;
                $docSql = $conn->prepare("SELECT * FROM tbldocument WHERE document_request_id = ? ORDER BY document_id DESC LIMIT ?");
                $docSql->bindParam(1, $reqNo);
                $docSql->bindParam(2, $total, PDO::PARAM_INT);
                $docSql->execute();
                $docs = "";
                $docsArray = array();
                while ($arr = $docSql->fetch(PDO::FETCH_ASSOC))
                    array_push($docsArray, $arr['document_id']);
                $docs = implode(",", $docsArray);
            }

            $officername = $toOfficerName[$j];
            $remark = $remarks[$j];
            $officer = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
            $officer->bindParam(1, $toOfficerName[$j]);
            $officer->execute();
            $officerRow = $officer->fetch(PDO::FETCH_ASSOC);
            $status = 'Forwarded to Departmental Officer ' . $officerRow['officer_name'];
            $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_documents, activity_type) VALUES (?,?,?,?,?,?,?)");
            $sql->bindParam(1, $reqNo);
            $sql->bindParam(2, $fromOfficerName);
            $sql->bindParam(3, $officername);
            $sql->bindParam(4, $remark);
            $sql->bindParam(5, $status);
            $sql->bindParam(6, $docs);
            $sql->bindParam(7, $activityType);
            if (!($sql->execute())) {
                echo "<script>window.alert(`Something went wrong!`)</script>";
                echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "','_self')</script>";
            }
        }

        $totalOfficers = implode(",", $toOfficerName);

        $updateSql = $conn->prepare("UPDATE tblrequest SET request_current_handler = ? WHERE request_no = ?");
        $updateSql->bindParam(1, $totalOfficers);
        $updateSql->bindParam(2, $reqNo);
        if ($updateSql->execute()) {
            echo "<script>window.alert(`Forwarded to concerned departments successfully!`)</script>";
            echo "<script>window.open('../pendingRTI.php','_self')</script>";
        } else {
            echo "<script>window.alert(`Something went wrong!`)</script>";
            echo "<script>window.open('../pendingRTI.php','_self')</script>";
        }
    } else if (isset($_POST['closeRTI'])) {
        // print_r($_POST);
        $actId = $_POST['actId'];
        $reqNo = $_POST['reqNo'];
        echo $actId;
        $updateSql = $conn->prepare("UPDATE tblactivity SET activity_completed = 1 WHERE activity_request_no = ?");
        $updateSql->bindParam(1, $reqNo);
        if ($updateSql->execute())
            echo "<script> alert('Confirmed')</script>";
        $checkSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? ORDER BY activity_id DESC");
        $checkSql->bindParam(1, $reqNo);
        $checkSql->execute();
        $arr = $checkSql->fetch(PDO::FETCH_ASSOC);
        // print_r($arr);
        // exit;
        if ($arr['activity_to'] == "Nodal Officer" && $arr['activity_type'] == "Rejected") {
            $confirm = 1;
            $currentHandler = "none";
            $activityType = "Rejected";
            $status = "Rejected";
            $completeSql = $conn->prepare("UPDATE tblrequest SET request_completed = ?, request_current_handler = ?, request_status = ? WHERE request_no = ?");
            $completeSql->bindParam(1, $confirm);
            $completeSql->bindParam(2, $currentHandler);
            $completeSql->bindParam(3, $activityType);
            $completeSql->bindParam(4, $reqNo);
            $fromOfficerName = 'Nodal Officer';
            $toOfficerName = 'Applicant';
            $remark = $_POST['remarks'];
            $status = 'Application Rejected successfully';
            if ($completeSql->execute()) {
                $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_type) VALUES (?,?,?,?,?,?)");
                $sql->bindParam(1, $reqNo);
                $sql->bindParam(2, $fromOfficerName);
                $sql->bindParam(3, $toOfficerName);
                $sql->bindParam(4, $remark);
                $sql->bindParam(5, $status);
                $sql->bindParam(6, $activityType);
                if ($sql->execute()) {
                    echo "<script>window.alert(`RTI closed successfully!`)</script>";
                    echo "<script>window.open('../pendingRTI.php','_self')</script>";
                } else {
                    echo "<script>window.alert(`Something went wrong!`)</script>";
                    echo "<script>window.open('../forwardRTI.php?reqNo" . $reqN . "','_self')</script>";
                }
            }
        } else if ($arr['activity_to'] == "Nodal Officer" && $arr['activity_type'] == "Revert") {
            $confirm = 1;
            $currentHandler = "none";
            $activityType = "Closed";
            $status = "Completed";
            $completeSql = $conn->prepare("UPDATE tblrequest SET request_completed = ?, request_current_handler = ?, request_status = ? WHERE request_no = ?");
            $completeSql->bindParam(1, $confirm);
            $completeSql->bindParam(2, $currentHandler);
            $completeSql->bindParam(3, $status);
            $completeSql->bindParam(4, $reqNo);
            $fromOfficerName = 'Nodal Officer';
            $toOfficerName = 'Applicant';
            $remark = $_POST['remarks'];
            $status = 'Application closed successfully';
            if ($completeSql->execute()) {
                $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_type) VALUES (?,?,?,?,?,?)");
                $sql->bindParam(1, $reqNo);
                $sql->bindParam(2, $fromOfficerName);
                $sql->bindParam(3, $toOfficerName);
                $sql->bindParam(4, $remark);
                $sql->bindParam(5, $status);
                $sql->bindParam(6, $activityType);
                if ($sql->execute()) {
                    echo "<script>window.alert(`RTI closed successfully!`)</script>";
                    $to = $_POST['email'];
                    // exit;
                    $subject = 'ALERT :: RTI Application completed';
                    $msg =
                        "<!DOCTYPE html>
                    <html>
                    <body>
                    
                      <h3>Dear citizen, your requested information is prepared. Please open the following link, enter required information and do necessary payments. Then you will be able to download your information. 
                      <br>
                      <br>
                      <span style='color:red'>Your request reference number: $reqNo <br>
                      Note: use this for downloading your information. </span>
                      </h3>

                      <h3><a href='localhost/rti_tracker/viewStatus.php' target='_blank'>Click here</a></h3>
                      </body>
                    </html>";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    if (mail($to, $subject, $msg, $headers)) {
                        echo "<script>window.open('../pendingRTI.php','_self')</script>";
                    } else
                        echo "<script>window.alert(`Something went wrong!`)</script>";
                } else {
                    echo "<script>window.alert(`Something went wrong!`)</script>";
                    echo "<script>window.open('../forwardRTI.php?reqNo" . $reqN . "','_self')</script>";
                }
            }
        } else {
            $confirm = 1;
            $currentHandler = "none";
            $activityType = "Rejected";
            $status = "Rejected";
            $completeSql = $conn->prepare("UPDATE tblrequest SET request_completed = ?, request_current_handler = ?, request_status = ? WHERE request_no = ?");
            $completeSql->bindParam(1, $confirm);
            $completeSql->bindParam(2, $currentHandler);
            $completeSql->bindParam(3, $activityType);
            $completeSql->bindParam(4, $reqNo);
            $fromOfficerName = 'Nodal Officer';
            $toOfficerName = 'Applicant';
            $remark = $_POST['remarks'];
            $status = 'Application Rejected successfully';
            if ($completeSql->execute()) {
                $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_type, activity_completed) VALUES (?,?,?,?,?,?,1)");
                $sql->bindParam(1, $reqNo);
                $sql->bindParam(2, $fromOfficerName);
                $sql->bindParam(3, $toOfficerName);
                $sql->bindParam(4, $remark);
                $sql->bindParam(5, $status);
                $sql->bindParam(6, $activityType);
                if ($sql->execute()) {
                    echo "<script>window.alert(`RTI closed successfully!`)</script>";
                    echo "<script>window.open('../pendingRTI.php','_self')</script>";
                } else {
                    echo "<script>window.alert(`Something went wrong!`)</script>";
                    echo "<script>window.open('../forwardRTI.php?reqNo" . $reqN . "','_self')</script>";
                }
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
