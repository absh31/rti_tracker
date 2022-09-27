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
                lastLogin($type, $uname, $pass);
            } else {
                echo "<script>alert('Invalid Credentials')</script>";
                echo "<script>window.open('../login.php','_self')</script>";
            }
        }
    }
}
