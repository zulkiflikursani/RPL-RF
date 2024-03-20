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
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                        alt="Header Avatar"> -->
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= session()->get("username") ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= base_url('Admin') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile">Profile</span></a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
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
                        <a class="nav-link arrow-none" href="<?= base_url('Admin') ?>" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Dashboard' ?></span>

                        </a>
                    </li>
                    <?php

                    if (session()->get('sttpengguna') == 1) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('pengguna') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Pengguna' ?></span>

                            </a>
                        </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 1) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= "Mahasiswa" ?></span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                                <a href="<?= base_url('resetpassmhs') ?>" class="dropdown-item" key="t-default"><?= "Password & Biodata" ?></a>
                                <a href="<?= base_url('adminklaim') ?>" class="dropdown-item" key="t-default"><?= "Klaim Mandiri" ?></a>


                            </div>
                        </li>

                    <?php
                    };
                    if (session()->get('sttpengguna') == 3) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('statusklaim') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Status Klaim' ?></span>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('menu-data-mhs-per-prodi') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Daftar Peserta' ?></span>

                            </a>
                        </li>
                    <?php
                    };

                    if (session()->get('sttpengguna') == 1) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('dataasessor') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Asessor' ?></span>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('data-peserta') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Rekapitulasi Peserta' ?></span>

                            </a>
                        </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 1) {
                    ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= "Kurikulum" ?></span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                <a href="<?= base_url('cpmk') ?>" class="dropdown-item" key="t-default"><?= "Matakuliah Umum & CPMK" ?></a>
                                <a href="<?= base_url('daftar-mk-rpl-admin') ?>" class="dropdown-item" key="t-default"><?= "Penyajian Matakuliah RPL" ?></a>

                            </div>
                        </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 3) {
                    ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= "Kurikulum" ?></span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                <a href="<?= base_url('cpmk-prodi') ?>" class="dropdown-item" key="t-default"><?= "Matakuliah & CPMK" ?></a>
                                <a href="<?= base_url('daftar-mk-rpl-prodi') ?>" class="dropdown-item" key="t-default"><?= "Penyajian Matakuliah RPL" ?></a>

                            </div>
                        </li>

                    <?php
                    };
                    if (session()->get('sttpengguna') == 3) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('data-asessi-prodi') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Asessor' ?></span>

                            </a>
                        </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 3) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('data-asessor-prodi') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Asessi' ?></span>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('setup-konsentrasi') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Konsentrasi' ?></span>

                            </a>
                        </li>
                    <?php
                    };
                    if (session()->get('sttpengguna') == 1) {
                    ?>

                    <?php
                    };
                    if (session()->get('sttpengguna') == 1) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= "Setup" ?></span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                                <a href="<?= base_url('setup-tarif') ?>" class="dropdown-item" key="t-default"><?= "Tarif Program Rekognisi" ?></a>
                                <a href="<?= base_url('setup-taakademik') ?>" class="dropdown-item" key="t-default"><?= "Aktivasi Tahun Akademik" ?></a>
                                <a href="<?= base_url('setup-rpl') ?>" class="dropdown-item" key="t-default"><?= "Prodi Penyelenggara RPL" ?></a>


                            </div>
                        </li>

                    <?php

                    };
                    if (session()->get('sttpengguna') == 5) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('data-keuangan') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Data Keuangan' ?></span>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('data-status-mhs/' . $ta_akademik) ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Data Status Pembayaran' ?></span>

                            </a>
                        </li>
                    <?php
                    };

                    if (session()->get('sttpengguna') == 6) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="<?= base_url('home-akademik-2') ?>" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Data Singkron Siska' ?></span>

                            </a>
                        </li>
                    <?php
                    };
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('/template/Manual-Book-Pengguna-SILAJU.pdf') ?>" id="topnav-dashboard" role="button" target='_blank'>
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Panduan Silaju' ?></span>

                        </a>


                    </li>



                </ul>
            </div>
        </nav>
    </div>
</div>