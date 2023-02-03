<?php
session_start();
include '../connection.php';
include './lastLogin.php';
if (isset($_POST['forgotPass'])) {
    $uname = htmlspecialchars($_POST['email']);
    $comb = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%?";
    $shfl = str_shuffle($comb);
    $pwd = substr($shfl, 0, 10);
    $pass = md5($pwd);
    // echo $pwd;
    $sql = $conn->prepare("UPDATE tblofficer SET officer_password = ? WHERE officer_email = ?");
    $sql->bindParam(1, $pass);
    $sql->bindParam(2, $uname);
    $sql->execute();

    $sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_email = ? ANd officer_password = ?");
    $sql->bindParam(1, $uname);
    $sql->bindParam(2, $pass);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $to = $row['officer_email'];
        $subject = 'RTI Tracker | Password Reset';
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
                    
                      <h3>Hello " . $row['officer_name'] . ", below is the new password generated for your account</h3>
                      <b><h4>$pwd</h4></b>
                      </body>
                 </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        if (mail($to, $subject, $msg, $headers)) {
            echo "<script>alert('New password has been sent to your email id!')</script>";
            echo "<script>window.open('../login.php','_self')</script>";
        }else{
            echo "<script>alert('Something went wrong!')</script>";
            echo "<script>window.open('../login.php','_self')</script>";
        }
    }
}else{
    echo "<script>alert('Bad request!')</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
