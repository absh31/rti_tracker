<?php
session_start();
include './header.php';
include './nav.php';
if (!isset($_SESSION['otpVerified'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
    include './connection.php';
    if (isset($_SESSION['existingUser'])) {
        // print_r($_POST);
        $name = $_SESSION['name'] = $_POST['name'];
        $email = $_SESSION['email'] = $_POST['email'];
        $mobileNumber = $_SESSION['mobileNumber'] = $_POST['mobileNumber'];
        $phoneNumber = $_SESSION['phoneNumber'] = $_POST['phoneNumber'];
        $gender = $_SESSION['gender'] = $_POST['gender'];
        $address = $_SESSION['address'] = $_POST['address'];
        $pincode = $_SESSION['pincode'] = $_POST['pincode'];
        $country = $_SESSION['country'] = $_POST['country'];
        $countryName = $_SESSION['countryName'] = $_POST['countryName'];
        if ($country == "Other") {
            $country = $countryName;
            $_SESSION['country'] = $country = $_POST['country'];
        }
        $state = $_SESSION['state'] = $_POST['state'];
        $status = $_SESSION['status'] = $_POST['status'];
        $eduStatus = $_SESSION['educationalStatus'] = $_POST['educationalStatus'];
        $edu = $_SESSION['education'] = $_POST['education'];
    }
?>
    <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/requestRTI.php">
        <div class="container-fluid px-5">
            <br>
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-9">
                    <h3><b>Online RTI Form</b></h3>
                    <p>Request Details</p>
                    <div class="headingsall">
                        <div class="form-group" id="departmentDiv">
                            <label for="department" class="my-2">Department:</label>
                            <select class="form-control" id="departmentSel" name="department" required>
                                <option value="" disabled selected>Select Department</option>
                                <?php
                                $sql = $conn->prepare("SELECT * FROM `tbldepartment`");
                                $sql->execute();
                                while ($key = $sql->fetch(PDO::FETCH_ASSOC)) {
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
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall" id="BPLNoDiv" style="display: none;">
                        <div class="form-group">
                            <label for='bpl'>BPL Card No. :</label>
                            <input type="text" name="bplCard" id="bplCard" class="form-control" oninput="validateNumber(this)">
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
                                ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <!-- <input type="text" name="YOI" id="year" class="form-control" oninput="validateNumber(this)"> -->
                            <br>
                        </div>
                    </div>
                    <div class="headingsall" id="issueAuthDiv" style="display: none;">
                        <div class="form-group">
                            <label for='issueAuth'>Issuing Authority :</label>
                            <input type="text" name="issueAuth" id="issueAuth" class="form-control" oninput="validateText(this)">
                            <br>
                        </div>
                    </div>
                    <div class="headingsall" id="bplCardDiv" style="display: none;">
                        <div class="form-group" id="docBPL">
                            <label for="docBPL">BPL Card :</label>
                            <input type="file" accept="image/jpe,image/png,image/jpeg,image/jpg,application/pdf" name="docBPL" id="docBPL" class="form-control">
                            <label class="mt-2 text-danger">Supported file formats: jpe, png, jpeg, jpg, pdf <br>Maximum file size: 2 MB</label>
                        </div>
                        <br>
                    </div>
                    <div class="headingsall">
                        <div class="form-group" id="textDiv">
                            <label for='text'>Text for RTI Application :</label>
                            <textarea name="reqText" id="reqText" class="form-control" rows="5" oninput="validateTextarea(this)"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">
                        <div class="col-sm-6 form-group">
                            <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                            <span class="text-danger" id="recaptcha_error"></span>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">
                        <div class="form-group">
                            <button type="submit" name="requestRTI" class="btn btn-dark text-light">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
    include './footer.php';
    ?>
    <script type="text/javascript">
        document.getElementById("rti-nav").classList.add("active");
        document.getElementById("rti-nav").style.fontWeight = 600;
        document.getElementById("home-nav").classList.remove("active");
        document.getElementById("apel-nav").classList.remove("active");
        document.getElementById("status-nav").classList.remove("active");
        document.getElementById("history-nav").classList.remove("active");
        document.getElementById("contact-nav").classList.remove("active");

        function showBpl(input) {
            var value = input.value
            if (value == 'Yes') {
                document.getElementById("BPLNoDiv").style.display = "block";
                document.getElementById("yearDiv").style.display = "block";
                document.getElementById("issueAuthDiv").style.display = "block";
                document.getElementById("bplCardDiv").style.display = "block";
                document.getElementById("bplCard").setAttribute('required', '');
                document.getElementById("docBPL").setAttribute('required', '');
                document.getElementById("year").setAttribute('required', '');
                document.getElementById("issueAuth").setAttribute('required', '');
            } else {
                document.getElementById("BPLNoDiv").style.display = "none";
                document.getElementById("yearDiv").style.display = "none";
                document.getElementById("issueAuthDiv").style.display = "none";
                document.getElementById("bplCardDiv").style.display = "none";
                document.getElementById("bplCard").removeAttribute('required');
                document.getElementById("docBPL").removeAttribute('required');
                document.getElementById("year").removeAttribute('required');
                document.getElementById("issueAuth").removeAttribute('required');
            }
        }

        const validateText = function(usr) {
            var regexp = /^[A-Za-z0-9.\-\/ ]+$/;
            var input = usr.value
            if (input != "") {
                if (regexp.test(input)) {
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
            console.log(input.length)
            if (input != "") {
                if (regexp.test(input)) {
                    if (input.length > 30) {
                        alert("Maximum length reached!")
                        usr.value = input.slice(0, 30);
                    } else {
                        return true
                    }
                } else {
                    alert("Only numbers are allowed!")
                    usr.value = null;
                }
            }
        }

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
    </script>
<?php

}
?>