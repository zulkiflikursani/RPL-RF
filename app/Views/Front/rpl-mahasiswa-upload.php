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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Memperbahrui data<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    if (isset($datasubmit)) {
                        // print_r($datasubmit-nama);
                        foreach ($datasubmit as $bio) {
                            $biodata['nama'] = $bio['nama'];
                            $biodata['email'] = $bio['email'];
                            $biodata['alamat'] = $bio['alamat'];
                            $biodata['kotkab'] = $bio['kotkab'];
                            $biodata['propinsi'] = $bio['propinsi'];
                            $biodata['instansi_asal'] = $bio['instansi_asal'];
                            $biodata['nohape'] = $bio['nohape'];
                            $biodata['kode_prodi'] = $bio['kode_prodi'];
                        }
                    }

                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Registrasi RPL</h4>

                                    <button type="button" class="btn btn-light waves-effect" data-bs-toggle="modal"
                                        data-bs-target=".tambah-upload-modal">Large modal</button>
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
                                                    <form method="POST" action="<?= base_url("Front/Registrasi") ?>">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label mx-2">File
                                                                Name</label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="inputGroupFile04"
                                                                    aria-describedby="inputGroupFileAddon04"
                                                                    aria-label="Upload">
                                                                <button class="btn btn-primary" type="button"
                                                                    id="inputGroupFileAddon04">Button</button>
                                                                <label for="formrow-nama-input"
                                                                    class="form-label  mx-2">File
                                                                    Name</label>

                                                                <button class="btn btn-primary mx-2" type="button"
                                                                    id="inputGroupFileAddon04">Lihat File</button>
                                                            </div>

                                                        </div>




                                                        <div>
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Simpan</button>
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Pengajuan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

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