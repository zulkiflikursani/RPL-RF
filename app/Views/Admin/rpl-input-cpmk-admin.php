<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <!-- DataTables -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
                                    <h4 class="card-title mb-4">Data Matakuliah</h4>
                                    <div class="">

                                        <!-- modal tambah asessor -->
                                        <div class="modal fade tambah-cpmk-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content" id='modal-content'>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Tambah
                                                            Capaian Pembelajaran Matakuliah
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- content -->
                                                        <h5 class="modal-title" id="myLargeModalLabel">Prodi <span id='jprodi'></span>
                                                        </h5>

                                                        <form method="POST">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-nama-input" class="form-label">Pilih Kurikulum</label>
                                                                        <select name="mkinput" class="form-select select2" id="kurinput">
                                                                            <option value="">Pilih Kurikulum</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-1">
                                                                        <label for="formrow-nama-input" class="form-label">Nama Matakuliah</label>

                                                                        <select name="mkinput" class="form-select select2" id="mkinput">
                                                                            <option value="">Pilih Matakuliah</option>
                                                                        </select>

                                                                        <div id="mkinput-source" hidden></div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input" class="form-label">Kode CPMK</label>
                                                                        <input type="text" class="form-control" id="idcpmk" placeholder="Masukkan No CPMK" value="" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input" class="form-label">Nama CPMK</label>
                                                                        <textarea type="text" class="form-control" id="cpmk" placeholder="Masukkan Nama CPMK" value="" required></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <button type="button" onclick='simpancpmk()' class="btn btn-primary w-md">Simpan</button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <div class="modal fade edit-cpmk-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Edit
                                                            Capaian Pembelajaran Matakuliah
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- content -->
                                                        <h5 class="modal-title" id="myLargeModalLabel">Prodi <span id='jprodi'></span>
                                                        </h5>

                                                        <form method="POST" action="" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="formrow-nama-input" class="form-label">Kode Matakuliah</label>
                                                                        <input type="text" class="form-control" id="ekdmk" placeholder="Masukkan Kode Matakuliah" value="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="formrow-nama-input" class="form-label">Nama Matakuliah</label>
                                                                        <input type="text" class="form-control" id="enmmk" placeholder="Masukkan No CPMK" value="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input" class="form-label">Kode CPMK</label>
                                                                        <input type="text" class="form-control" id="eidcpmk" placeholder="Masukkan No CPMK" value="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="formrow-email-input" class="form-label">Nama CPMK</label>
                                                                        <textarea type="text" class="form-control" id="ecpmk" placeholder="Masukkan Nama CPMK" value="" required></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <button type="button" onclick='editcpmk()' class="btn btn-primary w-md">Simpan</button>
                                                                <button type="button" onclick='hapuscpmk()' class="btn btn-primary w-md mx-2">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                    </div>

                                    <h3 class="text-center">DAFTAR MATAKULIAH DAN CPMK</h3>
                                    <h3 class="text-center">UNIVERSITAS </h3>
                                    <div class="col-lg-12">
                                        <div class="mb-3">

                                            <a href='<?= base_url('mk-admin') ?>' class="btn btn-primary">Daftar
                                                Matakuliah</a>
                                            <button class="btn btn-primary" data-bs-toggle="modal" id='bt-tambah-cpmk' data-bs-target='.tambah-cpmk-modal'>Tambah Cpmk</button>

                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-lg-1">Filter :</label>
                                            <div class="col-lg-5">
                                                <select name="" class="form-select " id="filter">
                                                    <option value="1" selected>Semua</option>
                                                    <option value="2">Memiliki CPMK</option>
                                                    <option value="3">Tidak Memiliki CPMK</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <button class="button btn btn-primary" onclick="tampilkan()">Tampilkan</button>
                                            </div>
                                        </div>
                                        <div class="mb-3">


                                        </div>
                                    </div>
                                    <table class='table-matakuliah table table-bordered dt-responsive   w-100'>
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Matakuliah</th>
                                                <th width='30%'>Nama Matakuliah</th>
                                                <th>Id Cpmk</th>
                                                <th>Nama Cpmk</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // if (isset($datacpmk)) {
                                            //     $i = 0;
                                            //     // print_r($datacpmk);
                                            //     foreach ($datacpmk as $row) {
                                            //         $i++;
                                            //         echo "<tr>
                                            //     <td>$i</td>
                                            //     <td>$row->kode_matakuliah</td>
                                            //     <td>$row->nama_matakuliah</td>
                                            //     <td>$row->idcpmk</td>
                                            //     <td>$row->cpmk</td>
                                            //     <td><button class='btn btn-primary btn-sm' >Edit</button></td>
                                            //     </tr>";
                                            //     }
                                            // }

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
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>

    <!-- Datatable init js -->
    <script src="<?= base_url() ?>assets/js/pages/datatables.init.js"></script>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        $('document').ready(function() {
            $('#prodi > option').hide()

            $('.select2').select2({
                dropdownParent: $('#modal-content')
            })

            var cari = $('#filter');
            // $('#bt-tambah-cpmk').hide();
            getMatakuliah()
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                // $("#loading").show();

                var cari2 = cari.val()
                var idcpmk = data[3];
                // alert(idcmk)
                if (
                    cari2 == 1
                ) {
                    return true;
                } else if (cari2 == 2 && idcpmk != "") {
                    return true
                } else if (cari2 == 3 && idcpmk == "") {
                    return true
                }

                return false;
            });
            var table = $('.table-matakuliah').DataTable()

            cari.on('change', function() {
                // alert(cari.val())

                table.draw();
                $("#loading").hide();


            })
            $('.table-matakuliah tbody').on('click', 'button', function() {
                var data = table.row($(this).parents('tr')).data();
                $('#ekdmk').val(data[1]);
                $('#enmmk').val(data[2]);
                $('#eidcpmk').val(data[3]);
                $('#ecpmk').val(data[4]);

                $('.edit-cpmk-modal').modal('show')




                // alert(data[0] + "'s salary is: " + data[5]);
            });

            $('#kurinput').on('change', function() {
                idkur = $('#kurinput').val()
                $('#mkinput').html("<option value=''>Pilih Matakuliah</option");
                // i = 1;
                $('#mkinput-source option').each(function() {
                    kur = $(this).attr('id_kurikulum')


                    if ($(this).attr('id_kurikulum') == idkur) {
                        let option = $(this).clone();
                        $('#mkinput').append(option[0]);
                    }
                })

            });

        })

        function tampilkan() {
            // 
            // prodi = $('#cprodi').val();

        }


        function kosongkan() {
            $('#cprodi').val("");
            $('#mkInput').val("").trigger('change');
            $('#idcpmk').val("");
            $('#cpmk').val("");
        }

        function simpancpmk() {
            $("#loading").show();
            prodi = $('#cprodi').val();
            kdmk = $('#mkinput').val();
            idcpmk = $('#idcpmk').val();
            cpmk = $('#cpmk').val();
            url = '<?= base_url('simpancpmk') ?>'
            $.post(url, {
                prodi: prodi,
                kdmk: kdmk,
                idcpmk: idcpmk,
                cpmk: cpmk
            }, function(data) {
                if (alert(data)) {} else {
                    getMatakuliah()
                    $('.tambah-cpmk-modal').modal('hide');
                    kosongkan();
                    $("#loading").hide();

                };
            })

        }

        function editcpmk() {
            $("#loading").show();

            prodi = "";
            kdmk = $('#ekdmk').val();
            idcpmk = $('#eidcpmk').val();
            cpmk = $('#ecpmk').val();
            url = '<?= base_url('editcpmk') ?>'

            $.post(url, {
                prodi: prodi,
                kdmk: kdmk,
                idcpmk: idcpmk,
                cpmk: cpmk
            }, function(data) {
                if (alert(data)) {} else {
                    getMatakuliah()
                    $('.edit-cpmk-modal').modal('hide');
                    $("#loading").hide();


                };
            })


        }

        function hapuscpmk() {
            $("#loading").show();

            prodi = "";
            kdmk = $('#enmmk').val();
            idcpmk = $('#eidcpmk').val();
            cpmk = $('#ecpmk').val();
            url = '<?= base_url('hapuscpmk') ?>'

            $.post(url, {
                prodi: prodi,
                kdmk: kdmk,
                idcpmk: idcpmk,
                cpmk: cpmk
            }, function(data) {
                alert(data);
                $('.edit-cpmk-modal').modal('hide');
                getMatakuliah()

                $("#loading").hide();

            })

        }

        function getMatakuliah() {
            $('#loading').show();
            $('#bt-tambah-cpmk').show();
            table = $('.table-matakuliah').DataTable()
            table.clear().draw();
            url = '<?= base_url('getcpmk-admin') ?>'
            value = '';

            $.post(url, {

            }).done(function(data) {
                data = JSON.parse(data)
                c = []
                $.each(data, function(i, v) {
                    no = parseFloat(i) + 1;
                    var id = no;
                    var kdmk = v['kode_matakuliah'];
                    var nmmk = v['nama_matakuliah'];
                    var idcpmk = v['idcpmk'];
                    var cpmk = v['cpmk'];
                    var btn = "<button class='btn btn-primary btn-sm' >Edit</button>";
                    item = {}
                    item[0] = id;
                    item[1] = kdmk;
                    item[2] = nmmk;
                    item[3] = idcpmk;
                    item[4] = cpmk;
                    item[5] = btn;

                    c.push(item);
                    // table.row.add([no, v['kode_matakuliah'], v['nama_matakuliah'], v[
                    //         'idcpmk'], v['cpmk'],
                    //     "<button class='btn btn-primary btn-sm' >Edit</button>"
                    // ]).draw()

                    if (value != v['kode_matakuliah']) {
                        text = v['kode_matakuliah'] + " : " + v['nama_matakuliah']
                        value = v['kode_matakuliah']
                        kurikulum = v['id_kurikulum']
                        $('#mkinput-source').append($('<option />').val(value).text(text)
                            .attr({
                                'id_kurikulum': kurikulum

                            })
                        );
                    }
                })
                data3 =
                    // console.log(data3)
                    table.rows.add(c).draw()
                $('#mkinput').val("").trigger('change');
                $('#mkinput > option').hide();
                $('#loading').hide();

            }).fail(function(xhr, status, error) {});

        }
    </script>
</body>

</html>