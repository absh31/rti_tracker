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
    if ($key['role_id'] == 4) {
        $reqNo = $_GET['id'];
        $applicant_sql = $conn->prepare("SELECT * FROM tblapplicant a, tblrequest r WHERE a.applicant_id = r.request_applicant_id AND r.request_no = ?");
        $applicant_sql->bindParam(1, $reqNo);
        $applicant_sql->execute();
        $row = $applicant_sql->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>RTI Details:</h5>
                    <p style="font-size: 16px; font-weight: 600;">Personal Details</p>
                    <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/processRTI.php">
                        <div class="mb-4">
                            <div class="headingsall">

                                <div class="form-group" id="fullNameDiv">
                                    <label for='name'><span class="text-danger">*</span> Name :</label>
                                    <input type="text" name="reqNo" value="<?= $reqNo ?>" hidden>
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
                            <!-- <div class="headingsall">

                                <div class="form-group" id="addressDiv">
                                    <label for='address'><span class="text-danger">*</span> Address :</label>
                                    <textarea name="address" id="address" class="form-control" required oninput="validateTextarea(this)" rows="4"><?= $row['request_address'] ?></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="headingsall">

                                <div class="form-group" id="pincodeDiv">
                                    <label for='pincode'><span class="text-danger">*</span> Pincode :</label>
                                    <input disabled type="text" value="<?= $row['request_pincode'] ?>" name="pincode" id="pincode" class="form-control" oninput="validatePincode(this)">
                                </div>
                            </div>
                            <br>
                            <div class="headingsall">

                                <div class="radio d-md-flex">
                                    <label for="country" class="col-form-label"><span class="text-danger">*</span> Country:</label>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="country" onclick="funHide()" <?php echo $row['request_country'] == 'India' ? 'checked' : '' ?> id="indiaRadio" value="India">&nbsp;&nbsp;India
                                    </div>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="country" onclick="funShow()" <?php echo $row['request_country'] != 'India' ? 'checked' : '' ?> id="otherRadio" value="Other">&nbsp;&nbsp;Other
                                    </div>
                                </div>

                            </div>
                            <div class="headingsall" style="display: none;" id="countryDiv">
                                <br>
                                <div class="form-group">
                                    <label for='country'><span class="text-danger"><span class="text-danger">*</span> </span> Other Country Name:</label>
                                    <input disabled type="text" name="countryName" id="countryName" class="form-control" value="<?php echo $row['request_country'] != 'India' ?  $row['request_country'] : '' ?>" oninput="validateText(this)">
                                </div>
                            </div>
                            <?php $states  = array(
                                "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu & Kashmir", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Tripura", "Uttarakhand", "Uttar Pradesh", "West Bengal", "Andaman & Nicobar", "Chandigarh", "Dadra and Nagar Haveli", "Daman & Diu", "Delhi", "Lakshadweep", "Puducherry", "Other"
                            ); ?>
                            <br>
                            <div class="headingsall">

                                <div class="form-group" id="stateDiv">
                                    <label for="usr" class="my-2"><span class="text-danger">*</span> State:</label>
                                    <select class="form-control" id="stateSel" name="state" required>
                                        <option value="" disabled selected>Select State</option>
                                        <?php
                                        foreach ($states as $key) {
                                            if ($key == $row['request_state']) {
                                        ?>
                                                <option value="<?php echo $key; ?>" selected><?php echo $key; ?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                        <?php }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="headingsall">

                                <div class="radio d-md-flex">
                                    <label for="status" class="col-form-label"><span class="text-danger">*</span> Status:</label>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="status" <?php echo $row['request_place_type'] == "Urban" ? "checked" : ""; ?> id="urbanRadio" value="Urban">&nbsp;&nbsp;Urban
                                    </div>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="status" <?php echo $row['request_place_type'] == "Rural" ? "checked" : ""; ?> id="ruralrRadio" value="Rural">&nbsp;&nbsp;Rural
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="headingsall">

                                <div class="radio d-md-flex">
                                    <label for="education" class="col-form-label"><span class="text-danger">*</span> Educational Status:</label>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="educationalStatus" <?php echo $row['applicant_education'] == "Literate" ? "checked" : ""; ?> id="literateRadio" value="Literate">&nbsp;&nbsp;Literate
                                    </div>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="educationalStatus" <?php echo $row['applicant_education'] == "Illiterate" ? "checked" : ""; ?> id="illiterateRadio" value="Illiterate">&nbsp;&nbsp;Illiterate
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="headingsall">

                                <div class="radio d-md-flex">
                                    <label for="education" class="col-form-label"><span class="text-danger">*</span> Education:</label>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="education" <?php echo $row['applicant_more_education'] == "Below" ? "checked" : ""; ?> id="BelowRadio" value="Below">&nbsp;&nbsp;Below 12th
                                    </div>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="education" <?php echo $row['applicant_more_education'] == "12th" ? "checked" : ""; ?> id="passRadio" value="12th">&nbsp;&nbsp;12th Pass
                                    </div>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="education" <?php echo $row['applicant_more_education'] == "Graduate" ? "checked" : ""; ?> id="graduateRadio" value="Graduate">&nbsp;&nbsp;Graduate
                                    </div>
                                    <div class="form-check mx-md-5 my-2">
                                        <input disabled type="radio" name="education" <?php echo $row['applicant_more_education'] == "Above" ? "checked" : ""; ?> id="aboveRadio" value="Above">&nbsp;&nbsp;Above Graduate
                                    </div>
                                </div>

                            </div> -->
                            <p style="font-size: 16px; font-weight: 600;" class="mt-4">RTI Details</p>
                            <div class="headingsall">
                                <div class="form-group" id="departmentDiv">
                                    <label for="department" class="my-2">Department:</label>
                                    <select class="form-control" id="departmentSel" name="department" required>
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
                                    <label for="BPL" class="my-2">Do you have BPL Card?</label>
                                    <select class="form-control" id="bplSel" name="isBPL" required onchange="showBpl(this)">
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

                                <div class="headingsall" id="BPLNoDiv" style="display: none;">
                                    <div class="form-group">
                                        <label for='bpl'>BPL Card No. :</label>
                                        <input disabled type="text" name="bplCard" value="<?= $row['request_bpl_no'] ?>" id="bplCard" class="form-control">
                                        <br>
                                    </div>
                                </div>
                                <div class="headingsall" id="yearDiv" style="display: none;">
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
                                <div class="headingsall" id="issueAuthDiv" style="display: none;">
                                    <div class="form-group">
                                        <label for='issueAuth'>Issuing Authority :</label>
                                        <input disabled type="text" name="issueAuth" id="issueAuth" value="<?= $row['request_bpl_ia'] ?>" class="form-control" oninput="validateText(this)">
                                        <br>
                                    </div>
                                </div>
                                <div class="headingsall" id="bplCardDiv" style="display: none;">
                                    <div class="form-group" id="docBPL">
                                        <label for="docBPL">BPL Card :</label>
                                        <iframe id="iframeid" src='../bplFiles/<?php echo $UserName . "_resume.pdf"; ?>' width="100%" height="500px"></iframe>
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
                                    <label for='text'>Remarks for RTI Application :</label>
                                    <textarea name="remarksRTI" id="remarksRTI" class="form-control" rows="5" oninput="validateTextarea(this)" required></textarea>
                                </div>
                            </div>
                            <br>

                            <div class="headingsall">
                                <div class="form-group" id="textDiv">
                                    <label for='text'>Attachments for RTI Application :</label>
                                    <input class="form-control" type="file" name="attachments[]" multiple>
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
<?php
        include "../footer.php";
    }
}
?>