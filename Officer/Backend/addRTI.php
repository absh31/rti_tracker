<?php
session_start();
include '../../connection.php';
if (!isset($_POST['personalRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../dashboard.php","_self")</script>';
} else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobileNumber'];
    $phoneNumber = $_POST['phoneNumber'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $country = $_POST['country'];
    $countryName = $_POST['countryName'];
    if ($country == "Other") {
        $country = $countryName;
        $_POST['country'] = $country;
    }
    $state = $_POST['state'];
    $status = $_POST['status'];
    $eduStatus = $_POST['educationalStatus'];
    $edu = $_POST['education'];
    $sql = $conn->prepare("INSERT INTO `tblapplicant` (`applicant_name`, `applicant_email`, `applicant_mobile`, `applicant_phone`, `applicant_gender`, `applicant_education`, `applicant_more_education`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bindParam(1, $name);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $mobileNumber);
    $sql->bindParam(4, $phoneNumber);
    $sql->bindParam(5, $gender);
    $sql->bindParam(6, $eduStatus);
    $sql->bindParam(7, $edu);
    if ($sql->execute()) {
        $sql = $conn->prepare('SELECT * FROM `tblapplicant` WHERE `applicant_email` = ?');
        $sql->bindParam(1, $email);
        $sql->execute();
        $id = $sql->fetch(PDO::FETCH_ASSOC);
        $appId = $id['applicant_id'];
        $deptId = $_POST['department'];
        $isBPL = $_POST['isBPL'];
        if ($isBPL == "Yes") {
            $bplCard = $_POST['bplCard'];
            $YOI = $_POST['YOI'];
            $issueAuth = $_POST['issueAuth'];
            $docBPL = $_FILES['docBPL']['name'];
            $upload_status = false;

            if ($docBPL != "") {
                $ImageName_tmp_error = $_FILES['docBPL']['error'];
                if ($ImageName_tmp_error > 0) {
                    echo '<script>alert("File is not allowed.");</script>';
                    echo '<script>window.open("../dashboard.php","_self")</script>';
                } else {

                    if (!file_exists('../../bplFiles')) {
                        mkdir('../../bplfiles', 0777, true);
                    }

                    $ImageName_type = $_FILES['docBPL']['type'];
                    $ImageName_size = $_FILES['docBPL']['size'];
                    $ImageName_tmp_name = $_FILES['docBPL']['tmp_name'];

                    /* Figure out the MIME type | Check in array */
                    $known_mime_types = array(
                        "application/pdf",
                        "image/png",
                        "image/jpg",
                        "image/jpeg"
                    );
                    if (!in_array($ImageName_type, $known_mime_types)) {
                        echo "<script> alert('File format not supported!')</script>";
                        echo "<script>window.open('../dashboard.php','_self')</script>";
                        // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
                    } else if ($ImageName_size >= "2097152") {
                        echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                        echo "<script>window.open('../dashboard.php','_self')</script>";
                        // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
                    } else {
                        $pos = strrpos($docBPL, '.');
                        if ($pos === false) {
                            // file has no extension; do something special?
                            $ext = "";
                        } else {
                            // includes the period in the extension; do $pos + 1 if you don't want it
                            $ext = substr($docBPL, $pos);
                        }
                        $docBPL = md5($appId) . '_bplCard' . $ext;
                        $docBPL_path = "../../bplFiles/" . $docBPL;

                        if (file_exists($docBPL_path)) {
                            unlink($docBPL_path);
                        }

                        $check_upload = move_uploaded_file($ImageName_tmp_name, $docBPL_path);

                        if (!$check_upload) {
                            $upload_status = false;
                            echo '<script>alert("File is not uploaded.");</script>';
                            echo "<script>window.open('../addRTI.php','_self')</script>";
                        } else {
                            $upload_status = true;
                        }
                    }
                }
            }
        } else {
            $bplCard = "NULL";
            $YOI = "NULL";
            $issueAuth = "NULL";
            $docBPL = "NULL";
            $docBPL_path = "NULL";
        }
        $requestNo = date("Ymdhis");
        $reqMode = 'Online';
        $reqBase = '20';
        $reqIsBase = 1;
        $reqCurr = 'user';
        $reqIsAppeal = 0;
        $reqStatus = 'Requested';
        $reqComplete = 0;
        $text = $_POST['reqText'];
        $reqAddress = $_POST['address'];
        $reqPincode = $_POST['pincode'];
        $reqCountry = $_POST['country'];
        $reqState = $_POST['state'];
        $reqPlaceType = $_POST['status'];

        $sql = $conn->prepare("INSERT INTO `tblrequest` (`request_applicant_id`, `request_department_id`, `request_no`, `request_from_bpl`, `request_bpl_no`, `request_bpl_yoi`, `request_bpl_ia`, `request_bpl_file`, `request_address`, `request_pincode`, `request_country`, `request_state`, `request_place_type`, `request_text`, `request_mode`, `request_base_pay`, `request_is_base_pay`, `request_current_handler`, `request_is_appealed`, `request_status`, `request_completed`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bindParam(1, $appId);
        $sql->bindParam(2, $deptId);
        $sql->bindParam(3, $requestNo);
        $sql->bindParam(4, $isBPL);
        $sql->bindParam(5, $bplCard);
        $sql->bindParam(6, $YOI);
        $sql->bindParam(7, $issueAuth);
        $sql->bindParam(8, $docBPL);
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
        if ($sql->execute()) {
            if ($isBPL == 'Yes') {
                $doc_type = 'bplcard';
                $doc_sql = $conn->prepare("INSERT INTO tbldocument (document_request_id, document_title, document_path, document_type) VALUES(?,?,?,?)");
                $doc_sql->bindParam(1, $requestNo);
                $doc_sql->bindParam(2, $docBPL);
                $doc_sql->bindParam(3, $docBPL_path);
                $doc_sql->bindParam(4, $doc_type);
                if ($doc_sql->execute()) {
                    $from = "Nodal Officer";
                    $to = "Nodal Officer";
                    $type = "Filed";
                    $status = "Application filed successfully";

                    $activity_sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_type, activity_status) VALUES(?,?,?,?,?)");
                    $activity_sql->bindParam(1, $requestNo);
                    $activity_sql->bindParam(2, $from);
                    $activity_sql->bindParam(3, $to);
                    $activity_sql->bindParam(4, $type);
                    $activity_sql->bindParam(5, $status);
                    if ($activity_sql->execute()) {
                        echo "<script>alert('Your request is filed successfully! Your Request Reference number is: " . $requestNo . "')</script>";
                        echo "<script>window.open('../dashboard.php', '_self')</script>";
                    } else {
                        echo "<script>alert('Something went wrong!')</script>";
                        echo '<script>window.open("../addRTI.php","_self")</script>';
                    }
                }
            } else {
                $from = "Nodal Officer";
                $to = "Nodal Officer";
                $type = "Filed";
                $status = "Application filed successfully";

                $activity_sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_type, activity_status) VALUES(?,?,?,?,?)");
                $activity_sql->bindParam(1, $requestNo);
                $activity_sql->bindParam(2, $from);
                $activity_sql->bindParam(3, $to);
                $activity_sql->bindParam(4, $type);
                $activity_sql->bindParam(5, $status);
                if ($activity_sql->execute()) {
                    echo "<script>alert('Your request is filed successfully! Your Request Reference number is: " . $requestNo . "')</script>";
                    echo "<script>window.open('../dashboard.php', '_self')</script>";
                } else {
                    echo "<script>alert('Something went wrong!')</script>";
                    echo '<script>window.open("../addRTI.php","_self")</script>';
                }
            }
        } else {
            echo '<script>alert("Something went Wrong!");</script>';
            echo '<script>window.open("../addRTI.php","_self")</script>';
        }
    } else {
        echo '<script>alert("Something went Wrong!");</script>';
        echo '<script>window.open("../addRTI.php","_self")</script>';
    }
}
