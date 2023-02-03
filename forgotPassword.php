<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
include './connection.php';
include "header.php";
include "nav.php";
?>
<style>
    body {
        background-image: url(./uploads/images/image5.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    @media screen and (max-width : 600px) {
        #logo1{
            display: none;
        }
        #logo2{
            display: none;
        }
    }
</style>
<br>
<div class="container">
    <div class="col-md-6 mx-auto my-5 p-4 transparent" style="background : url(./uploads/images/Rectangle32.png) ">
        <div class="row">
            <div class="col text-center">
                <h4 style="font-weight: 700; color : black;">Password Reset</h4>
                <hr>
            </div>
        </div>
        <div class="px-3 mb-4 pt-3 apply">
            <form method="post" action="./Backend/forgotPassword.php">
                <div class="mt-2 headingsall">
                    <label name="email" style="margin-bottom : 10px; color : black; font-weight : 600;">Email address</label>
                    <input name="email" type="text" class="form-control" required="required" placeholder="Enter email id" style="border : 2px solid black; opacity : 0.7">
                    <div id="emailHelp" class="form-text">New password will be sent to your registered email id.</div>
                </div>
                <div class="row">
                    <div class="col mt-4 text-center">
                        <input type="submit" name="forgotPass" class="w-100 btn text-light py-2 px-5" style="background-color : black" value="Submit" />
                    </div>
                    <div class="col mt-4 text-center">
                        <a href="./login.php" class="w-100 btn text-dark py-2 px-5" style="background-color: darkgrey;"> Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="space" style="margin-bottom: 4.5%;"></div>
<?php include './footer.php';?>
</body>