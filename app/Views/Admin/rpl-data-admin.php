<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

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
                                    <h4 class="card-title mb-4">Data Pengguna</h4>
                                    <div class="col-12">
                                        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target=".tambah-asessor-modal">Tambah Pengguna</button>
                                    </div>
                                    <!-- modal tambah asessor -->
                                    <div class="modal fade tambah-asessor-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Tambah Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Admin/SimpanPengguna") ?>"
                                                        enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="mb-3">
                                                                    <label for="formrow-nama-input"
                                                                        class="form-label">Nama</label>
                                                                    <input type="text" class="form-control"
                                                                        id="formrow-firstname-input" name="nama"
                                                                        placeholder="Masukkan Nama" value="" required>
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
                                                                    <label for="formrow-inputPendidikan"
                                                                        class="form-label">Status Pengguna</label>
                                                                    <select class="form-select" id="autoSizingSelect"
                                                                        name='status' required>
                                                                        <option value=''>Pilih</option>
                                                                        <option value='1'>Admin</option>
                                                                        <option value='2'>Asessor</option>
                                                                        <option value='3'>Prodi</option>
                                                                        <option value='4'>Fakultas</option>
                                                                        <option value='5'>Manajemen</option>
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
                                                                    <select class="form-select" id="autoSizingSelect"
                                                                        name='kode_prodi'>
                                                                        <option value=''
                                                                            <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
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
                                                                        name='estatus' required>
                                                                        <option value=''>Pilih</option>
                                                                        <option value='1'>Admin</option>
                                                                        <option value='2'>Asessor</option>
                                                                        <option value='3'>Prodi</option>
                                                                        <option value='4'>Fakultas</option>
                                                                        <option value='5'>Manajemen</option>
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
                                                                        <option value=''
                                                                            <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
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
                                                        $statuspengguna = "Manajemen";
                                                    }

                                                    echo "<tr idpengguna='" . $row['idpengguna'] . "'>
                                                        <td >$i</td>
                                                        <td for='nmpengguna'>" . $row['nmpengguna'] . "</td>
                                                        <td for='email'>" . $row['email'] . "</td>
                                                        <td for='status' sts='" . $row['sttpengguna'] . "'>" . $statuspengguna . "</td>
                                                        <td for='prodi'>" . $row['kode_prodi'] . "</td>
                                                        <td>
                                                        <button class='button btn-primary btn-sm' onClick='getData($(this))' >Edit</button>
                                                        <button class='button btn-primary btn-sm mx-2' onClick='getDataHapus($(this))'>Hapus</button>
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
                                                    <form method="POST" action="<?= base_url("resetpassword") ?>">
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

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
    function getDataResetPassword(ini) {
        email = ini.parent().parent().find('td[for=email]').html();
        $('#email').html(email);
        $('#remail').val(email);
        $('.resetpass-modal').modal('show');

    }

    function getData(ini) {
        idpengguna = ini.parent().parent().attr('idpengguna')
        nm = ini.parent().parent().find('td[for=nmpengguna]').html();
        email = ini.parent().parent().find('td[for=email]').html();
        prodi = ini.parent().parent().find('td[for=prodi]').html();
        status = ini.parent().parent().find('td[for=status]').attr('sts');
        // alert(prodi)
        $("#enama").val(nm);
        $("#eemail").val(email);
        $("#ekode_prodi").val(prodi).change();
        $("#estatus").val(status);
        $(".edit-asessor-modal").modal('show');
    }
    </script>
</body>

</html>