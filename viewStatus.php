<?php
session_start();
include "./header.php";
include "./nav.php";
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col-6">
            <h5>Check Your RTI Status</h5>
            <p>To check the RTI, fill below form with required information. <br>
            <form method="POST" action="./Backend/statusView.php">
                <div class="mb-3">
                    <label for="reqNo" class="form-label"><span class="text-danger">*</span> RTI Request Reference Number</label>
                    <input type="text" class="form-control" id="reqNo" aria-describedby="emailHelp" name="reqNo" required>
                </div>
                <div class="mb-3">
                    <label for="reqEmail" class="form-label"><span class="text-danger">*</span> Email ID</label>
                    <input type="email" class="form-control" id="reqEmail" name="reqEmail" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <!-- <button type="submit" id="viewStatus" class="btn btn-dark text-light">Submit</button> -->
                <button class="btn-spinner-border btn btn-dark py-2 submit" type="submit" name="viewStatus" id="viewStatus">
                    <span class="spinner-border spinner-border-sm" hidden></span> View Status
                </button>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div id="responseData">
        </div>
    </div>
</div>
<br>
<?php
include './footer.php';
?>
<script>
    document.getElementById("status-nav").classList.add("active");
    document.getElementById("status-nav").style.fontWeight = 600;
    document.getElementById("rti-nav").classList.remove("active");
    document.getElementById("apel-nav").classList.remove("active");
    document.getElementById("home-nav").classList.remove("active");
    document.getElementById("history-nav").classList.remove("active");
    document.getElementById("contact-nav").classList.remove("active");

    $(document).ready(function() {
        $('#viewStatus').on('click', function(e) {
            $('#responseData').html();
            e.preventDefault();
            $('#responseData').html();
            e.preventDefault();
            $('.spinner-border').prop("hidden", null);
            $('.btn-spinner-border').prop("disabled", true);
            var reqNo = $('#reqNo').val().toString();
            var reqEmail = $('#reqEmail').val().toString();
            var captcha = $('#g-recaptcha-response').val().toString();
            console.log(captcha);
            $.ajax({
                type: "POST",
                url: "./Backend/statusView.php",
                data: {
                    reqNo: reqNo,
                    reqEmail: reqEmail,
                    captcha: captcha,
                },
                success: function(response) {
                    $('.spinner-border').prop("hidden", true);
                    $('.btn-spinner-border').prop("disabled", false);
                    // $("#table_id").dataTable().fnDestroy();
                    // $("#table_id").DataTable();
                    $('#responseData').html(response);
                    allData = response;
                    // $("#table_id").DataTable();
                    // $("#export_to_excel").show();
                }
            })
        })
    });
</script>
</body>

</html>