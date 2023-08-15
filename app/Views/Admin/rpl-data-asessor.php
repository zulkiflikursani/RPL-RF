<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
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
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        foreach ($dataerror as $error) {

                            echo $error . "</br>";
                        };
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                    }

                    if (isset($status)) {
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Menambahkan Mahasiswa<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Modal tambah mahasiswa -->
                            <div class="modal fade tambah-mahasiswa-modal" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-mahasiswa-modal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Tambah Mahasiswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <form method="POST" action="<?= base_url("simpanpesertaasessor") ?>"
                                                enctype="multipart/form-data">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Nama
                                                        Mahasiswa</label>
                                                    <select name="noregis" id="mhsnoasessor"
                                                        class="select2 form-control">
                                                        <option value="">Pilih Mahasiswa</option>
                                                    </select>
                                                    <!-- <input list="suggestionList" id="noregisInput" class='form-control'>
                                                    <datalist id="suggestionList" class="col-md-12"
                                                        style="width: 100%;">
                                                       
                                                    </datalist>
                                                    <input type="hidden" name="noregis" id="noregisInput-hidden">-->
                                                    <input type="hidden" name="noasessor" id="noasessorInput">

                                                </div>

                                                <div>
                                                    <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Asessor</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <select name="nmasessor" id="nmasessor" class="select2 form-control"
                                                    onchange="getMahasiswa()">
                                                    <option value=''>Pilih Asessor</option>
                                                    <?php
                                                    if ($dataAsessor != null) {
                                                        foreach ($dataAsessor as $row) {
                                                            echo "<option prodi='" . $row['kode_prodi'] . "' value='" . $row['idpengguna'] . "'>" . $row['nmpengguna'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target='.tambah-mahasiswa-modal'>Pilih Mahasiswa</button>
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
    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
    // $('.tambah-mahasiswa-modal select').css('width', '100%');
    $('select').select2({
        // matcher: matchStart
    })
    $('#mhsnoasessor').select2({
        width: '100%',
        dropdownParent: $('.tambah-mahasiswa-modal'),

    })
    $('document').ready(function() {
        // $("#mhsnoasessor").select2({
        //     // tags: true,
        //     dropdownParent: $('#myModal')
        // });

    })


    function getMahasiswa() {
        $('#bodytable').children().remove();
        $('#suggestionList').children().remove();


        kode_prodi = $("#nmasessor option:selected").attr('prodi');
        getdatamahsiswaBelumPunyaAsessor(kode_prodi)

        idasessor = $("#nmasessor").val();
        $('#noasessorInput').val(idasessor);
        url = '<?= base_url('getDataMhsPerAsessor') ?>'
        $.post(url, {
            "idasessor": idasessor
        }, function(data) {
            data = JSON.parse(data)
            // console.log(data);
            getdata(data);

        })

    }


    function getdatamahsiswaBelumPunyaAsessor(kode_prodi) {
        url = '<?= base_url('getdatamhsblmpunyaassessor') ?>'
        $.post(url, {
            "kode_prodi": kode_prodi
        }).done(function(data) {
            data = JSON.parse(data)
            // console.log(data);
            $.each(data, function(index, value) {
                // $("#select_with_data").append('<option value="5">Twitter</option>');
                $('#mhsnoasessor').append("<option value='" + value['no_peserta'] +
                    "'>" + value['no_peserta'] +
                    " : " + value['nama'] +
                    "</option>");
                // $("#mhsnoasessor").val(value['no_peserta']);
                // $("#mhsnoasessor").trigger('change');
            })



        })
    }

    function getdata(data) {
        $.each(data, function(index, value) {
            // alert(value['nama'])
            i = index + 1
            $('#bodytable').append(
                "<tr><td>" + i + "</td><td for='noreg'>" + value['no_peserta'] +
                "</td><td for='nmmhs'>" + value['nama'] + "</td><td for='prodi'>" + value[
                    'kode_prodi'] + "</td></tr>"
            )
        })
        // return kode_prodi;
    }
    </script>
</body>

</html>