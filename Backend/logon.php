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
            $url = '';

            if ($type == 'Admin') {
                $url = '../Admin/dashboard.php';
                $sql = $conn->prepare("SELECT * FROM tbladmin WHERE `admin_username` = ? AND `admin_password` = ?");

            } elseif ($type == 'Nodal Officer') {
                $url = '../Nodal/dashboard.php';
                $sql = $conn->prepare("SELECT * FROM tblnodal WHERE `nodal_username` = ? AND `nodal_password` = ?");

            } elseif ($type == 'Department Officer') {
                $url = '../Department/dashboard.php';
                $sql = $conn->prepare("SELECT * FROM tblofficer WHERE `officer_username` = ? AND `officer_password` = ?");

            } elseif ($type == 'Appellate Officer') {
                $url = '../Appellate/dashboard.php';
                $sql = $conn->prepare("SELECT * FROM tblappellate WHERE `appellate_username` = ? AND `appellate_password` = ?");

            } else {
                echo "<script>alert('Bad Request.')</script>";
                echo "<script>window.open('../login.php','_self')</script>";
            }

            $sql->bindParam(1, $uname);
            $sql->bindParam(2, $pass);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $_SESSION['username'] = $uname;
                $_SESSION['password'] = $pass;
                $_SESSION['auth'] = $type;
                $_SESSION['url'] = $url;
                lastLogin($type, $uname, $pass);
            } else {
                echo "<script>alert('Invalid Credentials')</script>";
                echo "<script>window.open('../login.php','_self')</script>";
            }
        }
    }
}
