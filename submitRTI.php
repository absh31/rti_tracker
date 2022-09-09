<?php
include './header.php';
include './nav.php';
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col">
            <h5>Online RTI Form</h5>
            <p style="font-size: 20px;">Personal Details</p>
            <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/personalRTI.php">
                <div class="px-3 mb-4 pt-3 apply" style="border: 1px solid #003865">
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="fullNameDiv">
                            <label for='name'><span class="text-danger">*</span> Name :</label>
                            <input type="text" name="name" oninput="validateText(this)" id="name" class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="emailAddDiv">
                            <label for='email'><span class="text-danger">*</span> Email Address :</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="confirmEmailAddDiv">
                            <label for='email'><span class="text-danger">*</span> Confirm Email :</label>
                            <input type="email" name="confirmEmail" id="confirmEmail" class="form-control" required oninput="compareEmail(this)">
                            <span class="text-danger" style="display: none;" id="hiddenSpan">Email doesn't match!</span>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="mobileDiv">
                            <label for='mobileNumber'>Mobile Number :</label>
                            <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" oninput="validateNumber(this)">
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="phoneDiv">
                            <label for='phoneNumber'>Phone Number :</label>
                            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" oninput="validateNumber(this)">
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

                        <div class="col-sm-6 form-group" id="addressDiv">
                            <label for='address'><span class="text-danger">*</span> Address :</label>
                            <textarea name="address" id="address" class="form-control" required oninput="validateTextarea(this)" rows="4"></textarea>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="pincodeDiv">
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
                        <div class="col-sm-6 form-group">
                            <label for='country'><span class="text-danger"><span class="text-danger">*</span> </span> Other Country Name:</label>
                            <input type="text" name="countryName" id="countryName" class="form-control" oninput="validateText(this)">
                        </div>
                    </div>
                    <?php $states  = array(
                        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu & Kashmir", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Tripura", "Uttarakhand", "Uttar Pradesh", "West Bengal", "Andaman & Nicobar", "Chandigarh", "Dadra and Nagar Haveli", "Daman & Diu", "Delhi", "Lakshadweep", "Puducherry", "Other"
                    ); ?>
                    <br>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="stateDiv">
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
                    <div class="headingsall">
                        <div class="col-sm-6 form-group">
                            <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                            <span class="text-danger" id="recaptcha_error"></span>
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">
                        <div class="col-sm-6 form-group">
                            <button class="btn btn-dark text-light" type="submit" name="personalRTI">Submit</button>
                        </div>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<?php
include './footer.php';
?>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
    const validateText = function(usr) {
        var regexp = /^[A-Za-z0-9. ]+$/;
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
</body>

</html>