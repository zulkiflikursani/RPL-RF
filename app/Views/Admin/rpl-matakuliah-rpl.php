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


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="card-title mb-4">Data Matakuliah</h4> -->

                                    <h3 class="text-center">DAFTAR MATAKULIAH YANG DITAWARKAN RPL </h3>
                                    <h3 class="text-center">PRODI <span
                                            id='jprodi'><?= strtoupper($nama_prodi) ?></span> TA. <span
                                            id='jprodi'><?= strtoupper($ta_akademik) ?></span></h3>

                                    <table class='table-matakuliah table table-bordered dt-responsive   w-100'>
                                        <thead class=" table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Matakuliah</th>
                                                <th>Nama Matakuliah</th>
                                                <th>Konsentrasi</th>
                                                <th>Jumlah SKS</th>
                                                <th>Id Kurikulum</th>
                                                <th class="text-center">Status </br> <input type='checkbox'
                                                        id='checkall' class="form-check-input mx-2" />Pilih Semua
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id='bodymk'>
                                            <?php
                                            $i = 0;
                                            // print_r($datamk);
                                            if (isset($datamk)) {
                                                foreach ($datamk as $row) {
                                                    if ($row->status_rpl == 0) {
                                                        $statusrpl = "<input class='form-check-input checkitem' type='checkbox' value='0'>";
                                                    } else {
                                                        $statusrpl = "<input class='form-check-input checkitem' type='checkbox' value='1' checked>";
                                                    }
                                                    $i++;
                                                    echo "<tr kdkons='" . $row->kode_konsentrasi . "'>
                                                            <td>$i</td>
                                                            <td for='kdmk'>" . $row->kode_matakuliah . "</td>
                                                            <td for='nmmk'>" . $row->nama_matakuliah . "</td>
                                                            <td for='kons' >" . $row->konsentrasi . "</td>
                                                            <td for='sks'>" . $row->sks . "</td>
                                                            <td for='idkur'>" . $row->id_kurikulum . "</td>
                                                        <td for='status'>$statusrpl Aktif</td>
                                                        </tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                    <p>Catatan : </p>
                                    <ul>
                                        <li>Centang status untuk menawarkan matakuliah ke RPL</li>
                                        <li>Matakuliah yang tampil adalah matakuliah yang memiliki CPMK</li>
                                    </ul>

                                    <div class="">
                                        <button class="button btn btn-primary" onclick="updateMkRpl()">SIMPAN</button>
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

    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>

    <!-- Datatable init js -->
    <script src="<?= base_url() ?>/assets/js/pages/datatables.init.js"></script>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
    function updateMkRpl() {
        $("#loading").show();
        var data = []
        url = '<?= base_url('update-mk-rpl') ?>'
        $('#bodymk > tr').each(function() {
            if ($(this).find('td[for=status]').children().is(':checked')) {
                data.push($(this).find('td[for=kdmk]').html())
            }
        })
        console.log(data);
        $.post(url, {
            data: data
        }, function(data) {
            $("#loading").hide();
            alert(data);

        })
    }


    $(".checkitem").change(function() {
        if ($(this).prop("checked") == false) {
            $("#checkall").prop("checked", false)
        }
        // saat beberapa item terpilih dan hampir semua maka akan pada checkbox yang memiliki id CHECKALL terchecklist
        if ($(".checkitem:checked").length == $(".checkitem").length) {
            $("#checkall").prop("checked", true)
        }
    })

    $("#checkall").change(function() {
        $(".checkitem").prop("checked", $(this).prop("checked"))
    })


    function kosongkan() {
        // $('#prodi').val("");
        $('#kdmk').val("");
        $('#nmmk').val("");
        $('#sks').val("");
        $('#idkur').val("");
    }
    </script>
</body>

</html>