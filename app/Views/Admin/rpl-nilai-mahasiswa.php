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

        <?=
        $this->include("partials/rpl-horizontal-afterregis-pengguna")
        ?>

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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }
                    if (isset($datasubmit)) {
                        if (isset($datasubmit[0])) {
                            $datasubmit = json_encode($datasubmit[0]);
                            $datasubmit = json_decode($datasubmit, true);
                        } else {
                            // $datasubmit = "";

                            echo "<script>
                            alert('Data tidak ditemukan !')
                            window.location.href='" . base_url('nilai-mahasiswa') . "'
                            </script>";
                        }
                    }
                    if (isset($datasubmit['no_peserta'])) {
                        $noregis = $datasubmit['no_peserta'];
                    } else {
                        $noregis = '';
                    }

                    if (isset($datasiska)) {
                        $datasiska = json_decode($datasiska);

                        // var_dump($datasiska);
                        // die;
                        $datasiska = $datasiska->result;
                        if ($datasiska == "not found") {
                            $nim = "";
                            $nama = "";
                        } else if ($datasiska == 'gagal') {
                            $nim = '';
                            $nama = '';
                        } else {
                            foreach ($datasiska as $row) {
                                $nim = $row->nim;
                                $nama = $row->nama;
                            }
                        }
                    } else {
                        $datasiska = 'not isset';
                    }
                    ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title mb-4">Biodata Mahasiswa</h4>
                                    <div>
                                        <div class="row">
                                            <div class="row col-md-12">
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-nama-input" class="form-label">No
                                                        Registrasi</label>
                                                    <input type="text" class="form-control" id="noregis" name="no_peserta" value="<?= (isset($datasubmit["no_peserta"]) ? $datasubmit["no_peserta"] : '') ?>" required readonly>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label for="formrow-nama-input" class="form-label">NIM</label>
                                                    <input type="text" class="form-control" id="nim" name="nim" value="<?= (isset($nim) ? $nim : $nim) ?>" required <?= ($nim == '' ? "" : "readonly") ?> />
                                                </div>
                                                <div class="mb-3 mt-1 col-md-2 pt-4">
                                                    <button class="btn btn-primary btn-sm" onclick="ceknim()">Cek
                                                        Nim</button>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-nama-input" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" name="nama" value="<?= (isset($datasubmit["nama"]) ? $datasubmit["nama"] : '') ?>" required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-nama-input" class="form-label">Nama
                                                        Siska</label>
                                                    <input type="text" class="form-control" id="nama_siska" name="nama_siska" value="<?= (isset($nama) ? $nama : '') ?>" required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input" name="email" value="<?= (isset($datasubmit["email"]) ? $datasubmit["email"] : '') ?>" required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat" name="alamat" value="<?= (isset($datasubmit["alamat"]) ? $datasubmit["alamat"] : '') ?>" required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-inputProvinsi" class="form-label">Provinsi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi" name="provinsi" value="<?= (isset($datasubmit["propinsi"]) ? $datasubmit["propinsi"] : '') ?>" required readonly>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputKab" class="form-label">Kota
                                                            Kabupaten</label>
                                                        <input type="text" class="form-control" id="formrow-inputProvinsi" name="provinsi" value="<?= (isset($datasubmit["propinsi"]) ? $datasubmit["propinsi"] : '') ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputKab" class="form-label">Tempat
                                                            Lahir</label>
                                                        <input type="text" class="form-control" id="formrow-inputAlamat" name="tlahir" value="<?= (isset($datasubmit["t_lahir"]) ? $datasubmit["t_lahir"] : '') ?>" required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Tanggal
                                                            Lahir</label>
                                                        <input type="date" class="form-control" id="formrow-inputInstansi" name="ttl" value="<?= (isset($datasubmit["ttl"]) ? $datasubmit["ttl"] : '') ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Nama
                                                            Ibu
                                                            Kandung</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="ibukandung" value="<?= (isset($datasubmit["ibu_kandung"]) ? $datasubmit["ibu_kandung"] : '') ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                            (WA)</label>
                                                        <input type="text" class="form-control" id="formrow-inputProvinsi" name="nohp" value="<?= (isset($datasubmit["nohape"]) ? $datasubmit["nohape"] : '') ?>" required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Instansi
                                                            Asal</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="instansi" value="<?= (isset($datasubmit["instansi_asal"]) ? $datasubmit["instansi_asal"] : '') ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Nomor
                                                            Induk Kependudukan (NIK)</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="nik" value="<?= (isset($datasubmit["nik"]) ? $datasubmit["nik"] : '') ?>" required readonly>
                                                    </div>
                                                </div>
                                                <?php

                                                if (isset($datasubmit['didikakhir'])) {
                                                    if ($datasubmit['didikakhir'] == "1") {
                                                        $pendidikan = "SD";
                                                    } else if ($datasubmit['didikakhir'] == "2") {
                                                        $pendidikan = "SLTP";
                                                    } else if ($datasubmit['didikakhir'] == "3") {
                                                        $pendidikan = "SLTA";
                                                    } else if ($datasubmit['didikakhir'] == "4") {
                                                        $pendidikan = "D3";
                                                    } else if ($datasubmit['didikakhir'] == "5") {
                                                        $pendidikan = "S1";
                                                    } else if ($datasubmit['didikakhir'] == "6") {
                                                        $pendidikan = "D1";
                                                    } else if ($datasubmit['didikakhir'] == "7") {
                                                        $pendidikan = "D2";
                                                    }
                                                }

                                                ?>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan" class="form-label">Pendidikan
                                                            Terakhir</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="pendidikan" value="<?= (isset($pendidikan) ? $pendidikan : '') ?>" required readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan" class="form-label">Jenis
                                                            RPL</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="jenisrpl" value="<?= (isset($datasubmit["jenis_rpl"]) ? "A" . $datasubmit["jenis_rpl"] : '') ?>" required readonly />

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan" class="form-label">Program
                                                            Studi Pilihan</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="kode_prodi" value="<?= (isset($namaprodi) ? $namaprodi : '') ?>" required readonly />

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan" class="form-label">Konsentrasi</label>
                                                        <input type="text" class="form-control" id="formrow-inputInstansi" name="konsentrasi" value="<?= (isset($datasubmit["konsentrasi"]) ? $datasubmit["didikakhir"] : '') ?>" required readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="card-title mb-4 text-center">LEMBAR KERJA ASESSMENT
                                                </h4>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class='table table-bordered table-responsive table-sm border-dark' style="font-size: 10px;">
                                                                <thead class="">
                                                                    <tr>
                                                                        <th width='5%'>No</th>
                                                                        <th>Kode Matakuliah Asal</th>
                                                                        <th>Nama Matakuliah Asal</th>
                                                                        <th>Kode Matakuliah</th>
                                                                        <th>Nama Matakuliah</th>
                                                                        <th width='7%'>Kredit</th>
                                                                        <th width='7%'>Nilai</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id='tbody-klaim-mk'>
                                                                    <?php
                                                                    if (isset($dataKlaimAsessor)) {
                                                                        $i = 0;
                                                                        $countdata = count($dataKlaimAsessor);
                                                                        $jumlahsks = 0;
                                                                        $kdmk = "";
                                                                        foreach ($dataKlaimAsessor as $row) {
                                                                            $i++;
                                                                            if ($row->jenis_rpl != 1) {
                                                                                $kd_mk_asal = $row->kode_matakuliah;
                                                                                $nm_mk_asal = $row->nama_matakuliah;
                                                                            } else {
                                                                                $kd_mk_asal = $row->kode_matakuliah_asal;
                                                                                $nm_mk_asal = $row->nama_matakuliah_asal;
                                                                            }
                                                                            // $kdmk = "";
                                                                            $rowspan = 1;
                                                                            $tempkolom = '';
                                                                            if ($kdmk == $row->kode_matakuliah) {
                                                                            } else {
                                                                                if ($row->entry_count == 0) {
                                                                                    $rowspan = 1;
                                                                                } else {
                                                                                    $rowspan = $row->entry_count;
                                                                                }
                                                                                $kdmk = $row->kode_matakuliah;
                                                                                $tempkolom = "<td rowspan='$rowspan'>$row->kode_matakuliah</td>        
                                                                                <td rowspan='$rowspan' >$row->nama_matakuliah</td>        
                                                                                <td class='text-center' rowspan='$rowspan'>$row->sks</td>        
                                                                                <td class='text-center' rowspan='$rowspan'>$row->nilai</td>";
                                                                                $jumlahsks = floatval($jumlahsks) + floatval($row->sks);
                                                                            }
                                                                            $kolom = "<tr>
                                                                                <td>$i</td>        
                                                                                <td>$kd_mk_asal</td>        
                                                                                <td>$nm_mk_asal</td>
                                                                               " . $tempkolom . "           
                                                                            </tr>";

                                                                            echo $kolom;

                                                                            if ($i == $countdata) {
                                                                                echo "<tr>
                                                                        <td colspan='5' class='text-center'> Jumlah</td>        
                                                                        <td class='text-center' >$jumlahsks</td>        
                                                                        <td></td>          
                                                                    </tr>";
                                                                            }
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
                                        <div class="row mt-4">
                                            <div class="col-md-2">
                                                <button onclick="push_submit()" class="btn btn-primary w-md">Submit</button>
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
        <div class="modal fade" id="notifikasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id='notif-message'></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id='btn-ya' onclick="">YA</button>
                    </div>
                </div>
            </div>
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
    <!-- <script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script> -->


    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script>
        $('document').ready(function() {
            $('#notif-message').html(
                'Pastikan nama sama dengan nama siska sebelum menyimpan data.')
            $('#btn-ya').hide();
            $('#notifikasi').modal('show');
        })

        function ceknim() {
            nim = $('#nim').val()
            url = '<?= base_url('data-mahasiswa-siska-nim') ?>'
            $.post(url, {
                nim: nim
            }, function(data) {
                data = JSON.parse(data)

                if (data.result !== 'not found') {
                    $.each(data.result, function(index, value) {
                        $('#notif-message').html('Nama : ' + value['nama'])
                        $('#btn-ya').hide()
                        $('#notifikasi').modal('show');
                        // alert(value['nama'])
                        $('#nama_siska').val(value['nama'])
                    })
                } else {
                    $('#notif-message').html('Data tidak ditemukan')
                    $('#btn-ya').hide()
                    $('#notifikasi').modal('show')
                    $('#nim').val('');
                    // alert('Data tidak ditemukan');
                }

            })

        }

        function push_data(noregis, nim) {
            $.post(url, {
                nim: nim,
                noregis: noregis
            }, function(data) {
                if (data == "sukses") {
                    $('#notif-message').html('Data Berhasil disimpan')
                    $('#btn-ya').hide()
                    $('#notifikasi').modal('show')
                } else {
                    $('#notif-message').html(data)
                    $('#btn-ya').hide()
                    $('#notifikasi').modal('show')
                }
            })
        }

        function push_submit() {
            nim = $('#nim').val();
            nama = $('#nama_siska').val()
            noregis = $('#noregis').val()
            url = '<?= base_url('push-siska') ?>'
            if (nim == "" || nama == "") {
                $('#notif-message').html(
                    'Silahkan isi nim mahasiswa dan pastikan nama mahasiswa muncul dengan menekan tombol cek nim.')
                $('#notifikasi').modal('show');
                $('#btn-ya').hide()
            } else {
                $('#notif-message').html(
                    'Pastikan nama sama dengan nama siska sebelum menyimpan data.')
                $('#btn-ya').show();
                $('#btn-ya').attr('onclick', `push_data(noregis, nim)`)
                $('#notifikasi').modal('show');

            }


        }
    </script>
</body>

</html>