<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    include './nav.php';
    if ($key['role_id'] == 3) {
?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h5>Track RTI</h5>
                    <div class="mb-3">
                        <label for="reqNo" class="form-label"><span class="text-danger">*</span> RTI Request Reference Number</label>
                        <input type="text" class="form-control" id="reqNo" name="reqNo" required>
                    </div>
                    <div class="mb-3">
                        <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                        <span class="text-danger" id="recaptcha_error"></span>
                    </div>
                    <button class="btn-spinner-border btn btn-dark py-2 submit" type="submit" name="trackRTI" id="trackRTI">
                        <span class="spinner-border spinner-border-sm" hidden></span> Track RTI
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div id="responseData">
                </div>
            </div>
        </div>
        <?php
        include '../footer.php';
        ?>

        <script>
            document.getElementById("trck-nav").classList.add("active");
            document.getElementById("trck-nav").style.fontWeight = 600;

            $(document).ready(function() {
                $('#trackRTI').on('click', function(e) {
                    console.log("HELLo")
                    $('.spinner-border').prop("hidden", null);
                    $('.btn-spinner-border').prop("disabled", true);
                    var reqNo = $('#reqNo').val().toString();
                    $.ajax({
                        type: "POST",
                        url: "./Backend/RTItrack.php",
                        data: {
                            reqNo: reqNo
                        },
                        success: function(response) {
                            $('.spinner-border').prop("hidden", true);
                            $('.btn-spinner-border').prop("disabled", false);
                            console.log(response);
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
<?php
    }
}
