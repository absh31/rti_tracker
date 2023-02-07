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
    $officer_id = $key['officer_id'];
    include '../nav.php';
    include './nav.php';
    if ($key['role_id'] == 4 && !empty($_GET['reqNo'])) {
        $reqNo = $_GET['reqNo'];
        $applicant_sql = $conn->prepare("SELECT a.*,r.*,act.activity_id FROM tblapplicant a, tblrequest r, tblactivity act WHERE a.applicant_id = r.request_applicant_id AND r.request_no = ? AND act.activity_request_no = r.request_no AND act.activity_completed != 1");
        $applicant_sql->bindParam(1, $reqNo);
        $applicant_sql->execute();
        $row = $applicant_sql->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col">
                    <h5>RTI Details:</h5>
                    <p style="font-size: 16px; font-weight: 600;">Personal Details</p>
                    <form method="POST" enctype="multipart/form-data" action="./Backend/processRTI.php">
                        <div class="mb-4">
                            <div class="form-group" id="fullNameDiv">
                                <label for='reqNo'><span class="text-danger">*</span> Request Numebr :</label>
                                <input type="text" class="form-control" name="reqNo" value="<?= $reqNo ?>" disabled>
                                <input type="text" class="form-control" name="reqNo" value="<?= $reqNo ?>" hidden required>
                                <input type="text" class="form-control" name="actId" value="<?= $row['activity_id'] ?>" required>
                            </div>
                            <br>
                            <div class="headingsall">

                                <div class="form-group" id="fullNameDiv">
                                    <label for='name'><span class="text-danger">*</span> Name :</label>
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
                            <p style="font-size: 16px; font-weight: 600;" class="mt-4">RTI Details</p>
                            <div class="headingsall">
                                <div class="form-group" id="departmentDiv">
                                    <label for="department" class="my-2">Department:</label>
                                    <select class="form-control" id="departmentSel" name="department" required disabled>
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
                                        <select class="form-control" name="YOI" id="year">
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
                                        ?>
                                        <a class="btn btn-dark mx-2" href="../bplfiles/<?php echo $docRow['document_title'] ?>" target="_blank">View BPL Card</a>
                                    </div>
                                    <br>
                                </div>
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

                                    $sql1 = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_to = ?");
                                    $sql1->bindParam(1, $reqNo);
                                    $sql1->bindParam(2, $officer_id);
                                    $sql1->execute();
                                    $a1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                    $docs = $a1['activity_documents'];

                                    $sql2 = $conn->prepare("SELECT * FROM tbldocument WHERE document_id IN ('$docs') AND document_type = '$docType'");
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
                                            <a class="btn btn-dark mx-2" href="../uploads/<?php echo $docRow['document_title'] ?>" target="_blank">View Attachment <?= $i++ ?></a>
                                        <?php
                                        } while ($docRow = $sql2->fetch(PDO::FETCH_ASSOC));
                                        ?>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                            <br>

                            <div class="headingsall">
                                <div class="form-group" id="textDiv">
                                    <label for='text'>Remarks for RTI Application :</label>
                                    <textarea name="remarksRTI" id="remarksRTI" class="form-control" rows="5" oninput="validateTextarea(this)" required></textarea>
                                </div>
                            </div>
                            <br>

                            <div class="headingsall">
                                <div class="form-group" id="textDiv">
                                    <label for='text'>Attachments for RTI Application :</label>
                                    <input class="form-control" type="file" name="attachments[]" required multiple>
                                </div>
                            </div>
                            <br>

                            <div class="headingsall">

                                <div class="form-group" id="phoneDiv">
                                    <label for='addFees'>Fees amount :</label>
                                    <input type="text" name="addFees" inputmode="numeric" id="addFees" class="form-control" oninput="validateNumber(this)" required>
                                </div>
                            </div>
                            <br>
                            <div class="headingsall">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                                    <span class="text-danger" id="recaptcha_error"></span>
                                </div>
                            </div>
                            <br>
                            <div class="headingsall">
                                <div class="form-group">
                                    <button class="btn btn-danger text-light" type="submit" name="rejectRTI">Reject</button>
                                    <button class="btn btn-success text-light mx-4" type="submit" name="revertRTI">Revert</button>
                                </div>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
            const validateNumber = function(usr) {
                var regexp = /^[0-9 ]+$/;
                var input = usr.value
                if (input != "") {
                    if (regexp.test(input)) {
                        if (input.length > 10) {
                            alert("Mobile number should contain only 10 digits!")
                            usr.value = input.slice(0, 10);
                        } else
                            return true
                    } else {
                        alert("Only numbers are allowed!")
                        usr.value = null;
                    }
                }
            }
        </script>
    <?php
    } else if ($key['role_id'] == 2 && !empty($_GET['reqNo'])) {
        $reqNo = $_GET['reqNo'];
        $applicant_sql = $conn->prepare("SELECT * FROM tblapplicant a, tblrequest r, tblappeal app WHERE a.applicant_id = r.request_applicant_id AND r.request_no = ? AND app.appeal_request_no = r.request_no");
        $applicant_sql->bindParam(1, $reqNo);
        $applicant_sql->execute();
        $row = $applicant_sql->fetch(PDO::FETCH_ASSOC);
    ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col">
                    <h5>RTI Details:</h5>
                    <p style="font-size: 16px; font-weight: 600;">Personal Details</p>
                    <form method="POST" enctype="multipart/form-data" action="./Backend/processRTI.php">
                        <div class="mb-4">
                            <div class="form-group" id="fullNameDiv">
                                <label for='reqNo'><span class="text-danger">*</span> Request Numebr :</label>
                                <input type="text" class="form-control" id="reqNo" name="reqNo" value="<?= $reqNo ?>" disabled>
                                <input type="text" class="form-control" name="reqNo" value="<?= $reqNo ?>" hidden required>
                            </div>
                            <br>
                            <div class="headingsall">

                                <div class="form-group" id="fullNameDiv">
                                    <label for='name'><span class="text-danger">*</span> Name :</label>
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
                                <label for='mobileNumber'><span class="text-danger">*</span> Mobile Number :</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+91</div>
                                    </div>
                                    <input disabled type="text" value="<?= $row['applicant_mobile'] ?>" name="mobileNumber" id="mobileNumber" class="form-control" minlength="10" maxlength="10" inputmode="numeric" oninput="validateNumber(this)" required>
                                </div>
                            </div>
                            <br>
                            <p style="font-size: 16px; font-weight: 600;" class="mt-4">RTI Details</p>
                            <div class="headingsall">
                                <div class="form-group" id="departmentDiv">
                                    <label for="department" class="my-2">Department:</label>
                                    <select class="form-control" id="departmentSel" name="department" required disabled>
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
                                <div class="form-group" id="textDiv">
                                    <label for='text'>Text for RTI request Application :</label>
                                    <textarea disabled name="reqText" id="reqText" class="form-control" rows="5" oninput="validateTextarea(this)"><?= $row['request_text'] ?></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="headingsall">
                                <div class="form-group">
                                    <label for='text'>Reason for appeal :</label>
                                    <textarea disabled class="form-control" oninput="validateTextarea(this)"><?= $row['appeal_reason'] ?></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="headingsall">
                                <div class="form-group">
                                    <label for='text'>Remarks for RTI Application :</label>
                                    <textarea name="remarksRTI" id="remarksRTI" class="form-control" rows="5" oninput="validateTextarea(this)" required></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="form-group" id="responseData">
                            </div>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-success text-light" type="submit" name="toNodal">Forward</button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include "../footer.php";
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
            $(document).ready(function() {
                var reqNo = $('#reqNo').val().toString();
                console.log(reqNo)
                $.ajax({
                    type: "POST",
                    url: "./Backend/RTItrack.php",
                    data: {
                        reqNo: reqNo
                    },
                    success: function(response) {
                        $('#responseData').html(response);
                        allData = response;
                    }
                })
            });
        </script>
<?php
    }
}
?>