<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include("partials/rpl-horizontal-registrasi") ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?= $page_title ?>

                    <?php
                    if (isset($datasubmit)) {
                        ($datasubmit['ta_akademik']);
                    }

                    if (isset($dataerror)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        foreach ($dataerror as $error) {

                            echo $error . "</br>";
                        };
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                    }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Registrasi RPL</h4>

                                    <form method="POST" action="<?= base_url("Front/Registrasi") ?>">
                                        <div class="mb-3">
                                            <label for="formrow-nama-input" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="formrow-firstname-input"
                                                name="nama" placeholder="Masukkan Nama"
                                                value="<?= $datasubmit["nama"] ?: '' ?>">
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input"
                                                        name="email" placeholder="Masukkan Email ID"
                                                        value="<?= $datasubmit["email"] ?: '' ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat" placeholder="Masukkan Alamat"
                                                        value="<?= $datasubmit["alamat"] ?: '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Kota
                                                        Kabupaten</label>
                                                    <input type="text" class="form-control" id="formrow-inputKab"
                                                        name="kab" placeholder="Masukkan Kota Kabupaten"
                                                        value="<?= $datasubmit["kotkab"] ?: '' ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi"
                                                        class="form-label">Provinsi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="provinsi" placeholder="Masukkan Provinsi"
                                                        value="<?= $datasubmit["propinsi"] ?: '' ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputInstansi" class="form-label">Instansi
                                                        Asal</label>
                                                    <input type="text" class="form-control" id="formrow-inputInstansi"
                                                        name="instansi" placeholder="Masukkan Instansi Asal"
                                                        value="<?= $datasubmit["instansi_asal"] ?: '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Pendidikan
                                                        Terakhir</label>
                                                    <select class="form-select" id="autoSizingSelect" name='pendidikan'>
                                                        <option selected>Pilih...</option>
                                                        <option value="1"
                                                            <?php ($datasubmit["pendidikan"] == "1" ? 'selected="selected"' : '') ?>>
                                                            SD</option>
                                                        <option value="2"
                                                            <?php ($datasubmit["pendidikan"] == "2" ? 'selected="selected"' : '') ?>>
                                                            SLTP</option>
                                                        <option value="3"
                                                            <?php ($datasubmit["pendidikan"] == "3" ? 'selected="selected"' : '') ?>>
                                                            SLTA</option>
                                                        <option value="4"
                                                            <?php ($datasubmit["pendidikan"] == "4" ? 'selected="selected"' : '') ?>>
                                                            D3</option>
                                                        <option value="5"
                                                            <?php ($datasubmit["pendidikan"] == "5" ? 'selected="selected"' : '') ?>>
                                                            S1</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nohp" placeholder="Masukkan No. HP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi RPL</label>
                                                    <select class="form-select" id="autoSizingSelect" name='prodi'>
                                                        <option value=''
                                                            <?php ($datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>
                                                        <option value="1"
                                                            <?php ($datasubmit["kode_prodi"] == "1" ? 'selected="selected"' : '') ?>>
                                                            D3 Akuntansi</option>
                                                        <option value="2"
                                                            <?php ($datasubmit["kode_prodi"] == "2" ? 'selected="selected"' : '') ?>>
                                                            D3 Binawisata</option>
                                                        <option value="3"
                                                            <?php ($datasubmit["kode_prodi"] == "3" ? 'selected="selected"' : '') ?>>
                                                            S1 Akuntansi</option>
                                                        <option value="4"
                                                            <?php ($datasubmit["kode_prodi"] == "4" ? 'selected="selected"' : '') ?>>
                                                            S1 Arsitektur</option>
                                                        <option value="5"
                                                            <?php ($datasubmit["kode_prodi"] == "5" ? 'selected="selected"' : '') ?>>
                                                            S1 Ilmu Hubungan Internasional</option>
                                                        <option value="6"
                                                            <?php ($datasubmit["kode_prodi"] == "6" ? 'selected="selected"' : '') ?>>
                                                            S1 Ilmu Komunikasi</option>
                                                        <option value="7"
                                                            <?php ($datasubmit["kode_prodi"] == "7" ? 'selected="selected"' : '') ?>>
                                                            S1 Informatika</option>
                                                        <option value="8"
                                                            <?php ($datasubmit["kode_prodi"] == "8" ? 'selected="selected"' : '') ?>>
                                                            S1 Manajemen</option>
                                                        <option value="9"
                                                            <?php ($datasubmit["kode_prodi"] == "9" ? 'selected="selected"' : '') ?>>
                                                            S1 Sastra Inggris</option>
                                                        <option value="10"
                                                            <?php ($datasubmit["kode_prodi"] == "10" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Elektro</option>
                                                        <option value="11"
                                                            <?php ($datasubmit["kode_prodi"] == "11" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Kimia</option>
                                                        <option value="12"
                                                            <?php ($datasubmit["kode_prodi"] == "12" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Mesin</option>
                                                        <option value="13"
                                                            <?php ($datasubmit["kode_prodi"] == "13" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Sipil</option>
                                                        <option value="14"
                                                            <?php ($datasubmit["kode_prodi"] == "14" ? 'selected="selected"' : '') ?>>
                                                            S2 Ilmu Komunikasi</option>
                                                        <option value="15"
                                                            <?php ($datasubmit["kode_prodi"] == "15" ? 'selected="selected"' : '') ?>>
                                                            S2 Manajemen</option>
                                                        <option value="16"
                                                            <?php ($datasubmit["kode_prodi"] == "16" ? 'selected="selected"' : '') ?>>
                                                            S2 Rekayasa Infrastruktur dan Lingkungan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>


                                        <div>
                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->






            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



        <?= $this->include('partials/rpl-footer') ?>
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?= $this->include('partials/vendor-scripts') ?>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>