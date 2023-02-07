<?php
session_start();
include '../connection.php';
// if (empty($_POST['captcha'])) {
//     echo "<script>alert('Captcha Error1. Try Again')</script>";
//     echo "<script>window.open('./viewStatus.php','_self')</script>";
// } else {
//     $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
//     $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['captcha']);

//     $response_data = json_decode($response);

//     if (!$response_data->success) {
//         echo "<script>alert('Captcha Error. Try Again')</script>";
//         echo "<script>window.open('./viewStatus.php','_self')</script>";
//     } else {
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
    <b>
        <p>Request Details:</p>
    </b>
    <table class="table table-bordered" id="rtiStatus">
        <thead>
            <tr class="bg-dark text-light">
                <th class="text-center align-middle">Applicant Email</th>
                <th class="text-center align-middle">Request No</th>
                <th class="text-center align-middle">Request Current Handler</th>
                <th class="text-center align-middle">Requested Department</th>
                <th class="text-center align-middle">Request Status</th>
                <th class="text-center align-middle">Requested Information</th>
                <th class="text-center align-middle">Payment Details</th>
                <th class="text-center align-middle">Documents</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center align-middle"><?= $key['applicant_email']; ?></td>
                <td class="text-center align-middle"><?= $key['request_no']; ?></td>
                <td class="text-center align-middle">
                    <?php
                    if ($key['request_current_handler'] == "user") {
                        echo "Forwarded to Nodal Officer";
                    } else if ($key['request_current_handler'] == 'none') {
                        echo "RTI Completed";
                    } else if ($key['request_current_handler'] == 'Nodal Officer') {
                        echo "At Nodal Officer";
                    }
                    ?>
                </td>
                <td class="text-center align-middle"><?= $array['department_name']; ?></td>
                <td class="text-center align-middle"><?= $key['request_status']; ?></td>
                <td class="text-center align-middle"><?= $key['request_text']; ?></td>
                <?php
                if ($key['request_status'] != "Rejected" && $key['request_current_handler'] == 'none') {
                    if ($key['request_is_base_pay'] == 0) {
                ?>
                        <td class="text-center align-middle">
                            <a href="./Transactions/payRequest.php?requestNo=<?= $reqNo ?>&payType=base">Pay Registration Fees Now</a>
                        </td>
                        <td class="text-center align-middle">None</td>
                    <?php
                    } else if ($key['request_is_add_pay'] == "0" && $key['request_add_pay'] != "0") {
                    ?>
                        <td class="text-center align-middle">
                            <a href="./Transactions/payRequest.php?requestNo=<?= $reqNo ?>&payType=add">Pay Additional Fees</a>
                        </td>
                        <td class="text-center align-middle">None</td>
                        <?php
                    } else if ($key['request_is_base_pay'] != 0 && ($key['request_is_add_pay'] == 1 || $key['request_add_pay'] == 0)) {
                        $docSql = $conn->prepare("SELECT * FROM tbldocument WHERE document_request_id = ? ORDER BY document_id DESC LIMIT 1");
                        $docSql->bindParam(1, $reqNo);
                        $docSql->execute();
                        $docRow = $docSql->fetch(PDO::FETCH_ASSOC);
                        if ($key['request_is_base_pay'] == 'NA' || $key['request_add_pay'] == 0) {
                        ?>
                            <td class="text-center align-middle"> - </td>
                        <?php
                        } else {
                        ?>

                            <td class="text-center align-middle"><a class="btn btn-success" target="_blank" href="./Backend/downloadReceipt.php?reqNo=<?= $reqNo ?>&reqEmail=<?= $key['applicant_email'] ?>">Download Receipt</a> </td>
                        <?php
                        }
                        ?>
                        <td class="text-center align-middle">
                            <a class="btn btn-dark mx-2" href="./uploads/<?= $docRow['document_title'] ?>" target="_blank">Download Attachment</a>
                        </td>
                    <?php
                    } else {
                    ?>
                        <td class="text-center align-middle">No payment needed yet</td>
                        <td class="text-center align-middle">NA</td>

                    <?php
                    }
                } else {
                    ?>
                    <td class="text-center align-middle">NA</td>
                    <td class="text-center align-middle">NA</td>
                <?php
                }
                ?>
            </tr>
        </tbody>
    </table>
    <br>
    <?php
    $sql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? ORDER BY activity_id");
    $sql->bindParam(1, $reqNo);
    $sql->execute();
    if ($sql->rowCount() > 0) {
    ?>
        <b>
            <p>Activity Details: </p>
        </b>
        <table class="table table-bordered align-middle">
            <thead>
                <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>Activity From</th>
                    <th>Activity To</th>
                    <th>Activity Remarks</th>
                    <th>Activity Status</th>
                    <th>Activity Time</th>
                    <!-- <th>Documents</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $j = 1;
                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?= $j++ ?></td>
                        <td><?= $row['activity_from']; ?></td>
                        <td>
                            <?php
                            if (is_numeric($row['activity_to'])) {
                                $id = $row['activity_to'];
                                $officer = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                                $officer->bindParam(1, $id);
                                $officer->execute();
                                $orow = $officer->fetch(PDO::FETCH_ASSOC);
                                echo $orow['officer_name'];
                            } else {
                                echo $row['activity_to'];
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($row['activity_to'] == "Applicant") {
                                echo $row['activity_remarks'];
                            } else
                                echo "none";

                            ?>
                        </td>
                        <td><?= $row['activity_status']; ?></td>
                        <td><?= $row['activity_time']; ?></td>
                        <!-- <td>
                                    <?php
                                    $docs = $row['activity_documents'];
                                    if ($docs != "") {

                                        $sql2 = $conn->prepare("SELECT * FROM tbldocument WHERE document_id IN ($docs)");
                                        $sql2->execute();
                                        $docRow = $sql2->fetch(PDO::FETCH_ASSOC);
                                        $i = 1;
                                        if (empty($docRow)) {
                                    ?>
                                            <label for="">No Attachments</label>
                                            <?php
                                        } else {
                                            do {
                                            ?>
                                                <a class="btn btn-dark mx-2" href="./uploads/<?php echo $docRow['document_title'] ?>" target="_blank">View <?= $i++ ?></a>
                                            <?php
                                            } while ($docRow = $sql2->fetch(PDO::FETCH_ASSOC));
                                            ?>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        No Attachments
                                    <?php
                                    } ?>

                                </td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }
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
                <td class="text-center align-middle" colspan="5" class="text-danger text-center">NO DATA AVAIALABLE</td>
            </tr>
        </tbody>
    </table>

<?php
    // }
    // }
}
