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
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">
                <h5>Manage Departments</h5>
            </div>
            <div class="col text-end">
                <a href="./addDepartment.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add Department</a>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            $dept_sql = $conn->prepare("SELECT * FROM tbldepartment WHERE is_active = 1");
            $dept_sql->execute();
            $departments = $dept_sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Department Email</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Active</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sr_no = 1;
                        foreach($departments as $department){
                    ?>
                    <tr>
                        <th scope="row"><?php echo $sr_no; ?></th>
                        <td><?php echo $department['department_name'] ?></td>
                        <td><?php echo $department['department_email'] ?></td>
                        <td><?php echo $department['department_other'] ?></td>
                        <td><?php echo $department['is_active'] ?></td>
                        <td>
                            <a href="editDepartment.php?id=<?php echo $department['department_id'] ?>" class="btn btn-primary text-light"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp; 
                            <button class="btn btn-danger text-light delete" id="<?php echo $department['department_id'] ?>"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php $sr_no++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>

    <script>
        document.getElementById("manage-nav").classList.add('active');
        document.getElementById("dash-nav").classList.remove('active');
        $(document).ready(function () {
            $(".delete").on('click', function(){
                if(confirm("Are you sure you want to delete")){
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "POSt",
                        url: "Backend/deleteDept.php",
                        data: {
                            deptId : id
                        },
                        success: function (response) {
                          window.location.reload();  
                        }
                    });
                }
            })
        });
    </script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>