<?php
include "header.php";
include "nav.php";
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col-6">
            <h5>Submit First Appeal</h5>
            <p>To submit the first appeal, fill below form with required information. <br>
            <form method="POST" action="./Backend/appealRequest.php">
                <div class="mb-3">
                    <label for="reqNo" class="form-label">RTI Number</label>
                    <input type="text" class="form-control" id="reqNo" name="reqNo" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="reqEmail" class="form-label">Email ID</label>
                    <input type="email"  name="reqEmail" class="form-control" id="reqEmail">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <button type="submit" class="btn btn-dark text-light" name="requestAppeal">Submit</button>
            </form>
        </div>
    </div>
</div>
<br>
<script>
    document.getElementById("apel-nav").classList.add("active");
    document.getElementById("apel-nav").style.fontWeight = 600;
    document.getElementById("rti-nav").classList.remove("active");
    document.getElementById("home-nav").classList.remove("active");
    document.getElementById("status-nav").classList.remove("active");
    document.getElementById("history-nav").classList.remove("active");
    document.getElementById("contact-nav").classList.remove("active");
</script>
<?php
include './footer.php';
?>
</body>

</html>