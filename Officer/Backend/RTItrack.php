<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $reqNo = $_POST['reqNo'];
    $req = $conn->prepare("SELECT * FROM tblrequest WHERE request_no = ?");
    $req->bindParam(1, $reqNo);
    $req->execute();
    $reqRow = $req->fetch(PDO::FETCH_ASSOC);
    $sql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? ORDER BY activity_id");
    $sql->bindParam(1, $reqNo);
    $sql->execute();
    if ($sql->rowCount() > 0) {
?>
        <h5>Activity Details:</h5>
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>Activity From</th>
                    <th>Activity To</th>
                    <th>Activity Remarks</th>
                    <th>Activity Status</th>
                    <th>Activity Time</th>
                    <th>Documents</th>
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
                        <td><?= $row['activity_remarks']; ?></td>
                        <td><?= $row['activity_status']; ?></td>
                        <td><?= $row['activity_time']; ?></td>
                        <td>
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
                                        <a class="btn btn-dark mx-2" href="../uploads/<?php echo $docRow['document_title'] ?>" target="_blank">View <?= $i++ ?></a>
                                    <?php
                                    } while ($docRow = $sql2->fetch(PDO::FETCH_ASSOC));
                                    ?>
                                <?php
                                }
                            } else {
                                ?>
                                No Attachments available
                            <?php
                            } ?>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php
    } else {
    ?>
        <h5>Activity Details:</h5>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>Activity From</th>
                    <th>Activity To</th>
                    <th>Activity Remarks</th>
                    <th>Activity Status</th>
                    <th>Documents</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" colspan="6">NO DATA AVAILABLE</td>
                </tr>
            </tbody>
        </table>
    <?php
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
