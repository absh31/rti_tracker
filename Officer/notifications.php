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
    if ($key['officer_role_id'] == 4) {
        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `to` = ? AND is_deleted = 0 ORDER BY id DESC");
        $sql2->bindParam(1, $key['officer_id']);
        $sql2->execute();
        $msgs = $sql2->fetchAll(PDO::FETCH_ASSOC);
        
        if(isset($_POST['deleteNoti'])){
            $reqNo = $_POST['reqNo'];
            $del = $conn->prepare("UPDATE tblnotifications SET is_deleted = 1 WHERE `id` = ?");
            $del->bindParam(1, $reqNo);
            if($del->execute()){
                echo "<script>window.alert(`Message Deleted!`)</script>";
            }else{
                echo "<script>window.alert(`Something went wrong!`)</script>";
            }
        }
?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <?php
                                if ($sql2->rowCount() < 1) {
                                ?>
                                    NO MESSAGES YET
                                    <?php
                                } else {
                                    foreach ($msgs as $msg) {
                                    ?>
                                        <li class="p-2 border-bottom">
                                            <div class="row">
                                                <div class="col-9">
                                                    <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer</p>
                                                    <p class="small text-muted" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                    <p class="small text-muted" style="font-size: 16px;">
                                                        RTI Application Number:<b> <?= $msg['request_no'] ?></b>
                                                    </p>
                                                </div>
                                                <div class="col-3" style="text-align: right;">
                                                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                                                        <input type="text" name="reqNo" hidden value="<?=$msg['id'] ?>">
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
        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `from` = ? AND is_deleted = 0 ORDER BY id DESC");
        $sql2->bindParam(1, $from);
        $sql2->execute();
        $msgs = $sql2->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <?php
                                if ($sql2->rowCount() < 1) {
                                ?>
                                    NO MESSAGES YET
                                    <?php
                                } else {
                                    foreach ($msgs as $msg) {
                                    ?>
                                        <li class="p-2 border-bottom" style="display: none;">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row" style="margin-right: 5px;">
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer</p>
                                                        <p class="small text-muted" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="small text-muted mb-1"><?php echo date('H:i, d-m-Y', strtotime($msg['time'])) ?></p>
                                                    <!-- <span class="badge bg-danger float-end">1</span> -->
                                                    <button class="btn btn-danger float-end">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg>&nbsp;&nbsp;Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="p-2 border-bottom">
                                            <div class="row text-right">
                                                <div class="col-9">
                                                    <p class="fw-bold mb-0" style="font-size: 20px;">Nodal Officer</p>
                                                    <p class="small text-muted" style="font-size: 16px;"><?= $msg['msg'] ?></p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="small text-muted"><?php echo date('H:i, d-m-Y', strtotime($msg['time'])) ?></p>
                                                    <button class="btn btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg>&nbsp;&nbsp;Delete
                                                    </button>
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
            <br>
        </div>

<?php
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
</body>

</html>