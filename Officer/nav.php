<body>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php
    if ($key['role_id'] == 2) {
        ?>
        <nav class="navbar sticky-top navbar-expand-lg px-0 navbar-dark" id="navigation" style="background-color : black">
            <div class="container-fluid px-5">
                <!-- <a class="navbar-brand fw-bold" href="./index.php">GURUKRUPA ENTERPRISE</a> -->
                <a class="navbar-brand"  style="font-weight: 800;">
                    <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                    APPELLATE LOGIN
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a id="dash-nav" class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a id="pend-nav" class="nav-link" aria-current="page" href="./pendingRTI.php">Appealed RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="trck-nav" class="nav-link" aria-current="page" href="./trackRTI.php">RTI History</a>
                        </li>
                    </ul>
                    <a href="./notifications.php" class="mx-4">
                        <button class="btn btn-light text-dark" name="login" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                            </svg>
                            Notifications
                        </button>
                    </a>
                    <a href="../logout.php">
                        <button class="btn btn-danger text-light" name="login" type="submit">Logout</button>
                    </a>
                </div>
            </div>
        </nav>
        <?php
    } else if ($key['role_id'] == 3) {
    ?>
        <nav class="navbar sticky-top navbar-expand-lg px-0 navbar-dark" id="navigation" style="background-color : black">
            <div class="container-fluid px-5">
                <!-- <a class="navbar-brand fw-bold" href="./index.php">GURUKRUPA ENTERPRISE</a> -->
                <a class="navbar-brand" style="font-weight: 800;">
                    <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                    <?php
                    echo $key['officer_role_id'] == "1" ? "ADMIN LOGIN" : ($key['officer_role_id'] == "3" ? "NODAL LOGIN" : ($key['officer_role_id'] == "4" ? "DEPARTMENT LOGIN" : ""));
                    ?>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a id="dash-nav" class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a id="add-nav" class="nav-link" aria-current="page" href="./addRTI.php">Add RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="pend-nav" class="nav-link" aria-current="page" href="./pendingRTI.php">Pending RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="actv-nav" class="nav-link" aria-current="page" href="./activeRTI.php">Active RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="trck-nav" class="nav-link" aria-current="page" href="./trackRTI.php">RTI History</a>
                        </li>
                    </ul>
                    <a href="./notifications.php" class="mx-4">
                        <button class="btn btn-light text-dark" name="login" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                            </svg>
                            Notifications
                        </button>
                    </a>
                    <a href="../logout.php">
                        <button class="btn btn-danger text-light" name="login" type="submit">Logout</button>
                    </a>
                </div>
            </div>
        </nav>
    <?php
    } else if ($key['role_id'] == 4) {
        $dept = $conn->prepare("SELECT * FROM tbldepartment WHERE department_id = ?");
        $dept->bindParam(1, $key['officer_department_id']);
        $dept->execute();
        $row = $dept->fetch(PDO::FETCH_ASSOC);
        
        $sql2 = $conn->prepare("SELECT * FROM tblnotifications WHERE `to` = ? AND officer_del = 0 ORDER BY id DESC");
        $sql2->bindParam(1, $key['officer_id']);
        $sql2->execute();
        $count = $sql2->rowCount();
    ?>
        <nav class="navbar sticky-top navbar-expand-lg px-0 navbar-dark" id="navigation" style="background-color : black">
            <div class="container-fluid px-5">
                <!-- <a class="navbar-brand fw-bold" href="./index.php">GURUKRUPA ENTERPRISE</a> -->
                <a class="navbar-brand" style="font-weight: 600;">
                    <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                    <?php echo strtoupper($row['department_name']); ?>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a id="dash-nav" class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a id="pend-nav" class="nav-link" aria-current="page" href="./pendingRTI.php">Pending RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="trck-nav" class="nav-link" aria-current="page" href="./trackRTI.php">RTI History</a>
                        </li>
                    </ul>
                    <a href="./notifications.php" class="mx-4">
                        <button class="btn btn-light text-dark" name="login" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                            </svg>
                            Notifications <span class="text-danger">(<?=$count?>) </span>
                        </button>
                    </a>
                    <a href="../logout.php">
                        <button class="btn btn-danger text-light" name="login" type="submit">Logout</button>
                    </a>
                </div>
            </div>
        </nav>

    <?php
    }
