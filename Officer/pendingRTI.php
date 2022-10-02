<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    include './nav.php';
    if ($key['role_id'] == 3) {
?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>Forward RTIs</h5>
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
                                    <td class="text-center"><?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
                                        <?php
                                        $diff = date_diff(date_create($ThisTime), date_create($exp_date));
                                        if ($diff->days <= 10) {
                                        ?>
                                            <span class="text-danger">
                                                (<?= $diff->format('%a day(s) left'); ?>)
                                            </span>
                                        <?php
                                        } else {
                                        ?>
                                            <span>
                                                (<?= $diff->format('%a day(s) left'); ?>)
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="./forwardRTI.php?reqNo=<?= $row['request_no'] ?>" class="btn btn-outline-success">Forward</a>
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
        <script>
            document.getElementById("pend-nav").style.fontWeight = 600;
            document.getElementById("pend-nav").classList.add("active");
            document.getElementById("dash-nav").classList.remove("active")
            document.getElementById("add-nav").classList.remove("active")
            document.getElementById("trck-nav").classList.remove("active")
            document.getElementById("hist-nav").classList.remove("active")
        </script>
    <?php
    } else if ($key['role_id'] == 4) {
        //OFFICER
    ?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>Pending RTIs</h5>
                    <br>
                    <table class="table table-striped table-bordered" id="pending1">
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
                            $sql = $conn->prepare("SELECT * FROM tblrequest WHERE request_status = 'Requested' AND TIMESTAMPDIFF(DAY, `request_time`, ?) < 30 AND request_current_handler = ? AND request_department_id = ?");
                            $sql->bindParam(1, $ThisTime);
                            $sql->bindParam(2, $reqCur);
                            $sql->bindParam(3, $key['officer_department_id']);
                            $sql->execute();
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $row['request_no'] ?></td>
                                    <td class="text-center"><?= $row['request_time'] ?></td>
                                    <td class="text-center"><?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
                                        <?php
                                        $diff = date_diff(date_create($ThisTime), date_create($exp_date));
                                        if ($diff->days <= 10) {
                                        ?>
                                            <span class="text-danger">
                                                (<?= $diff->format('%a day(s) left'); ?>)
                                            </span>
                                        <?php
                                        } else {
                                        ?>
                                            <span>
                                                (<?= $diff->format('%a day(s) left'); ?>)
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="./viewRTI.php?id=<?= $row['request_no'] ?>" target="_blank" id="revertButton" class="btn btn-dark">View</a>
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
        <script>
            document.getElementById("pend-nav").style.fontWeight = 600;
            document.getElementById("pend-nav").classList.add("active");
            document.getElementById("dash-nav").classList.remove("active")
            document.getElementById("hist-nav").classList.remove("active")
        </script>
    <?php
    }
    ?>
    <?php include '../footer.php'; ?>

    <script>
        $(document).ready(function() {
            $('#pending').DataTable();
            $('#pending1').DataTable();
            $('#pending').on('click', '#rejectButton', function() {
                var reqNo = $(this).attr('data-id')
                reqNo = reqNo.toString()
                console.log(reqNo);
                $.ajax({
                    type: "POST",
                    url: "./Backend/rejectRTI.php",
                    data: {
                        id: JSON.stringify(data1)
                    },
                    success: function(response) {
                        var res = JSON.parse(response)
                        console.log(res)
                        // $('#AserviceID').val(res['book_id'])
                        // $('#AserviceName').val(res['book_name'])
                        // $('#Adate').val(res['book_date'])
                        // $('#Address').val(res['book_address'])
                        $('#toggleModalBtn2').click()
                    }
                });
            })
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