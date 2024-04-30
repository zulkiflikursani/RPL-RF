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
                                    <button class="btn btn-primary" data-bs-toggle="modal" id='bt-tambah-matakuliah'
                                        data-bs-target='.conf-modal'>Sinkron data Matakuliah Dari
                                        Siska </button>
                                    <h4 class="card-title mb-4">Data Matakuliah</h4>
                                    <div class="">

                                        <!-- modal tambah asessor -->
                                        <div class="modal fade tambah-matakuliah-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content" id='modal-content'>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Tambah
                                                            Matakuliah
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- content -->
                                                        <h5 class="modal-title" id="myLargeModalLabel">Prodi <span
                                                                id='jprodi'></span>
                                                        </h5>

                                                        <form method="POST">
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="formrow-nama-input"
                                                                            class="form-label">Kode Matakuliah</label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            id="kdmk"
                                                                            placeholder="Masukkan Kode Matakuliah"
                                                                            value="" required>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">Nama Matakuliah</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nmmk"
                                                                            placeholder="Masukkan Nama Matakuliah"
                                                                            value="" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">Jumlah SKS</label>
                                                                        <input type="text" class="form-control" id="sks"
                                                                            placeholder="Masukkan Jumlah SKS" value=""
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">id kurikulum</label>
                                                                        <input type="text" class="form-control"
                                                                            id="idkur"
                                                                            placeholder="Masukkan Id Kurikulum" value=""
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <button type="button" onclick='simpancpmk()'
                                                                    class="btn btn-primary w-md">Simpan</button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <div class="modal fade edit-matakuliah-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Edit
                                                            Matakuliah
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- content -->
                                                        <h5 class="modal-title" id="myLargeModalLabel">Prodi <span
                                                                id='jprodi'><?= strtoupper($nama_prodi) ?></span>
                                                        </h5>

                                                        <form method="POST" action="" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="formrow-nama-input"
                                                                            class="form-label">Kode Matakuliah</label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            id="ekdmk"
                                                                            placeholder="Masukkan Kode Matakuliah"
                                                                            value="" required readonly>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">Nama Matakuliah</label>
                                                                        <input type="text" class="form-control"
                                                                            id="enmmk"
                                                                            placeholder="Masukkan Nama Matakuliah"
                                                                            value="" required readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">jenis Matakuliah</label>
                                                                        <select class="form-select " id='ejenis-mk'>
                                                                            <option value="">Pilih Jenis Matakuliah
                                                                            </option>
                                                                            <option value="3">Wajib Prodi</option>
                                                                            <option value="4">Wajib Konsentrasi atau
                                                                                peminatan</option>
                                                                            <option value="5">Pilihan</option>
                                                                            <option value="6">Skripsi</option>
                                                                            <option value="7">MBKM</option>
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row konsentrasi" style='display:none'>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">Konsentrasi</label>
                                                                        <select class="form-select " id='ekdkons'>
                                                                            <option value="">Pilih Konsentrasi</option>
                                                                            <?php
                                                                            if (isset($datakonst)) {
                                                                                foreach ($datakonst as $row) {
                                                                                    echo "<option value='" . $row['kode_konsentrasi'] . "'>" . $row['konsentrasi'] . "</option>";
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
                                                                            class="form-label">Jumlah SKS</label>
                                                                        <input type="text" class="form-control"
                                                                            id="esks" placeholder="Masukkan Jumlah SKS"
                                                                            value="" required readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input"
                                                                            class="form-label">id kurikulum</label>
                                                                        <input type="text" class="form-control"
                                                                            id="eidkur"
                                                                            placeholder="Masukkan Id Kuriulum" value=""
                                                                            required readonly>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <button type="button" onclick='editmk()'
                                                                    class="btn btn-primary w-md">Simpan</button>
                                                                <!-- <button type="button" onclick='confirmhapus()'
                                                                    class="btn btn-primary w-md mx-2">Hapus</button> -->
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        <div class="modal fade hapus-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class=" modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Perhatian !</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-12">
                                                                        <label for="formrow-nama-input"
                                                                            class="form-label">Menghapus Matakuliah akan
                                                                            menghapus CPMK Matakuliah tersebut </br>
                                                                            Yakin akan Menghapus Matakuliah ?</label>
                                                                        <input type="hidden" class="form-control"
                                                                            id="hkdmk" name="hkdmk"
                                                                            placeholder="Masukkan Nama" value=""
                                                                            required readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button onclick="hapusmk()"
                                                                    class="btn btn-primary w-md">
                                                                    Ya</button> <button type="button"
                                                                    class="btn btn-light"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>

                                        <div class="modal fade conf-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class=" modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Perhatian !</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-12">
                                                                        <label for="formrow-nama-input"
                                                                            class="form-label">Mensingkron matakuliah
                                                                            akan menghapus semua jenis konsentrasi
                                                                            matakuliah. Apakah anda yakin ?</label>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button onclick="sinkron()"
                                                                    class="btn btn-primary w-md">
                                                                    Ya</button> <button type="button"
                                                                    class="btn btn-light"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>

                                    </div>

                                    <h3 class="text-center">DAFTAR MATAKULIAH </h3>
                                    <h3 class="text-center">PRODI <span
                                            id='jprodi'><?= strtoupper($nama_prodi) ?></span></h3>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <!-- <button class="btn btn-primary" data-bs-toggle="modal"
                                                id='bt-tambah-matakuliah'
                                                data-bs-target='.tambah-matakuliah-modal'>Tambah Matakuliah</button> -->
                                            <a href='<?= base_url('cpmk-prodi') ?> ' class="btn btn-primary">Daftar
                                                CPMK</a>
                                        </div>
                                        <!-- <div class="mb-3 row">
                                            <label for="" class="col-lg-1">Kurikulum:</label>
                                            <div class="col-lg-5">
                                                <select name="" class="form-select " id="filter">
                                                    <option value="" selected>Pilih Kurikulum</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                        </div> -->


                                    </div>
                                    <table class='table-matakuliah table table-bordered dt-responsive   w-100'>
                                        <thead class=" table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Matakuliah</th>
                                                <th>Nama Matakuliah</th>
                                                <th>Konsentrasi</th>
                                                <th>Jumlah SKS</th>
                                                <th>Jenis Matakuliah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            if (isset($datamk)) {
                                                foreach ($datamk as $row) {
                                                    $i++;
                                                    $jenismk = '';
                                                    if ($row->jenis_matakuliah == '3') {
                                                        $jenismk = 'Wajib Prodi';
                                                    } else if ($row->jenis_matakuliah == '4') {
                                                        $jenismk = 'Wajib konsentrasi atau peminatan';
                                                    } else if ($row->jenis_matakuliah == '5') {
                                                        $jenismk = 'Pilihan';
                                                    } else if ($row->jenis_matakuliah == '6') {
                                                        $jenismk = 'Skripsi/thesis';
                                                    } else if ($row->jenis_matakuliah == '7') {
                                                        $jenismk = 'MBKM';
                                                    }
                                                    echo "<tr kdkons='" . $row->kode_konsentrasi . "' jenismk='" . $row->jenis_matakuliah . "'>
                                                    <td>$i</td>
                                                    <td for='kdmk'>" . $row->kode_matakuliah . "</td>
                                                    <td for='nmmk'>" . $row->nama_matakuliah . "</td>
                                                    <td for='kons' >" . $row->konsentrasi . "</td>
                                                    <td for='sks'>" . $row->sks . "</td>
                                                    <td for='jenismk'>" . $jenismk . $row->jenis_matakuliah."</td>
                                                  <td><button class='btn btn-sm btn-primary bt-edit-matakuliah' data-bs-toggle='modal'
                                                  id='bt-edit-matakuliah'
                                                  data-bs-target='.edit-matakuliah-modal' >Edit</button></td>
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
    $('document').ready(function() {
        // alert('s')
        var cari = $('#filter');

        // $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        //     // $("#loading").show();

        //     var cari2 = cari.val()
        //     var kurikulum = data[4];
        //     // alert(idcmk)
        //     if (cari2 == kurikulum) {
        //         return true;
        //     } else if (cari2 == "") {
        //         return true
        //     }

        //     return false;
        // });

        // $('.table-matakuliah thead tr')
        //     .clone(true)
        //     .addClass('filters')
        //     .appendTo('.table-matakuliah thead');
        var table = $('.table-matakuliah').DataTable()
        cari.on('change', function() {
            // alert(cari.val())

            table.draw();
            $("#loading").hide();


        })

        $('#ejenis-mk').on('change', function() {
            if ($(this).val() == 4) {
                $('.konsentrasi').show()
            } else {
                $('.konsentrasi').hide()

            }
        })

        $('.table-matakuliah tbody').on('click', '.bt-edit-matakuliah', function() {
            var data = table.row($(this).parents('tr')).data();
            var data2 = table.row($(this).parents('tr')).nodes()[0];
            data3 = data2.getAttribute("kdkons");
            data4 = data2.getAttribute('jenismk')
            $('#ekdmk').val(data[1]);
            $('#enmmk').val(data[2]);
            $('#esks').val(data[4]);
            $('#ekdkons').val(data3);
            $('#ejenis-mk').val(data4)
            if (data4 == 4) {
                $('.konsentrasi').show();
            }
            // $('#eidkur').val(data[5]);

        });




    })


    function sinkron() {
        $('#loading').show()
        url = '<?= base_url('singkron-mk-siska') ?>'
        $.post(url, function(data) {
            console.log(data);
            if (alert(data)) {} else {
                window.location.reload()
                $("#loading").hide();


            };
        })
    }

    function kosongkan() {
        // $('#prodi').val("");
        $('#kdmk').val("");
        $('#nmmk').val("");
        $('#sks').val("");
        $('#idkur').val("");
    }

    function simpancpmk() {
        $("#loading").show();
        prodi = '<?= $jenis_prodi ?>'
        kdmk = $('#kdmk').val();
        nmmk = $('#nmmk').val();
        sks = $('#sks').val();
        idkur = $('#idkur').val();
        url = '<?= base_url('simpanmk') ?>'

        $.post(url, {
            prodi: prodi,
            kdmk: kdmk,
            nmmk: nmmk,
            sks: sks,
            idkur: idkur
        }, function(data) {
            if (alert(data)) {} else {
                // getMatakuliah()
                window.location.reload()
                kosongkan();
                $("#loading").hide();

            };
        })

    }

    function editmk() {
        $("#loading").show();

        prodi = '<?= $jenis_prodi ?>'
        kdmk = $('#ekdmk').val();
        nmmk = $('#enmmk').val();
        kdkons = $('#ekdkons').val();
        sks = $('#esks').val();
        idkur = $('#eidkur').val();
        jenismk = $('#ejenis-mk').val();
        url = '<?= base_url('editmk') ?>'

        $.post(url, {
            prodi: prodi,
            kdmk: kdmk,
            nmmk: nmmk,
            kdkons: kdkons,
            jenismk: jenismk,
            sks: sks,
            idkur: idkur
        }, function(data) {
            if (alert(data)) {} else {
                window.location.reload()
                $("#loading").hide();


            };
        })


    }

    function confirmhapus() {
        kdmk = $('#ekdmk').val();
        $('#hkdmk').val(kdmk);
        $('.edit-matakuliah-modal').modal('hide')
        $('.hapus-modal').modal('show')



    }

    function hapusmk() {

        // Save it!
        // prodi = $('#prodi').val();
        kdmk = $('#hkdmk').val();
        // nmmk = $('#enmmk').val();

        url = '<?= base_url('hapusmk') ?>'

        $.post(url, {
            prodi: '<?= $jenis_prodi ?>',
            kdmk: kdmk

        }, function(data) {
            if (alert(data)) {} else {
                window.location.reload()
                $("#loading").hide();


            };

        })




    }
    </script>
</body>

</html>