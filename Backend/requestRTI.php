<?php
include '../connection.php';
session_start();
if (!isset($_POST['requestRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    if (empty($_POST['g-recaptcha-response'])) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('../submitRTI.php','_self')</script>";
    } else {
        $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

        $response_data = json_decode($response);

        if (!$response_data->success) {
            echo "<script>alert('Captcha Error. Try Again')</script>";
            echo "<script>window.open('./submitRTI.php','_self')</script>";
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

            $docBPL = $_FILES['docBPL']['name'];
            $upload_status = false;

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
                        "application/png",
                        "application/jpg",
                        "application/jpeg"
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
                            echo '<script>alert("File is not uploaded.");</script>';
                            echo "<script>window.open('../submitRequest.php','_self')</script>";
                        } else {
                            // echo '<script>alert("File is uploaded.");</script>';
                            // echo "<script>window.open('../submitRequest.php','_self')</script>";
                        }
                    }
                }
            }
            
            // $allowed_doc = array('jpe', 'png', 'jpeg', 'jpg', 'pdf', 'xls', 'csv');
            // $ext1 = strtolower(substr($docBPL, strpos($docBPL, ".") + 1, strlen($docBPL)));
            // if (!in_array($ext1, $allowed_doc)) {
            //     echo '<script>alert("File is not allowed.");</script>';
            //     echo '<script>window.open("../index.php","_self")</script>';
            // }
            // $ext = pathinfo($_FILES['docBPL']['name'], PATHINFO_EXTENSION);
            // if (!in_array($ext, $allowed_doc)) {
            //     echo '<script>alert("File is not allowed.");</script>';
            //     echo '<script>window.open("../index.php","_self")</script>';
            // }
            // if (!file_exists('../bplFiles')) {
            //     mkdir('../bplFiles', 0777, true);
            // }
            // $uploadDir = '../bplFiles/';
            // $bplName = uniqid() . '_bpl.' . $ext;
            // ob_clean();
            // $bpl = $uploadDir . $bplName;

            $requestNo = date("Ymdhis");
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
                echo "<script>alert('Your request is filed successfully! Your Request Reference number is: ".$requestNo."')</script>";
                session_unset();
                session_destroy();
                echo '<script>window.open("../index.php","_self")</script>';
            } else {
                echo "<script>alert('Something went wrong!')</script>";
                // echo '<script>window.open(".../submitRequest.php","_self")</script>';
            }
        }
    }
}
