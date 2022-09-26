<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Pending RTIs</h5>
                <br>
                <table class="table table-bordered" id="pending">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>RTI reference number</td>
                            <td>RTI issue date</td>
                            <td>RTI expiring date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $ThisTime = date("Y-m-d H:i:s");
                        $sql = $conn->prepare("SELECT * FROM tblrequest WHERE request_status = 'Requested' AND TIMESTAMPDIFF(DAY, `request_time`, ?) < 30");
                        $sql->bindParam(1, $ThisTime);
                        $sql->execute();
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $row['request_no'] ?></td>
                                <td><?= $row['request_time'] ?></td>
                                <td><?= date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?></td>
                                <td>FORWARD</td>
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