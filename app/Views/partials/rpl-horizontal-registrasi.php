<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo.svg" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>/assets/images/logo-light.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url() ?>/assets/images/logo-light-icon.png" alt="" height="30">
                        <!-- <h2 class="text-light">Universitas Fajar</h2> -->
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">

            </form>

            <div class="dropdown dropdown-mega d-none d-lg-block ms-2">

            </div>
        </div>

        <div class="d-flex">



            <div class="dropdown d-inline-block">

                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->

                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">

            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">

            </div>

            <div class="dropdown d-inline-block">

            </div>

            <div class="dropdown d-inline-block">
                <!-- <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">Henry</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button> -->
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <!-- <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile">Profile</span></a>
                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i>
                        <span key="t-my-wallet">My Wallet</span></a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i
                            class="bx bx-wrench font-size-16 align-middle me-1"></i> <span
                            key="t-settings">Settings</span></a>
                    <a class="dropdown-item" href="auth-lock-screen"><i
                            class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock
                            screen</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="auth-login"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">Logout</span></a> -->
                </div>
            </div>

            <div class="dropdown d-inline-block">
               
                <a href='<?= base_url('login') ?>'><button type="button" class="btn btn-primary mx-3">
                        LOG IN
                    </button></a>
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="desc">
                <h4 style="color:#1C1265;">REKOGNISI PEMBELAJARAN LAMPAU</h4>
            </div>
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                            <!-- <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"></span> -->
                            <a class="" style="color:#ffffff">x</a>
                        </a>
                        <!-- <div class="dropdown-menu" aria-labelledby="topnav-dashboard"> -->

                        <!-- <a href="/" class="dropdown-item" key="t-default"><?= lang('Files.Dashboard') ?></a> -->
                        <!-- <a href="dashboard-saas" class="dropdown-item" key="t-saas"><?= lang('Files.Saas') ?></a>
                            <a href="dashboard-crypto" class="dropdown-item"
                                key="t-crypto"><?= lang('Files.Crypto') ?></a>
                            <a href="dashboard-blog" class="dropdown-item" key="t-blog"><?= lang('Files.Blog') ?></a> -->
                        <!-- </div> -->
                    </li>




                </ul>
            </div>
        </nav>
    </div>
</div>