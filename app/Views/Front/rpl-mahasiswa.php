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

                        if (isset($datasubmit["jenis_rpl"])) {
                            $biodata = $datasubmit;
                        } else {

                            $biodata = $datasubmit[0];
                        }
                    }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Registrasi</h4>
                                    <div>
                                        <div class="mb-3">
                                            <h3 for="formrow-nama-input" class="form-label">No Registrasi :
                                                <?= session()->get("noregis") ?>
                                            </h3>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formrow-nama-input" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="formrow-firstname-input"
                                                name="nama" placeholder="Masukkan Nama"
                                                value="<?= (isset($biodata["nama"]) ? $biodata["nama"] : '') ?>"
                                                readonly>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input"
                                                        name="email" placeholder="Masukkan Email ID"
                                                        value="<?= (isset($biodata["email"]) ? $biodata["email"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat" placeholder="Masukkan Alamat"
                                                        value="<?= (isset($biodata["alamat"]) ? $biodata["alamat"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Kota
                                                        Kabupaten</label>
                                                    <input type="text" class="form-control" id="formrow-inputKab"
                                                        name="kab" placeholder="Masukkan Kota Kabupaten"
                                                        value="<?= (isset($biodata["kotkab"]) ? $biodata["kotkab"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi"
                                                        class="form-label">Provinsi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="provinsi" placeholder="Masukkan Provinsi"
                                                        value="<?= (isset($biodata["propinsi"]) ? $biodata["propinsi"] : '') ?>"
                                                        readonly>
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
                                                        value="<?= (isset($biodata["instansi_asal"]) ? $biodata["instansi_asal"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nohp" placeholder="Masukkan No. HP"
                                                        value="<?= (isset($biodata["nohape"]) ? $biodata["nohape"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">Pendidikan
                                                        Terakhir </label>
                                                    <select class="form-select" id="autoSizingSelect" name='didakhir'
                                                        disabled>
                                                        <option value="1"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "1" ? 'selected="selected"' : '') ?>>
                                                            SD</option>
                                                        <option value="2"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "2" ? 'selected="selected"' : '') ?>>
                                                            SLTP</option>
                                                        <option value="3"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "3" ? 'selected="selected"' : '') ?>>
                                                            SLTA</option>
                                                        <option value="4"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "4" ? 'selected="selected"' : '') ?>>
                                                            D3</option>
                                                        <option value="5"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "5" ? 'selected="selected"' : '') ?>>
                                                            S1</option>
                                                        <option value="6"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "6" ? 'selected="selected"' : '') ?>>
                                                            D2</option>
                                                        <option value="7"
                                                            <?= (isset($biodata["didikakhir"]) && $biodata["didikakhir"] == "7" ? 'selected="selected"' : '') ?>>
                                                            D3</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Nama Ibu
                                                        Kandung</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat" placeholder="Masukkan Alamat"
                                                        value="<?= (isset($biodata["ibu_kandung"]) ? $biodata["ibu_kandung"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Tempat
                                                        Lahir</label>
                                                    <input type="text" class="form-control" id="formrow-inputKab"
                                                        name="kab" placeholder="Masukkan Kota Kabupaten"
                                                        value="<?= (isset($biodata["t_lahir"]) ? $biodata["t_lahir"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">Tanggal
                                                        Lahir</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="provinsi" placeholder="Masukkan Provinsi"
                                                        value="<?= (isset($biodata["ttl"]) ? $biodata["ttl"] : '') ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi RPL</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="prodi" placeholder="Masukkan Prodi"
                                                        value="<?= (isset($biodata["kode_prodi"]) ? $biodata["kode_prodi"] : '') ?>"
                                                        hidden>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nmnohp" placeholder="Masukkan No. HP"
                                                        value="<?= (isset($prodi) ? $prodi : '') ?>" disabled>

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Jenis
                                                        RPL</label>

                                                    <?php
                                                    $db = \Config\Database::connect();
                                                    $noregis = session()->get('noregis');
                                                    $cekberkas = $db->query("select no_peserta from dok_portofolio where no_peserta='$noregis'")->getRow();
                                                    if (!isset($cekberkas)) {

                                                    ?>
                                                    <select class="form-select" id="autoSizingSelect" name='jenis_rpl'
                                                        <?= (isset($biodata["jenis_rpl"]) ? "disabled" : "") ?>>
                                                        <option value=''
                                                            <?= (isset($biodata["jenis_rpl"]) && $biodata["jenis_rpl"] == "" ? 'selected="selected" ' : '') ?>>
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
                                                    <?php

                                                    } else {
                                                    ?>
                                                    <select class="form-select" id="autoSizingSelect" name='jenis_rpl'
                                                        <?= (isset($biodata["jenis_rpl"]) ? "disabled" : "") ?>
                                                        disabled>
                                                        <option value=''
                                                            <?= (isset($biodata["jenis_rpl"]) && $biodata["jenis_rpl"] == "" ? 'selected="selected" ' : '') ?>>
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
                                                    <?php
                                                    }

                                                    ?>

                                                    <?= (isset($biodata["jenis_rpl"]) && isset($cekberkas) ? '<input type="text" name="jenis_rpl" id="" value="' . $biodata["jenis_rpl"] . '" hidden readonly>' : "") ?>



                                                </div>


                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan"
                                                        class="form-label">Konsentrasi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="prodi" placeholder="Masukkan Prodi"
                                                        value="<?= (isset($biodata["kode_konsentrasi"]) ? $biodata["kode_konsentrasi"] : '') ?>"
                                                        hidden>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nmnohp" placeholder="Tidak ada konsentrasi"
                                                        value="<?= (isset($konsentrasi) ? $konsentrasi : '') ?>"
                                                        disabled>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="row ">
                                            <label for="formrow-inputPendidikan" class="form-label">KTP atau Kartu
                                                Keluarga</label>
                                            <div class="col-md-2">

                                                <a class="button btn btn-primary btn-sm " target="_blank"
                                                    href='<?= base_url() . "/uploads/berkas/$noregis/ii$noregis.pdf" ?>'>
                                                    Lihat Identitas</a>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <label for="formrow-inputPendidikan" class="form-label">Ijazah</label>
                                            <div class="col-md-2">

                                                <a target="_blank"
                                                    href='<?= base_url() . "/uploads/berkas/$noregis/i$noregis.pdf" ?>'
                                                    class="button btn btn-primary btn-sm "> Lihat Ijazah</a>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <label for="formrow-inputPendidikan" class="form-label">Bukti
                                                Pembayaran</label>
                                            <div class="col-md-2">

                                                <a target="_blank"
                                                    href='<?= base_url() . "/uploads/berkas/$noregis/bb$noregis.pdf" ?>'
                                                    class="button btn btn-primary btn-sm "> Lihat Bukti Pembayaran</a>
                                            </div>
                                        </div>


                                    </div>
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
    <!-- <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script> -->

    <!-- dashboard init -->
    <!-- <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script> -->

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script>
    function gantiijazah() {
        label = $('.ganti').html();
        if (label == 'Ganti') {
            $('.ganti').html('Batal')
            $('inputijazah').attr('required=false')
        } else {
            $('.ganti').html('Ganti')
            $('inputijazah').attr('required=true')

        }
        $('#input-ijazah').toggle();
    }
    </script>
</body>

</html>