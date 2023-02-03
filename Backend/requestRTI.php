<?php
include '../connection.php';
session_start();
if (!isset($_POST['requestRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    // if (empty($_POST['g-recaptcha-response'])) {
    //     echo "<script>alert('Captcha Error. Try Again')</script>";
    //     echo "<script>window.open('../submitRequest.php','_self')</script>";
    // } else {
    //     $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
    //     $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

    //     $response_data = json_decode($response);

    //     if (!$response_data->success) {
    //         echo "<script>alert('Captcha Error. Try Again')</script>";
    //         echo "<script>window.open('./submitRequest.php','_self')</script>";
    //     } else {
    $email = $_SESSION['email'];
    if (isset($_SESSION['existingUser']) && $_SESSION['existingUser'] != 1) {
        $name = $_SESSION['name'];
        $mobileNumber = $_SESSION['mobileNumber'];
        $phoneNumber = $_SESSION['phoneNumber'];
        $gender = $_SESSION['gender'];
        $eduStatus = $_SESSION['educationalStatus'];
        $edu = $_SESSION['education'];
        $sql = $conn->prepare("INSERT INTO `tblapplicant` (`applicant_name`, `applicant_email`, `applicant_mobile`, `applicant_phone`, `applicant_gender`, `applicant_education`, `applicant_more_education`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->bindParam(1, $name);
        $sql->bindParam(2, $email);
        $sql->bindParam(3, $mobileNumber);
        $sql->bindParam(4, $phoneNumber);
        $sql->bindParam(5, $gender);
        $sql->bindParam(6, $eduStatus);
        $sql->bindParam(7, $edu);
        $sql->execute();
    }

    $sql = $conn->prepare('SELECT * FROM `tblapplicant` WHERE `applicant_email` = ?');
    $sql->bindParam(1, $email);
    $sql->execute();
    $id = $sql->fetch(PDO::FETCH_ASSOC);
    $appId = $id['applicant_id'];
    $deptId = $_POST['department'];
    $isBPL = $_POST['isBPL'];
    $upload_status = false;
    $reqIsBase;

    $docSample = $_FILES['docSample']['name'];
    $upload_status = false;

    if ($docSample != "") {
        $ImageName_tmp_error = $_FILES['docSample']['error'];
        if ($ImageName_tmp_error > 0) {
            echo '<script>alert("File is not allowed.");</script>';
            echo '<script>window.open("../index.php","_self")</script>';
        } else {

            if (!file_exists('../bplFiles')) {
                mkdir('../bplFiles', 0777, true);
            }

            $ImageName_type = $_FILES['docSample']['type'];
            $ImageName_size = $_FILES['docSample']['size'];
            $ImageName_tmp_name = $_FILES['docSample']['tmp_name'];

            /* Figure out the MIME type | Check in array */
            $known_mime_types = array(
                "application/pdf",
                "image/png",
                "image/jpg",
                "image/jpeg"
            );
            if (!in_array($ImageName_type, $known_mime_types)) {
                echo "<script> alert('File format not supported!')</script>";
                echo "<script>window.open('../submitRequest.php','_self')</script>";
                // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
            } else if ($ImageName_size >= "2097152") {
                echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                echo "<script>window.open('../submitRequest.php','_self')</script>";
                // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
            } else {
                $pos = strrpos($docSample, '.');
                if ($pos === false) {
                    // file has no extension; do something special?
                    $ext = "";
                } else {
                    // includes the period in the extension; do $pos + 1 if you don't want it
                    $ext = substr($docSample, $pos);
                }
                $docSample = md5($appId) . '_attachment' . $ext;
                $docSample_path = "../bplFiles/" . $docSample;

                if (file_exists($docSample_path)) {
                    unlink($docSample_path);
                }

                $check_upload = move_uploaded_file($ImageName_tmp_name, $docSample_path);

                if (!$check_upload) {
                    $upload_status = false;
                    echo '<script>alert("File is not uploaded.");</script>';
                    echo "<script>window.open('../submitRequest.php','_self')</script>";
                } else {
                    $upload_status = true;
                    $reqIsBase = "NA";
                    // echo '<script>alert("File is uploaded.");</script>';
                    // echo "<script>window.open('../submitRequest.php','_self')</script>";
                }
            }
        }
    }

    if ($isBPL == "Yes") {
        $bplCard = $_POST['bplCard'];
        $YOI = $_POST['YOI'];
        $issueAuth = $_POST['issueAuth'];
        $docBPL = $_FILES['docBPL']['name'];
        $upload_status1 = false;

        if ($docBPL != "") {
            $ImageName_tmp_error = $_FILES['docBPL']['error'];
            if ($ImageName_tmp_error > 0) {
                echo '<script>alert("File is not allowed.");</script>';
                echo '<script>window.open("../index.php","_self")</script>';
            } else {

                if (!file_exists('../bplFiles')) {
                    mkdir('../bplFiles', 0777, true);
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
                    echo "<script>window.open('../submitRequest.php','_self')</script>";
                    // $_SESSION['admin_add_companyvisitdetails_fail'] = 1;
                } else if ($ImageName_size >= "2097152") {
                    echo "<script> alert('Make sure that file size is less than 2 MB')</script>";
                    // echo "<script>window.open('../submitRequest.php','_self')</script>";
                    header('Location: ../submitRequest.php');
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
                    $docBPL_path = "../bplFiles/" . $docBPL;

                    if (file_exists($docBPL_path)) {
                        unlink($docBPL_path);
                    }

                    $check_upload = move_uploaded_file($ImageName_tmp_name, $docBPL_path);

                    if (!$check_upload) {
                        $upload_status1 = false;
                        echo '<script>alert("File is not uploaded.");</script>';
                        echo "<script>window.open('../submitRequest.php','_self')</script>";
                    } else {
                        $upload_status1 = true;
                        $reqIsBase = "NA";
                        // echo '<script>alert("File is uploaded.");</script>';
                        // echo "<script>window.open('../submitRequest.php','_self')</script>";
                    }
                }
            }
        }
    } else {
        $reqIsBase = 0;
        $bplCard = "NULL";
        $YOI = "NULL";
        $issueAuth = "NULL";
        $docBPL = "NULL";
        $docBPL_path = "NULL";
    }

    $requestNo = $_SESSION['requestNo'] = date("Ymdhis");
    echo $_SESSION['requestNo'];
    // exit;
    $reqMode = 'Online';
    $reqBase = '20';
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
    $sql->bindParam(8, $docBPL_path);
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
        $document = '';
        $from = "Applicant";
        $to = "Nodal Officer";
        $type = "Filed";
        $status = "Application filed successfully";
        if ($upload_status1) {
            $doc_type = 'bplcard';
            $doc_sql = $conn->prepare("INSERT INTO tbldocument (document_request_id, document_title, document_path, document_type) VALUES(?,?,?,?)");
            $doc_sql->bindParam(1, $requestNo);
            $doc_sql->bindParam(2, $docBPL);
            $doc_sql->bindParam(3, $docBPL_path);
            $doc_sql->bindParam(4, $doc_type);
            $doc_sql->execute();
            $doc_sql = $conn->prepare("SELECT * FROM tbldocument WHERE document_request_id = ? AND document_type = 'bplcard'");
            $doc_sql->bindParam(1, $requestNo);
            $doc_sql->execute();
            $doc_row = $doc_sql->fetch(PDO::FETCH_ASSOC);
            $document .= $doc_row['document_id'];
        }
        if ($upload_status) {
            $doc_type = 'sample doc';
            $doc_sql = $conn->prepare("INSERT INTO tbldocument (document_request_id, document_title, document_path, document_type) VALUES(?,?,?,?)");
            $doc_sql->bindParam(1, $requestNo);
            $doc_sql->bindParam(2, $docSample);
            $doc_sql->bindParam(3, $docSample_path);
            $doc_sql->bindParam(4, $doc_type);
            $doc_sql->execute();
            $doc_sql = $conn->prepare("SELECT * FROM tbldocument WHERE document_request_id = ? AND document_type = 'sample doc'");
            $doc_sql->bindParam(1, $requestNo);
            $doc_sql->execute();
            $doc_row = $doc_sql->fetch(PDO::FETCH_ASSOC);
            $document == '' ? $document .= $doc_row['document_id'] : $document .= "," . $doc_row['document_id'];
        }
        $activity_sql = $conn->prepare("INSERT INTO tblactivity (activity_request_no, activity_from, activity_to, activity_type, activity_status, activity_documents) VALUES(?,?,?,?,?,?)");
        $activity_sql->bindParam(1, $requestNo);
        $activity_sql->bindParam(2, $from);
        $activity_sql->bindParam(3, $to);
        $activity_sql->bindParam(4, $type);
        $activity_sql->bindParam(5, $status);
        $activity_sql->bindParam(6, $document);
        if ($activity_sql->execute()) {
            echo "<script>alert('Your request is filed successfully! Your Request Reference number is: " . $requestNo . "')</script>";
            // echo "<script>window.open('../responseRTI.php', '_self')</script>";
        } else {
            echo "<script>alert('Something went wrong!')</script>";
            echo '<script>window.open(".../submitRequest.php","_self")</script>';
        }
    } else {
        echo "<script>alert('Something went wrong!')</script>";
        echo '<script>window.open(".../submitRequest.php","_self")</script>';
    }
    //     }
    // }
}
