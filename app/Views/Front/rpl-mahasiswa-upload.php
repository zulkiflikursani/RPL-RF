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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Mengaupload data<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    if (isset($databio[0])) {
                        // print_r($datasubmit-nama);
                        $biodata = $databio[0];
                        $jenis_rpl = $databio[0]['jenis_rpl'];
                        if ($jenis_rpl == 1) {
                            $nm_rpl = "A1";
                        } else if ($jenis_rpl == 2) {
                            $nm_rpl = "A2";
                        } else if ($jenis_rpl == 3) {
                            $nm_rpl = "A3";
                        }
                    } else if (isset($databio['jenis_rpl'])) {
                        $jenis_rpl = $databio['jenis_rpl'];
                        if ($jenis_rpl == 1) {
                            $nm_rpl = "A1";
                        } else if ($jenis_rpl == 2) {
                            $nm_rpl = "A2";
                        } else if ($jenis_rpl == 3) {
                            $nm_rpl = "A3";
                        }
                    }


                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Upload Dokumen RPL</h4>

                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                        data-bs-target=".tambah-upload-modal">Upload</button>

                                    <!-- Modal upload -->
                                    <div class="modal fade tambah-upload-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-upload-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Upload Berkas
                                                        <?= $nm_rpl ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Front/Simpanberkas") ?>"
                                                        enctype="multipart/form-data">
                                                        <div class="mb-3">
                                                            <label for="formrow-inputPendidikan"
                                                                class="form-label">Jenis Dokumen</label>
                                                            <select class="form-select" id="autoSizingSelect"
                                                                name='jenis_file'>
                                                                <option value=''>
                                                                    Pilih...</option>
                                                                "<option value='02'>Ijazah dan atau transkip nilai bagi
                                                                    lulusan D1, D2, D3, S1</option>"
                                                                <?php
                                                                if ($jenis_rpl == 1) {
                                                                } else {
                                                                    $db      = \Config\Database::connect();
                                                                    $jenisfile = $db->query('select * from tb_jenis_file');
                                                                    if ($jenisfile->getResult() != null) {
                                                                        foreach ($jenisfile->getResult() as $b) {
                                                                            echo "<option value='$b->kd_jenis'>$b->nama_jenis</option>";
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formrow-inputProvinsi" class="form-label">Nama
                                                                Dokumen</label>
                                                            <input type="text" class="form-control"
                                                                id="formrow-inputProvinsi" name="nmfile"
                                                                placeholder="Masukkan Nama Dokumen" value="">
                                                        </div>
                                                        <div class="mb-3  text-left">
                                                            <div class="input-group">

                                                                <div class="form-check ">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="formRadios" id="formRadios1" checked>
                                                                    <label class="form-check-label" for="formRadios1">
                                                                        Upload File
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mx-3">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="formRadios" id="formRadios2">
                                                                    <label class="form-check-label" for="formRadios2">
                                                                        Link File
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="input-group mt-3" id='input-upload'>
                                                                <input type="file" class="form-control" name='userFile'
                                                                    id="inputGroupFile04"
                                                                    aria-describedby="inputGroupFileAddon04"
                                                                    accept="application/pdf" aria-label="Upload">
                                                            </div>
                                                            <div class="mb-3 mt-3" id='input-url' style='display:none'>
                                                                <label for="formrow-inputProvinsi"
                                                                    class="form-label">Url Dokumen
                                                                </label>
                                                                <input type="text" class="form-control"
                                                                    id="formrow-inputProvinsi" name="url"
                                                                    placeholder="Masukkan URL Dokumen" value="">
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

                                    <!-- daftar dokumen -->
                                    <h4 class="text-center">Daftar Dokumen</h4>
                                    <div>
                                        <table class="table table-border">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>Nama Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                if (isset($datadok)) {
                                                    $i = 1;
                                                    foreach ($datadok as $datafile) {
                                                        $url = $datafile['lokasi_file'] . "/" . $datafile['nmfile_asli'];
                                                        $link = base_url($url);
                                                        echo "<tr>
                                                            <td>$i</td>
                                                            <td>" . $datafile['jenis_dokumen'] . "</td>
                                                            <td>" . $datafile['nmfile'] . "</td>
                                                            <td><a href='" . $link . "' target='_blank'><button class='btn btn-sm btn-primary'>Lihat file</button></a></td>
                                                            
                                                        </tr>";
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary w-md">Pengajuan</button>
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

<script>
$(document).ready(function() {
    $('#formRadios1').click(function() {
        $('#input-url').hide()
        $('#input-upload').show()
    })
    $('#formRadios2').click(function() {
        $('#input-url').show()
        $('#input-upload').hide()
    })

})
</script>