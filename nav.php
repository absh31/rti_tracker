<body>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php
    if ($_SERVER['PHP_SELF'] != '/rti_tracker/login.php' && $_SERVER['PHP_SELF'] != '/rti_tracker/forgotPassword.php' && !isset($key)) {
    ?>
        <div class="container-fluid" style="background-color : #D9D9D9">
            <div class="row mx-4 py-2">
                <div class="col" id="logo1">
                    <img src="http:\\localhost\rti_tracker\uploads\images\logo2.png" alt="">
                </div>
                <div class="col text-center mt-3">
                    <a class="navbar-brand" href="index.php" style="font-weight: 800; color:black; font-size:30;">
                        <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                        RTI TRACKER
                    </a>
                </div>
                <div class="col text-end" id="logo2">
                    <img src="http:\\localhost\rti_tracker\uploads\images\logo1.png" alt="">
                </div>
            </div>
        </div>
        <nav class="navbar sticky-top navbar-expand-lg px-0 navbar-dark" id="navigation" style="background-color : black">
            <div class="container-fluid px-5">
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
                            <a id="home-nav" class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a id="rti-nav" class="nav-link" aria-current="page" href="instructionsRTI.php">Submit RTI</a>
                        </li>
                        <li class="nav-item">
                            <a id="apel-nav" class="nav-link" href="submitAppeal.php">Submit First Appeal</a>
                        </li>
                        <li class="nav-item">
                            <a id="status-nav" class="nav-link" href="viewStatus.php">View Status</a>
                        </li>
                        <li class="nav-item">
                            <a id="history-nav" class="nav-link" href="viewHistory.php">View History</a>
                        </li>
                        <li class="nav-item">
                            <a id="contact-nav" class="nav-link" href="contactUs.php">Contact Us</a>
                        </li>
                    </ul>
                    <div class="nav-link" id="google_translate_element"></div>
                    <a href="./login.php">
                        <button class="btn text-light border-light" name="login" type="submit">Login</button>
                    </a>
                </div>
            </div>
        </nav>
        <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en'
                }, 'google_translate_element');
            }
        </script>
    <?php
    } else {
    ?>
        <div class="container-fluid" style="background-color : #D9D9D9">
            <div class="row mx-4 py-2">
                <div class="col" id="logo1">
                    <img src="http:\\localhost\rti_tracker\uploads\images\logo2.png" alt="">
                </div>
                <div class="col text-center mt-3">
                    <a class="navbar-brand" href="index.php" style="font-weight: 800; color:black; font-size:30;">
                        <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
                        RTI TRACKER
                    </a>
                </div>
                <div class="col text-end" id="logo2">
                    <img src="http:\\localhost\rti_tracker\uploads\images\logo1.png" alt="">
                </div>
            </div>
        </div>
    <?php
    }
    ?>