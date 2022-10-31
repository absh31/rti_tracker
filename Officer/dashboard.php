<?php
session_start();
if ((isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['auth']))) {
    include "../header.php";
    include '../connection.php';
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id AND o.officer_username = ? AND o.officer_password = ?');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->bindParam(2, $_SESSION['username']);
    $sql->bindParam(3, $_SESSION['password']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
    if ($sql->rowCount() > 0) {
        // echo $key['officer_id'];
        include "../nav.php";
        include './nav.php';
        $depts = $conn->prepare("SELECT department_name, department_id FROM tbldepartment WHERE is_active = 1");
        $depts->execute();
        $deptRTI = array();
        $monRTI = array();
        while ($deptsarr = $depts->fetch(PDO::FETCH_ASSOC)) {
            $rticount = $conn->prepare("SELECT COUNT(*) AS RTICOUNT FROM tblrequest WHERE request_department_id = ?");
            $rticount->bindParam(1, $deptsarr['department_id']);
            $rticount->execute();
            $cnt = $rticount->fetch(PDO::FETCH_ASSOC);
            $data = ['label' => $deptsarr['department_name'], 'y' => $cnt['RTICOUNT']];
            array_push($deptRTI, $data);
        }
        // print_r($deptRTI);
        $thisMM = date("m");
        for ($i = $thisMM - 6; $i <= $thisMM; $i++) {
            if ($i >= 10)
                $time = "____-$i%";
            else
                $time = "____-_$i%";
            $months = $conn->prepare("SELECT COUNT(*) AS MONCOUNT FROM tblrequest WHERE request_time LIKE ?");
            $months->bindParam(1, $time);
            $months->execute();
            $cnt = $months->fetch(PDO::FETCH_ASSOC);
            $data = ['label' => date("F", mktime(0, 0, 0, $i, 10)), 'y' => $cnt['MONCOUNT']];
            array_push($monRTI, $data);
        }
        // print_r($monRTI);
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
                <h4>Total RTIs</h4>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body text-dark">
                            <h5 class="card-title text-center font-weight-bold" style="font-size: 60px;">
                                <?php
                                $sql = $conn->prepare("SELECT COUNT(*) AS totalRti FROM tblrequest");
                                $sql->execute();
                                $count = $sql->fetch();
                                echo $count['totalRti'];
                                ?>
                            </h5>
                            <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body text-dark">
                            <h5 class="card-title text-center font-weight-bold" style="font-size: 60px;">
                                <?php
                                $type = 'user';
                                $type1 = 'none';
                                $sql = $conn->prepare("SELECT COUNT(*) AS activeRti FROM tblrequest WHERE request_current_handler != ? AND request_current_handler != ?");
                                $sql->bindParam(1, $type);
                                $sql->bindParam(2, $type1);
                                $sql->execute();
                                $count = $sql->fetch();
                                echo $count['activeRti'];
                                ?>
                            </h5>
                            <p class="card-text text-center" style="font-size: 20px; font-weight: 500;">Active</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body" style="text-decoration: none;">
                            <h5 class="card-title text-center text-danger font-weight-bold" style="font-size: 60px; color: #003975; text-decoration: none;">
                                <?php
                                $type = 'user';
                                $sql = $conn->prepare("SELECT COUNT(*) AS pendingRti FROM tblrequest WHERE request_current_handler = ?");
                                $sql->bindParam(1, $type);
                                $sql->execute();
                                $count = $sql->fetch();
                                //$count['pendingRti'];
                                ?>
                                <?= $count['pendingRti'] ?>
                            </h5>
                            <a class="stretched-link" style="text-decoration: none;" href="./pendingRTI.php">
                                <p class="card-text text-center text-danger" style="font-size: 20px; font-weight: 500;">Pending</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center text-success font-weight-bold" style="font-size: 60px; color: #003975;">
                                <?php
                                $type = 'none';
                                $sql = $conn->prepare("SELECT COUNT(*) AS completedRti FROM tblrequest WHERE request_current_handler = ?");
                                $sql->bindParam(1, $type);
                                $sql->execute();
                                $count = $sql->fetch();
                                echo $count['completedRti'];
                                ?>
                            </h5>
                            <p class="card-text text-center text-success" style="font-size: 20px; font-weight: 500;">Completed</p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <h4 class="card-header">RTI Received by Departments</h4>
                        <div class="card-body" style="height: 450px;">
                            <div id="chartContainer"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <h4 class="card-header">RTI history</h4>
                        <div class="card-body" style="height: 450px;">
                            <div id="chartContainer1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

        <script>
            window.onload = function() {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "theme2",
                    subtitles: [{
                        text: "RTI Application Count"
                    }],

                    data: [{
                        type: "pie",
                        indexLabel: "#percent%",
                        percentFormatString: "#0.##",
                        indexLabel: "{label} (#percent%)",
                        // toolTipContent: "{label} ({y} (#percent%))",
                        dataPoints: <?php echo json_encode($deptRTI, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
                //CanvasJS spline chart to show orders from Jan 2015 to Dec 2015
                var ordersSplineChart = new CanvasJS.Chart("chartContainer1", {
                    animationEnabled: true,
                    backgroundColor: "transparent",
                    theme: "theme2",
                    toolTip: {
                        borderThickness: 0,
                        cornerRadius: 0
                    },
                    axisX: {
                        labelFontSize: 14,
                        lineThickness: 2
                    },
                    axisY: {
                        gridThickness: 0,
                        labelFontSize: 14,
                        lineThickness: 2
                    },
                    data: [{
                        type: "spline",
                        dataPoints: <?php echo json_encode($monRTI, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                ordersSplineChart.render();
            }
        </script>
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