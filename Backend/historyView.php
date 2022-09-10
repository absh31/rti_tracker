<?php
session_start();
include '../connection.php';
if (empty($_POST['g-recaptcha-response'])) {
    echo "<script>alert('Captcha Error. Try Again')</script>";
    echo "<script>window.open('./viewHistory.php','_self')</script>";
} else {
    $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

    $response_data = json_decode($response);

    if (!$response_data->success) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('./viewHistory.php','_self')</script>";
    } else {
        $reqMobile = $_POST['reqMobile'];
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
        }
    }
}
?>