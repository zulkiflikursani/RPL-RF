<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $title_meta ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/rpl-index.css">

</head>

<body>
    <div class="container-fluid">
        <section class="banner min-h d-flex justify-content-center  ">
            <video autoplay muted loop id="video">
                <source src="<?= base_url() ?>/assets/video/web-banner.webm" type="video/webm">
                <p>Your browser cannot play the provided video file.</p>
            </video>
            <div class="container position-absolute" data-aos="fade-up" data-aos-delay="500">
                <nav class=" navbar navbar-expand-lg navbar-light bg-light-transparan">
                    <a class="navbar-brand" href="#">Universitas Fajar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="https://unifa.ac.id/pages/tentang-unifa" target="_blank">Tentang
                                    Unifa <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://unifa.ac.id/pages/pendidikan" target="_blank">Program
                                    Studi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="https://unifa.ac.id/pages/kemahasiswaan">
                                    Mahasiswa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="https://simba.unifa.ac.id"> Pendaftaran Maba
                                    Reguler</a>
                            </li>

                        </ul>
                    </div>
                </nav>
                <div class="page-content ">
                    <div class="row hero col-lg-12 mt-5 justify-content-center text-center">
                        <div class="d-flex text-content">
                            <div class="d-flex flex-column text-column">

                                <h4 class="mb-3">Hallo......</h4>
                                <h2>Mau Kuliah Tapi .....</br>Tidak ingin mulai dari awal lagi...</h1>
                                    <div class="">
                                        <a href="<?= base_url('login'); ?>"><button class="button btn btn-primary">Login</button></a>
                                        <a href="<?= base_url('registrasi'); ?>"><button class=" button btn
                                        btn-secondary">Registrasi</button></a>
                                    </div>
                            </div>
                        </div>
                        <div class=" img-unifa bg-black justify-content-end">
                            <img src="assets/images/img-unifa-index.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>