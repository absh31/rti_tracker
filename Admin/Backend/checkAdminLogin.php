<?php
function checkAdminLogin($auth)
{
    include "../../connection.php";
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $auth);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    return $key['role_name'];
}
