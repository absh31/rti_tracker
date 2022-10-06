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
                        <th>Payment Details</th>
                        <th>Documents</th>
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
                        <?php
                        if ($key['request_status'] != "Rejected") {
                            if ($key['request_is_base_pay'] == 0) {
                        ?>
                                <td>
                                    <a href="./Transactions/payRequest.php?reqNo=<?= $reqNo ?>&payType=base">Pay Now</a>
                                </td>
                                <td>None</td>
                            <?php
                            } else if ($key['request_is_add_pay'] == 0) {
                            ?>
                                <td>
                                    <a href="./Transactions/payRequest.php?reqNo=<?= $reqNo ?>&payType=add">Pay Now</a>
                                </td>
                                <td>None</td>
                            <?php
                            } else if ($key['request_is_base_pay'] == 1 && $key['request_is_add_pay'] == 1) {
                                $docSql = $conn->prepare("SELECT * FROM tbldocument WHERE document_request_id = ? ORDER BY document_id DESC LIMIT 1");
                                $docSql->bindParam(1, $reqNo);
                                $docSql->execute();
                                $docRow = $docSql->fetch(PDO::FETCH_ASSOC);
                            ?>
                                <td>Paid</td>
                                <td>
                                    <a class="btn btn-dark mx-2" href="./uploads/<?= $docRow['document_title'] ?>" target="_blank">Download Attachment</a>
                                </td>
                        <?php
                            }
                        }else{
                            ?>
                            <td>NA</td>
                            <td>NA</td>
                            <?php
                        }
                        ?>
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
