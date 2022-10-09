<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    include '../nav.php';
    include './nav.php';
?>
    <br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col">
                <h5>Add Department</h5>
            </div>
        </div>
        <br>
        <form action="./Backend/addDept.php" method="POST">
            <div class="row">
                <div class="col">

                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <td>Department Name</td>
                                <td><input class="form-control" type="text" name="deptName" id="dept_name" required></td>
                            </tr>
                            <tr>
                                <td>Department Email</td>
                                <td><input class="form-control" type="email" name="deptEmail" id="dept_email" required></td>
                            </tr>
                            <tr>
                                <td>Remarks</td>
                                <td><input class="form-control" type="text" name="deptOthers" id="dept_others"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <a href="./department.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-5" type="submit" name="addDept" value="Add">
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>
    </body>

    </html>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>