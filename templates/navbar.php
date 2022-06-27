<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <img class="" src="<?= $config[ 'urls' ][ 'img' ] . "icon-128x128.png"; ?>" height="32px" width="32px" alt="Icon">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0 ml-2">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Finance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            </ul>
            <div class="d-flex">
                <button id="btn-logout" name="btn-logout" class="btn btn-danger" type="button">
                    <i class="fas fa-power-off text-white"></i>
                </button>
            </div>
        </div>
    </div>
</nav>