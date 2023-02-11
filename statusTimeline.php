<?php
include './connection.php';
include './header.php';
$filed = 0;
$forward = 0;
$reverted = 0;
$close = 0;
$reqNo = $_GET['reqNo'];
$fileActSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_type = 'Filed'");
$fileActSql->bindParam(1, $reqNo);
$fileActSql->execute();
if ($fileActSql->rowCount() > 0)
    $filed = 1;

$fileActSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_type = 'Forwarded'");
$fileActSql->bindParam(1, $reqNo);
$fileActSql->execute();
if ($fileActSql->rowCount() > 0)
    $forward = 1;

$fileActSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_type = 'Revert'");
$fileActSql->bindParam(1, $reqNo);
$fileActSql->execute();
if ($fileActSql->rowCount() > 0)
    $reverted = 1;

$fileActSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_type = 'Closed'");
$fileActSql->bindParam(1, $reqNo);
$fileActSql->execute();
if ($fileActSql->rowCount() > 0)
    $close = 1;

$fileActSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_request_no = ? AND activity_type = 'Rejected'");
$fileActSql->bindParam(1, $reqNo);
$fileActSql->execute();
if ($fileActSql->rowCount() > 0)
    $close = 1;
    $reverted = 1;
    $forward = 1;

$fileActs = $fileActSql->fetchAll(PDO::FETCH_ASSOC);

?>
<html>

<head>
    <script src="js/jquery.js"></script>
    <script src="js/timeline.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/timeline.min.css" />
</head>

<body>
    <!-- <div class="container"> -->
    <br />
    <!-- <div class="panel panel-default"> -->
    <!-- <div class="panel-body"> -->
    <div class="timeline">
        <div class="timeline__wrap">
            <div class="timeline__items">
                <div class="timeline__item">
                    <div class="timeline__content">
                        <h2 style="color:<?php if ($filed) {
                                                echo 'green';
                                            } else {
                                                echo 'red';
                                            } ?>;"><?php echo "Information Requested"; ?></h2>
                        <p><?php echo "RTI Added" ?></p>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                        <h2 style="color:<?php if ($forward) {
                                                echo 'green';
                                            } else {
                                                echo 'red';
                                            } ?>;"><?php echo "Forwarded"; ?></h2>
                        <p><?php echo "Forwarded to Concerned Department." ?></p>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                        <h2 style="color:<?php if ($reverted) {
                                                echo 'green';
                                            } else {
                                                echo 'red';
                                            } ?>;"><?php echo "Reverted"; ?></h2>
                        <p><?php echo "Data is Reverted to Nodal." ?></p>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                        <h2 style="color:<?php if ($close) {
                                                echo 'green';
                                            } else {
                                                echo 'red';
                                            } ?>;"><?php echo "Closed"; ?></h2>
                        <p><?php echo "Information is Ready.<br>RTI Closed." ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!-- </div> -->
    <!-- </div> -->
</body>

</html>

<script>
    $(document).ready(function() {
        jQuery('.timeline').timeline({
            mode: 'horizontal',
            visibleItems: 4,
        });
    });
</script>