<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "admin") {

        if (isset($_POST['userRoleId'])) {
            $userRoleId = $_POST['userRoleId'];

            $deleteUserRoleSql = $conn->prepare("UPDATE tblrole SET is_active = 0 WHERE role_priority = ?");
            $deleteUserRoleSql->bindParam(1, $userRoleId);
            $deleteUserRoleSql->execute();

            $userSql = $conn->prepare("SELECT * FROM tblrole WHERE role_priority > ?");
            $userSql->bindParam(1, $userRoleId);
            $userSql->execute();

            $users = $userSql->fetchAll();

            if ($userSql->rowCount() > 0) {
                foreach ($users as $user) {
                    $newUserRolePriority = (int)$user['role_priority'] - 1;
                    $UpdateUserPrioritySql = $conn->prepare("UPDATE tblrole SET role_priority = ? WHERE role_id = ?");
                    $UpdateUserPrioritySql->bindParam(1, $newUserRolePriority);
                    $UpdateUserPrioritySql->bindParam(2, $user['role_id']);
                    $UpdateUserPrioritySql->execute();
                }
            }

            echo "<script>window.alert(`User Role Deleted Successfully`)</script>";
            echo "<script>window.open('../manageUsers.php','_self')</script>";
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
