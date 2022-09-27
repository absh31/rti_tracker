<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
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
        <form action="./Backend/addOfficer.php" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td>Officer Name</td>
                            <td><input class="form-control" type="text" name="officerName" id="dept_name" required></td>
                        </tr>
                        <tr>
                            <td>Officer Email</td>
                            <td><input class="form-control" type="email" name="officerEmail" id="dept_email" required></td>
                        </tr>
                        <tr>
                            <td>Officer Mobile</td>
                            <td><input class="form-control" type="tel" name="officerMobile" id="dept_others"></td>
                        </tr>
                        <tr>
                            <td>Officer Username</td>
                            <td><input class="form-control" type="text" name="officerMobile" id="dept_others"></td>
                        </tr>
                        <tr>
                            <td>Officer Password</td>
                            <td><input class="form-control" type="password" name="officerMobile" id="dept_others"></td>
                        </tr>
                        <tr>
                            <td>Officer Department</td>
                            <td>
                                <select name="officerDept" id="" class="form-control">
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
                            <td>Officer Role</td>
                            <td>
                                <select name="officerRole" id="" class="form-control">
                                    <option disabled selected>Choose Role</option>
                                    <?php
                                    $deptSql = $conn->prepare("SELECT * FROM tblrole WHERE is_active = 1");
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
                    </tbody>
                </table>
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