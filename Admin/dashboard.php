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
                <h5>Hello <?= ucwords($key['officer_name']) ?></h5>
            </div>
        </div>
        <br>
        <div class="row">
            <h4>Stats</h4>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center font-weight-bold" style="font-size: 60px;">
                            <?php
                            $deptCountSql = $conn->prepare("SELECT COUNT(*) AS dept_cnt FROM tbldepartment WHERE is_active = 1");
                            $deptCountSql->execute();
                            $deptCount = $deptCountSql->fetch();
                            echo $deptCount['dept_cnt'];
                            ?>
                        </h5>
                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Departments</p>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center font-weight-bold" style="font-size: 60px;">
                            <?php
                            $officerCountSql = $conn->prepare("SELECT COUNT(*) AS count FROM tblofficer WHERE is_active = 1");
                            $officerCountSql->execute();
                            $officerCount = $officerCountSql->fetch();
                            echo $officerCount['count'];
                            ?>
                        </h5>
                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Officers</p>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center font-weight-bold" style="font-size: 60px;">
                            <?php
                            $roleCountSql = $conn->prepare("SELECT DISTINCT(COUNT(role_name)) AS count FROM tblrole WHERE is_active = 1");
                            $roleCountSql->execute();
                            $rolesCount = $roleCountSql->fetch();

                            echo $rolesCount['count'];
                            ?>
                        </h5>
                        <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Roles</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
    <br><br>
    <script>
        document.getElementById("manage-nav").classList.remove('active');
        document.getElementById("dash-nav").classList.add('active');
        document.getElementById("dash-nav").style.fontWeight = 600;
    </script>
    <?php include '../footer.php'; ?>
    </body>

    </html>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>