<!doctype html>
<html lang="en">
<style>
thead input {
    width: 100%;
}
</style>

<head>

    <?= $title_meta ?>

    <!-- DataTables -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        right: 10px !important;
        left: auto !important;
    }

    .select2 {
        width: 100% !important;
    }
    </style>

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
                    <div class="modal fade tambah-pt-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Tambah
                                        Perguruan Tinggi
                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- content -->
                                    <div class="text-center">
                                        <h5 class="modal-title" id="myLargeModalLabel">Tambah Perguruan TInggi</span>
                                        </h5>
                                    </div>

                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label for="formrow-nama-input" class="form-label">Kode Perguruan
                                                        Tinggi Dikti </label>
                                                    <input type="text" class="form-control" id="kdptdikti"
                                                        placeholder="Masukkan Kode Perguruan Tinggi" value="" required>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Kode Perguruan
                                                        Tinggi</label>
                                                    <input type="text" class="form-control" id="kdpt"
                                                        placeholder="Masukkan Kode Perguruan Tinggi" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Nama Perguruan
                                                        Tinggi</label>
                                                    <input type="text" class="form-control" id="namapt"
                                                        placeholder="Masukkan Nama Perguruan Tinggi" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Nama Perguruan
                                                        Tinggi Singkat</label>
                                                    <input type="text" class="form-control" id="namasingkat"
                                                        placeholder="Masukkan Nama Singkat" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" onclick='simpanpt()'
                                                class="btn btn-primary w-md">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div class="modal fade edit-pt-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Edit
                                        Perguruan Tinggi
                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- content -->
                                    <div class="text-center">
                                        <h5 class="modal-title" id="myLargeModalLabel">Edit Perguruan TInggi</span>
                                        </h5>
                                    </div>

                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label for="formrow-nama-input" class="form-label">Kode Perguruan
                                                        Tinggi </label>
                                                    <input type="text" class="form-control" id="ekdptdikti"
                                                        placeholder="Masukkan Kode Perguruan Tinggi" value="" required
                                                        readonly>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Kode Perguruan
                                                        Tinggi</label>
                                                    <input type="text" class="form-control" id="ekdpt"
                                                        placeholder="Masukkan Kode Perguruan Tinggi" value="" required
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Nama Perguruan
                                                        Tinggi</label>
                                                    <input type="text" class="form-control" id="enamapt"
                                                        placeholder="Masukkan Nama Perguruan Tinggi" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Nama Perguruan
                                                        Tinggi Singkat</label>
                                                    <input type="text" class="form-control" id="enamasingkat"
                                                        placeholder="Masukkan Nama Singkat" value="" required>
                                                </div>
                                            </div>
                                        </div>



                                        <div>
                                            <button type="button" onclick='editpt()'
                                                class="btn btn-primary w-md">Simpan</button>
                                            <!-- <button type="button" onclick='confirmhapus()'
                                                                    class="btn btn-primary w-md mx-2">Hapus</button> -->
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="card pt-4">
                                <div class="text-center">
                                    <h3 class="mx-auto w-auto">
                                        DAFTAR PERGURUAN TINGGI
                                    </h3>
                                </div>
                                <div class="p-2">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn button btn-primary" data-bs-toggle='modal'
                                            data-bs-target='.tambah-pt-modal'>Tambah PT</button>
                                    </div>
                                    <table class="table-pt  table dt-responsive   w-100">
                                        <thead class=" table-primary text-center ">
                                            <tr class="item-center">
                                                <th>No</th>
                                                <th>Kode Perguruan Tinggi Dikti</th>
                                                <th>Kode Perguruan Tinggi</th>
                                                <th>Nama Perguruan Tinggi</th>
                                                <th>Nama Singkat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($dataPT)) {
                                                $i = 0;
                                                foreach ($dataPT as $row) {
                                                    $i++;
                                                    echo "<tr>
                                                            <td>" . $i . "</td>
                                                            <td>" . $row['id_perguruan_tinggi_dikti'] . "</td>
                                                            <td>" . $row['kode_perguruan_tinggi'] . "</td>
                                                            <td>" . $row['nama_perguruan_tinggi'] . "</td>
                                                            <td>" . $row['nama_singkat'] . "</td>
                                                            <td><button class='btn btn-sm btn-primary bt-edit-pt' data-bs-toggle='modal'
                                                  id='bt-edit-pt'
                                                  data-bs-target='.edit-pt-modal' >Edit</button></td>
                                                            </tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?= $this->include('partials/vendor-scripts') ?>
<?= $this->include('partials/rpl-footer') ?>
<!-- Required datatable js -->
<script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
</script>

<!-- <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script> -->

<!-- Datatable init js -->
<script src="<?= base_url() ?>/assets/js/pages/datatables.init.js"></script>

<!-- apexcharts -->
<script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- dashboard init -->
<script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

<script src="<?= base_url() ?>/assets/js/app.js"></script>
<script>
$('document').ready(function() {
    var table = $('.table-pt').DataTable()

    $('.table-pt tbody').on('click', '#bt-edit-pt', function() {
        row = $(this).parents('tr')[0];
        var data = table.row(row).data();
        $('#ekdptdikti').val(data[1]);
        $('#ekdpt').val(data[2]);
        $('#enamapt').val(data[3]);
        $('#enamasingkat').val(data[4]);
    });
})

function editpt() {
    $("#loading").show();
    kodeptdikti = $('#ekdptdikti').val()
    kodept = $('#ekdpt').val()
    namapt = $('#enamapt').val()
    namasingkat = $('#enamasingkat').val()
    url = '<?= base_url('updatedatapt') ?>'
    $.post(url, {
        kodeptdikti: kodeptdikti,
        kodept: kodept,
        namapt: namapt,
        namasingkat: namasingkat
    }, function(data) {
        if (alert(data)) {} else {
            window.location.reload()
            $("#loading").hide();
        };
    })
}

function simpanpt() {
    $("#loading").show();
    kodeptdikti = $('#kdptdikti').val()
    kodept = $('#kdpt').val()
    namapt = $('#namapt').val()
    namasingkat = $('#namasingkat').val()
    url = '<?= base_url('insertdatapt') ?>'
    $.post(url, {
        kodeptdikti: kodeptdikti,
        kodept: kodept,
        namapt: namapt,
        namasingkat: namasingkat
    }, function(data) {
        if (alert(data)) {} else {
            window.location.reload()
            $("#loading").hide();
        };
    })

}
</script>