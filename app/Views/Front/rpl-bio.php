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
                                            <input type="text" class="form-control" id="formrow-firstname-input" name="nama" placeholder="Masukkan Nama" value="<?= $datasubmit["nama"] ?: '' ?>">
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input" name="email" placeholder="Masukkan Email ID" value="<?= $datasubmit["email"] ?: '' ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat" name="alamat" placeholder="Masukkan Alamat" value="<?= $datasubmit["alamat"] ?: '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Kota
                                                        Kabupaten</label>
                                                    <input type="text" class="form-control" id="formrow-inputKab" name="kab" placeholder="Masukkan Kota Kabupaten" value="<?= $datasubmit["kotkab"] ?: '' ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">Provinsi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi" name="provinsi" placeholder="Masukkan Provinsi" value="<?= $datasubmit["propinsi"] ?: '' ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputInstansi" class="form-label">Instansi
                                                        Asal</label>
                                                    <input type="text" class="form-control" id="formrow-inputInstansi" name="instansi" placeholder="Masukkan Instansi Asal" value="<?= $datasubmit["instansi_asal"] ?: '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Pendidikan
                                                        Terakhir</label>
                                                    <select class="form-select" id="autoSizingSelect" name='pendidikan'>
                                                        <option selected>Pilih...</option>
                                                        <option value="1" <?= ($datasubmit["didikakhir"] == "1" ? 'selected="selected"' : '') ?>>
                                                            SD</option>
                                                        <option value="2" <?= ($datasubmit["didikakhir"] == "2" ? 'selected="selected"' : '') ?>>
                                                            SLTP</option>
                                                        <option value="3" <?= ($datasubmit["didikakhir"] == "3" ? 'selected="selected"' : '') ?>>
                                                            SLTA</option>
                                                        <option value="4" <?= ($datasubmit["didikakhir"] == "4" ? 'selected="selected"' : '') ?>>
                                                            D3</option>
                                                        <option value="5" <?= ($datasubmit["didikakhir"] == "5" ? 'selected="selected"' : '') ?>>
                                                            S1</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi" name="nohp" placeholder="Masukkan No. HP">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi" name="nohp" placeholder="Masukkan No. HP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi RPL</label>
                                                    <select class="form-select" id="autoSizingSelect" name='prodi'>
                                                        <option value='' <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>
                                                        <?php
                                                        $db      = \Config\Database::connect();
                                                        $result = $db->query("select * from prodi")->getResult();
                                                        if ($result != null) {
                                                            foreach ($result as $row) {
                                                        ?>
                                                                <option value="<?= $row->kode_prodi ?>" <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == $row->kode_prodi ? 'selected="selected"' : '') ?>>
                                                                    <?= $row->nama_prodi . $datasubmit['kode_prodi'] ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
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