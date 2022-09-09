<?php
session_start();
include "header.php";
include "nav.php";
include "./connection.php";
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col-6">
            <?php
            if(isset($_SESSION['reqs'])){
                $reqs = $_SESSION['reqs'];
                foreach ($reqs as $key) {
                   echo "Request No. - ".$key."<br/>";
               }
            }
            ?>
            <h5>Get Your RTI History</h5>
            <p>To get the RTI history, fill below form with required information. <br>
            <form method="POST" action="./Backend/historyView.php">
                <div class="mb-3">
                    <label for="reqMobile" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="reqMobile" name="reqMobile" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="reqEmail" class="form-label">Email ID</label>
                    <input type="email" class="form-control" id="reqEmail" name="reqEmail">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <button type="submit" class="btn btn-primary" name="viewHistory">Submit</button>
            </form>
        </div>
    </div>
</div>
<br>
</body>

</html>