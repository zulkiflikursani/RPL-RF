<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include("partials/rpl-horizontal-afterregis") ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?= $page_title ?>

                    <?php
                    if (isset($dataerror)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        foreach ($dataerror as $error) {

                            echo $error . "</br>";
                        };
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                    }

                    if (isset($status)) {
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Memperbaharui data.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    if (isset($datasubmit)) {
                        // print_r($datasubmit-nama);
                        if (isset($jenis_rpl)) {
                            $biodata = $datasubmit;
                        } else {

                            $biodata = $datasubmit[0];
                        }
                        // foreach ($datasubmit as $bio) {
                        //     $biodata['nama'] = $bio['nama'];
                        //     $biodata['email'] = $bio['email'];
                        //     $biodata['alamat'] = $bio['alamat'];
                        //     $biodata['kotkab'] = $bio['kotkab'];
                        //     $biodata['propinsi'] = $bio['propinsi'];
                        //     $biodata['instansi_asal'] = $bio['instansi_asal'];
                        //     $biodata['nohape'] = $bio['nohape'];
                        //     $biodata['kode_prodi'] = $bio['kode_prodi'];
                        // }
                    }

                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Registrasi RPL</h4>
                                    <form method="POST" action="<?= base_url("Front/Insertbiodata") ?>">
                                        <div class="mb-3">
                                            <label for="formrow-nama-input" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="formrow-firstname-input"
                                                name="nama" placeholder="Masukkan Nama"
                                                value="<?= (isset($biodata["nama"]) ? $biodata["nama"] : '') ?>">
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input"
                                                        name="email" placeholder="Masukkan Email ID"
                                                        value="<?= (isset($biodata["email"]) ? $biodata["email"] : '') ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat" placeholder="Masukkan Alamat"
                                                        value="<?= (isset($biodata["alamat"]) ? $biodata["alamat"] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Kota
                                                        Kabupaten</label>
                                                    <input type="text" class="form-control" id="formrow-inputKab"
                                                        name="kab" placeholder="Masukkan Kota Kabupaten"
                                                        value="<?= (isset($biodata["kotkab"]) ? $biodata["kotkab"] : '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi"
                                                        class="form-label">Provinsi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="provinsi" placeholder="Masukkan Provinsi"
                                                        value="<?= (isset($biodata["propinsi"]) ? $biodata["propinsi"] : '') ?>">
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
                                                        value="<?= (isset($biodata["instansi_asal"]) ? $biodata["instansi_asal"] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nohp" placeholder="Masukkan No. HP"
                                                        value="<?= (isset($biodata["nohape"]) ? $biodata["nohape"] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">Pendidikan
                                                        Terakhir</label>
                                                    <select class="form-select" id="autoSizingSelect" name='didakhir'>
                                                        <option value=''
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>

                                                        <option value='1'
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "1" ? 'selected="selected"' : '') ?>>
                                                            SD</option>
                                                        <option value='2'
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "2" ? 'selected="selected"' : '') ?>>
                                                            SLTP</option>
                                                        <option value='3'
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "3" ? 'selected="selected"' : '') ?>>
                                                            SLTA</option>
                                                        <option value='4'
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "4" ? 'selected="selected"' : '') ?>>
                                                            D3</option>
                                                        <option value='5'
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "5" ? 'selected="selected"' : '') ?>>
                                                            S1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi RPL</label>
                                                    <select class="form-select" id="autoSizingSelect" name='prodi'>
                                                        <option value=''
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>
                                                        <option value="1"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "1" ? 'selected="selected"' : '') ?>>
                                                            D3 Akuntansi</option>
                                                        <option value="2"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "2" ? 'selected="selected"' : '') ?>>
                                                            D3 Binawisata</option>
                                                        <option value="3"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "3" ? 'selected="selected"' : '') ?>>
                                                            S1 Akuntansi</option>
                                                        <option value="4"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "4" ? 'selected="selected"' : '') ?>>
                                                            S1 Arsitektur</option>
                                                        <option value="5"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "5" ? 'selected="selected"' : '') ?>>
                                                            S1 Ilmu Hubungan Internasional</option>
                                                        <option value="6"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "6" ? 'selected="selected"' : '') ?>>
                                                            S1 Ilmu Komunikasi</option>
                                                        <option value="7"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "7" ? 'selected="selected"' : '') ?>>
                                                            S1 Informatika</option>
                                                        <option value="8"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "8" ? 'selected="selected"' : '') ?>>
                                                            S1 Manajemen</option>
                                                        <option value="9"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "9" ? 'selected="selected"' : '') ?>>
                                                            S1 Sastra Inggris</option>
                                                        <option value="10"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "10" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Elektro</option>
                                                        <option value="11"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "11" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Kimia</option>
                                                        <option value="12"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "12" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Mesin</option>
                                                        <option value="13"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "13" ? 'selected="selected"' : '') ?>>
                                                            S1 Teknik Sipil</option>
                                                        <option value="14"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "14" ? 'selected="selected"' : '') ?>>
                                                            S2 Ilmu Komunikasi</option>
                                                        <option value="15"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "15" ? 'selected="selected"' : '') ?>>
                                                            S2 Manajemen</option>
                                                        <option value="16"
                                                            <?= (isset($biodata["kode_prodi"]) && $biodata["kode_prodi"] == "16" ? 'selected="selected"' : '') ?>>
                                                            S2 Rekayasa Infrastruktur dan Lingkungan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Jenis
                                                        RPL</label>
                                                    <select class="form-select" id="autoSizingSelect" name='jenis_rpl'>
                                                        <option value=''
                                                            <?= (isset($biodata["jenis_rpl"]) && $biodata["jenis_rpl"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>
                                                        <option value="1"
                                                            <?= (isset($biodata["jenis_rpl"]) && $biodata["jenis_rpl"] == "1" ? 'selected="selected"' : '') ?>>
                                                            A1</option>
                                                        <option value="2"
                                                            <?= (isset($biodata["jenis_rpl"]) && $biodata["jenis_rpl"] == "2" ? 'selected="selected"' : '') ?>>
                                                            A2</option>
                                                        <option value="3"
                                                            <?= (isset($biodata["jenis_rpl"]) && $biodata["jenis_rpl"] == "3" ? 'selected="selected"' : '') ?>>
                                                            A3</option>

                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                        <div>
                                            <p>Pilih Jenis RPL dan Sumbit terlebih dahulu untuk menampilkan Form Upload
                                                dokumen</p>
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