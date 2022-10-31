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
                // $alert = $conn->prepare("SELECT * FROM tblrequest WHERE DATEDIFF(?, request_time) > 15");
                $alert = $conn->prepare("SELECT * FROM tblrequest");
                // $alert->bindParam(1, $today);
                $alert->execute();
                if ($alert->rowCount() > 0) {
                    $to = $row['officer_email'];
                    $subject = 'ALERT :: EXPIRING RTIs';
                    $msg =
                        "<!DOCTYPE html>
                    <html>
                    
                    <head>
                      <style>
                        table {
                          font-family: arial, sans-serif;
                          border-collapse: collapse;
                          width: 100%;
                        }
                    
                        td,
                        th {
                          border: 1px solid #dddddd;
                          text-align: left;
                          padding: 8px;
                        }
                    
                        tr:nth-child(even) {
                          background-color: #dddddd;
                        }
                      </style>
                    </head>
                    
                    <body>
                    
                      <h3>Dear Nodal Officer, below is the list of expiring RTIs. Please take necessary actions onto it.</h3>
                    
                      <table>
                        <tr>
                          <th>Request Number</th>
                          <th>Request Date</th>
                          <th>Request Expiry</th>
                          <th>Request Department</th>
                        </tr>";
                    while ($alertrow = $alert->fetch(PDO::FETCH_ASSOC)) {
                        $reqdate = date('d-m-Y', strtotime($alertrow['request_time']));
                        $exp_date = date('d-m-Y', strtotime($alertrow['request_time'] . ' + 30 days'));
                        $dept = $conn->prepare("SELECT * FROM tbldepartment WHERE department_id = ?");
                        $dept->bindParam(1, $alertrow['request_department_id']);
                        $dept->execute();
                        $deptrow = $dept->fetch(PDO::FETCH_ASSOC);
                        $msg .= "
                        <tr style='border: 1px solid black;'>
                            <td>" . $alertrow['request_no'] . "</td>
                            <td>" . $reqdate . "</td>
                            <td>" . $exp_date . "</td>
                            <td>" . $deptrow['department_name'] . "</td>
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
