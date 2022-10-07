<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if(checkAdminLogin($_SESSION['auth']) == "admin"){
        if(isset($_POST['addUser'])){
            $roleName = $_POST["roleName"];
            $newRolePriority = (int)$_POST["rolePriority"] + 1;
            ($roleDepartment = $_POST["roleDepartment"]) ? $_POST["roleDepartment"] != "None" : 0;

            $getUsersSql = $conn->prepare("SELECT * FROM tblrole WHERE role_priority > ?");
            $getUsersSql->bindParam(1, $_POST["rolePriority"]);
            $getUsersSql->execute();
            $users = $getUsersSql->fetchAll(PDO::FETCH_ASSOC);
            
            // print_r($users);
            foreach($users as $user){
                $userNewPriority = (int)$user['role_priority'] + 1;
                // echo $userNewPriority. " ". $user['role_priority'];
                $updatePrioritySql = $conn->prepare("UPDATE tblrole SET role_priority = ? WHERE role_id = ?");
                $updatePrioritySql->bindParam(1, $userNewPriority);
                $updatePrioritySql->bindParam(2, $user['role_id']);
                $updatePrioritySql->execute();
            }
            $isActive = 1;
            $addUserSql = $conn->prepare("INSERT INTO tblrole (role_name, role_priority, role_department, is_active) VALUES (?, ?, ?, ?)");
            $addUserSql->bindParam(1, $roleName);
            $addUserSql->bindParam(2, $newRolePriority);
            $addUserSql->bindParam(3, $roleDepartment);
            $addUserSql->bindParam(4, $isActive);
            if($addUserSql->execute()){
                echo "<script>window.alert(`User Role Added Successfully`)</script>";
                echo "<script>window.open('../manageUsers.php','_self')</script>";
            }
    
        }
    } else {
        echo "<script>window.alert(`Don't peep!`)</script>";
        echo "<script>window.open('../login.php','_self')</script>";
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>