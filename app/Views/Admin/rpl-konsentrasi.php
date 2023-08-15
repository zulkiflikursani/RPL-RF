<!doctype html>
<html lang="en">

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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

                    if (isset($alert)) {
                        if ($alert != "") {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">' . $alert . '<button type="button" class="btn-close" data-bs-dismiss="alert"
        aria-label="Close"></button></div>';
                        }
                    }


                    // if (isset($status)) {
                    //     if ($status == true) {
                    //         echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                    //     aria-label="Close"></button></div>';
                    //     }
                    // }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="modal fade update-konsentrasi" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Update Konsentrasi
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Kode
                                                                Konsentrasi</label>
                                                            <input type="text" class="form-control" id="ekode_kons" placeholder="Masukkan Kode Konsentrasi" value="" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Nama
                                                                Konsentrasi</label>
                                                            <input type="text" class="form-control" id="enama_kons" placeholder="Masukkan Nama Konsentrasi" value="">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" onclick='updatekons()' class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!---End Model--->
                            <div class="modal fade tambah-konsentrasi" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Tambah Konsentrasi
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Kode
                                                                Konsentrasi</label>
                                                            <input type="text" class="form-control" id="kode_kons" placeholder="Masukkan Kode Konsentrasi" value="">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Nama
                                                                Konsentrasi</label>
                                                            <input type="text" class="form-control" id="nama_kons" placeholder="Masukkan Nama Konsentrasi" value="">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" onclick='simpankons()' class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade delete-konsentrasi" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Hapus Konsentrasi
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <label for="formrow-nama-input" class="form-label">Apakah
                                                                Anda ingin Menghapus Konsentrasi <span id='dkonsentrasi'></span> ?</label>
                                                            <input type="hidden" class="form-control" id="dkode_kons" />

                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <button type="button" onclick='hapuskons()' class="btn btn-primary w-md">Ya</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Tabel Konsentrasi Prodi</h4>
                                    <button class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target=".tambah-konsentrasi">Tambah Konsentrasi</button>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered ">
                                                <thead class="table-light ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Prodi</th>
                                                        <th>Prodi</th>
                                                        <th>Kode Konsentrasi</th>
                                                        <th>Konsentrasi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($data)) {
                                                        $i = 0;
                                                        foreach ($data as $row) {
                                                            $i++;
                                                            echo "<tr>
                                                            <td>$i</td>
                                                            <td for='prodi'>" . $row->prodi . "</td>
                                                            <td for='nama_prodi'>" . $row->nama_prodi . "</td>
                                                            <td for='kode_kons'>" . $row->kode_konsentrasi . "</td>
                                                            <td for='kons'>" . $row->konsentrasi . "</td>
                                                            <td>
                                                            <button class='button btn btn-sm btn-primary' onclick='edit($(this))'>Edit</button>
                                                            <button class='button btn btn-sm btn-danger' onclick='hapus($(this))'>Hapus</button>
                                                            </td>
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
    <!-- data-table -->
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
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
        function edit(ini) {
            kodekon = ini.parent().parent().find('td[for=kode_kons').html()
            konsentrasi = ini.parent().parent().find('td[for=kons').html()
            $('#ekode_kons').val(kodekon)
            $('#enama_kons').val(konsentrasi)

            $('.update-konsentrasi').modal('show')


        }

        function hapus(ini) {
            kodekon = ini.parent().parent().find('td[for=kode_kons').html()
            konsentrasi = ini.parent().parent().find('td[for=kons').html()
            $('#dkode_kons').val(kodekon)
            $('#dkonsentrasi').html(konsentrasi)
            $('.delete-konsentrasi').modal('show')


        }

        function simpankons() {
            url = '<?= base_url('simpan-konsentrasi') ?>'
            kode_kons = $('#kode_kons').val()
            nama_kons = $('#nama_kons').val()
            $.post(url, {
                kode_kons: kode_kons,
                nama_kons: nama_kons
            }, function(data) {
                data = JSON.parse(data);
                console.log(data['message'])
                if (data['status'] === 0) {
                    let confirmAction = confirm("DATA BERHASIL DISIMPAN");
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                } else {
                    if (data['message']['kode_konsentrasi'] != 'undefined') {
                        errormessage = data['message']['kode_konsentrasi']
                    } else if (data['message']['konsentrasi'] != 'undefined') {
                        errormessage = data['message']['konsentrasi']
                    }
                    let confirmAction = confirm(errormessage);
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            })
        }

        function updatekons() {
            url = '<?= base_url('update-konsentrasi') ?>'
            kode_kons = $('#ekode_kons').val()
            nama_kons = $('#enama_kons').val()
            $.post(url, {
                kode_kons: kode_kons,
                nama_kons: nama_kons
            }, function(data) {
                data = JSON.parse(data);
                console.log(data)
                if (data['status'] === true) {
                    let confirmAction = confirm("DATA BERHASIL DISIMPAN");
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                } else {
                    if (data['message']['konsentrasi'] != 'undefined') {
                        errormessage = data['message']['konsentrasi']
                    } else if (data['message']['kode_konsentrasi'] != 'undefined') {
                        errormessage = data['message']['kode_konsentrasi']
                    }
                    let confirmAction = confirm(errormessage);
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            })
        }

        function hapuskons() {
            url = '<?= base_url('delete-konsentrasi') ?>'
            kode_kons = $('#dkode_kons').val()
            // nama_kons = $('#enama_kons').val()
            $.post(url, {
                kode_kons: kode_kons,
                // nama_kons: nama_kons
            }, function(data) {
                data = JSON.parse(data);
                console.log(data)
                if (data['status'] === true) {
                    let confirmAction = confirm("DATA BERHASIL DIHAPUS");
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                } else {
                    if (data['message']['konsentrasi'] != 'undefined') {
                        errormessage = data['message']['konsentrasi']
                    } else if (data['message']['kode_konsentrasi'] != 'undefined') {
                        errormessage = data['message']['kode_konsentrasi']
                    }
                    let confirmAction = confirm(errormessage);
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            })
        }
    </script>
</body>

</html>