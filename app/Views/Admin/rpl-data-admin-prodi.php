<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        right: 10px !important;
        left: auto !important;
    }

    .choose-position .select2-container {
        width: 100% !important;
    }
    </style>

</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include("partials/rpl-horizontal-afterregis-pengguna") ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?= $page_title ?>

                    <?php

                    if (isset($dataerror)) {
                        // print_r($dataerror);
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
                                    <h4 class="card-title mb-4">Data Asessor</h4>
                                    <div class="col-12">
                                        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target=".tambah-asessor-modal">Tambah Asessor</button>
                                    </div>
                                    <!-- modal tambah asessor -->
                                    <div class="modal fade tambah-asessor-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Tambah Asessor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST"
                                                        action="<?= base_url("Admin/SimpanPenggunaprodi") ?>"
                                                        enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="mb-3">
                                                                    <label for="formrow-nama-input"
                                                                        class="form-label">Nama</label>
                                                                    <select class="form-control select2"
                                                                        id="formrow-firstname-input" name="nama"
                                                                        placeholder="Masukkan Nama" value="" required>
                                                                        <option value="">Pilih Dosen</option>
                                                                        <?php
                                                                        if (isset($dataDosen)) {
                                                                            foreach ($dataDosen as $row) {
                                                                                $namalengkap = $row['kode_nama'] . ":" . $row['gelar_depan'] . $row['nama'] . $row['gelar_belakang'];
                                                                                echo "<option value='" . $namalengkap . "'>" . $row['kode_nama'] . " : " . $row['gelar_depan'] . $row['nama'] . $row['gelar_belakang'] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="formrow-email-input"
                                                                        class="form-label">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="formrow-email-input" name="email"
                                                                        placeholder="Masukkan Email ID" value=""
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <input class="form-select" id="level" name='status'
                                                                        readonly hidden value="2">
                                                                    </input>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">

                                                                    <input class="form-select" id="kode_prodi"
                                                                        name='kode_prodi' readonly hidden
                                                                        value="<?= session()->get('kode_prodi') ?>">

                                                                    </input>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">

                                                                    <input class="form-select" id="kode_fakultas"
                                                                        name='kode_fakultas' readonly hidden value='-'>

                                                                    </input>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Simpan</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!-- Modal edit pengguna -->
                                    <div class="modal fade edit-asessor-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Edit Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Admin/UpdatePengguna") ?>"
                                                        enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="mb-3">
                                                                    <label for="formrow-nama-input"
                                                                        class="form-label">Nama</label>
                                                                    <input type="text" class="form-control" id="enama"
                                                                        name="enama" placeholder="Masukkan Nama"
                                                                        value="" required readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="formrow-email-input"
                                                                        class="form-label">Email</label>
                                                                    <input type="email" class="form-control" id="eemail"
                                                                        name="eemail" placeholder="Masukkan Email ID"
                                                                        value="" required readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label for="formrow-inputPendidikan"
                                                                        class="form-label">Status Pengguna</label>
                                                                    <select class="form-select" id="estatus"
                                                                        onchange="egantistatus()" name='estatus'
                                                                        required>
                                                                        <option value=''>Pilih</option>
                                                                        <option value='1'>Admin</option>
                                                                        <option value='2'>Asessor</option>
                                                                        <option value='3'>Prodi</option>
                                                                        <option value='4'>Fakultas</option>
                                                                        <option value='5'>Keuangan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="formrow-inputPendidikan"
                                                                        class="form-label">Program
                                                                        Studi</label>
                                                                    <select class="form-select" id="ekode_prodi"
                                                                        name='ekode_prodi'>
                                                                        <option value='-' selected>
                                                                            Pilih...</option>
                                                                        <?php
                                                                        $db      = \Config\Database::connect();
                                                                        $result = $db->query("select * from prodi")->getResult();
                                                                        if ($result != null) {
                                                                            foreach ($result as $row) {
                                                                        ?>
                                                                        <option value="<?= $row->kode_prodi ?>"
                                                                            <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == $row->kode_prodi ? 'selected="selected"' : '') ?>>
                                                                            <?= $row->nama_prodi ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="formrow-inputPendidikan"
                                                                        class="form-label">Fakultas</label>
                                                                    <select class="form-select" id="ekode_fakultas"
                                                                        name='ekode_fakultas'>
                                                                        <option value='-' selected>
                                                                            Pilih...</option>
                                                                        <?php
                                                                        $db      = \Config\Database::connect();
                                                                        $result = $db->query("select * from fakultas")->getResult();
                                                                        if ($result != null) {
                                                                            foreach ($result as $row) {
                                                                        ?>
                                                                        <option value="<?= $row->kode_fakultas ?>">
                                                                            <?= $row->nama_fakultas ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Simpan</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>

                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th class="col-1">No</th>
                                                <th class="col-3">Nama Asessor</th>
                                                <th class="col-3">Email</th>
                                                <th class="col-1">Status</th>
                                                <th class="col-1">Prodi</th>
                                                <th class="col-1">fakultas</th>
                                                <th class="col-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // print_r($dataAsessor);
                                            if ($dataPengguna != null) {
                                                $i = 0;
                                                foreach ($dataPengguna as $row) {
                                                    $i++;
                                                    if ($row['sttpengguna'] == 1) {
                                                        $statuspengguna = "Admin";
                                                    } else if ($row['sttpengguna'] == 2) {
                                                        $statuspengguna = "Asessor";
                                                    } else if ($row['sttpengguna'] == 3) {
                                                        $statuspengguna = "Prodi";
                                                    } else if ($row['sttpengguna'] == 4) {
                                                        $statuspengguna = "Fakultas";
                                                    } else if ($row['sttpengguna'] == 5) {
                                                        $statuspengguna = "Keuangan";
                                                    }


                                                    echo "<tr idpengguna='" . $row['idpengguna'] . "'>
                                                        <td >$i</td>
                                                        <td for='nmpengguna'>" . $row['nmpengguna'] . "</td>
                                                        <td for='email'>" . $row['email'] . "</td>
                                                        <td for='status' sts='" . $row['sttpengguna'] . "'>" . $statuspengguna . "</td>
                                                        <td for='prodi'>" . $row['kode_prodi'] . "</td>
                                                        <td for='fakultas'>" . $row['kode_fakultas'] . "</td>
                                                        <td>
                                                        
                                                        <button class='button btn-primary btn-sm ' onClick='getDataResetPassword($(this))'>Reset Password</button></td>
                                                    </tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="modal fade resetpass-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class=" modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Perhatian !</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="<?= base_url("resetpasswordprodi") ?>">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="formrow-nama-input"
                                                                        class="form-label">Yakin
                                                                        akan Mereset Password <span id='email'></span>
                                                                        ?</label>
                                                                    <input type="hidden" class="form-control"
                                                                        id="remail" name="eemail"
                                                                        placeholder="Masukkan Nama" value="" required
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type=" submit" class="btn btn-primary w-md">
                                                                Ya</button> <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
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
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
    $('document').ready(function() {
        $('.select2').select2({
            width: '100%',
            dropdownParent: $('.tambah-asessor-modal'),

        })
    })

    function getDataResetPassword(ini) {
        email = ini.parent().parent().find('td[for=email]').html();
        $('#email').html(email);
        $('#remail').val(email);
        $('.resetpass-modal').modal('show');

    }

    function gantistatus() {
        $level = $('#level').val()
        if ($level == 1 || $level == 5) {
            $('#kode_prodi').parent().hide();
            $('#kode_fakultas').parent().hide();
            $('#kode_fakultas').val("-");
            $('#kode_prodi').val("-");

        } else if ($level == 2 || $level == 3) {
            $('#kode_prodi').parent().show();
            $('#kode_fakultas').parent().hide();
            $('#kode_fakultas').val("-");
            $('#kode_prodi').val("");
        } else if ($level == 4) {
            $('#kode_prodi').parent().hide();
            $('#kode_fakultas').parent().show();
            $('#kode_prodi').val("-");
            $('#kode_fakultas').val("");

        } else {
            $('#kode_prodi').parent().hide();
            $('#kode_fakultas').parent().hide();
            $('#kode_prodi').val("-");
            $('#kode_fakultas').val("-");

        }

    }

    function egantistatus() {
        $level = $('#estatus').val()
        if ($level == 1 || $level == 5) {
            $('#ekode_prodi').parent().hide();
            $('#ekode_fakultas').parent().hide();
            $('#ekode_prodi').val("-").change();
            $('#ekode_fakultas').val("-").change();
        } else if ($level == 2 || $level == 3) {
            $('#ekode_prodi').parent().show();
            $('#ekode_fakultas').parent().hide();
            $('#ekode_fakultas').val("-").change();
            $('#ekode_prodi').val("").change();
        } else if ($level == 4) {
            $('#ekode_prodi').parent().hide();
            $('#ekode_fakultas').parent().show();
            $('#ekode_prodi').val("-").change();
            $('#ekode_fakultas').val("").change();

        } else {
            $('#ekode_prodi').parent().hide();
            $('#ekode_fakultas').parent().hide();
            $('#ekode_prodi').val("-").change();
            $('#ekode_fakultas').val("-").change();

        }

    }


    function getData(ini) {
        idpengguna = ini.parent().parent().attr('idpengguna')
        nm = ini.parent().parent().find('td[for=nmpengguna]').html();
        email = ini.parent().parent().find('td[for=email]').html();
        prodi = ini.parent().parent().find('td[for=prodi]').html();
        fakutlas = ini.parent().parent().find('td[for=fakultas]').html();
        status = ini.parent().parent().find('td[for=status]').attr('sts');
        // alert(proedi)
        if (status == 1 || status == 5) {
            $('#ekode_prodi').parent().hide();
            $('#ekode_fakultas').parent().hide();
            $('#ekode_fakultas').val("-").change();
            $('#ekode_prodi').val("-").change();
        } else if (status == 2 || status == 3) {
            $('#ekode_prodi').parent().show();
            $('#ekode_fakultas').parent().hide();
            $('#ekode_fakultas').val("-").change();
            $('#ekode_prodi').val("-").change();
        } else if (status == 4) {
            $('#ekode_prodi').parent().hide();
            $('#ekode_fakultas').parent().show();
            $('#ekode_prodi').val("-").change();
            $('#ekode_fakultas').val("");
        } else {
            $('#ekode_prodi').parent().hide();
            $('#ekode_fakultas').parent().hide();
            $('#ekode_prodi').val("-").change();
            $('#ekode_fakultas').val("-").change();

        }

        $("#enama").val(nm);
        $("#eemail").val(email);
        $("#estatus").val(status);
        $("#ekode_prodi").val(prodi);
        $("#ekode_fakultas").val(fakutlas);
        $(".edit-asessor-modal").modal('show');
    }
    </script>
</body>

</html>