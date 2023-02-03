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
                    <h5>Active RTIs</h5>
                    <p>Below is the list of RTIs which are currently under process.</p>
                    <table class="table table-striped table-bordered align-middle" id="pending1">
                        <thead>
                            <tr class="bg-dark text-light">
                                <td class="text-center">#</td>
                                <td class="text-center">RTI reference number</td>
                                <td class="text-center">RTI issue date</td>
                                <td class="text-center">RTI expiring date</td>
                                <td class="text-center">RTI Status</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $ThisTime = date("Y-m-d H:i:s");
                            $completed = 0;
                            $type1 = 'user';
                            $type2 = 'none';
                            $sql = $conn->prepare("SELECT * FROM tblrequest WHERE request_current_handler != ? AND request_current_handler != ?");
                            $sql->bindParam(1, $type1);
                            $sql->bindParam(2, $type2);
                            $sql->execute();
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $from = "nodal";
                                $sql2 = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_from = ? ORDER BY activity_id DESC ");
                                $sql2->bindParam(1, $row['request_no']);
                                $sql2->bindParam(2, $from);
                                $sql2->execute();
                                $row2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
                                // echo "<pre>";
                                // print_r($row2);
                                // echo $row2[0]['activity_to'];
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
                                            if ($sql2->rowCount() > 1) {
                                                $msg = "";
                                                foreach ($row2 as $singleRow) {
                                                    $sql3 = $conn->prepare("SELECT * FROM tblofficer o, tbldepartment d WHERE o.officer_department_id = d.department_id AND o.officer_id = ?");
                                                    $sql3->bindParam(1, $singleRow['activity_to']);
                                                    $sql3->execute();
                                                    $row3 = $sql3->fetch(PDO::FETCH_ASSOC);
                                                    // echo "<PRE>";
                                                    // print_r($row3);
                                                    if (!empty($row3))
                                                        $msg .= $singleRow['activity_status'] . " (" . $row3['department_name'] . ")" . " || ";
                                                    // echo $singleRow['activity_status'] . " (" . $row3['department_name'] . ")";
                                                }
                                                echo $msg;
                                            } else {
                                                foreach ($row2 as $singleRow) {
                                                    if ($singleRow['activity_to'] == 'Applicant') {
                                        ?>
                                                        <span class="text-success">
                                                            Reverted back to the applicant
                                                        </span>
                                        <?php
                                                    } else if ($singleRow['activity_to'] == 'Nodal Officer') {
                                                        echo "Forwarded to Nodal Officer";
                                                    } else {
                                                        $sql3 = $conn->prepare("SELECT * FROM tblofficer o, tbldepartment d WHERE o.officer_department_id = d.department_id AND o.officer_id = ?");
                                                        $sql3->bindParam(1, $singleRow['activity_to']);
                                                        $sql3->execute();
                                                        $row3 = $sql3->fetch(PDO::FETCH_ASSOC);
                                                        if (!empty($row3))
                                                            echo $singleRow['activity_status'] . " (" . $row3['department_name'] . ")";
                                                    }
                                                }
                                            }
                                        } else {
                                            echo "<span class='text-danger'>NO INFO AVAILABLE </span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank" id="<?= $row['request_no'] ?>" class="track btn btn-dark">Track</a>
                                        <a target="_blank" id="<?= $row['request_no'] ?>" class="btn btn btn-dark alertbtn" data-bs-toggle="modal" data-bs-target="#alertModal">Alert</a>
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
            <!-- Modal -->
            <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel">Notify Officer</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="./Backend/sendNotification.php" method="POST">
                            <div class="modal-body" id="modal-body">
                                <div class="form-group">
                                    <!-- <label for='text'>Officer IDs: </label> -->
                                    <input type="text" name="ids" hidden id="ids" class="form-control">
                                    <input type="text" name="reqNo" hidden id="req" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for='text'>Write your message: </label>
                                    <textarea name="msg" required class="form-control" rows="5" oninput="validateTextarea(this)"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" name="notifyOfficers" class="btn btn-success" value="Send notification">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <?php
        include '../footer.php';
        ?>

        <script>
            const validateTextarea = function(usr) {
                var regexp = /^[A-Za-z0-9.,\w-\n ]+$/;
                var input = usr.value
                if (input != "") {
                    if (regexp.test(input)) {
                        if (input.length > 3000) {
                            alert("Maximum characters limit reached!")
                            usr.value = input.slice(0, 3000);
                        } else
                            return true
                    } else {
                        alert("Special characters are not allowed!")
                        usr.value = null;
                    }
                }
            }
            document.getElementById("dash-nav").classList.remove("active")
            document.getElementById("actv-nav").classList.add("active")
            document.getElementById("actv-nav").style.fontWeight = 600

            $(document).ready(function() {
                $('#deptName').on('change', function() {
                    var deptID = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "./Backend/getOfficers.php",
                        data: {
                            deptID: deptID
                        },
                        dataType: "html",
                        success: function(data) {
                            $("#officerName").html(data);
                        }
                    })
                });
            });

            $(document).ready(function() {
                var table = $('#pending1').DataTable();
                var rows = table.rows().nodes()
                rows.$('.alertbtn').on('click', function(e) {
                    // console.log('hello')
                    var reqNo = $(this).attr('id')
                    $.ajax({
                        type: "POST",
                        url: "./Backend/RTInotify.php",
                        data: {
                            reqNo: reqNo
                        },
                        success: function(response) {
                            var res = JSON.parse(response)
                            console.log(reqNo);
                            $('#ids').val(res);
                            $('#req').val(reqNo);
                            // allData = response;
                        }
                    })
                })
            });
            $(document).ready(function() {
                var table = $('#pending1').DataTable();
                var rows = table.rows().nodes()
                rows.$('.track').on('click', function(e) {
                    $('.spinner-border').prop("hidden", null);
                    $('.btn-spinner-border').prop("disabled", true);
                    var reqNo = $(this).attr('id')
                    $.ajax({
                        type: "POST",
                        url: "./Backend/RTItrack.php",
                        data: {
                            reqNo: reqNo
                        },
                        success: function(response) {
                            $('.spinner-border').prop("hidden", true);
                            $('.btn-spinner-border').prop("disabled", false);
                            $('#responseData').html(response);
                            allData = response;
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
