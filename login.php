<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
include './connection.php';
include "header.php";
include "nav.php";
?>
<div class="row">
    <div class="col-md-4 mx-auto my-5">
        <div class="row">
            <div class="col text-center">
                <h4 class="text-dark" style="font-weight: 500;">Authority Login</h4>
            </div>
        </div>
        <div class="px-3 mb-4 pt-3 apply" style="border: 1px solid #003865;">
            <!-- <h4 class="headingsall bg-light"></h4> -->
            <form method="post" action="./Backend/logon.php">
                <div class="headingsall">
                    <label name="type">Login Type</label>
                    <select class="form-control" required="required" name="type" id="admin_type">
                        <option value="" disabled selected>Select Login Type</option>
                        <?php
                        $sql = $conn->prepare("SELECT * FROM `tblrole`");
                        $sql->execute();
                        while ($key = $sql->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?php echo $key['role_id']; ?>"><?php echo ucwords($key['role_name']); ?></option>
                        <?php }
                        ?>

                    </select>
                </div>
                <div class="mt-3 headingsall">
                    <label name="username">Username</label>
                    <input name="username" type="text" class="form-control" required="required">
                </div>
                <div class="mt-3 headingsall">
                    <label name="password">Password</label>
                    <input name="password" type="password" class="form-control" required="required">
                </div>
                <div class="form-group mt-3">
                    <div class="g-recaptcha" data-sitekey="6Lewa-AZAAAAAMS-ZF5qUSZWezNJ1L9wQ5Iu13IU"></div>
                    <span class="text-danger" id="recaptcha_error"></span>
                </div>
                <div class="col-md-6 mx-auto my-3 text-center">
                    <input type="submit" name="AuthLogin" class="btn btn-primary py-2 px-5" value="Login" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="space" style="margin-bottom: 5.75%;"></div>
</body>