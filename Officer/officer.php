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
                <h5>Departments</h5>
            </div>
            <div class="col text-end">
                <a href="./addOfficer.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add Officer</a>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            $officersSql = $conn->prepare("SELECT * FROM tblofficer t, tbldepartment d WHERE t.officer_department_id = d.department_id AND t.is_active = 1");
            $officersSql->execute();
            $officers = $officersSql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Officer Name</th>
                        <th scope="col">Officer Email</th>
                        <th scope="col">Officer Mobile</th>
                        <th scope="col">Officer Department</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sr_no = 1;
                        foreach($officers as $officer){
                    ?>
                    <tr>
                        <th scope="row"><?php echo $sr_no; ?></th>
                        <td><?php echo $officer['officer_name'] ?></td>
                        <td><?php echo $officer['officer_email'] ?></td>
                        <td><?php echo $officer['officer_mobile'] ?></td>
                        <td><?php echo $officer['department_name'] ?></td>
                        <td><?php echo $officer['is_active'] ?></td>
                        <td>
                            <a href="editofficer.php?id=<?php echo $officer['officer_id'] ?>" class="btn btn-primary text-light"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp; 
                            <button class="btn btn-danger text-light delete" id="<?php echo $officer['officer_id'] ?>"><i class="fa-solid fa-trash"></i></button>
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