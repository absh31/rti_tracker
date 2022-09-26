<body>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark" id="navigation" style="background-color : black">
        <div class="container-fluid">
            <!-- <a class="navbar-brand fw-bold" href="./index.php">GURUKRUPA ENTERPRISE</a> -->
            <a class="navbar-brand" href="index.php" style="font-weight: 800;">
                <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                RTI TRACKER
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
                        <a id="trck-nav" class="nav-link" aria-current="page" href="dashboard.php">Track RTI</a>
                    </li>
                    <li class="nav-item">
                        <a id="hist-nav" class="nav-link" aria-current="page" href="dashboard.php">RTI History</a>
                    </li>
                </ul>
                <a href="../logout.php">
                    <button class="btn text-light border-light" name="login" type="submit">Logout</button>
                </a>
            </div>
        </div>
    </nav>