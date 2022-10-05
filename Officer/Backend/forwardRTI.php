<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    if (isset($_POST['forwardRTI']) && $_POST['confirm'] == 0) {
        $reqNo = $_POST['reqNo'];
        $fromOfficerName = $_SESSION['officer_name'];
        $toOfficerName = $_POST['officerName'];
        $remarks = $_POST['forwardRemarks'];
        $count = count($toOfficerName);
        $docs = array();
        $status = "YES";

        for ($j = 0; $j < $count; $j++) {
            $total = isset($_FILES["attachments"]) ? count($_FILES["attachments"]["name"]) : 0;
            if ($_FILES["attachments"]["size"][0] > 0) {
                for ($i = 0; $i < $total; $i++) {
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
                        "application/png",
                        "image/jpg",
                        "image/jpeg"
                    );
                    if (!in_array($doc_type, $known_mime_types)) {
                        echo "<script> alert('File format not supported!')</script>";
                        echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "&confirm=0','_self')</script>";
                    } else if ($doc_size >= "2097152") {
                        echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                        echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "&confirm=0','_self')</script>";
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
                            echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "&confirm=0','_self')</script>";
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
                $officername = $toOfficerName[$j];
                $remark = $remarks[$j];
                $status = 'Forwarded to Departmental Officer ' . $toOfficerName[$j];
                $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status) VALUES (?,?,?,?,?)");
                $sql->bindParam(1, $reqNo);
                $sql->bindParam(2, $fromOfficerName);
                $sql->bindParam(3, $officername);
                $sql->bindParam(4, $remark);
                $sql->bindParam(5, $status);
                if ($sql->execute()) {
                    continue;
                } else {
                    echo "<script>window.alert(`Something went wrong!`)</script>";
                    echo "<script>window.open('../forwardRTI.php?reqNo=" . $reqNo . "&confirm=0','_self')</script>";
                }
            }
        }
        $totalOfficers = "";
        if ($count == 1) {
            $totalOfficers = $toOfficerName[0];
        } else {
            for ($i = 0; $i < $count; $i++) {
                if ($i == 0)
                    $totalOfficers .=  $toOfficerName[$i] . ",";
                else
                    $totalOfficers .= $toOfficerName[$i];
            }
        }
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
    } else if (isset($_POST['closeRTI']) && $_POST['confirm'] == 1) {
        $reqNo = $_POST['reqNo'];
        $confirm = $_POST['confirm'];
        $currentHandler = "none";
        $completeSql = $conn->prepare("UPDATE tblrequest SET request_completed = ?, request_current_handler = ? WHERE request_no = ?");
        $completeSql->bindParam(1, $confirm);
        $completeSql->bindParam(2, $currentHandler);
        $completeSql->bindParam(3, $reqNo);
        $fromOfficerName = 'Nodal Officer';
        $toOfficerName = 'Applicant';
        $remark = $_POST['remarks'];
        $status = 'Application closed successfully';
        if($completeSql->execute()){
            $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status) VALUES (?,?,?,?,?)");
            $sql->bindParam(1, $reqNo);
            $sql->bindParam(2, $fromOfficerName);
            $sql->bindParam(3, $toOfficerName);
            $sql->bindParam(4, $remark);
            $sql->bindParam(5, $status);
            if($sql->execute()){
                echo "<script>window.alert(`RTI closed successfully!`)</script>";
                echo "<script>window.open('../pendingRTI.php','_self')</script>";
            }else{
                echo "<script>window.alert(`Something went wrong!`)</script>";
                echo "<script>window.open('../forwardRTI.php?reqNo".$reqN."&confirm=".$confirm."','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
