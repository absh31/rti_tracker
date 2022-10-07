<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Add Department</h5>
            </div>
        </div>
        <br>
        <?php
            $deptId = $_GET['id'];
            $deptSql = $conn->prepare("SELECT * FROM tbldepartment WHERE department_id = ?");
            $deptSql->bindParam(1, $deptId);
            $deptSql->execute();
            $department = $deptSql->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="./Backend/editDept.php" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="deptId" id="dept_name" value="<?php echo $department['department_id'] ?>" hidden required></td>
                        </tr>
                        <tr>
                            <td>Department Name</td>
                            <td><input class="form-control" type="text" name="deptName" id="dept_name" value="<?php echo $department['department_name'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Department Email</td>
                            <td><input class="form-control" type="email" name="deptEmail" id="dept_email" value="<?php echo $department['department_email'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><input class="form-control" type="text" name="deptOthers" id="dept_others" value="<?php echo $department['department_other'] ?>"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./department.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-4" type="submit" name="addDept" value="Save Changes">
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