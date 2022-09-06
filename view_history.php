<?php
include "header.php";
include "nav.php";
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col-6">
            <h5>Get Your RTI History</h5>
            <p>To get the RTI history, fill below form with required information. <br>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="regno" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="regno" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email ID</label>
                    <input type="email" class="form-control" id="email">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<br>
</body>

</html>