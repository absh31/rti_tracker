<?php
session_start();
include "../header.php";
include '../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    // $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    // $sql->bindParam(1, $_SESSION['auth']);
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id AND o.officer_username = ? AND o.officer_password = ?');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->bindParam(2, $_SESSION['username']);
    $sql->bindParam(3, $_SESSION['password']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    include '../nav.php';
    include './nav.php';
    if ($key['officer_role_id'] == 4) {
        if (isset($_POST['deleteNoti'])) {
            $reqNo = $_POST['reqNo'];
            $del = $conn->prepare("UPDATE tblnotifications SET officer_del = 1 WHERE `id` = ?");
            $del->bindParam(1, $reqNo);
            if ($del->execute()) {
                echo "<script>window.alert(`Message Deleted!`)</script>";
            } else {
                echo "<script>window.alert(`Something went wrong!`)</script>";
            }
        }
?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active text-dark fw-4" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">New</button>
                        <button class="nav-link text-danger" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Deleted</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `to` = ? AND officer_del = 0 ORDER BY id DESC");
                        $sql2->bindParam(1, $key['officer_id']);
                        $sql2->execute();
                        $msgs = $sql2->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <?php
                                        if ($sql2->rowCount() < 1) {
                                        ?>
                                            NO NEW MESSAGES
                                            <?php
                                        } else {
                                            foreach ($msgs as $msg) {
                                            ?>
                                                <li class="p-2 border-bottom">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer</p>
                                                            <p class="small text-muted mt-2" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                            <p class="small text-muted" style="font-size: 16px;">
                                                                RTI Application Number:<b> <?= $msg['request_no'] ?></b>
                                                            </p>
                                                        </div>
                                                        <div class="col-3" style="text-align: right;">
                                                            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                                                <input type="text" name="reqNo" hidden value="<?= $msg['id'] ?>">
                                                                <p class="small text-muted"><?php echo date('H:i, d-m-Y', strtotime($msg['time'])) ?></p>
                                                                <button name="deleteNoti" type="submit" class="btn btn-danger">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                                    </svg>&nbsp;&nbsp;Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php
                        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `to` = ? AND officer_del = 1 ORDER BY id DESC");
                        $sql2->bindParam(1, $key['officer_id']);
                        $sql2->execute();
                        $msgs = $sql2->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <?php
                                        if ($sql2->rowCount() < 1) {
                                        ?>
                                            NO DELETED MESSAGES
                                            <?php
                                        } else {
                                            foreach ($msgs as $msg) {
                                            ?>
                                                <li class="p-2 border-bottom">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer</p>
                                                            <p class="small text-muted mt-2" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                            <p class="small text-muted" style="font-size: 16px;">
                                                                RTI Application Number:<b> <?= $msg['request_no'] ?></b>
                                                            </p>
                                                        </div>
                                                        <div class="col-3" style="text-align: right;">
                                                                <p class="small text-muted"><?php echo date('H:i, d-m-Y', strtotime($msg['time'])) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <br><br>
        <script>
            document.getElementById('dash-nav').classList.remove('active');
        </script>
        <?php include '../footer.php'; ?>
    <?php
    } else if ($key['officer_role_id'] == 3) {
        $from = "Nodal Officer";
        if (isset($_POST['deleteNoti'])) {
            $reqNo = $_POST['reqNo'];
            $del = $conn->prepare("UPDATE tblnotifications SET nodal_del = 1 WHERE `id` = ?");
            $del->bindParam(1, $reqNo);
            if ($del->execute()) {
                echo "<script>window.alert(`Message Deleted!`)</script>";
            } else {
                echo "<script>window.alert(`Something went wrong!`)</script>";
            }
        }
    ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active text-dark fw-4" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">New</button>
                        <button class="nav-link text-danger" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Deleted</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `from` = ? AND nodal_del = 0 ORDER BY id DESC");
                        $sql2->bindParam(1, $from);
                        $sql2->execute();
                        $msgs = $sql2->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <?php
                                        if ($sql2->rowCount() < 1) {
                                        ?>
                                            NO NEW MESSAGES SENT
                                            <?php
                                        } else {
                                            foreach ($msgs as $msg) {
                                                $officer = $conn->prepare("SELECT officer_name, department_name from tblofficer, tbldepartment WHERE officer_id = ? AND officer_department_id = department_id");
                                                $officer->bindParam(1, $msg['to']);
                                                $officer->execute();
                                                $off = $officer->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <li class="p-2 border-bottom">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer -> <?= $off['officer_name'] ?> (<?= $off['department_name'] ?>)</p>
                                                            <p class="small text-muted mt-2" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                            <p class="small text-muted" style="font-size: 16px;">
                                                                RTI Application Number:<b> <?= $msg['request_no'] ?></b>
                                                            </p>
                                                        </div>
                                                        <div class="col-3" style="text-align: right;">
                                                            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                                                <input type="text" name="reqNo" hidden value="<?= $msg['id'] ?>">
                                                                <p class="small text-muted"><?php echo date('H:i, d-m-Y', strtotime($msg['time'])) ?></p>
                                                                <button name="deleteNoti" type="submit" class="btn btn-danger">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                                    </svg>&nbsp;&nbsp;Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php
                        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `from` = ? AND nodal_del = 1 ORDER BY id DESC");
                        $sql2->bindParam(1, $from);
                        $sql2->execute();
                        $msgs = $sql2->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <?php
                                        if ($sql2->rowCount() < 1) {
                                        ?>
                                        NO DELETED MESSAGES
                                        <?php
                                        } else {
                                            foreach ($msgs as $msg) {
                                                $officer = $conn->prepare("SELECT officer_name, department_name from tblofficer, tbldepartment WHERE officer_id = ? AND officer_department_id = department_id");
                                                $officer->bindParam(1, $msg['to']);
                                                $officer->execute();
                                                $off = $officer->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <li class="p-2 border-bottom">
                                                    <div class="row">
                                                        <div class="col-9">
                                                        <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer -> <?= $off['officer_name'] ?> (<?= $off['department_name'] ?>)</p>
                                                            <p class="small text-muted mt-2" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                            <p class="small text-muted" style="font-size: 16px;">
                                                                RTI Application Number:<b> <?= $msg['request_no'] ?></b>
                                                            </p>
                                                        </div>
                                                        <div class="col-3" style="text-align: right;">
                                                                <p class="small text-muted"><?php echo date('H:i, d-m-Y', strtotime($msg['time'])) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <br><br>
        <script>
            document.getElementById('dash-nav').classList.remove('active');
        </script>
        <?php include '../footer.php'; ?>
<?php
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
</body>

</html>