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
    if ($key['officer_role_id'] == 3) {
        include '../nav.php';
        include './nav.php';
?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div id="responseData">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>ALL RTIs</h5>
                    <p>Below is the list of total RTIs received by the organization so far.</p>
                    <table class="table table-striped table-bordered align-middle" id="pending1">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">RTI Status</td>
                                <td class="text-center">View</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $ThisTime = date("Y-m-d H:i:s");
                            $completed = 0;
                            $sql = $conn->prepare("SELECT * FROM tblrequest");
                            $sql->execute();
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $sql2 = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? ORDER BY activity_id DESC LIMIT 1");
                                $sql2->bindParam(1, $row['request_no']);
                                $sql2->execute();
                                $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center" id="reqNo"><?= $row['request_no'] ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['request_time'])) ?></td>
                                    <td class="text-center"><?php echo $exp_date = date('d-m-Y', strtotime($row['request_time'] . ' + 30 days')) ?>
                                        <?php
                                        $diff = date_diff(date_create($ThisTime), date_create($exp_date));
                                        if ($row['request_completed'] == 1) {
                                        ?>
                                            <span class="text-success">
                                                (RTI completed)
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
                                    <td class="text-center" style="width: 300px;">
                                        <?php
                                        if (!empty($row2)) {
                                            if ($row2['activity_to'] == 'Applicant') {
                                        ?>
                                                <span class="text-success">
                                                    Reverted back to the applicant
                                                </span>
                                        <?php
                                            } else if ($row2['activity_to'] == 'Nodal Officer') {
                                                echo "Forwarded to Nodal Officer";
                                            } else {
                                                $sql3 = $conn->prepare("SELECT * FROM tblofficer o, tbldepartment d WHERE o.officer_department_id = d.department_id AND o.officer_id = ?");
                                                $sql3->bindParam(1, $row2['activity_to']);
                                                $sql3->execute();
                                                $row3 = $sql3->fetch(PDO::FETCH_ASSOC);
                                                if (!empty($row3))
                                                    echo $row2['activity_status'] . " (" . $row3['department_name'] . ")";
                                            }
                                        } else {
                                            echo "<span class='text-danger'>NO INFO AVAILABLE </span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank" id="<?= $row['request_no'] ?>" class="track btn btn-dark">Track</a>
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
        <br>
        <?php
        include '../footer.php';
        ?>

        <script>
            document.getElementById("dash-nav").classList.remove("active");
            document.getElementById("trck-nav").classList.add("active");
            document.getElementById("trck-nav").style.fontWeight = 600;

            $(document).ready(function() {
                var table = $('#pending1').DataTable();
                var rows = table.rows().nodes()
                rows.$('.track').on('click', function(e) {
                    $('.spinner-border').prop("hidden", null);
                    $('.btn-spinner-border').prop("disabled", true);
                    var reqNo = $(this).attr('id')
                    console.log(reqNo)
                    $.ajax({
                        type: "POST",
                        url: "./Backend/RTItrack.php",
                        data: {
                            reqNo: reqNo
                        },
                        success: function(response) {
                            $('.spinner-border').prop("hidden", true);
                            $('.btn-spinner-border').prop("disabled", false);
                            console.log(response);
                            // $("#table_id").dataTable().fnDestroy();
                            // $("#table_id").DataTable();
                            $('#responseData').html(response);
                            allData = response;
                            // $("#table_id").DataTable();
                            // $("#export_to_excel").show();
                        }
                    })
                })
            });
        </script>
        </body>

        </html>
    <?php
    } else if ($key['officer_role_id'] != 3) {
        include '../nav.php';
        include './nav.php';
    ?>

        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div id="responseData">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>All RTIs</h5>
                    <p>Below is the list of total RTIs received by the department so far.</p>
                    <table class="table table-striped table-bordered align-middle" id="pending1">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">RTI Status</td>
                                <td class="text-center">View</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $ThisTime = date("Y-m-d H:i:s");
                            $completed = 0;
                            $sql = $conn->prepare("SELECT * FROM tblrequest WHERE request_department_id = ?");
                            $sql->bindParam(1, $key['officer_department_id']);
                            $sql->execute();
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $sql2 = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? ORDER BY activity_id DESC LIMIT 1");
                                $sql2->bindParam(1, $row['request_no']);
                                $sql2->execute();
                                $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center" id="reqNo"><?= $row['request_no'] ?></td>
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
                                    <td class="text-center" style="width: 300px;">
                                        <?php
                                        if (!empty($row2)) {
                                            if ($row2['activity_to'] == 'Applicant') {
                                                echo "Reverted back to the applicant";
                                            } else if ($row2['activity_to'] == 'Nodal Officer') {
                                                echo "Forwarded to Nodal Officer";
                                            } else {
                                                $sql3 = $conn->prepare("SELECT * FROM tblofficer o, tbldepartment d WHERE o.officer_department_id = d.department_id AND o.officer_id = ?");
                                                $sql3->bindParam(1, $row2['activity_to']);
                                                $sql3->execute();
                                                $row3 = $sql3->fetch(PDO::FETCH_ASSOC);
                                                if (!empty($row3))
                                                    echo $row2['activity_status'] . " (" . $row3['department_name'] . ")";
                                            }
                                        } else {
                                            echo "<span class='text-danger'>NO INFO AVAILABLE </span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank" id="<?= $row['request_no'] ?>" class="track btn btn-dark">Track</a>
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
        <br>
        <?php
        include '../footer.php';
        ?>

        <script>
            document.getElementById("dash-nav").classList.remove("active");
            document.getElementById("trck-nav").classList.add("active");
            document.getElementById("trck-nav").style.fontWeight = 600;

            $(document).ready(function() {
                var table = $('#pending1').DataTable();
                var rows = table.rows().nodes()
                rows.$('.track').on('click', function(e) {
                    $('.spinner-border').prop("hidden", null);
                    $('.btn-spinner-border').prop("disabled", true);
                    var reqNo = $(this).attr('id')
                    console.log(reqNo)
                    $.ajax({
                        type: "POST",
                        url: "./Backend/RTItrack.php",
                        data: {
                            reqNo: reqNo
                        },
                        success: function(response) {
                            $('.spinner-border').prop("hidden", true);
                            $('.btn-spinner-border').prop("disabled", false);
                            console.log(response);
                            // $("#table_id").dataTable().fnDestroy();
                            // $("#table_id").DataTable();
                            $('#responseData').html(response);
                            allData = response;
                            // $("#table_id").DataTable();
                            // $("#export_to_excel").show();
                        }
                    })
                })
            });
        </script>
        </body>

        </html>
<?php
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
