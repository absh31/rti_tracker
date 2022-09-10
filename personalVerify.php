<?php
session_start();
include './header.php';
include './nav.php';
if (!isset($_SESSION['otp'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {

?>
    <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/verifyOTP.php">
        <br>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h5>Online RTI Form OTP Verification</h5>
                </div>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col-lg-3 text-center">
                    <br>
                    <div class="headingsall">
                        <div class="form-group" id="fullNameDiv">
                            <label for='otp'>Enter OTP :</label>
                            <br><br>
                            <input type="text" name="otp" id="otp" class="text-center form-control" required oninput="validateNumber(this)">
                        </div>
                    </div>
                    <br>
                    <div class="headingsall">
                        <div class="form-group">
                            <button type="submit" name="personalRTI" class="btn btn-dark text-light">Verify OTP</button>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
        </div>
    </form>
    <script>
        const validateNumber = function(usr) {
            var regexp = /^[0-9 ]+$/;
            var input = usr.value
            if (input != "") {
                if (regexp.test(input)) {
                    if (input.length > 6) {
                        alert("OTP should only have 6 digits!")
                        usr.value = input.slice(0, 6);
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
}
?>