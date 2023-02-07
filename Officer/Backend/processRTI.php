<?php
session_start();
include '../../connection.php';
if (!isset($_POST['rejectRTI']) && !isset($_POST['revertRTI']) && !isset($_POST['toNodal'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../dashboard.php","_self")</script>';
} else {
    if (isset($_POST['rejectRTI'])) {
        $actId = $_POST['actId'];
        $reqNo = $_POST['reqNo'];

        $updateSql = $conn->prepare("UPDATE tblactivity SET activity_completed = 1 WHERE activity_request_no = ?");
        $updateSql->bindParam(1, $reqNo);
        if ($updateSql->execute())
            echo "<script> alert('Confirmed')</script>";

        $remarks = $_POST['remarksRTI'];
        $fromOfficerName = $_SESSION['officer_name'];
        $toOfficerName = "Nodal Officer";
        $activity_status = "RTI Rejected and returned to Nodal Officer.";
        $docs = "";
        $total = isset($_FILES["attachments"]) ? count($_FILES["attachments"]["name"]) : 0;
        if ($_FILES["attachments"]["name"][0] == '')
            $total = 0;
        $status = "YES";

        // (B) PROCESS FILE UPLOAD
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
                    "image/png",
                    "image/jpg",
                    "image/jpeg"
                );
                if (!in_array($doc_type, $known_mime_types)) {
                    echo "<script> alert('File format not supported!')</script>";
                    echo "<script>window.open('../viewRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                    // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
                } else if ($doc_size >= "2097152") {
                    echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                    echo "<script>window.open('../viewRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                    // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
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
                        echo "<script>window.open('../viewRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                    } else {
                        $doc_type = 'attachment';
                        $upload_status = true;
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
        $activity_type = "Rejected";
        $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_type) VALUES(?,?,?,?,?,?)");

        $sql->bindParam(1, $reqNo);
        $sql->bindParam(2, $fromOfficerName);
        $sql->bindParam(3, $toOfficerName);
        $sql->bindParam(4, $remarks);
        $sql->bindParam(5, $activity_status);
        $sql->bindParam(6, $activity_type);
        if ($sql->execute()) {
            $sql2 = $conn->prepare("UPDATE tblrequest SET request_current_handler = ? WHERE request_no = ?");
            $sql2->bindParam(1, $toOfficerName);
            $sql2->bindParam(2, $reqNo);
            $sql2->execute();
            echo '<script>alert("Returned to the Nodal Officer successfully!");</script>';
            echo '<script>window.open("../dashboard.php","_self")</script>';
        } else {
            echo '<script>alert("Something went wrong!");</script>';
            echo '<script>window.open("../viewRTI.php?reqNo=".$reqNo."?id=' . $reqNo . '","_self")</script>';
        }
    } else if (isset($_POST['revertRTI'])) {
        $actId = $_POST['actId'];
        $reqNo = $_POST['reqNo'];

        $updateSql = $conn->prepare("UPDATE tblactivity SET activity_completed = 1 WHERE activity_request_no = ?");
        $updateSql->bindParam(1, $reqNo);
        if ($updateSql->execute())
            echo "<script> alert('Confirmed')</script>";
        $remarks = $_POST['remarksRTI'];
        $fromOfficerName = $_SESSION['officer_name'];
        $toOfficerName = "Nodal Officer";
        $activity_status = "Reverted back to the Nodal Officer.";
        $fees = $_POST['addFees'];
        $docs = "";
        $total = isset($_FILES["attachments"]) ? count($_FILES["attachments"]["name"]) : 0;
        if ($_FILES["attachments"]["name"][0] == '')
            $total = 0;

        $status = "YES";
        // print_r($_FILES);
        // exit;

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
                    echo "<script>window.open('../viewRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                    // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
                } else if ($doc_size >= "2097152") {
                    echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                    echo "<script>window.open('../viewRTI.php?reqNo=" . $reqNo . "','_self')</script>";
                    // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
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
                    $doc_type = "attachment";
                    $check_upload = move_uploaded_file($doc_tmp, $doc_path);

                    if (!$check_upload) {
                        $upload_status = false;
                        echo '<script>alert("File is not uploaded.");</script>';
                        echo "<script>window.open('../submitRequest.php','_self')</script>";
                    } else {
                        $upload_status = true;
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
        }
        $docs = implode(",", $docsArray);
        $activity_type = "Revert";
        $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_documents, activity_type) VALUES(?,?,?,?,?,?,?)");
        $sql->bindParam(1, $reqNo);
        $sql->bindParam(2, $fromOfficerName);
        $sql->bindParam(3, $toOfficerName);
        $sql->bindParam(4, $remarks);
        $sql->bindParam(5, $activity_status);
        $sql->bindParam(6, $docs);
        $sql->bindParam(7, $activity_type);
        if ($sql->execute()) {
            $sql2 = $conn->prepare("UPDATE tblrequest SET request_current_handler = ?, request_add_pay = ? WHERE request_no = ?");
            $sql2->bindParam(1, $toOfficerName);
            $sql2->bindParam(2, $fees);
            $sql2->bindParam(3, $reqNo);
            $sql2->execute();
            echo '<script>alert("Returned to the Nodal Officer successfully!");</script>';
            echo '<script>window.open("../dashboard.php","_self")</script>';
        } else {
            echo '<script>alert("Something went wrong!");</script>';
            echo '<script>window.open("../viewRTI.php?reqNo=".$reqNo."?id=' . $reqNo . '","_self")</script>';
        }
    } else if (isset($_POST['toNodal'])) {
        $reqNo = $_POST['reqNo'];
        $remarks = $_POST['remarksRTI'];
        $fromOfficerName = $_SESSION['officer_name'];
        $toOfficerName = "Nodal Officer";
        $activity_type = "Appeal Forward";
        $activity_status = "Reverted back to the Nodal Officer for appeal.";
        $sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_remarks, activity_status, activity_type, activity_is_appealed) VALUES(?,?,?,?,?,?,1)");
        $sql->bindParam(1, $reqNo);
        $sql->bindParam(2, $fromOfficerName);
        $sql->bindParam(3, $toOfficerName);
        $sql->bindParam(4, $remarks);
        $sql->bindParam(5, $activity_status);
        $sql->bindParam(6, $activity_type);
        if ($sql->execute()) {
            $sql2 = $conn->prepare("UPDATE tblrequest SET request_current_handler = ?, request_completed = 0 WHERE request_no = ?");
            $sql2->bindParam(1, $toOfficerName);
            $sql2->bindParam(2, $reqNo);
            // $sql2->bindParam(2, $fees);
            if ($sql2->execute()) {
                echo '<script>alert("Forwarded to the Nodal Officer successfully!");</script>';
                echo '<script>window.open("../dashboard.php","_blank")</script>';
            }
        } else {
            echo '<script>alert("Something went wrong!");</script>';
            echo '<script>window.open("../viewRTI.php?reqNo=".$reqNo."?id=' . $reqNo . '","_self")</script>';
        }
    }
}
