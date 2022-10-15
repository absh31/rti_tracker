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
?>
    <br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-8">
                <h5>Add RTI</h5>
                <p style="font-size: 16px; font-weight: 600;">Personal Details</p>
                <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/addRTI.php">
                    <div class="mb-4">
                        <div class="headingsall">

                            <div class="form-group" id="fullNameDiv">
                                <label for='name'><span class="text-danger">*</span> Name :</label>
                                <input type="text" name="name" oninput="validateText(this)" id="name" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="form-group" id="emailAddDiv">
                                <label for='email'><span class="text-danger">*</span> Email Address :</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="form-group" id="confirmEmailAddDiv">
                                <label for='email'><span class="text-danger">*</span> Confirm Email :</label>
                                <input type="email" name="confirmEmail" id="confirmEmail" class="form-control" required oninput="compareEmail(this)">
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
                                <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" minlength="10" maxlength="10" inputmode="numeric" oninput="validateNumber(this)" required>
                            </div>
                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="form-group" id="phoneDiv">
                                <label for='phoneNumber'>Phone Number :</label>
                                <input type="text" name="phoneNumber" minlength="10" maxlength="10" inputmode="numeric" id="phoneNumber" class="form-control" oninput="validateNumber(this)">
                            </div>
                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="radio d-md-flex">
                                <label for="s_name" class="col-form-label"><span class="text-danger">*</span> Gender:</label>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="gender" checked id="maleRadio" value="Male">&nbsp;&nbsp;Male
                                </div>
                                <div class="form-check mx-mf-5 my-2">
                                    <input type="radio" name="gender" id="femaleRadio" value="Female">&nbsp;&nbsp;Female
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="gender" id="otherRadio" value="Other">&nbsp;&nbsp;Other
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="form-group" id="addressDiv">
                                <label for='address'><span class="text-danger">*</span> Address :</label>
                                <textarea name="address" id="address" class="form-control" required oninput="validateTextarea(this)" rows="4"></textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="headingsall">

                            <div class="form-group" id="pincodeDiv">
                                <label for='pincode'><span class="text-danger">*</span> Pincode :</label>
                                <input type="text" name="pincode" id="pincode" class="form-control" oninput="validatePincode(this)">
                            </div>
                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="radio d-md-flex">
                                <label for="country" class="col-form-label"><span class="text-danger">*</span> Country:</label>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="country" onclick="funHide()" checked id="indiaRadio" value="India">&nbsp;&nbsp;India
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="country" onclick="funShow()" id="otherRadio" value="Other">&nbsp;&nbsp;Other
                                </div>
                            </div>

                        </div>
                        <div class="headingsall" style="display: none;" id="countryDiv">
                            <br>
                            <div class="form-group">
                                <label for='country'><span class="text-danger"><span class="text-danger">*</span> </span> Other Country Name:</label>
                                <input type="text" name="countryName" id="countryName" class="form-control" oninput="validateText(this)">
                            </div>
                        </div>
                        <?php $states  = array(
                            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu & Kashmir", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Tripura", "Uttarakhand", "Uttar Pradesh", "West Bengal", "Andaman & Nicobar", "Chandigarh", "Dadra and Nagar Haveli", "Daman & Diu", "Delhi", "Lakshadweep", "Puducherry", "Other"
                        ); ?>
                        <br>
                        <div class="headingsall">

                            <div class="form-group" id="stateDiv">
                                <label for="usr" class="my-2"><span class="text-danger">*</span> State:</label>
                                <!-- <input type="text" onpaste="return validateText(this)" class="form-control" id="State" placeholder="Enter State Name" required> -->
                                <select class="form-control" id="stateSel" name="state" required>
                                    <option value="" disabled selected>Select State</option>
                                    <?php
                                    foreach ($states as $key) {
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
                                    <input type="radio" name="status" checked id="urbanRadio" value="Urban">&nbsp;&nbsp;Urban
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="status" id="ruralrRadio" value="Rural">&nbsp;&nbsp;Rural
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="radio d-md-flex">
                                <label for="education" class="col-form-label"><span class="text-danger">*</span> Educational Status:</label>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="educationalStatus" checked id="literateRadio" value="Literate">&nbsp;&nbsp;Literate
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="educationalStatus" id="illiterateRadio" value="Illiterate">&nbsp;&nbsp;Illiterate
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="headingsall">

                            <div class="radio d-md-flex">
                                <label for="education" class="col-form-label"><span class="text-danger">*</span> Education:</label>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="education" checked id="BelowRadio" value="Below">&nbsp;&nbsp;Below 12th
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="education" id="passRadio" value="12th">&nbsp;&nbsp;12th Pass
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="education" checked id="graduateRadio" value="Graduate">&nbsp;&nbsp;Graduate
                                </div>
                                <div class="form-check mx-md-5 my-2">
                                    <input type="radio" name="education" id="aboveRadio" value="Above">&nbsp;&nbsp;Above Graduate
                                </div>
                            </div>

                        </div>
                        <br>
                        <hr>
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
                                <input type="text" name="bplCard" id="bplCard" class="form-control">
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
                                <label for='text'>Text for RTI request Application :</label>
                                <textarea name="reqText" id="reqText" class="form-control" rows="5" oninput="validateTextarea(this)"></textarea>
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
                                <button class="btn btn-dark text-light" type="submit" name="personalRTI">Submit</button>
                            </div>
                        </div>
                        <br>
                    </div>
                </form>
            </div>
        </div>
        <br>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>
    <script type="text/javascript">
        document.getElementById("add-nav").style.fontWeight = 600;
        document.getElementById("add-nav").classList.add("active");
        document.getElementById("dash-nav").classList.remove("active")
        document.getElementById("pend-nav").classList.remove("active")
        document.getElementById("trck-nav").classList.remove("active")

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
            var regexp = /^[A-Za-z0-9. ]+$/;
            var input = usr.value
            console.log(input);
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

        const validatePincode = function(usr) {
            var regexp = /^[0-9 ]+$/;
            var input = usr.value
            if (input != "") {
                if (regexp.test(input)) {
                    if (input.length > 6) {
                        alert("Pincode should contain only 6 digits!")
                        usr.value = input.slice(0, 6);
                    } else
                        return true
                } else {
                    alert("Only numbers are allowed!")
                    usr.value = null;
                }
            }
        }

        const compareEmail = function(usr) {
            var input1 = document.getElementById("email").value;
            var input2 = usr.value
            if (input1 == input2) {
                document.getElementById("hiddenSpan").style.display = "none";
            } else {
                document.getElementById("hiddenSpan").style.display = "block";
            }
        }

        const funShow = function() {
            document.getElementById("countryDiv").style.display = "block";
            const input = document.getElementById('countryName');
            input.setAttribute('required', '');
        }

        const funHide = function() {
            document.getElementById("countryDiv").style.display = "none";
            const input = document.getElementById('countryName');
            input.removeAttribute('required')
        }

        const validateTextarea = function(usr) {
            var regexp = /^[A-Za-z0-9.,\w-\n ]+$/;
            var input = usr.value
            if (input != "") {
                if (regexp.test(input))
                    return true
                else {
                    alert("Special characters are not allowed!")
                    usr.value = null;
                }
            }
        }
    </script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
</body>

</html>