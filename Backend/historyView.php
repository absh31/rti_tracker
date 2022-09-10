<?php
session_start();
include '../connection.php';
// if (!isset($_POST['viewHistory'])) {
//     echo '<script>alert("Bad Request");</script>';
//     echo '<script>window.open("../index.php","_self")</script>';
// } else {
$reqMobile = $_POST['reqMobile'];
// echo $reqMobile;
$reqEmail = $_POST['reqEmail'];
$sql = $conn->prepare("SELECT tblrequest.request_no, tblrequest.*
    FROM tblapplicant 
    INNER JOIN tblrequest
    ON tblapplicant.applicant_id = tblrequest.request_applicant_id
    WHERE tblapplicant.applicant_email = ? AND tblapplicant.applicant_mobile LIKE ?;");
$sql->bindParam(1, $reqEmail);
$sql->bindParam(2, $reqMobile);
$sql->execute();
$reqs = array();
$i = 0;
if ($sql->rowCount() > 0) {
?>
    <table class="table table-bordered">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Request No</th>
                <th>Request Text</th>
                <th>Request Department</th>
                <th>Request Date</th>
                <th>Request Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($key = $sql->fetch(PDO::FETCH_ASSOC)) {
                $sql2 = $conn->prepare("SELECT * FROM tbldepartment WHERE department_id = ?");
                $sql2->bindParam(1, $key['request_department_id']);
                $sql2->execute();
                $array = $sql2->fetch(PDO::FETCH_ASSOC);
                $i++;
            ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $key['request_no']; ?></td>
                    <td><?= $key['request_text']; ?></td>
                    <td><?= $array['department_name']; ?></td>
                    <td><?= $key['request_time']; ?></td>
                    <td><?= $key['request_status']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    // $_SESSION['reqs'] = $reqs;
    // echo '<script>window.open("../viewHistory.php","_self")</script>'; 
} else {
?>
    <table class="table table-bordered">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Request No</th>
                <th>Request Text</th>
                <th>Request Department</th>
                <th>Request Date</th>
                <th>Request Status</th>
            </tr>
        </thead>
        <tbody>
            <tr> 
                <td class="text-danger text-center" colspan="6">NO DATA AVAIALABLE</td>
            </tr>
        </tbody>
    </table>
    
<?php
    session_destroy();
    // unset($_POST['viewStatus']);
    // echo '<script>alert("Wrong Details!");</script>';
    // echo '<script>window.open("../viewStatus.php","_self")</script>';
}
// }

?>