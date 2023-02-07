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
            <div class="row px-3 text-center divHide" style="font-size : 18px; font-family : Poppins; font-weight : bold">
                <div class="col py-2 active1" style="cursor: pointer;border : 1px solid black" id="pendingLink">
                    <?php
                    $i = 1;
                    $ThisTime = date("Y-m-d H:i:s");
                    $reqCur = 'user';
                    $pendingSql = $conn->prepare("SELECT * FROM tblrequest WHERE request_status = 'Requested' AND TIMESTAMPDIFF(DAY, `request_time`, ?) < 30 AND request_current_handler = ?");
                    $pendingSql->bindParam(1, $ThisTime);
                    $pendingSql->bindParam(2, $reqCur);
                    $pendingSql->execute();
                    ?>
                    Pending RTIs <?php echo ($pendingSql->rowCount()) ? "(" . $pendingSql->rowCount() . ")" : ""; ?>
                </div>
                <div class="col py-2" style="border : 1px solid black; cursor: pointer;" id="revertLink">
                    <?php
                    $i = 1;
                    $currentHandler = "Nodal Officer";
                    $type = "Filed";
                    // $ThisTime = date("Y-m-d H:i:s");
                    $completed = 0;
                    $revertSql = $conn->prepare("SELECT * FROM tblrequest r, tblactivity a WHERE r.request_no = a.activity_request_no AND a.activity_to = ? AND a.activity_type != ? AND r.request_completed = ? AND r.request_current_handler = ? AND a.activity_from != 'appellate' AND a.activity_completed = 0");
                    $revertSql->bindParam(1, $currentHandler);
                    $revertSql->bindParam(2, $type);
                    $revertSql->bindParam(3, $completed);
                    $revertSql->bindParam(4, $currentHandler);
                    $revertSql->execute();
                    ?>
                    Reverted RTIs <?php echo ($revertSql->rowCount()) ? "(" . $revertSql->rowCount() . ")" : ""; ?>
                </div>
                <div class="col py-2" style="border : 1px solid black; cursor: pointer;" id="appealLink">
                    <?php
                    $i = 1;
                    $currentHandler = "Nodal Officer";
                    // $to = "Appellate ";
                    $type = "Filed";
                    // $ThisTime = date("Y-m-d H:i:s");
                    $completed = 1;
                    $appealSql = $conn->prepare("SELECT * FROM tblrequest r, tblactivity a, tblappeal ap WHERE r.request_no = a.activity_request_no AND a.activity_to = ? AND r.request_no = ap.appeal_request_no AND a.activity_is_appealed = 1 AND a.activity_completed = 0");
                    $appealSql->bindParam(1, $currentHandler);
                    $appealSql->execute();
                    ?>
                    Appealed RTIs <?php echo ($appealSql->rowCount()) ? "(" . $appealSql->rowCount() . ")" : ""; ?>
                </div>
            </div>
            <br>
            <div class="row" id="pendingDiv">
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
                            while ($row = $pendingSql->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $row['request_no'] ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                    <td class="text-center">
                                        <?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
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
            <div class="row" id="revertDiv">
                <div class="col">
                    <h5>Reverted RTIs</h5>
                    <p>Below is the list of reverted RTIs from the Departmental Officers.</p>
                    <table class="table table-striped table-bordered align-middle" id="reverted">
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
                            while ($row = $revertSql->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center text-danger"><?= $row['request_no'] ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                    <td class="text-center">
                                        <?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
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
            <div class="row" id="appealDiv">
                <div class="col">
                    <h5>Appealed RTIs</h5>
                    <p>Below is the list of Frst Appealed RTIs.</p>
                    <table class="table table-striped table-bordered align-middle" id="appealed">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date (NEW)</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">Appeal Reason</td>
                                <td class="text-center">Appeal Remarks</td>
                                <td class="text-center">RTI Status</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $appealSql->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center text-danger"><?= $row['request_no'] ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                    <td class="text-center">
                                        <?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
                                        <?php
                                        $diff = date_diff(date_create($ThisTime), date_create($exp_date));
                                        if ($diff->days <= 10) {
                                        ?>
                                            <span class="text-danger">
                                                (<?= $diff->format('%a day(s) left'); ?>)
                                            </span>
                                        <?php
                                        } else if ($diff->days < 1) {
                                        ?>
                                            <span class="text-danger">
                                                (<?= $diff->format('EXPIRED'); ?>)
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
                                    <td class="text-center"><?= $row['appeal_reason'] ?></td>
                                    <td class="text-center"><?= $row['activity_remarks'] ?></td>
                                    <td class="text-center"><?= $row['activity_type'] ?></td>
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
        <?php include '../footer.php'; ?>

        <script>
            $('#pending').DataTable();
            $('#reverted').DataTable();
            $('#appealed').DataTable();
            $('#pendingDiv').show();
            $('#revertDiv').hide();
            $('#appealDiv').hide();
            $('#pendingLink').click(function() {
                $('#pendingDiv').show(function() {
                    $('#pendingLink').addClass('active1')
                });
                $('#revertDiv').hide(function() {
                    $('#revertLink').removeClass('active1')
                });
                $('#appealDiv').hide(function() {
                    $('#appealLink').removeClass('active1')
                });
            })
            $('#revertLink').click(function() {
                $('#revertDiv').show(function() {
                    $('#revertLink').addClass('active1')
                });
                $('#pendingDiv').hide(function() {
                    $('#pendingLink').removeClass('active1')
                });
                $('#appealDiv').hide(function() {
                    $('#appealLink').removeClass('active1')
                });
            })
            $('#appealLink').click(function() {
                $('#appealDiv').show(function() {
                    $('#appealLink').addClass('active1')
                });
                $('#pendingDiv').hide(function() {
                    $('#pendingLink').removeClass('active1')
                });
                $('#revertDiv').hide(function() {
                    $('#revertLink').removeClass('active1')
                });
            })
            document.getElementById("dash-nav").classList.remove("active")
            document.getElementById("pend-nav").style.fontWeight = 600;
            document.getElementById("pend-nav").classList.add("active");
        </script>
    <?php
    } else if ($key['officer_role_id'] == 4) {
        //OFFICER
        include '../nav.php';
        include './nav.php';
    ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row px-3 text-center divHide" style="font-size : 18px; font-family : Poppins; font-weight : bold">
                <div class="col py-2 active1" style="border : 1px solid black; cursor: pointer;" id="pendingLink">
                    <?php
                    $i = 1;
                    $ThisTime = date("Y-m-d H:i:s");
                    $completed = 0;
                    $dept = "%" . $key['officer_id'] . "%";
                    $pendingSql = $conn->prepare("SELECT * FROM tblrequest r, tblactivity a WHERE r.request_no = a.activity_request_no AND a.activity_to = ? AND r.request_current_handler LIKE ?  AND r.request_completed = ? AND r.request_is_appealed = 0 ORDER BY a.activity_id DESC");
                    $pendingSql->bindParam(1, $key['officer_id']);
                    $pendingSql->bindParam(2, $dept);
                    $pendingSql->bindParam(3, $completed);
                    $pendingSql->execute();
                    ?>
                    Pending RTIs <?php echo ($pendingSql->rowCount()) ? "(" . $pendingSql->rowCount() . ")" : ""; ?>
                </div>
                <div class="col py-2" style="border : 1px solid black; cursor: pointer;" id="appealLink">
                    <?php
                    $i = 1;
                    $ThisTime = date("Y-m-d H:i:s");
                    $completed = 0;
                    $dept = "%" . $key['officer_id'] . "%";
                    $appealSql = $conn->prepare("SELECT * FROM tblrequest r, tblactivity a WHERE r.request_no = a.activity_request_no AND a.activity_to = ? AND r.request_current_handler LIKE ? AND r.request_completed = ? AND a.activity_completed = 0 AND r.request_is_appealed = 1 ORDER BY a.activity_id DESC");
                    $appealSql->bindParam(1, $key['officer_id']);
                    $appealSql->bindParam(2, $dept);
                    $appealSql->bindParam(3, $completed);
                    $appealSql->execute();
                    ?>
                    Appealed RTIs <?php echo ($appealSql->rowCount()) ? "(" . $appealSql->rowCount() . ")" : ""; ?>
                </div>
            </div>
            <br>
            <div class="row" id="pendingDiv">
                <div class="col">
                    <h5>Pending RTIs</h5>
                    <p>Below is the list of RTIs which needs to be worked upon.</p>
                    <table class="table table-striped align-middle table-bordered" id="pending">
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
                            if (!empty($row = $pendingSql->fetch(PDO::FETCH_ASSOC))) {
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
                                            <td class="text-center">
                                                <?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
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
                                    } while ($row = $pendingSql->fetch(PDO::FETCH_ASSOC));
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" id="appealDiv">
                <div class="col">
                    <h5>Appealed RTIs</h5>
                    <p>Below is the list of RTIs which needs to be worked upon.</p>
                    <table class="table table-striped align-middle table-bordered" id="appeal">
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
                            if (!empty($row = $appealSql->fetch(PDO::FETCH_ASSOC))) {
                                $officers = explode(',', $row['request_current_handler']);
                                if (in_array($key['officer_id'], $officers)) {
                                    do {
                            ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td class="text-center"><?= $row['request_no'] ?></td>
                                            <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                            <td class="text-center">
                                                <?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
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
                                    } while ($row = $appealSql->fetch(PDO::FETCH_ASSOC));
                                }
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
            $('#pending').DataTable();
            $('#appeal').DataTable();

            $('#pendingDiv').show();
            $('#appealDiv').hide();
            $('#pendingLink').click(function() {
                $('#pendingDiv').show(function() {
                    $('#pendLink').addClass('active1')
                });
                $('#appealDiv').hide(function() {
                    $('#appealLink').removeClass('active1')
                });
            })
            $('#appealLink').click(function() {
                $('#appealDiv').show(function() {
                    $('#appealLink').addClass('active1')
                });
                $('#pendingDiv').hide(function() {
                    $('#pendingLink').removeClass('active1')
                });
            })
            document.getElementById("pend-nav").style.fontWeight = 600;
            document.getElementById("pend-nav").classList.add("active");
            document.getElementById("dash-nav").classList.remove("active")
        </script>
    <?php
    } else if ($key['officer_role_id'] == 2) {
        //APPELLATE
        include '../nav.php';
        include './nav.php';
    ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col">
                    <h5>Appealed RTIs</h5>
                    <p>Below is the list of RTIs which needs to be worked upon.</p>
                    <table class="table table-striped align-middle table-bordered" id="pending">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI appeal date</td>
                                <td class="text-center">Appeal Reason</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $ThisTime = date("Y-m-d H:i:s");
                            $completed = 0;
                            $sql = $conn->prepare("SELECT * FROM tblrequest req, tblappeal app WHERE app.appeal_request_no = req.request_no AND req.request_is_appealed = 1 AND req.request_current_handler = 'user'");
                            // $sql->bindParam(1, $key['officer_id']);
                            // $sql->bindParam(2, $dept);
                            // $sql->bindParam(3, $completed);
                            $sql->execute();
                            if (!empty($row = $sql->fetch(PDO::FETCH_ASSOC))) {
                                do {
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $row['request_no'] ?></td>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                        <td class="text-center">
                                            <?php echo $exp_date = date('d-m-Y', strtotime($row['appeal_time'] . ' + 30 days')) ?></td>
                                        <td class="text-center"><?= $row['appeal_reason'] ?></td>
                                        <td class="text-center">
                                            <a href="./viewRTI.php?reqNo=<?= $row['request_no'] ?>" target="_blank" id="revertButton" class="btn btn-dark">View</a>
                                        </td>
                                    </tr>
                            <?php
                                    $i++;
                                } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
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
            $('#pending').DataTable();

            document.getElementById("pend-nav").style.fontWeight = 600;
            document.getElementById("pend-nav").classList.add("active");
            document.getElementById("dash-nav").classList.remove("active")
        </script>
    <?php
    }
    ?>

    <script>
        $(document).ready(function() {

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