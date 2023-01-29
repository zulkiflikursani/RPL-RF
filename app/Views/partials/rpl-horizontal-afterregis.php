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
                    <a class="dropdown-item" href="<?= base_url('Biodata') ?>"><i
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
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span
                                key="t-dashboards"><?= lang('Files.Dashboards') ?></span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                            <a href="/Biodata" class="dropdown-item" key="t-default"><?= lang('Files.Dashboard') ?></a>
                            <!-- <a href="dashboard-saas" class="dropdown-item" key="t-saas"><?= lang('Files.Saas') ?></a>
                            <a href="dashboard-crypto" class="dropdown-item"
                                key="t-crypto"><?= lang('Files.Crypto') ?></a>
                            <a href="dashboard-blog" class="dropdown-item" key="t-blog"><?= lang('Files.Blog') ?></a> -->
                        </div>
                        <a>
                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                                <a href="/Biodata" class="dropdown-item"
                                    key="t-default"><?= lang('Files.Dashboard') ?></a>
                                <!-- <a href="dashboard-saas" class="dropdown-item" key="t-saas"><?= lang('Files.Saas') ?></a>
                            <a href="dashboard-crypto" class="dropdown-item"
                                key="t-crypto"><?= lang('Files.Crypto') ?></a>
                            <a href="dashboard-blog" class="dropdown-item" key="t-blog"><?= lang('Files.Blog') ?></a> -->
                            </div>
                    </li>

                    <?php
                    if (isset($databio)) {
                        if ($databio != null) {

                            if (isset($databio['jenis_rpl'])) {
                                $jenis_rpl = $databio['jenis_rpl'];
                            } else {
                                if (isset($databio[0]['jenis_rpl'])) {
                                    $jenis_rpl = $databio[0]['jenis_rpl'];
                                } else {

                                    $jenis_rpl = null;
                                }
                            }
                            if ($jenis_rpl != null) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('upload') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards"><?= 'Upload Berkas' ?></span>
                            <div class="arrow-down"></div>
                        </a>


                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('assesment-mandiri') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span
                                key="t-dashboards"><?= 'Assesment Mandiri' ?></span>
                            <div class="arrow-down"></div>
                        </a>


                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="<?= base_url('respon-asessor') ?>" id="topnav-dashboard"
                            role="button">
                            <i class="bx bx-home-circle me-2"></i><span
                                key="t-dashboards"><?= 'Respon Asessor' ?></span>
                            <div class="arrow-down"></div>
                        </a>


                    </li>
                    <?php
                            }
                        }
                    }
                    ?>




                </ul>
            </div>
        </nav>
    </div>
</div>