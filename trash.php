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