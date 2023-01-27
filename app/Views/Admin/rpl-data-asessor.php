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
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">

                                                <select name="nmasessor" id="nmasessor" class="form-select col-3"
                                                    onchange="getMahasiswa()">
                                                    <option value=''>Pilih Asessor</option>
                                                    <?php
                                                    if ($dataAsessor != null) {
                                                        foreach ($dataAsessor as $row) {
                                                            echo "<option value='" . $row['idpengguna'] . "'>" . $row['nmpengguna'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <button class="btn btn-primary">Tambah Mahasiswa</button>
                                            </div>
                                        </div>
                                    </div>




                                </div>

                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>Program Studi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>

                                                </tbody>
                                            </table>

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
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
    function getMahasiswa() {
        $('#bodytable').children().remove();

        idasessor = $("#nmasessor").val();
        url = '<?= base_url('getDataMhsPerAsessor') ?>'
        $.post(url, {
            "idasessor": idasessor
        }, function(data) {
            data = JSON.parse(data)
            // console.log(data);

            $.each(data, function(index, value) {
                // alert(value['nama'])
                i = index + 1
                $('#bodytable').append(
                    "<tr><td>" + i + "</td><td for='noreg'>" + value['no_peserta'] +
                    "</td><td for='nmmhs'>" + value['nama'] + "</td><td for='prodi'>" + value[
                        'kode_prodi'] + "</td></tr>"
                )


            })

        })

    }
    </script>
</body>

</html>