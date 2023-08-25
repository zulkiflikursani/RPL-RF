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

        <?= $this->include("partials/rpl-horizontal-afterregis-pengguna") ?>

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
                    ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Biodata Mahasiswa</h4>
                                    <form method="POST" action="<?= base_url("Admin/setBiodata") ?>">
                                        <div class="row">
                                            <div class="row col-md-12">
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-nama-input" class="form-label">No
                                                        Registrasi</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input"
                                                        name="no_peserta"
                                                        value="<?= (isset($datasubmit["no_peserta"]) ? $datasubmit["no_peserta"] : '') ?>"
                                                        required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-nama-input" class="form-label">NIM</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input"
                                                        name="nama"
                                                        value="<?= (isset($datasubmit["nim"]) ? $datasubmit["nim"] : '') ?>"
                                                        required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-nama-input" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input"
                                                        name="nama"
                                                        value="<?= (isset($datasubmit["nama"]) ? $datasubmit["nama"] : '') ?>"
                                                        required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input"
                                                        name="email"
                                                        value="<?= (isset($datasubmit["email"]) ? $datasubmit["email"] : '') ?>"
                                                        required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat"
                                                        value="<?= (isset($datasubmit["alamat"]) ? $datasubmit["alamat"] : '') ?>"
                                                        required readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="formrow-inputProvinsi"
                                                        class="form-label">Provinsi</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="provinsi"
                                                        value="<?= (isset($datasubmit["propinsi"]) ? $datasubmit["propinsi"] : '') ?>"
                                                        required readonly>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputKab" class="form-label">Kota
                                                            Kabupaten</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputProvinsi" name="provinsi"
                                                            value="<?= (isset($datasubmit["propinsi"]) ? $datasubmit["propinsi"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputKab" class="form-label">Tempat
                                                            Lahir</label>
                                                        <input type="text" class="form-control" id="formrow-inputAlamat"
                                                            name="tlahir"
                                                            value="<?= (isset($datasubmit["t_lahir"]) ? $datasubmit["t_lahir"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Tanggal
                                                            Lahir</label>
                                                        <input type="date" class="form-control"
                                                            id="formrow-inputInstansi" name="ttl"
                                                            value="<?= (isset($datasubmit["ttl"]) ? $datasubmit["ttl"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Nama
                                                            Ibu
                                                            Kandung</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="ibukandung"
                                                            value="<?= (isset($datasubmit["ibu_kandung"]) ? $datasubmit["ibu_kandung"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                            (WA)</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputProvinsi" name="nohp"
                                                            value="<?= (isset($datasubmit["nohape"]) ? $datasubmit["nohape"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Instansi
                                                            Asal</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="instansi"
                                                            value="<?= (isset($datasubmit["instansi_asal"]) ? $datasubmit["instansi_asal"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputInstansi" class="form-label">Nomor
                                                            Induk Kependudukan (NIK)</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="nik"
                                                            value="<?= (isset($datasubmit["nik"]) ? $datasubmit["nik"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan"
                                                            class="form-label">Pendidikan
                                                            Terakhir</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="pendidikan"
                                                            value="<?= (isset($datasubmit["didikakhir"]) ? $datasubmit["didikakhir"] : '') ?>"
                                                            required readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan" class="form-label">Jenis
                                                            RPL</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="jenisrpl"
                                                            value="<?= (isset($datasubmit["jenis_rpl"]) ? $datasubmit["jenis_rpl"] : '') ?>"
                                                            required readonly />

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan" class="form-label">Program
                                                            Studi Pilihan</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="kode_prodi"
                                                            value="<?= (isset($datasubmit["kode_prodi"]) ? $datasubmit["kode_prodi"] : '') ?>"
                                                            required readonly />

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan"
                                                            class="form-label">Konsentrasi</label>
                                                        <input type="text" class="form-control"
                                                            id="formrow-inputInstansi" name="konsentrasi"
                                                            value="<?= (isset($datasubmit["konsentrasi"]) ? $datasubmit["didikakhir"] : '') ?>"
                                                            required readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="card-title mb-4 text-center">TRANSKRIP NILAI REKOGNISI
                                                </h4>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <table
                                                                class='table table-bordered table-responsive table-sm border-dark'
                                                                style="font-size: 10px;">
                                                                <thead class="">
                                                                    <tr>
                                                                        <th width='5%'>No</th>
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
                                                                        foreach ($dataKlaimAsessor as $row) {
                                                                            $i++;
                                                                            echo "<tr>
                                                            <td>$i</td>        
                                                            <td>$row->nama_matakuliah</td>        
                                                            <td class='text-center'>$row->sks</td>        
                                                            <td class='text-center'>$row->nilai</td>          
                                                        </tr>";
                                                                            $jumlahsks = floatval($jumlahsks) + floatval($row->sks);

                                                                            if ($i == $countdata) {
                                                                                echo "<tr>
                                                                        <td colspan='2' class='text-center'> Jumlah</td>        
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
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </div>
                                    </form>
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
    <!-- <script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script> -->


    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script>

    </script>
</body>

</html>