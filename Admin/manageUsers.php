<?php
session_start();
include "../header.php";
include '../connection.php';

function getDepartmentName($conn, $department_id){
    $deptSql = $conn->prepare("SELECT department_name FROM tbldepartment WHERE department_id = ?");
    $deptSql->bindParam(1, $department_id);
    $deptSql->execute();
    $departmentName = $deptSql->fetch(PDO::FETCH_ASSOC);
    return $departmentName['department_name'];
}

if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    
    if ($key['role_name'] == "admin") {
        include '../nav.php';
        include './nav.php';
?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col">
                    <h5>Manage User Roles</h5>
                </div>
                <div class="col text-end">
                    <a href="./addUser.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add Role</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">

                    <?php
                    $role_sql = $conn->prepare("SELECT * FROM tblrole WHERE is_active = 1 ORDER BY role_priority");
                    $role_sql->execute();
                    $roles = $role_sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Role Name</th>
                                <th scope="col">Role Priority</th>
                                <th scope="col">Role Department</th>
                                <!-- <th scope="col">Active</th> -->
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sr_no = 1;
                            foreach ($roles as $role) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $sr_no; ?></th>
                                    <td><?php echo $role['role_name'] ?></td>
                                    <td><?php echo $role['role_priority'] ?></td>
                                    <td>
                                        <?php 
                                            if($role['role_department'] == 0){
                                                echo "None";
                                            } else {
                                                echo getDepartmentName($conn, $role['role_department']);
                                            }
                                        ?>
                                    </td>
                                    <!-- <td><?php //echo $role['is_active'] ?></td> -->
                                    <td>
                                        <!-- <a href="edit.php?id=<?php echo $role['role_priority'] ?>" class="btn btn-primary text-light"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp; -->
                                        <button class="btn btn-danger text-light delete" id="<?php echo $role['role_priority'] ?>"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php $sr_no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
                            type: "POST",
                            url: "Backend/deleteUserRole.php",
                            data: {
                                userRoleId: id
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