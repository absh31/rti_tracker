<?php
include '../../connection.php';
if (isset($_POST['deptID'])) {
    $id = $_POST['deptID'];
    $roleID = 4;
    $query = $conn->prepare("SELECT * FROM tblofficer WHERE (officer_department_id = ? OR officer_department_id = '') AND officer_role_id = ?");
    $query->bindParam(1, $id);
    $query->bindParam(2, $roleID);
    $query->execute();
    if($query->rowCount() == 0){
        echo "<option disabled selected value=''> NO OFFICER ASSIGNED </option>";
    }else{
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['officer_id'];
            $name = $row['officer_name'];
            echo "<option value='$id'> $name </option>";
        }
    }
}