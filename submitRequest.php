<?php
session_start();
include './header.php';
include './nav.php';
if (!isset($_SESSION['otpVerified'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
    include './connection.php';

?>
    <form method="POST" enctype="multipart/form-data" id="register" action="./Backend/requestRTI.php">
        <div id="page1">
            <div class="col-md-8 mx-auto my-5">
                <div class="alert text-center alert-dismissible fade show" role="alert">
                    <h2><b>Online RTI Form</b></h2>
                </div>
                <h3 class="dept-title">Request Details</h3>
                <div class="px-3 mb-4 pt-3 apply" style="border: 1px solid #003865">
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="departmentDiv">
                            <label for="department" class="my-2">Department:</label>
                            <select class="form-control" id="departmentSel" name="department" required>
                                <option value="" disabled selected>Select Department</option>
                                <?php
                                $sql = $conn->prepare("SELECT * FROM `tbldepartment`");
                                $sql->execute();
                                while ($key = $sql->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $key['department_id']; ?>"><?php echo $key['department_name']; ?></option>
                                <?php }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="bplDiv">
                            <label for="BPL" class="my-2">Is the Applicant Below Poverty Line?:</label>
                            <select class="form-control" id="bplSel" name="isBPL" required>
                                <option value="" disabled selected>---</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="BPLNoDiv">
                            <label for='bpl'>BPL Card No. :</label>
                            <input type="text" name="bplCard" id="bplCard" class="form-control" required>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="yearDiv">
                            <label for='year'>Year of Issue :</label>
                            <input type="text" name="YOI" id="year" class="form-control" required>
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="issueAuthDiv">
                            <label for='issueAuth'>Issuing Authority :</label>
                            <input type="text" name="issueAuth" id="issueAuth" class="form-control">
                        </div>
                    </div>
                    <div class="headingsall">
                        <div class="col-sm-6 form-group" id="docBPL">
                            <label for="docBPL">Supporting Document :</label>
                            <input type="file" name="docBPL" id="docBPL" class="form-control">
                        </div>
                    </div>
                    <div class="headingsall">

                        <div class="col-sm-6 form-group" id="textDiv">
                            <label for='text'>Text for RTI request Application :</label>
                            <textarea name="reqText" id="reqText" class="form-control"></textarea>
                        </div>
                    </div>
                  <div class="headingsall">
                        <div class="col-sm-6 form-group">
                            <button type="submit" name="requestRTI" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <div class="headingsall">
                        <div class="col-sm-6">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php

}
?>