<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

</head>

<body>
    <!-- <div class="home-btn d-none d-sm-block">
        <a href="/" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div> -->

    <section class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="home-wrapper">
                        <div class="mb-5">
                            <a href="/" class="d-block auth-logo">
                                <!-- <img src="assets/images/logo-light.png" alt="" height="20" class="auth-logo-light mx-auto"> -->
                                <img src="assets/images/logo-light.png" alt="" height="20" class="auth-logo-light mx-auto">
                            </a>
                            <h3>SILAJU UNIFA</h3>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="assets/images/maintenance.svg" alt="" class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-5">Website Sedang Dalam Perawatan Data</h3>
                        <p>Silahkan kembali beberapa saat lagi.</p>


                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?= $this->include('partials/vendor-scripts') ?>

    <script src="assets/js/app.js"></script>

</body>

</html>