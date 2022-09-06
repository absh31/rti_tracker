<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light" id="navigation">
    <div class="container-fluid">
        <!-- <a class="navbar-brand fw-bold" href="./index.php">GURUKRUPA ENTERPRISE</a> -->
        <a class="navbar-brand" href="index.php" style="font-weight: 800;">
            <!-- <img src="logo.png" width="45"height="45" class="d-inline-block align-text-center" style="margin-right:2px;"> -->
            RTI TRACKER (NODAL OFFICER)
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a id="home-nav" class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a id="home-nav" class="nav-link" aria-current="page" href="submit_rti_form.php">Add RTI</a>
                </li>
                <li class="nav-item">
                    <a id="list-nav" class="nav-link" href="pending_rti.php">Pending RTI</a>
                </li>
                <li class="nav-item">
                    <a id="resc-nav" class="nav-link" href="active_rti.php">Active RTI</a>
                </li>
                <li class="nav-item">
                    <a id="cmpltd-nav" class="nav-link" href="manage_departments.php">Manage Departments</a>
                </li>
                <li class="nav-item">
                    <a id="cmpltd-nav" class="nav-link" href="rti_history.php">RTI History</a>
                </li>
            </ul>
            <a href="../login.php">
                <button class="btn btn-danger" name="logout" type="submit">Logout</button>
            </a>
        </div>
    </div>
</nav>