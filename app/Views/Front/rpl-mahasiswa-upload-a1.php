<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            right: 10px;
            left: auto;
        }
    </style>
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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Menyimpan data<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }
                    if (isset($statushapus)) {
                        if ($statushapus == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Menghapus data.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }


                    if (isset($databio[0])) {
                        // print_r($datasubmit-nama);
                        $biodata = $databio[0];
                        $jenis_rpl = $databio[0]['jenis_rpl'];
                        $noregis = $databio[0]['no_peserta'];
                        if ($jenis_rpl == 1) {
                            $nm_rpl = "A1";
                        } else if ($jenis_rpl == 2) {
                            $nm_rpl = "A2";
                        } else if ($jenis_rpl == 3) {
                            $nm_rpl = "A3";
                        }
                    } else if (isset($databio['jenis_rpl'])) {
                        $jenis_rpl = $databio['jenis_rpl'];
                        $noregis = $databio['no_peserta'];

                        if ($jenis_rpl == 1) {
                            $nm_rpl = "A1";
                        } else if ($jenis_rpl == 2) {
                            $nm_rpl = "A2";
                        } else if ($jenis_rpl == 3) {
                            $nm_rpl = "A3";
                        }
                    }


                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Upload Dokumen RPL</h4>

                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target=".tambah-upload-modal">Upload</button>

                                    <!-- modal konfirmasi -->
                                    <div class="modal fade confirmasi-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Konfirmasi
                                                    </h5>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <h5 class="modal-title" id="myLargeModalLabel">Apakah anda yakin
                                                        untuk menghapus dokumen ini ?
                                                    </h5>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id='btya' iddokumen='' onclick='hapus($(this))' class="btn btn-primary w-md">Ya</button>
                                                    <button type="button" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close">Tidak</button>

                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>

                                    <!-- Modal upload -->
                                    <div class="modal fade tambah-upload-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-upload-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Upload Berkas
                                                        <?= $nm_rpl ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Front/Simpanberkas") ?>" enctype="multipart/form-data">
                                                        <div class="mb-3">
                                                            <label for="formrow-inputPendidikan" class="form-label">Jenis Dokumen</label>
                                                            <select class="form-select" id="autoSizingSelect" name='jenis_file'>
                                                                <option value=''>
                                                                    Pilih...</option>
                                                                "<option value='02'>Transkip nilai </option>"
                                                                <?php
                                                                if ($jenis_rpl == 1) {
                                                                } else {
                                                                    $db      = \Config\Database::connect();
                                                                    $jenisfile = $db->query('select * from tb_jenis_file');
                                                                    if ($jenisfile->getResult() != null) {
                                                                        foreach ($jenisfile->getResult() as $b) {
                                                                            echo "<option value='$b->kd_jenis'>$b->nama_jenis</option>";
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formrow-inputProvinsi" class="form-label">Nama
                                                                Dokumen</label>
                                                            <input type="text" class="form-control" id="formrow-inputProvinsi" name="nmfile" placeholder="Masukkan Nama Dokumen" value="">
                                                        </div>
                                                        <div class="mb-3  text-left">
                                                            <div class="input-group">

                                                                <div class="form-check ">
                                                                    <input class="form-check-input" type="radio" name="formRadios" id="formRadios1" checked>
                                                                    <label class="form-check-label" for="formRadios1">
                                                                        Upload File
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mx-3">
                                                                    <input class="form-check-input" type="radio" name="formRadios" id="formRadios2">
                                                                    <label class="form-check-label" for="formRadios2">
                                                                        Link File
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="input-group mt-3" id='input-upload'>
                                                                <input type="file" class="form-control" name='userFile' id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" accept="application/pdf" aria-label="Upload">

                                                            </div>
                                                            <span class="text-danger">Note: File PDF dengan ukuran
                                                                maksimal 1
                                                                Mb</span>
                                                            <div class="mb-3 mt-3" id='input-url' style='display:none'>
                                                                <label for="formrow-inputProvinsi" class="form-label">Url Dokumen
                                                                </label>
                                                                <input type="text" class="form-control" id="formrow-inputProvinsi" name="url" placeholder="Masukkan URL Dokumen" value="">
                                                            </div>

                                                        </div>
                                                        <div>
                                                            <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!-- modal tambah matakuliah -->
                                    <div class="modal fade tambah-matakuliah-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-matakuliah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content col-12">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Tambah Matakuliah
                                                        <?= $nm_rpl ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Front/SimpanMatakuliahA1") ?>">
                                                        <div class="row">
                                                            <input type="hidden" name="kodept" id='mkode-pt'>
                                                            <input type="hidden" name="nmpt" id='mnama-pt'>
                                                            <div class="mb-3 col-md-5">
                                                                <label for="formrow-inputPendidikan" class="form-label">Kode
                                                                    Matakuliah</label>
                                                                <input type="text" class="form-control col-2" id="formrow-inputProvinsi" name="kode_matakuliah" placeholder="Masukkan Kode Matakuliah" value="">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="formrow-inputProvinsi" class="form-label">Nama
                                                                    Matakuliah</label>
                                                                <input type="text" class="form-control" id="formrow-inputProvinsi" name="nama_matakuliah" placeholder="Masukkan Nama Matakuliah" value="">
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label for="formrow-inputProvinsi" class="form-label">Jumlah
                                                                    SKS</label>
                                                                <input type="text" class="form-control col-md-3" id="formrow-inputProvinsi" name="sks" placeholder="Masukkan Jumlah SKS" value="">
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-2">
                                                                    <label for="formrow-inputProvinsi" class="form-label">Nilai</label>
                                                                    <select class='form-select col-md-3' name="Nilai" id="Nilai">
                                                                        <option value="">Pilih Nilai</option>
                                                                        <?php
                                                                        if (isset($nilai)) {
                                                                            foreach ($nilai as $row) {
                                                                                echo "<option value='" . $row['kode_nilai'] . "'>" . $row['kode_nilai'] . "</option>";
                                                                            }
                                                                        }

                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <!-- endmodal -->
                                    <div class="modal fade confirm-deletemk-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-matakuliah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content col-12">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Konfirmasi
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Front/HapusMatakuliahA1") ?>">
                                                        <div class="row">
                                                            <label for="">Apakah Yakin Akan Menghapus Matakuliah
                                                                ini</label>
                                                        </div>
                                                        <input type="hidden" id='ekdmk' name='kode_matakuliah' readonly>
                                                        <div>
                                                            <button type="submit" class="btn btn-primary w-md">Ya</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <div class="modal fade submit-matakuliah-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-matakuliah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content col-12">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Konfirmasi
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- content -->
                                                    <form method="POST" action="<?= base_url("Front/SubmitMatakuliahA1") ?>">
                                                        <div class="row">
                                                            <label for="">Apakah Yakin Akan Mengajukan Matakuliah.
                                                                Setelah pengajaruan anda tidak bisa membatalkan atau
                                                                menambahkan matakuliah.</label>
                                                        </div>
                                                        <input type="hidden" id='enoregis' name='noregis' value='<?= $noregis ?>' readonly>
                                                        <div>
                                                            <button type="submit" class="btn btn-primary w-md">Ya</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <!-- end modal hapus -->
                                    <!-- daftar dokumen -->
                                    <div id='dafrarmk'>
                                        <h4 class="text-center">Daftar Dokumen</h4>
                                        <div>
                                            <table class="table table-border">
                                                <thead class='bg-light'>
                                                    <tr>
                                                        <th class="col-1">No</th>
                                                        <th class="col-3">Jenis Dokumen</th>
                                                        <th class="col-5">Nama Dokumen</th>
                                                        <th class="col-3">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($datadok)) {
                                                        $i = 1;
                                                        foreach ($datadok as $datafile) {
                                                            $url = $datafile['lokasi_file'] . "/" . $datafile['nmfile_asli'];
                                                            $link = base_url($url);
                                                            echo "<tr>
                                                            <td>$i</td>
                                                            <td>" . $datafile['nama_jenis'] . "</td>
                                                            <td>" . $datafile['nmfile'] . "</td>
                                                            <td><a href='" . $link . "' target='_blank'><button class='btn btn-sm btn-primary'>Lihat file</button></a><button class='btn btn-sm btn-primary mx-2' onclick='showModal(" . $datafile['no_dokumen'] . ")'>Hapus File</button></td>
                                                            
                                                        </tr>";
                                                            $i++;
                                                        }
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title mb-4">Form Matakuliah Transkrip</h4>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label for="" class='col-md-2'>Perguruan Tinggi</label>
                                                <div for="" class='col-md-4'>
                                                    <?php
                                                    if (isset($kdptasal)) {
                                                        if ($kdptasal == null) {
                                                            if (isset($ptasal)) {
                                                                echo "<select class='form-select select2' name='ptasal' id='ptasal'><option value=''></option>";
                                                                // foreach ($ptasal as $row) {
                                                                // echo "<option  value='" . $row['nama_perguruan_tinggi'] . "'>" . $row['nama_perguruan_tinggi'] . "</option>";
                                                                // };
                                                                echo " </select>";
                                                            }
                                                        } else {
                                                    ?>
                                                            <input type="hidden" id='ptasal' class="form-control" name='ptasal' value='<?= $kdptasal ?>' readonly />
                                                            <input type="text" id='ptasal' class="form-control" name='nmptasal' value='<?= $nmptasal ?>' readonly />
                                                    <?php

                                                        }
                                                    } else {
                                                        if (isset($ptasal)) {
                                                            echo "<select class='form-select select2' name='ptasal' id='ptasal'>";
                                                            // foreach ($ptasal as $row) {
                                                            //     echo "<option  value='" . $row['nama_perguruan_tinggi'] . "'>" . $row['nama_perguruan_tinggi'] . "</option>";
                                                            // };
                                                            echo " </select>";
                                                        }
                                                    }
                                                    ?>


                                                </div>
                                            </div>
                                            <div class="row">

                                                <!-- <label for="">b</label> -->
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary" id='tambah-matakuliah' data-bs-toggle="modal" data-bs-target=".tambah-matakuliah-modal">Tambah
                                        Matakuliah</button>
                                    <a href="<?= base_url("importmka1") ?>"><button type="button" class="btn btn-primary ">Import Matakuliah</button></a>

                                    <!-- daftar dokumen -->
                                    <h4 class="text-center">Daftar Matakuliah</h4>
                                    <div>
                                        <table class="table table-border">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="col-1">No</th>
                                                    <th class="col-2">Kode Matakuliah</th>
                                                    <th class="col-5">Nama Matakuliah</th>
                                                    <th class="col-2">SKS</th>
                                                    <th class="col-2">Nilai</th>
                                                    <th class="col-2">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                if (isset($dataMkA1)) {
                                                    $i = 1;
                                                    $jumlahsks = 0;
                                                    foreach ($dataMkA1 as $data) {
                                                        $jumlahsks = $jumlahsks + $data['jumlah_sks'];
                                                        echo "<tr>
                                                                <td>$i</td>
                                                                <td>" . $data['kode_matakuliah'] . "</td>
                                                                <td>" . $data['nama_matakuliah'] . "</td>
                                                                <td>" . $data['jumlah_sks'] . "</td>
                                                                <td>" . $data['nilai'] . "</td>  
                                                                <td><button class='btn btn-sm btn-primary delete-matakuliah' id='delete-matakuliah' kdmk='" . $data['kode_matakuliah'] . "'
                                                                data-bs-toggle='modal' data-bs-target='.confirm-deletemk-modal'>Hapus</button></td>  
                                                            </tr>";
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        if (isset($jumlahsks)) {
                                            echo  "<div>Jumlah sks : $jumlahsks sks</div>";
                                        }
                                        ?>
                                        <button type="button" data-bs-toggle="modal" data-bs-target=".submit-matakuliah-modal" class="btn btn-primary mt-2">Submit</button>
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
</body>

</html>

<script>
    var url = '<?= base_url('searchtpasal') ?>'
    $('.select2').select2({
        ajax: {
            url: url,
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $(document).ready(function() {

        $('#formRadios1').click(function() {
            $('#input-url').hide()
            $('#input-upload').show()
        })
        $('#formRadios2').click(function() {
            $('#input-url').show()
            $('#input-upload').hide()
        })

        $('.tambah-matakuliah-modal').on('show.bs.modal', function(e) {
            <?php if (isset($nmptasal) && $nmptasal != "") {
            ?>
                kdpt = '<?= $kdptasal ?>'
                nmpt = '<?= $nmptasal ?>'
            <?php
            } else {
            ?>
                kdpt = $('#ptasal').val()
                nmpt = $('#ptasal').text()
            <?php
            }
            ?>

            // alert(nmpt);
            if (kdpt == "") {
                alert('Pilih Perguruan Tinggi')
                // $('.tambah-matakuliah-modal').modal('hide')
                e.preventDefault(); // prevent the modal from being hidden
            } else {
                $('#mkode-pt').val(kdpt);
                $('#mnama-pt').val(nmpt);
            }
            // if (someCondition) {}
        })

        $(".delete-matakuliah").on('click', function() {
            b = $(this).attr('kdmk')

            $('#ekdmk').val(b);
        });

    })

    function showModal(ini) {

        $('#btya').attr('iddokumen', ini)
        $('.confirmasi-modal').modal("show")
    }

    function hapus(ini) {
        $('#loading').show();
        url = '<?= base_url('deldok') ?>'
        nodokumen = ini.attr('iddokumen');
        $.post(url, {
            nodokumen: nodokumen
        }).done(function(data) {
            $('#loading').hide();
            $('.confirmasi-modal').modal("hide")
            if (alert(data)) {} else {
                window.location.replace('<?= base_url('uploada1') ?>')
            };

        })
    }
</script>