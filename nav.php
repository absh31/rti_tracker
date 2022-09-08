<body>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php
    // echo $_SERVER['PHP_SELF'];
    if ($_SERVER['PHP_SELF'] != '/rti_tracker/login.php') {
    ?>
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark py-3" id="navigation" style="background-color : black">
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
                            <a id="home-nav" class="nav-link" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a id="home-nav" class="nav-link" aria-current="page" href="submitRTI.php">Submit RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="list-nav" class="nav-link" href="submitAppeal.php">Submit First Appeal</a>
                        </li>
                        <li class="nav-item">
                            <a id="resc-nav" class="nav-link" href="viewStatus.php">View Status</a>
                        </li>
                        <li class="nav-item">
                            <a id="cmpltd-nav" class="nav-link" href="viewHistory.php">View History</a>
                        </li>
                        <li class="nav-item">
                            <a id="cmpltd-nav" class="nav-link" href="contactUs.php">Contact Us</a>
                        </li>
                    </ul>
                    <a href="./login.php">
                        <button class="btn btn-outline-light px-4" name="login" type="submit">Login</button>
                    </a>
                </div>
            </div>
        </nav>
    <?php
    } else {
    ?>
        <div class="container">
            <div class="row">
                <div class="col text-center mt-4">
                    <a class="navbar-brand" href="index.php" style="font-weight: 800; color:black; font-size:30;">
                        <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                        RTI TRACKER
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>