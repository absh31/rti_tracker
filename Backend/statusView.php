<?php
session_start();
include '../connection.php';
if (empty($_POST['captcha'])) {
    echo "<script>alert('Captcha Error1. Try Again')</script>";
    echo "<script>window.open('./viewStatus.php','_self')</script>";
} else {
    $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['captcha']);

    $response_data = json_decode($response);

    if (!$response_data->success) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('./viewStatus.php','_self')</script>";
    } else {
        $reqNo = $_POST['reqNo'];
        $reqEmail = $_POST['reqEmail'];
        $sql = $conn->prepare("SELECT tblapplicant.applicant_email, tblrequest.* 
    FROM tblapplicant 
    INNER JOIN tblrequest
    ON tblapplicant.applicant_id = tblrequest.request_applicant_id
    WHERE tblrequest.request_no = ? AND tblapplicant.applicant_email = ? ;");
        $sql->bindParam(1, $reqNo);
        $sql->bindParam(2, $reqEmail);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $key = $sql->fetch(PDO::FETCH_ASSOC);
            $sql2 = $conn->prepare("SELECT * FROM tbldepartment WHERE department_id = ?");
            $sql2->bindParam(1, $key['request_department_id']);
            $sql2->execute();
            $array = $sql2->fetch(PDO::FETCH_ASSOC);
?>
            <p>Request Details:</p>
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-dark text-light">
                        <th>Applicant Email</th>
                        <th>Request No</th>
                        <th>Request Current Handler</th>
                        <th>Requested Department</th>
                        <th>Request Status</th>
                        <th>Requested Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $key['applicant_email']; ?></td>
                        <td><?= $key['request_no']; ?></td>
                        <td><?= $key['request_current_handler']; ?></td>
                        <td><?= $array['department_name']; ?></td>
                        <td><?= $key['request_status']; ?></td>
                        <td><?= $key['request_text']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php
        } else {
            unset($_POST['viewStatus']);
            session_unset();
        ?>
            <p>Request Details:</p>
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-dark text-light">
                        <th>Applicant Email</th>
                        <th>Request No</th>
                        <th>Request Current Handler</th>
                        <th>Requested Department</th>
                        <th>Request Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-danger text-center">NO DATA AVAIALABLE</td>
                    </tr>
                </tbody>
            </table>

<?php
        }
    }
}
