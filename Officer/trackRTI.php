<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    include '../nav.php';
    include './nav.php';
    if ($key['role_id'] == 3) {
?>
        <br>
        <div class="container-fluid px-5">
            <!-- <div class="row">
                <div class="col-6">
                    <h5>Track RTI</h5>
                    <div class="mb-3">
                        <label for="reqNo" class="form-label"><span class="text-danger">*</span> RTI Request Reference Number</label>
                        <input type="text" class="form-control" id="reqNo" name="reqNo" required>
                    </div>
                    <button class="btn-spinner-border btn btn-dark py-2 submit" type="submit" name="trackRTI" id="trackRTI">
                        <span class="spinner-border spinner-border-sm" hidden></span> Track RTI
                    </button>
                </div>
            </div>
            <br> -->
            <div class="row">
                <div id="responseData">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>ALL RTIs</h5>
                    <table class="table table-striped table-bordered" id="pending1">
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
                                    <td class="text-center" id="reqNo" aria-valuemax=""><?= $row['request_no'] ?></td>
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
                                    <td class="text-center"><?= $row2['activity_type'] ?></td>
                                    <td class="text-center">
                                        <a target="_blank" id="trackRTI" class="btn btn-dark">Track</a>
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
        <?php
        include '../footer.php';
        ?>

        <script>
            document.getElementById("dash-nav").classList.remove("active");
            document.getElementById("trck-nav").classList.add("active");
            document.getElementById("trck-nav").style.fontWeight = 600;

            $(document).ready(function() {
                $('#pending1').DataTable();
                $('#trackRTI').on('click', function(e) {
                    console.log("HELLo")
                    $('.spinner-border').prop("hidden", null);
                    $('.btn-spinner-border').prop("disabled", true);
                    var reqNo = $('#reqNo').val().toString();
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
}
