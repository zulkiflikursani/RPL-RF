<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <!-- DataTables -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-1">
                                                    <label for="" class="form-label">Fakultas</label>
                                                    <select name="fakultas" id="fakultas" onchange="getprodi()" class="form-select">
                                                        <option value="">Pilih Fakultas</option>
                                                        <option value="13123">TEKNIK</option>
                                                        <option value="60001">FEIS</option>
                                                        <option value="11222">PASCASARJANA</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi</label>
                                                    <select class="form-select" id="prodi" onchange='getMatakuliah()' name='prodi' required>
                                                        <option value=''>Pilih</option>
                                                        <?php
                                                        if (isset($jenis_prodi)) {
                                                            foreach ($jenis_prodi as $row) {
                                                                echo "<option idfak='$row->kode_fakultas' value='$row->kode_prodi' >$row->nama_prodi</option>";
                                                            }
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- modal tambah asessor -->
                                        <div class="modal fade tambah-cpmk-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
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

                                                        <form method="POST" action="<?= base_url("Admin/SimpanPengguna") ?>" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="formrow-nama-input" class="form-label">Nama Matakuliah</label>
                                                                        <input list="suggestionList" id="mkInput" class='form-control'>
                                                                        <datalist id="suggestionList" class="col-md-12" style="width: 100%;">
                                                                            <!-- <option data-value="45">1032 : 345sdfg</option> -->
                                                                        </datalist>
                                                                        <input type="hidden" name="mkinput" id="mkInput-hidden">
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
                                                                        <input type="text" class="form-control" id="cpmk" placeholder="Masukkan Nama CPMK" value="" required>
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
                                                                        <input type="text" class="form-control" id="ecpmk" placeholder="Masukkan Nama CPMK" value="" required>
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
                                    <h3 class="text-center">PRODI <span id='jprodi'>AKUNTANSI</span></h3>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" data-bs-toggle="modal" id='bt-tambah-cpmk' data-bs-target='.tambah-cpmk-modal'>Tambah Cpmk</button>
                                        </div>
                                    </div>
                                    <table class='table-matakuliah table table-bordered dt-responsive  nowrap w-100'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Matakuliah</th>
                                                <th>Nama Matakuliah</th>
                                                <th>Id Cpmk</th>
                                                <th>Nama Cpmk</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

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
    !-- Required datatable js -->
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

    <!-- Datatable init js -->
    <script src="<?= base_url() ?>assets/js/pages/datatables.init.js"></script>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
        document.querySelector('input[list]').addEventListener('input', function(e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
                inputValue = input.value;

            hiddenInput.value = inputValue;

            for (var i = 0; i < options.length; i++) {
                var option = options[i];

                if (option.innerText === inputValue) {
                    hiddenInput.value = option.getAttribute('data-value');
                    break;
                }
            }
        });
        $('document').ready(function() {
            $('#prodi > option').hide()
            $('#bt-tambah-cpmk').hide();
            var table = $('.table-matakuliah').DataTable()

            $('.table-matakuliah tbody').on('click', 'button', function() {
                var data = table.row($(this).parents('tr')).data();
                $('#enmmk').val(data[2]);
                $('#eidcpmk').val(data[3]);
                $('#ecpmk').val(data[4]);

                $('.edit-cpmk-modal').modal('show')




                // alert(data[0] + "'s salary is: " + data[5]);
            });

        })

        function getprodi() {
            fak = $('#fakultas').val()
            $('#prodi > option').hide()
            $('#prodi').val("")
            $('#prodi > option[idfak=' + fak + ']').show()

        }

        function simpancpmk() {
            prodi = $('#prodi').val();
            kdmk = $('#mkInput-hidden').val();
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

                };
            })

        }

        function editcpmk() {
            prodi = $('#prodi').val();
            kdmk = $('#enmmk').val();
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
                    $('.tambah-cpmk-modal').modal('hide');

                };
            })


        }

        function hapuscpmk() {
            prodi = $('#prodi').val();
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
            })

        }

        function getMatakuliah() {
            $('#loading').show();

            getMatakuliahModal();
            $('#bt-tambah-cpmk').show();
            table = $('.table-matakuliah').DataTable()
            table.clear().draw();
            url = '<?= base_url('getcpmk') ?>'
            prodi = $('#prodi').val();
            namaprodi = $('#prodi option:selected').text().toUpperCase();
            $('#jprodi').html(namaprodi)
            $.post(url, {
                prodi: prodi
            }).done(function(data) {
                data = JSON.parse(data)
                $.each(data, function(i, v) {
                    no = parseFloat(i) + 1;
                    table.row.add([no, v['kode_matakuliah'], v['nama_matakuliah'], v[
                            'idcpmk'], v['cpmk'],
                        "<button class='btn btn-primary btn-sm' >Edit</button>"
                    ]).draw()

                })

                $('#loading').hide();

            }).fail(function(xhr, status, error) {});

        }

        function getMatakuliahModal() {
            $('#suggestionList').children().remove()
            url = '<?= base_url('getmatakuliah') ?>'
            prodi = $('#prodi').val();
            namaprodi = $('#prodi option:selected').text().toUpperCase();
            $('#jprodi').html(namaprodi)
            $.post(url, {
                prodi: prodi
            }, function(data) {
                data = JSON.parse(data)
                $.each(data, function(i, v) {
                    no = parseFloat(i) + 1;
                    $('#suggestionList').append("<option data-value=" + v['kode_matakuliah'] + ">" + v[
                        'kode_matakuliah'] + " : " + v['nama_matakuliah'] + "</option>");

                })

            })

        }
    </script>
</body>

</html>