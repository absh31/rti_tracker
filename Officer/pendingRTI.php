<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Pending RTIs</h5>
                <br>
                <table class="table table-striped table-bordered" id="pending">
                    <thead>
                        <tr class="bg-dark text-light">
                            <td class="text-center">#</td>
                            <td class="text-center">RTI reference number</td>
                            <td class="text-center">RTI issue date</td>
                            <td class="text-center">RTI expiring date</td>
                            <td class="text-center">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $ThisTime = date("Y-m-d H:i:s");
                        $reqCur = 'user';
                        $sql = $conn->prepare("SELECT * FROM tblrequest WHERE request_status = 'Requested' AND TIMESTAMPDIFF(DAY, `request_time`, ?) < 30 AND request_current_handler = ?");
                        $sql->bindParam(1, $ThisTime);
                        $sql->bindParam(2, $reqCur);
                        $sql->execute();
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td class="text-center"><?= $row['request_no'] ?></td>
                                <td class="text-center"><?= $row['request_time'] ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?></td>
                                <td class="text-center">
                                    <a href="./forwardRTI.php?reqNo=<?= $row['request_no']?>" class="btn btn-outline-success">Forward</a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>

    <script>
        $(document).ready(function() {
            $('#pending').DataTable();
        });
    </script>
    </body>

    </html>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>