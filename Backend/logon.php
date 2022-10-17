<?php
session_start();
include '../connection.php';
include './lastLogin.php';
if (isset($_POST['AuthLogin'])) {
    if (empty($_POST['g-recaptcha-response'])) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('../login.php','_self')</script>";
    } else {
        $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

        $response_data = json_decode($response);

        if (!$response_data->success) {
            echo "<script>alert('Captcha Error. Try Again')</script>";
            echo "<script>window.open('../login.php','_self')</script>";
        } else {
            $uname = htmlspecialchars($_POST['username']);
            $pass = md5($_POST['password']);
            $type = htmlspecialchars($_POST['type']);
            $sql = $conn->prepare("SELECT * FROM `tblofficer` WHERE `officer_username` = ? AND `officer_password` = ? AND `officer_role_id` = ?");

            $sql->bindParam(1, $uname);
            $sql->bindParam(2, $pass);
            $sql->bindParam(3, $type);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $_SESSION['officer_name'] = $row['officer_name'];
                $_SESSION['username'] = $uname;
                $_SESSION['password'] = $pass;
                $_SESSION['auth'] = $type;

                $today = date("Y-m-d H:i:s");
                $alert = $conn->prepare("SELECT * FROM tblrequest WHERE DATEDIFF(?, request_time) > 15");
                $alert->bindParam(1, $today);
                $alert->execute();
                if ($alert->rowCount() > 0) {
                    $to = $row['officer_email'];
                    $subject = 'ALERT :: EXPIRING RTIs';
                    $msg = "<html><head></head><body><h5> Dear Nodal Officer, here is the list of RTI's expiring soon. Please take actions accordingly.</h5> 
                    <br> 
                    <table style='border: 1px solid black;'>
    <thead style='border: 1px solid black;'>
        <tr style='border: 1px solid black;'>
            <td style='border: 1px solid black;'>Request Number</td>
            <td style='border: 1px solid black;'>Request Date</td>
            <td style='border: 1px solid black;'>Request Expiry Date</td>
            <td style='border: 1px solid black;'>Request Department</td>
        </tr>
    </thead>
    <tbody style='border: 1px solid black;'>
        ";
                    while ($alertrow = $alert->fetch(PDO::FETCH_ASSOC)) {
                        $reqdate = date('d-m-Y', strtotime($alertrow['request_time']));
                        $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days'));
                        $dept = $conn->prepare("SELECT * FROM tbldepartment WHERE department_id = ?");
                        $dept->bindParam(1, $alertrow['request_department_id']);
                        $dept->execute();
                        $deptrow = $dept->fetch(PDO::FETCH_ASSOC);
                        $msg .= "
                        <tr style='border: 1px solid black;'>
                            <td style='border: 1px solid black;'>" . $alertrow['request_no'] . "</td>
                            <td style='border: 1px solid black;'>" . $reqdate . "</td>
                            <td style='border: 1px solid black;'>" . $exp_date . "</td>
                            <td style='border: 1px solid black;'>" . $deptrow['department_name'] . "</td>
                        </tr>";
                    }
                    $msg .= "</tbody> </html>";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    mail($to, $subject, $msg, $headers);
                }

                lastLogin($type, $uname, $pass);
            } else {
                echo "<script>alert('Invalid Credentials')</script>";
                echo "<script>window.open('../login.php','_self')</script>";
            }
        }
    }
}
