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
                <form action="./Backend/forwardRTI.php" method="POST">
                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td><input class="form-control" type="text" name="reqNo" value="<?php echo $_GET['reqNo'] ?>" hidden required></td>
                            </tr>
                            <tr>
                                <td>Department Name</td>
                                <td>
                                    <select name="officerDept" id="deptName" class="form-control">
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
                                    <select name="officerName" id="officerName" class="form-control">
                                        <option disabled selected>Choose Officer</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-top">Remarks</td>
                                <td><textarea class="form-control" rows="5" name="forwardRemarks"></textarea></td>
                            </tr>
                            <tr>
                                <td>Attach Files</td>
                                <td><input class="form-control" type="file" name="attachments" multiple></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col text-center">
                        <a href="./pendingRTI.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                        <input class="btn btn-dark px-5" type="submit" name="forwardRTI" value="Forward">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // $('#pending').DataTable();

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
                        console.log(data)
                        $("#officerName").html(data);
                    }
                })
            });
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