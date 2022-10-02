<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Forward RTI</h5>
                <br>
                <div id="wrapper">
                    <form action="./Backend/forwardRTI.php" method="POST" id="add_dept">
                        <div id="mainForm">
                            <table class="table align-middle" id="forward_dept">
                                <tr>
                                    <td><input class="form-control" type="text" name="reqNo" value="<?php echo $_GET['reqNo'] ?>" hidden required></td>
                                </tr>
                                <tr>
                                    <td>Department Name</td>
                                    <td>
                                        <select name="officerDept[]" id="deptName" class="form-control">
                                            <option disabled selected>Choose Department</option>
                                            <?php
                                            $deptSql = $conn->prepare("SELECT * FROM tbldepartment WHERE is_active = 1");
                                            $deptSql->execute();
                                            $departments = $deptSql->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($departments as $department) {
                                            ?>
                                                <option value="<?php echo $department['department_id'] ?>"><?php echo $department['department_name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Department Officer</td>
                                    <td>
                                        <select name="officerName[]" id="officerName" class="form-control">
                                            <option disabled selected>Choose Officer</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-top">Remarks</td>
                                    <td><textarea class="form-control" rows="5" name="forwardRemarks[]"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Attach Files</td>
                                    <td><input class="form-control" type="file" name="attachments[]" multiple></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col text-center">
                            <a href="./pendingRTI.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                            <input class="btn btn-dark px-5" type="submit" name="forwardRTI" value="Forward">
                        </div>
                    </form>
                    <div class="col text-center">
                        <button class="btn btn-primary text-light" id="dept"><i class="fa fa-plus"></i> Add Department</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger text-light" id="remove_dept"><i class="fa fa-trash-alt"></i> Remove Department</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->

    <script>
        var i=0;
        $(document).ready(function() {
            $('#deptName').on('change', function() {
                var deptID = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "./Backend/getOfficers.php",
                    data: {
                        deptID: deptID
                    },
                    dataType: "html",
                    success: function(data) {
                        $("#officerName").html(data);
                    }
                })
            });
        });

        $(document).ready(function() {
            $("#dept").on('click', function(e) {
                i+=1;
                var newElement = $("#forward_dept").clone();
                newElement.find("#deptName").val();
                newElement.find("#deptName").attr("id", "deptName"+i)
                newElement.find("#officerName").val();
                newElement.find("#officerName").attr("id", "officerName"+i)
                newElement.appendTo("#mainForm")
                // $("#forward_dept").clone(true, true).appendTo($("#mainForm"))
                for (var n=i; n<=i; n++){
                    $('#deptName'+i).on('change', function() {
                        var deptID = $(this).val();
                        $.ajax({
                            method: "POST",
                            url: "./Backend/getOfficers.php",
                            data: {
                                deptID: deptID
                            },
                            dataType: "html",
                            success: function(data) {
                                $("#officerName"+i).html(data);
                            }
                        })
                    });
                }
            })

            $("#remove_dept").on('click', function(e){
                e.preventDefault();
                if(i!=0){
                    i-=1;
                    $("#forward_dept:last-child").remove();
                }
            })
        });
    </script>
    </body>

    </html>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>