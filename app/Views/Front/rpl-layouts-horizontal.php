<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        right: 10px;
        left: auto;
    }
    </style>
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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Registrasi</h4>

                                    <form method="POST" action="<?= base_url("Front/Registrasi") ?>"
                                        enctype="multipart/form-data">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="mb-3">
                                                    <label for="formrow-nama-input" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input"
                                                        name="nama" placeholder="Masukkan Nama"
                                                        value="<?= (isset($datasubmit["nama"]) ? $datasubmit["nama"] : '') ?>"
                                                        required>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input"
                                                        name="email" placeholder="Masukkan Email ID"
                                                        value="<?= (isset($datasubmit["email"]) ? $datasubmit["email"] : '') ?>"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat" placeholder="Masukkan Alamat"
                                                        value="<?= (isset($datasubmit["alamat"]) ? $datasubmit["alamat"] : '') ?>"
                                                        required>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi"
                                                        class="form-label">Provinsi</label>
                                                    <!-- <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="provinsi" placeholder="Masukkan Provinsi"
                                                        value="<?= (isset($datasubmit["propinsi"]) ? $datasubmit["propinsi"] : '') ?>"
                                                        required> -->
                                                    <select name="provinsi" id="provinsi" class="form-select select2"
                                                        onchange="getkab()" required>
                                                        <option val="">Pilih Provinsi</option>
                                                        <?php
                                                        if (isset($dataprov)) {
                                                            foreach ($dataprov as $a) {
                                                                if (isset($datasubmit["propinsi"])) {
                                                                    if ($datasubmit["propinsi"] == $a->NMPROTBPRO) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    };
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo "<option kdprov='".$a->KDPROTBPRO."' $selected>".$a->NMPROTBPRO."</option>";
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Kota
                                                        Kabupaten</label>
                                                    <select name="kab" id="kab" class="form-select select2"
                                                        required></select>
                                                </div>


                                            </div>
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Tempat
                                                        Lahir</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="tlahir" placeholder="Masukkan Tempat Lahir"
                                                        value="<?= (isset($datasubmit["tlahir"]) ? $datasubmit["tlahir"] : '') ?>"
                                                        required>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputInstansi" class="form-label">Tanggal
                                                        Lahir</label>
                                                    <input type="date" class="form-control" id="formrow-inputInstansi"
                                                        name="ttl" placeholder="Masukkan Tanggal lahir"
                                                        value="<?= (isset($datasubmit["ttl"]) ? $datasubmit["ttl"] : '') ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputInstansi" class="form-label">Nama Ibu
                                                        Kandung</label>
                                                    <input type="text" class="form-control" id="formrow-inputInstansi"
                                                        name="ibukandung" placeholder="Masukkan Nama Ibu Kandung"
                                                        value="<?= (isset($datasubmit["ibukandung"]) ? $datasubmit["ibukandung"] : '') ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nohp" placeholder="Masukkan No. HP"
                                                        value="<?= (isset($datasubmit["nohape"]) ? $datasubmit["nohape"] : '') ?>"
                                                        required>
                                                </div>
                                                <div class="row">
                                                    <div class="">
                                                        <div class="mb-3">
                                                            <label for="formrow-inputInstansi"
                                                                class="form-label">Instansi
                                                                Asal</label>
                                                            <input type="text" class="form-control"
                                                                id="formrow-inputInstansi" name="instansi"
                                                                placeholder="Masukkan Instansi Asal"
                                                                value="<?= (isset($datasubmit["instansi_asal"]) ? $datasubmit["instansi_asal"] : '') ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="">
                                                        <div class="mb-3">
                                                            <label for="formrow-inputInstansi" class="form-label">Nomor
                                                                Induk Kependudukan (NIK)</label>
                                                            <input type="text" class="form-control"
                                                                id="formrow-inputInstansi" name="nik"
                                                                placeholder="Masukkan Nomor Induk Keluarga (NIK)"
                                                                value="<?= (isset($datasubmit["nik"]) ? $datasubmit["nik"] : '') ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan"
                                                            class="form-label">Pendidikan
                                                            Terakhir</label>
                                                        <select class="form-select" id="autoSizingSelect"
                                                            name='pendidikan'>
                                                            <option selected>Pilih...</option>
                                                            <option value="1"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "1" ? 'selected="selected"' : '') ?>>
                                                                SD</option>
                                                            <option value="2"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "2" ? 'selected="selected"' : '') ?>>
                                                                SLTP</option>
                                                            <option value="3"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "3" ? 'selected="selected"' : '') ?>>
                                                                SLTA</option>
                                                            <option value="4"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "6" ? 'selected="selected"' : '') ?>>
                                                                D1</option>
                                                            <option value="5"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "7" ? 'selected="selected"' : '') ?>>
                                                                D2</option>
                                                            <option value="4"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "4" ? 'selected="selected"' : '') ?>>
                                                                D3</option>
                                                            <option value="5"
                                                                <?php (isset($datasubmit["pendidikan"]) && $datasubmit["pendidikan"] == "5" ? 'selected="selected"' : '') ?>>
                                                                S1</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Jenis
                                                        RPL</label>
                                                    <select class="form-select" id="jenis_rpl" name='jenis_rpl'
                                                        onchange="findprodi($(this))">
                                                        <option value=''>
                                                            Pilih...</option>
                                                        <option value="1">A1</option>
                                                        <option value="2">A2</option>
                                                        <option value="3">A3</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi Pilihan</label>
                                                    <select class="form-select" id="kode_prodi" name='prodi'
                                                        onchange="findkonsentrasi()">
                                                        <option value=''
                                                            <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan"
                                                        class="form-label">Konsentrasi</label>
                                                    <select class="form-select" id="konsentrasi" name='konsentrasi'
                                                        required>


                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="form-check-label" for="formRadios1">
                                                Upload KTP atau Kartu Keluarga
                                            </label>
                                            <div class="input-group mt-3" id='input-buktibayar'>
                                                <input type="file" class="form-control" name='identitas'
                                                    id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                    accept="application/pdf" aria-label="buktiBayar" required>
                                            </div>
                                            <span class="text-danger">Note: File PDF dengan ukuran maksimal 1
                                                Mb</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-check-label" for="formRadios1">
                                                Upload Ijazah
                                            </label>
                                            <div class="input-group mt-3" id='input-ijazah'>
                                                <input type="file" class="form-control" name='ijazah'
                                                    id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                    accept="application/pdf" aria-label="ijazah" required>
                                            </div>
                                            <span class="text-danger">Note: File PDF dengan ukuran maksimal 1
                                                Mb</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-check-label" for="formRadios1">
                                                Upload Bukti Pembayaran
                                            </label>
                                            <div class="input-group mt-3" id='input-buktibayar'>
                                                <input type="file" class="form-control" name='buktiBayar'
                                                    id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                    accept="application/pdf" aria-label="buktiBayar" required>
                                            </div>
                                            <span class="text-danger">Note: File PDF dengan ukuran maksimal 1
                                                Mb</span>
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
    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>


    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script> -->


    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script>
    $('document').ready(function() {
        $('.select2').select2({
            placeholder: 'Select an option'
        });
    })

    function findkonsentrasi() {
        prodi = $('#kode_prodi').val();
        url = '<?= base_url("konsentrasi-by-prodi") ?>'

        $.post(url, {
            prodi: prodi
        }, function(data) {
            data = JSON.parse(data)
            $('#konsentrasi').children().remove();
            if (data.length == 0) {

                $('#konsentrasi').prop('required', false)
                $('#konsentrasi').prop('readonly', true)
                $('#konsentrasi').append("<option value=''> Tidak ada pilihan konsentrasi</option>")
            } else {
                $('#konsentrasi').prop('required', true)
                $('#konsentrasi').append("<option value=''> Pilih Konsentrasi.....</option>")

            }

            $.each(data, function(i, row) {
                $("#konsentrasi").append("<option value='" + row['kode_konsentrasi'] + "'>" + row[
                    'konsentrasi'] + "</option>")

            })

        })

    }

    function findprodi(ini) {
        url = '<?= base_url('getProdiByRpl') ?>'
        jenisrpl = ini.val()
        if (jenisrpl != "") {
            $.post(url, {
                jenis_rpl: jenisrpl
            }, function(data) {

                data = JSON.parse(data)

                $('#kode_prodi').children().remove()
                $('#kode_prodi').append("<option value=''> Pilih Prodi.....</option>")


                $.each(data, function(i, row) {
                    $('#kode_prodi').append("<option value='" + row['kode_prodi'] + "'>" + row[
                        'nama_prodi'] + "</option>")

                })

            })
        } else {
            $('#kode_prodi').children().remove()
            $('#kode_prodi').append("<option val=''> Pilih Prodi</option>")


        }
    }

    function getkab() {
        $('#loading').show();
        $('#kab').children().remove();
        url = '<?= base_url('getKab') ?>'
        a = $('#provinsi option:selected').attr('kdprov');
        $.post(url, {
            "a": a
        }).done(function(data) {
            data = JSON.parse(data)
            // console.log(data);
            setkab(data)
            $('#loading').hide();


        })
    }

    function setkab(data) {
        $.each(data, function(index, row) {
            $('#kab').append("<option>" + row['NMKABTBPRO'] + "</option>")
        })

    }
    </script>
</body>

</html>