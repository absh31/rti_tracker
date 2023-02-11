<?php
include '../connection.php';
$sql = $conn->prepare("SELECT * FROM tblaadhar WHERE aadhar_number = ?");
$sql->bindParam(1, $_POST['aadharNumber']);
$sql->execute();
if ($sql->rowCount() > 0) {
    echo '1';
} else{
    echo '0';
}
