<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';

function getDepartments($conn)
{
    $deptSql = $conn->prepare("SELECT * FROM tbldepartment");
    $deptSql->execute();
    $departments = $deptSql->fetchAll(PDO::FETCH_ASSOC);
    return $departments;
}


if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);

    if ($key['role_name'] == "admin") {
?>
        <br>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col">
                    <h5>Add Department</h5>
                </div>
            </div>
            <br>
            <form action="./Backend/addUser.php" method="POST">
                <div class="row">
                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td>Role Name</td>
                                <td><input class="form-control" type="text" name="roleName" id="dept_name" required></td>
                            </tr>
                            <tr>
                                <td>Add Role After</td>
                                <td>
                                    <select name="rolePriority" id="rolePriority" class="form-control" required>
                                        <option value="" selected disabled>Add Role After</option>
                                        <?php
                                        $role_sql = $conn->prepare("SELECT DISTINCT(role_name) AS role_name, role_priority FROM tblrole WHERE is_active = 1");
                                        $role_sql->execute();
                                        $roles = $role_sql->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($roles as $role) {
                                        ?>
                                            <option value="<?php echo $role['role_priority'] ?>"><?php echo $role['role_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Department Name</td>
                                <td>
                                    <select name="roleDepartment" id="rolePriority" class="form-control" required>
                                        <option value="" selected disabled>Select Department</option>
                                        <option value="None">None</option>
                                        <?php
                                        $departments = getDepartments($conn);
                                        foreach ($departments as $department) {
                                            echo "<option value = " . $department['department_id'] . ">" . $department["department_name"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col text-center">
                        <a href="./manageUsers.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                        <input class="btn btn-dark px-5" type="submit" name="addUser" value="Add">
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>

        <script>
            document.getElementById("manage-nav").classList.add('active');
            document.getElementById("dash-nav").classList.remove('active');
            $(document).ready(function() {
                $(".delete").on('click', function() {
                    if (confirm("Are you sure you want to delete")) {
                        var id = $(this).attr("id");
                        $.ajax({
                            type: "POSt",
                            url: "Backend/deleteDept.php",
                            data: {
                                deptId: id
                            },
                            success: function(response) {
                                window.location.reload();
                            }
                        });
                    }
                })
            });
        </script>
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>