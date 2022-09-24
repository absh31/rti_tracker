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
                <h5>Edit Officer</h5>
            </div>
        </div>
        <br>
        <?php
            $officerId = $_GET['id'];
            $officerSql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
            $officerSql->bindParam(1, $officerId);
            $officerSql->execute();
            $officer = $officerSql->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="./Backend/editOfficer.php" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="officerId" id="dept_name" value="<?php echo $officer['officer_id'] ?>" hidden required></td>
                        </tr>
                        <tr>
                            <td>Officer Name</td>
                            <td><input class="form-control" type="text" name="officerName" id="officer_name" value="<?php echo $officer['officer_name'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Officer Email</td>
                            <td><input class="form-control" type="email" name="officerEmail" id="officer_email" value="<?php echo $officer['officer_email'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Officer Mobile</td>
                            <td><input class="form-control" type="text" name="officerMobile" id="officerMobile" value="<?php echo $officer['officer_mobile'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Officer Department</td>
                            <td>
                                <select class="form-control" name="officerDept" id="officerDept">
                                    <?php
                                    $deptSql = $conn->prepare("SELECT * FROM tbldepartment");
                                    $deptSql->execute();
                                    while($deptArray = $deptSql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option class="form-control" value="<?= $deptArray['department_id']?>" <?php echo $deptArray['department_id'] == $officer['officer_department_id'] ? "selected" : "" ?>> <?= $deptArray['department_name']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><input class="form-control" type="text" name="officerOther" id="dept_others" value="<?php echo $officer['officer_other'] ?>"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./officer.php" class="btn btn-outline-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-outline-primary px-4" type="submit" name="editOfficer" value="Save Changes">
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