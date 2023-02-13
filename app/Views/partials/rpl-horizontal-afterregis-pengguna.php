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
                        <!-- <img src="assets/images/logo-light.png" alt="" height="19"> -->
                        <img src="<?= base_url() ?>/assets/images/logo-light-icon.png" alt="" height="30">

                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
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
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                        alt="Header Avatar"> -->
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= session()->get("username") ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= base_url('Admin') ?>"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile">Profile</span></a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">Logout</span></a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('Admin') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Dashboard' ?></span>
                            <div class="arrow-down"></div>
                        </a>
                    </li>
                    <?php
                    if (session()->get('sttpengguna') == 1) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('pengguna') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Data Pengguna' ?></span>
                            <div class="arrow-down"></div>
                        </a>
                    </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 1) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('resetpassmhs') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span
                                key="t-dashboards"><?= 'Reset Akun Maba' ?></span>
                            <div class="arrow-down"></div>
                        </a>
                    </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 3) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('data-mhs-per-prodi') ?>"
                            id="topnav-dashboard" role="button" target="_blank">
                            <i class="bx bx-home-circle me-2"></i><span
                                key="t-dashboards"><?= 'Data Klaim Mahasiswa' ?></span>
                            <div class="arrow-down"></div>
                        </a>
                    </li>
                    <?php
                    };

                    if (session()->get('sttpengguna') == 1) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('dataasessor') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Data Asessor' ?></span>
                            <div class="arrow-down"></div>
                        </a>
                    </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 1) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('cpmk') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span
                                key="t-dashboards"><?= 'Data Matakuliah' ?></span>
                            <div class="arrow-down"></div>
                        </a>
                    </li>
                    <?php
                    };
                    ?>


                </ul>
            </div>
        </nav>
    </div>
</div>