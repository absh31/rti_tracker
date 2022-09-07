<?php
include './header.php';
include './nav.php';
?>

<body>
    <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/personalRTI.php">
        <div id="page1">
            <div class="col-md-8 mx-auto my-5">
                <div class="alert text-center alert-dismissible fade show" role="alert">
                    <h2><b>Online RTI Form</b></h2>
                </div>
                <h3 class="dept-title">Personal Details</h3>
                <div class="px-3 mb-4 pt-3 apply" style="border: 1px solid #003865">
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="fullNameDiv">
                            <label for='name'>*Name :</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="emailAddDiv">
                            <label for='email'>*Email Address :</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="confirmEmailAddDiv">
                            <label for='email'>*Confirm Email :</label>
                            <input type="email" name="confirmEmail" id="confirmEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="mobileDiv">
                            <label for='mobileNumber'>Mobile Number :</label>
                            <input type="text" name="mobileNumber" id="mobileNumber" class="form-control">
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="phoneDiv">
                            <label for='phoneNumber'>Phone Number :</label>
                            <input type="text" name="phoneNumebr" id="phoneNumber" class="form-control">
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="radio d-md-flex">
                            <label for="s_name" class="col-form-label">*Gender:</label>
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
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="addressDiv">
                            <label for='address'>*Address :</label>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="pincodeDiv">
                            <label for='pincode'>*Pincode :</label>
                            <input type="number" name="pincode" id="pincode" class="form-control" required>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="radio d-md-flex">
                            <label for="country" class="col-form-label">*Country:</label>
                            <div class="form-check mx-md-5 my-2">
                                <input type="radio" name="country" checked id="indiaRadio" value="India">&nbsp;&nbsp;India
                            </div>
                            <div class="form-check mx-md-5 my-2">
                                <input type="radio" name="country" id="otherRadio" value="Other">&nbsp;&nbsp;Other
                            </div>
                        </div>

                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="countryDiv">
                            <label for='country'>*Other Country Name:</label>
                            <input type="text" name="countryName" id="countryName" class="form-control" required>
                        </div>
                    </div>
                    <?php $states  = array(
                        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
                        "Goa",
                        "Gujarat",
                        "Haryana",
                        "Himachal Pradesh",
                        "Jammu & Kashmir",
                        "Jharkhand",
                        "Karnataka",
                        "Kerala",
                        "Madhya Pradesh",
                        "Maharashtra",
                        "Manipur",
                        "Meghalaya",
                        "Mizoram",
                        "Nagaland",
                        "Odisha",
                        "Punjab",
                        "Rajasthan",
                        "Sikkim",
                        "Tamil Nadu",
                        "Tripura",
                        "Uttarakhand",
                        "Uttar Pradesh",
                        "West Bengal",
                        "Andaman & Nicobar",
                        "Chandigarh",
                        "Dadra and Nagar Haveli",
                        "Daman & Diu",
                        "Delhi",
                        "Lakshadweep",
                        "Puducherry",
                        "Other"
                    ); ?>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="stateDiv">
                            <label for="usr" class="my-2">*State:</label>
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
                    <div class="headingsall">

                        <div class="radio d-md-flex">
                            <label for="status" class="col-form-label">*Status:</label>
                            <div class="form-check mx-md-5 my-2">
                                <input type="radio" name="status" checked id="urbanRadio" value="Urban">&nbsp;&nbsp;Uarban
                            </div>
                            <div class="form-check mx-md-5 my-2">
                                <input type="radio" name="status" id="rularRadio" value="Rular">&nbsp;&nbsp;Rular
                            </div>
                        </div>

                    </div>
                    <div class="headingsall">

                        <div class="radio d-md-flex">
                            <label for="education" class="col-form-label">*Educational Status:</label>
                            <div class="form-check mx-md-5 my-2">
                                <input type="radio" name="educationalStatus" checked id="literateRadio" value="Literate">&nbsp;&nbsp;Literate
                            </div>
                            <div class="form-check mx-md-5 my-2">
                                <input type="radio" name="educationalStatus" id="illiterateRadio" value="Illiterate">&nbsp;&nbsp;Illiterate
                            </div>
                        </div>

                    </div>
                    <div class="headingsall">

                        <div class="radio d-md-flex">
                            <label for="education" class="col-form-label">*Education:</label>
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
                    <div class="headingsall">
                        <div class="col-sm-6 form-group">
                            <button type="submit" name="personalRTI" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <div class="headingsall">
                        <div class="col-sm-6">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>