<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id AND o.officer_username = ? AND o.officer_password = ?');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->bindParam(2, $_SESSION['username']);
    $sql->bindParam(3, $_SESSION['password']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    if ($key['role_id'] == 3) {
        // NODAL
        include '../nav.php';
        include './nav.php';
        ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col">
                    <h5>Pending RTIs</h5>
                    <p>Below is the list of RTIs which needs to be forwarded to conerned Departmental Officer.</p>
                    <table class="table table-striped table-bordered align-middle" id="pending">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">Request department</td>
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
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
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
                                        <?php
                                        $dept = $conn->prepare("SELECT department_name FROM tbldepartment WHERE department_id = ?");
                                        $dept->bindParam(1, $row['request_department_id']);
                                        $dept->execute();
                                        $deptr = $dept->fetch(PDO::FETCH_ASSOC);
                                        echo $deptr['department_name'];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="./forwardRTI.php?reqNo=<?= $row['request_no'] ?>" target="_blank" class="btn btn-outline-success">Forward</a>
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
            <br>
            <div class="row">
                <div class="col">
                    <h5>Reverted RTIs</h5>
                    <p>Below is the list of reverted RTIs from the Departmental Officers.</p>
                    <table class="table table-striped table-bordered align-middle" id="received">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">RTI Remarks</td>
                                <td class="text-center">RTI Status</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $currentHandler = "Nodal Officer";
                            $type = "Filed";
                            // $ThisTime = date("Y-m-d H:i:s");
                            $completed = 0;
                            $sql = $conn->prepare("SELECT * FROM tblrequest r, tblactivity a WHERE r.request_no = a.activity_request_no AND a.activity_to = ? AND a.activity_type != ? AND r.request_completed = ?");
                            $sql->bindParam(1, $currentHandler);
                            $sql->bindParam(2, $type);
                            $sql->bindParam(3, $completed);
                            $sql->execute();
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $row['request_no'] ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
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
                                    <td class="text-center"><?= $row['activity_remarks'] ?></td>
                                    <td class="text-center"><?= $row['activity_type'] ?></td>
                                    <!-- <td class="text-center">
                                        <a href="./forwardRTI.php?reqNo=<?= $row['request_no'] ?>&confirm=0" target="_blank" class="btn btn-outline-success">Forward</a>
                                        <a href="./forwardRTI.php?reqNo=<?= $row['request_no'] ?>&confirm=1" target="_blank" class="btn btn-outline-danger" style="margin-left: 15px;">Close RTI</a>
                                    </td> -->
                                    <td class="text-center">
                                        <a href="./forwardRTI.php?reqNo=<?= $row['request_no'] ?>" target="_blank" class="btn btn-outline-success">View</a>
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
            document.getElementById("dash-nav").classList.remove("active")
            document.getElementById("pend-nav").style.fontWeight = 600;
            document.getElementById("pend-nav").classList.add("active");
        </script>
    <?php
    } else if ($key['officer_role_id'] != 3) {
        //OFFICER
        include '../nav.php';
        include './nav.php';
    ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col">
                    <h5>Pending RTIs</h5>
                    <p>Below is the list of RTIs which needs to be worked upon.</p>
                    <table class="table table-striped align-middle table-bordered" id="pending1">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">RTI Remarks</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $ThisTime = date("Y-m-d H:i:s");
                            $completed = 0;
                            $dept = "%".$key['officer_id']."%";
                            $sql = $conn->prepare("SELECT * FROM tblrequest r, tblactivity a WHERE r.request_no = a.activity_request_no AND a.activity_to = ? AND r.request_current_handler LIKE ?  AND r.request_completed = ?  ORDER BY a.activity_id DESC");
                            $sql->bindParam(1, $key['officer_id']);
                            $sql->bindParam(2, $dept);
                            $sql->bindParam(3, $completed);
                            $sql->execute();
                            if (!empty($row = $sql->fetch(PDO::FETCH_ASSOC))) {
                                // echo "<pre>";
                                // print_r($row);
                                $officers = explode(',', $row['request_current_handler']);
                                if (in_array($key['officer_id'], $officers)) {
                                    do {
                            ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td class="text-center"><?= $row['request_no'] ?></td>
                                            <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                            <td class="text-center"><?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
                                                <?php
                                                $diff = date_diff(date_create($ThisTime), date_create($exp_date));
                                                if ($diff->days == 0) {
                                                ?>
                                                    <span class="text-danger">
                                                        RTI EXPIRED
                                                    </span>

                                                <?php
                                                } else if ($diff->days <= 10) {
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
                                            <td class="text-center"><?= $row['activity_remarks'] ?></td>
                                            <td class="text-center">
                                                <a href="./viewRTI.php?reqNo=<?= $row['request_no'] ?>" target="_blank" id="revertButton" class="btn btn-dark">View</a>
                                            </td>
                                        </tr>
                            <?php
                                        $i++;
                                    } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
                                }
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
        </script>
    <?php
    }
    ?>
    <?php include '../footer.php'; ?>

    <script>
        $(document).ready(function() {
            $('#pending').DataTable();
            $('#pending1').DataTable();
            $('#received').DataTable();
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