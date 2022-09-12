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
                <h5>Hello <?= ucwords($key['officer_name'])?></h5>
            </div>
        </div>
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