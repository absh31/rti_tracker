<?php
session_start();
include './connection.php';
include './header.php';
include './nav.php';
include '../nav.php';
if (!isset($_SESSION['requestNo'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("./index.php","_self")</script>';
} else {
?>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col text-center">
                <br><br>
                <h5 style="font-weight: 500;">You request is filed successfully! Your request reference number is <span class="text-danger" style="font-weight: 800;"><?= $_SESSION['requestNo']; ?></span></h5>
                <?php 
                    $sql = $conn-> prepare("SELECT * FROM `tblrequest` Where `request_no` = ?");
                    $sql->bindParam(1, $_SESSION['requestNo']);
                    $sql->execute();
                    $key = $sql->fetch(PDO::FETCH_ASSOC);
                    if ($key['request_is_base_pay'] == 0){
                    
                    ?>
                    <h4>To proceed further, pay request fees. <a href="./Transactions/payRequest.php?requestNo=<?php echo $_SESSION['requestNo']; ?>&payType=base">Pay Now</a></h4>
                <?php } else {
                ?>
                    <h4>Your fees are paid successfully!...</h4>
                <?php
                } ?>
                <a href="./index.php">Click Here</a> to go back to the home page...
            </div>
        </div>
    </div>
<?php
}
// sleep(5);
// session_destroy();
// echo '<script>window.open("./index.php","_self")</script>';