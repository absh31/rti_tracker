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
            <h5>Get Your RTI History</h5>
            <p>To get the RTI history, fill below form with required information. <br>
            <form method="POST" action="./Backend/historyView.php">
                <div class="mb-3">
                    <label for="reqMobile" class="form-label"><span class="text-danger">*</span> Mobile Number</label>
                    <input type="text" class="form-control" id="reqMobile" name="reqMobile" oninput="validateNumber(this)" aria-describedby="emailHelp" required>
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
                <!-- <button type="submit" class="btn btn-dark text-light">Submit</button> -->
                <button class="btn-spinner-border btn btn-dark py-2 submit" type="submit" name="viewHistory" id="viewHistory">
                    <span class="spinner-border spinner-border-sm" hidden></span> View History
                </button>
            </form>
        </div>
    </div>
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
    document.getElementById("history-nav").classList.add("active");
    document.getElementById("history-nav").style.fontWeight = 600;
    document.getElementById("rti-nav").classList.remove("active");
    document.getElementById("apel-nav").classList.remove("active");
    document.getElementById("status-nav").classList.remove("active");
    document.getElementById("home-nav").classList.remove("active");
    document.getElementById("contact-nav").classList.remove("active");

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

    $(document).ready(function() {
        $('#viewHistory').on('click', function(e) {
            $('#responseData').html();
            e.preventDefault();
            $('#responseData').html();
            e.preventDefault();
            $('.spinner-border').prop("hidden", null);
            $('.btn-spinner-border').prop("disabled", true);
            var reqMobile = $('#reqMobile').val().toString();
            var reqEmail = $('#reqEmail').val().toString();
            var captcha = $('#g-recaptcha-response').val().toString();
            $.ajax({
                type: "POST",
                url: "./Backend/historyView.php",
                data: {
                    reqMobile: reqMobile,
                    reqEmail: reqEmail,
                    captcha: captcha
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