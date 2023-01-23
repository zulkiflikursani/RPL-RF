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

                    if (isset($datasubmit[0])) {
                        // print_r($datasubmit-nama);
                        $biodata = $datasubmit[0];
                    }

                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Upload Dokumen RPL</h4>

                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                        data-bs-target=".tambah-upload-modal">Large modal</button>

                                    <!-- Modal upload -->
                                    <div class="modal fade tambah-upload-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-upload-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Upload Berkas</h5>
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
                                                                name='prodi'>
                                                                <option value=''
                                                                    <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
                                                                    Pilih...</option>
                                                                <option value="1"></option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formrow-inputProvinsi" class="form-label">Nama
                                                                Dokumen</label>
                                                            <input type="text" class="form-control"
                                                                id="formrow-inputProvinsi" name="nohp"
                                                                placeholder="Masukkan Nama Dokumen" value="">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label mx-2">File
                                                                Name</label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="inputGroupFile04"
                                                                    aria-describedby="inputGroupFileAddon04"
                                                                    accept="application/pdf" aria-label="Upload">
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
                                                        echo "<tr>
                                                            <td>$i</td>
                                                            <td>" . $datafile['jenis_dokumen'] . "</td>
                                                            <td>" . $datafile['nmfile'] . "</td>
                                                            <td><button>Liat file</button></td>
                                                            
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