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
    if (!empty($_GET['reqNo'])) {
        $reqNo = $_GET['reqNo'];
        $applicant_sql = $conn->prepare("SELECT a.*,r.*,act.activity_id FROM tblapplicant a, tblrequest r, tblactivity act WHERE a.applicant_id = r.request_applicant_id AND r.request_no = ? AND act.activity_request_no = r.request_no AND act.activity_completed != 1");
        $applicant_sql->bindParam(1, $reqNo);
        $applicant_sql->execute();
        $row = $applicant_sql->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {
?>
            <br>
            <div class="container-fluid px-5">
                <div class="row">
                    <div class="col">
                        <h5>RTI Details</h5>
                        <br>
                        <div id="wrapper">
                            <div class="mb-4">
                                <div class="form-group" id="fullNameDiv">
                                    <label for='name'><span class="text-danger">*</span> Request Number :</label>
                                    <input type="text" class="form-control" name="reqNo" value="<?= $reqNo ?>" disabled>
                                </div>
                                <br>
                                <div class="headingsall">
                                    <div class="form-group" id="fullNameDiv">
                                        <label for='name'><span class="text-danger">*</span> Name :</label>
                                        <input type="text" name="confirm" value="<?= $confirm ?>" hidden>
                                        <input type="text" readonly value="<?= $row['applicant_name'] ?>" name="name" oninput="validateText(this)" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">

                                    <div class="form-group" id="emailAddDiv">
                                        <label for='email'><span class="text-danger">*</span> Email Address :</label>
                                        <input type="email" value="<?= $row['applicant_email'] ?>" name="email" id="email" class="form-control" readonly required>
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">

                                    <div class="form-group" id="confirmEmailAddDiv">
                                        <label for='email'><span class="text-danger">*</span> Confirm Email :</label>
                                        <input type="email" value="<?= $row['applicant_email'] ?>" name="confirmEmail" id="confirmEmail" class="form-control" disabled required oninput="compareEmail(this)">
                                        <span class="text-danger" style="display: none;" id="hiddenSpan">Email doesn't match!</span>
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">
                                    <label for='mobileNumber'><span class="text-danger">*</span> Mobile Number :</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+91</div>
                                        </div>
                                        <input disabled type="text" value="<?= $row['applicant_mobile'] ?>" name="mobileNumber" id="mobileNumber" class="form-control" minlength="10" maxlength="10" inputmode="numeric" oninput="validateNumber(this)" required>
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">

                                    <div class="form-group" id="phoneDiv">
                                        <label for='phoneNumber'>Phone Number :</label>
                                        <input disabled type="text" value="<?= $row['applicant_phone'] ?>" name="phoneNumber" minlength="10" maxlength="10" inputmode="numeric" id="phoneNumber" class="form-control" oninput="validateNumber(this)">
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">

                                    <div class="radio d-md-flex">
                                        <label for="s_name" class="col-form-label"><span class="text-danger">*</span> Gender:</label>
                                        <div class="form-check mx-md-5 my-2">
                                            <input disabled type="radio" name="gender" checked id="maleRadio" value="Male">&nbsp;&nbsp;Male
                                        </div>
                                        <div class="form-check mx-mf-5 my-2">
                                            <input disabled type="radio" name="gender" id="femaleRadio" value="Female">&nbsp;&nbsp;Female
                                        </div>
                                        <div class="form-check mx-md-5 my-2">
                                            <input disabled type="radio" name="gender" id="otherRadio" value="Other">&nbsp;&nbsp;Other
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <p style="font-size: 16px; font-weight: 600;" class="mt-4">Application Details</p>
                                <div class="headingsall">
                                    <div class="form-group" id="departmentDiv">
                                        <label for="department" class="my-2">Department:</label>
                                        <select class="form-control" id="departmentSel" name="department" disabled required>
                                            <option value="" disabled selected>Select Department</option>
                                            <?php
                                            $sql = $conn->prepare("SELECT * FROM `tbldepartment`");
                                            $sql->execute();
                                            while ($key = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                if ($key['department_id'] == $row['request_department_id']) {
                                            ?>
                                                    <option value="<?php echo $key['department_id']; ?>" selected><?php echo $key['department_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                                <option value="<?php echo $key['department_id']; ?>"><?php echo $key['department_name']; ?></option>
                                            <?php }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">
                                    <div class="form-group" id="bplDiv">
                                        <label for="BPL" class="my-2">Does applicant have BPL Card?</label>
                                        <select class="form-control" id="bplSel" name="isBPL" disabled required onchange="showBpl(this)">
                                            <option value="" disabled selected>Select option</option>
                                            <option value="Yes" <?php echo $row['request_from_bpl'] == "Yes" ? "selected" : ""; ?>>Yes</option>
                                            <option value="No" <?php echo $row['request_from_bpl'] == "No" ? "selected" : ""; ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <?php
                                if ($row['request_from_bpl'] == "Yes") {
                                ?>
                                    <div class="headingsall" id="BPLNoDiv">
                                        <div class="form-group">
                                            <label for='bpl'>BPL Card No. :</label>
                                            <input disabled type="text" name="bplCard" value="<?= $row['request_bpl_no'] ?>" id="bplCard" class="form-control">
                                            <br>
                                        </div>
                                    </div>
                                    <div class="headingsall" id="yearDiv">
                                        <div class="form-group">
                                            <label for='year'>Year of Issue :</label>
                                            <select class="form-control" name="YOI" id="year" disabled>
                                                <option value="" disabled selected>Select Year</option>
                                                <?php
                                                $year = date("Y");
                                                for ($i = $year - 5; $i <= $year; $i++) {
                                                    if ($i == $row['request_bpl_yoi']) {
                                                ?>
                                                        <option value="<?= $i ?>" selected><?= $i ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="headingsall" id="issueAuthDiv">
                                        <div class="form-group">
                                            <label for='issueAuth'>Issuing Authority :</label>
                                            <input disabled type="text" name="issueAuth" id="issueAuth" value="<?= $row['request_bpl_ia'] ?>" class="form-control" oninput="validateText(this)">
                                            <br>
                                        </div>
                                    </div>
                                    <div class="headingsall" id="bplCardDiv">
                                        <div class="form-group" id="docBPL">
                                            <label for="docBPL">BPL Card :</label>
                                            <?php
                                            $docType = 'bplcard';
                                            $docSql = $conn->prepare("SELECT * FROM tbldocument WHERE document_request_id = ? AND document_type = ?");
                                            $docSql->bindParam(1, $reqNo);
                                            $docSql->bindParam(2, $docType);
                                            $docSql->execute();
                                            $docRow = $docSql->fetch(PDO::FETCH_ASSOC);
                                            if (empty($docRow)) {
                                            ?>
                                                Document not available
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-dark mx-2" href="../bplfiles/<?php echo $docRow['document_title'] ?>" target="_blank">View BPL Card</a>
                                            <?php
                                            }
                                            // print_r($docRow);
                                            ?>
                                        </div>
                                        <br>
                                        <div class="form-group" id="fullNameDiv">
                                            <label for='name'><span class="text-danger">*</span> Is application fees paid?</label>
                                            <input type="text" class="form-control" name="reqNo" value="Not Applicable" disabled>
                                        </div>
                                        <br>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="form-group" id="fullNameDiv">
                                        <label for='name'><span class="text-danger">*</span> Is application fees paid?</label>
                                        <input type="text" class="form-control" name="reqNo" value="<?php echo $row['request_is_base_pay'] == 0 ? "Not Paid" : "Paid"; ?>" disabled>
                                    </div>
                                    <br>
                                <?php
                                }
                                ?>
                                <div class="headingsall">
                                    <div class="form-group" id="textDiv">
                                        <label for='text'>Text for RTI request Application :</label>
                                        <textarea disabled name="reqText" id="reqText" class="form-control" rows="5" oninput="validateTextarea(this)"><?= $row['request_text'] ?></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="headingsall">
                                    <div class="form-group" id="textDiv">
                                        <label for='text'>Attachments:</label>
                                        <?php
                                        $docType = 'attachment';
                                        $activity_to = "Nodal Officer";
                                        $sql1 = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_to = ?");
                                        $sql1->bindParam(1, $reqNo);
                                        $sql1->bindParam(2, $activity_to);
                                        $sql1->execute();
                                        $a1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                        if (!empty($a1)) {
                                            $docs = $a1['activity_documents'];
                                            $sql2 = $conn->prepare("SELECT * FROM tbldocument WHERE document_id IN ('$docs') AND document_type = '$docType'");
                                            $sql2->execute();
                                            $docRow = $sql2->fetch(PDO::FETCH_ASSOC);
                                            $i = 1;
                                            if (!empty($docRow)) {
                                                do {
                                        ?>
                                                    <a class="btn btn-dark mx-2" href="../uploads/<?php echo $docRow['document_title'] ?>" target="_blank">View Attachment <?= $i++ ?></a>
                                                <?php
                                                } while ($docRow = $sql2->fetch(PDO::FETCH_ASSOC));
                                            } else {
                                                ?>
                                                No Attachmentss
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        } else {
                                        ?>
                                            No Attachmentss
                                        <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <br>
                        </div>
                    </div>
                </div>
                <form enctype="multipart/form-data" action="./Backend/forwardRTI.php" method="POST" id="add_dept">
                    <div class="row">
                        <div class="col">
                            <div id="mainForm">
                                <table class="table align-middle table-bordered" id="forward_dept">
                                    <h5>Forward to Department</h5>
                                    <br>
                                    <input class="form-control" type="text" name="reqNo" value="<?php echo $_GET['reqNo'] ?>" hidden required>
                                    <input class="form-control" type="text" name="email" value="<?= $row['applicant_email'] ?>" hidden required>
                                    <input class="form-control" type="text" name="actId" value="<?= $row['activity_id'] ?>" hidden required>
                                    <tr>
                                        <td>Department Name</td>
                                        <td>
                                            <select name="officerDept[]" id="deptName" class="form-control" required>
                                                <option disabled selected>Choose Department</option>
                                                <?php
                                                $deptSql = $conn->prepare("SELECT * FROM tbldepartment WHERE is_active = 1");
                                                $deptSql->execute();
                                                $departments = $deptSql->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($departments as $department) {
                                                ?>
                                                    <option value="<?php echo $department['department_id'] ?>"><?php echo $department['department_name'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Department Officer</td>
                                        <td>
                                            <select name="officerName[]" id="officerName" class="form-control" required>
                                                <option disabled selected>Choose Officer</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Remarks</td>
                                        <td><textarea class="form-control" rows="5" name="forwardRemarks[]"></textarea></td>
                                    </tr>
                                </table>
                            </div>
                            <table class="table align-middle table-bordered">
                                <tr>
                                    <td>Attach Files</td>
                                    <td><input class="form-control" type="file" name="attachments[]" multiple>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="d-flex justify-content-around">
                                            <a href="./pendingRTI.php" class="btn btn-danger px-4">Cancel</a>
                                            <input class="btn btn-success" type="submit" name="forwardRTI" value="Forward">
                                            <a class="btn btn-primary text-light" id="dept"><i class="fa fa-plus"></i> Add Officer</a>
                                            <a class="btn btn-danger text-light" id="remove_dept"><i class="fa fa-trash-alt"></i> Remove Officer</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </div>
                        <div class="col">
                            <table class="table align-top table-bordered">
                                <h5>Close RTI</h5>
                                <br>
                                <tr>
                                    <td>
                                        <label for='text'>Remarks :</label>
                                    </td>
                                    <td>
                                        <textarea name="remarks" class="form-control" rows="5" oninput="validateTextarea(this)"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle" colspan="2">
                                        <a href="./pendingRTI.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                                        <input class="btn btn-dark px-5" type="submit" name="closeRTI" value="Close RTI">
                                    </td>
                                </tr>
                            </table>
                        </div>
                </form>
            </div>
            </div>
            </div>
            <br><br>
            <?php include '../footer.php'; ?>
            <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->

            <script>
                document.getElementById("pend-nav").style.fontWeight = 600;
                document.getElementById("pend-nav").classList.add("active");
                document.getElementById("dash-nav").classList.remove("active")
                document.getElementById("add-nav").classList.remove("active")
                document.getElementById("trck-nav").classList.remove("active")
                var i = 0;
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
                    $("#dept").on('click', function(e) {
                        i += 1;
                        var newElement = $("#forward_dept").clone();
                        newElement.find("#deptName").val();
                        newElement.find("#deptName").attr("id", "deptName" + i)
                        newElement.find("#officerName").val();
                        newElement.find("#officerName").attr("id", "officerName" + i)
                        newElement.appendTo("#mainForm")
                        // $("#forward_dept").clone(true, true).appendTo($("#mainForm"))
                        for (var n = i; n <= i; n++) {
                            $('#deptName' + i).on('change', function() {
                                var deptID = $(this).val();
                                $.ajax({
                                    method: "POST",
                                    url: "./Backend/getOfficers.php",
                                    data: {
                                        deptID: deptID
                                    },
                                    dataType: "html",
                                    success: function(data) {
                                        $("#officerName" + i).html(data);
                                    }
                                })
                            });
                        }
                    })

                    $("#remove_dept").on('click', function(e) {
                        e.preventDefault();
                        if (i != 0) {
                            i -= 1;
                            $("#forward_dept:last-child").remove();
                        }
                    })
                });
            </script>
            </body>

            </html>
<?php
        } else {
            echo "<script>window.alert(`No request found!`)</script>";
            echo "<script>window.open('./pendingRTI.php','_self')</script>";
        }
    }
}
