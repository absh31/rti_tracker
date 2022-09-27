<?php
include '../../connection.php';
if (isset($_POST['deptID'])) {
    $id = $_POST['deptID'];
    $query = $conn->prepare("SELECT * FROM tblofficer WHERE officer_department_id = ? OR officer_department_id = ''");
    $query->bindParam(1, $id);
    $query->execute();
    if($query->rowCount() == 0){
        echo "<option disabled selected> NO OFFICER ASSIGNED </option>";
    }else{
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['officer_id'];
            $name = $row['officer_name'];
            echo "<option value='$name'> $name </option>";
        }
    }
}
