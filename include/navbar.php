<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="#pablo">Pet Shop - <?= $_SESSION['username'] ?></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn-rotate" href="include/logout.php">
                        <!-- <i class="nc-icon nc-settings-gear-65"></i> -->
                        <span>Logout </span>
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <p>
                            <span class="d-lg-none d-md-block">Logout</span>
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
