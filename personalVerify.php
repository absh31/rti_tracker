<?php
session_start();
include './header.php';
include './nav.php';
if (!isset($_SESSION['otp'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {

?>

    <body>
        <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/verifyOTP.php">
            <div id="page1">
                <div class="col-md-8 mx-auto my-5">
                    <div class="alert text-center alert-dismissible fade show" role="alert">
                        <h2><b>Online RTI Form OTP</b></h2>
                    </div>
                    <h3 class="dept-title">Verification</h3>
                    <div class="px-3 mb-4 pt-3 apply" style="border: 1px solid #003865">
                        <div class="headingsall">

                            <div class="col-sm-6 form-group" id="fullNameDiv">
                                <label for='name'>*OTP :</label>
                                <input type="text" name="otp" id="otp" class="form-control" required>
                                <br>
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
    <?php
}
    ?>