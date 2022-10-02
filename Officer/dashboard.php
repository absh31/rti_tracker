<?php
session_start();
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "../header.php";
    include '../connection.php';
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    if ($sql->rowCount() > 0) {
        include './nav.php';
?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>Hello <?= ucwords($key['officer_name']) ?></h5>
                </div>
            </div>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>
        <script>
            document.getElementById("dash-nav").style.fontWeight = 600;
        </script>
        </body>

        </html>
<?php
    } else {
        echo "<script>window.alert(`No users found!`)</script>";
        echo "<script>window.open('../login.php','_self')</script>";
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>