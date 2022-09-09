<?php
session_start();
include "./header.php";
include "./nav.php";
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col-6">
            <?php 
                if(isset($_SESSION['reqStatus'])){
                   $reqStatus = $_SESSION['reqStatus'];
                   $reqCurr = $_SESSION['reqCurr'];
                   $reqNo = $_SESSION['reqNo'];
                   $appEmail = $_SESSION['appEmail'];
                   echo "Request No - ".$reqNo."<br>";
                   echo "Applicant Email - ".$appEmail."<br>";
                   echo "Current Handler - ".$reqCurr."<br>";
                   echo "Current Status - ".$reqStatus."<br>";
                }
            ?>
            <h5>Check Your RTI Status</h5>
            <p>To check the RTI, fill below form with required information. <br>
            <form method="POST" action="./Backend/statusView.php">
                <div class="mb-3">
                    <label for="reqNo" class="form-label">RTI Request Registered Number</label>
                    <input type="text" class="form-control" id="reqNo" aria-describedby="emailHelp" name="reqNo">
                </div>
                <div class="mb-3">
                    <label for="reqEmail" class="form-label">Email ID</label>
                    <input type="email" class="form-control" id="reqEmail" name="reqEmail">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <button type="submit" class="btn btn-dark text-light">Submit</button>
            </form>
        </div>
    </div>
</div>
<br>
<?php
include './footer.php';
?>
</body>

</html>