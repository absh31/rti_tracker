<?php
session_start();
include "header.php";
include "nav.php";
include './connection.php';
if (!isset($_SESSION['reqAppId'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
    $reqNo = $_SESSION['reqNo'];
    $appEmail = $_SESSION['appEmail'];
    $sql = $conn->prepare("SELECT * FROM `tblrequest` WHERE `request_no` = ?");
    $sql->bindParam(1, $reqNo);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);

?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-6">
                <h5>Submit First Appeal</h5>
                <p>To submit the first appeal, fill below form with required information. <br>
                <form method="POST" action="./Backend/submitAppeal.php">
                    <div class="mb-3">
                        <label for="reqNo" class="form-label">RTI Number</label>
                        <input type="text" class="form-control" value="<?php echo $reqNo; ?>" id="reqNo" name="reqNo" aria-describedby="emailHelp" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="reqEmail" class="form-label">Email ID</label>
                        <input type="email" name="reqEmail" value="<?php echo $appEmail; ?>" class="form-control" id="reqEmail" readonly>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="headingsall">
                        <?php
                        $reasons = array('ABC', 'XYZ', 'PQR');
                        ?>
                        <div class="col-sm-6 form-group" id="reasonDiv">
                            <label for="usr" class="my-2"><span class="text-danger">*</span> Reason:</label>
                            <select class="form-control" id="reasonSel" name="appealReason" required>
                                <option value="" disabled selected>Select Reason</option>
                                <?php
                                foreach ($reasons as $key) {
                                ?>
                                    <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                <?php }
                                ?>

                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                        <span class="text-danger" id="recaptcha_error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submitAppeal">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    </body>

    </html>
<?php
}
?>