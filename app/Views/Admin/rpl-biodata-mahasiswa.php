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

    .select2-container {
        z-index: 100000;
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
                    if (isset($uploaderror)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo $uploaderror;
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                    }

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

                    if (isset($statusupload)) {
                        if ($statusupload == 'sukses') {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Mengupload file.<button type="button" class="btn-close" data-bs-dismiss="alert"
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
                            window.location.href='" . base_url('resetpassmhs') . "'
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
                            <div class="modal fade modal-edit-prop-kot-kab" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Update Alamat
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="mb-3  col-md-12 ">
                                                    <label for="formrow-inputProvinsi"
                                                        class="form-label col-md-12 ">Provinsi</label>
                                                    <select name="provinsi" id="m-propinsi" style="width: 80%;"
                                                        class="form-select select2 " onchange="getkab()" required>
                                                        <option val="">Pilih Provinsi</option>
                                                        <?php
                                                        if (isset($dataprov)) {
                                                            foreach ($dataprov as $a) {
                                                                if (isset($datasubmit["propinsi"])) {
                                                                    if ($datasubmit["propinsi"] == $a->NMPROTBPRO) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    };
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo "<option kdprov='$a->KDPROTBPRO' $selected>$a->NMPROTBPRO</option>";
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label for="formrow-inputKab" class="form-label col-md-12">Kota
                                                        Kabupaten</label>
                                                    <select name="kab" id="m-kab" style="width: 80%;"
                                                        class="col-8 form-select select2" required></select>
                                                </div>

                                            </div>

                                        </div><!-- /.modal-content -->
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" onclick="setProvKab()">OK</button>
                                            <button class="btn btn-warning" data-bs-dismiss="modal"
                                                aria-label="Close">BATAL</button>

                                        </div>
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </div>
                            <div class="modal fade modal-edit-bukti-bayar" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Upload Bukti
                                                Pembayaran
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form method="post" action="/updatebuktibayar"
                                                enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <label class="form-check-label" for="formRadios1">
                                                        Upload Bukti Pembayaran
                                                    </label>
                                                    <input type="hidden" name='noregis' value='<?= $noregis ?>'>
                                                    <div class="input-group mt-3" id='input-buktibayar'>
                                                        <input type="file" class="form-control" name='buktiBayar'
                                                            id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                            accept="application/pdf" aria-label="buktiBayar" required>
                                                    </div>
                                                    <span class="text-danger">Note: File PDF dengan ukuran
                                                        maksimal 1
                                                        Mb</span>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </form>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <div class="modal fade modal-edit-ijazah" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Upload Ijazah
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form method="post" action="/updateijazah" enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <label class="form-check-label" for="formRadios1">
                                                        Upload Ijazah
                                                    </label>
                                                    <input type="hidden" name='noregis' value='<?= $noregis ?>'>
                                                    <div class="input-group mt-3" id='input-buktibayar'>
                                                        <input type="file" class="form-control" name='ijazah'
                                                            id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                            accept="application/pdf" aria-label="ijazah" required>
                                                    </div>
                                                    <span class="text-danger">Note: File PDF dengan ukuran
                                                        maksimal 1
                                                        Mb</span>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </form>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <div class="modal fade modal-edit-identitas" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Upload Identitas
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form method="post" action="/updateidentitas" enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <label class="form-check-label" for="formRadios1">
                                                        Upload Identitas
                                                    </label>
                                                    <input type="hidden" name='noregis' value='<?= $noregis ?>'>
                                                    <div class="input-group mt-3" id='input-buktibayar'>
                                                        <input type="file" class="form-control" name='identitas'
                                                            id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                            accept="application/pdf" aria-label="identitas" required>
                                                    </div>
                                                    <span class="text-danger">Note: File PDF dengan ukuran
                                                        maksimal 1
                                                        Mb</span>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </form>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Biodata Mahasiswa</h4>

                                    <form method="POST" action="<?= base_url("Admin/setBiodata") ?>">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formrow-nama-input" class="form-label">No
                                                        Registrasi</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input"
                                                        name="no_peserta" placeholder="Masukkan Nama"
                                                        value="<?= (isset($datasubmit["no_peserta"]) ? $datasubmit["no_peserta"] : '') ?>"
                                                        required readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="formrow-nama-input" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input"
                                                        name="nama" placeholder="Masukkan Nama"
                                                        value="<?= (isset($datasubmit["nama"]) ? $datasubmit["nama"] : '') ?>"
                                                        required>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="formrow-email-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-email-input"
                                                        name="email" placeholder="Masukkan Email ID"
                                                        value="<?= (isset($datasubmit["email"]) ? $datasubmit["email"] : '') ?>"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="formrow-inputAlamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="alamat" placeholder="Masukkan Alamat"
                                                        value="<?= (isset($datasubmit["alamat"]) ? $datasubmit["alamat"] : '') ?>"
                                                        required>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-7 row">
                                                <div class="col-md-7">

                                                    <div class="mb-3">
                                                        <label for="formrow-inputProvinsi"
                                                            class="form-label">Provinsi</label>
                                                        <input type="text" class="form-control" id="prop"
                                                            name="provinsi" placeholder="Masukkan Provinsi"
                                                            value="<?= (isset($datasubmit["propinsi"]) ? $datasubmit["propinsi"] : '') ?>"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center py-4 mt-1">
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target=".modal-edit-prop-kot-kab"
                                                        class="  btn btn-sm btn-primary w-auto">Edit Wilayah</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Kota
                                                        Kabupaten</label>
                                                    <input type="text" class="form-control" id="kotkab" name="kab"
                                                        placeholder="Masukkan Provinsi"
                                                        value="<?= (isset($datasubmit["kotkab"]) ? $datasubmit["kotkab"] : '') ?>"
                                                        required readonly>
                                                    <!-- <select name="kab" id="kab" class="form-select select2" required></select> -->
                                                </div>


                                            </div>
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <label for="formrow-inputKab" class="form-label">Tempat
                                                        Lahir</label>
                                                    <input type="text" class="form-control" id="formrow-inputAlamat"
                                                        name="tlahir" placeholder="Masukkan Tempat Lahir"
                                                        value="<?= (isset($datasubmit["t_lahir"]) ? $datasubmit["t_lahir"] : '') ?>"
                                                        required>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputInstansi" class="form-label">Tanggal
                                                        Lahir</label>
                                                    <input type="date" class="form-control" id="formrow-inputInstansi"
                                                        name="ttl" placeholder="Masukkan Tanggal lahir"
                                                        value="<?= (isset($datasubmit["ttl"]) ? $datasubmit["ttl"] : '') ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputInstansi" class="form-label">Nama
                                                        Ibu
                                                        Kandung</label>
                                                    <input type="text" class="form-control" id="formrow-inputInstansi"
                                                        name="ibukandung" placeholder="Masukkan Nama Ibu Kandung"
                                                        value="<?= (isset($datasubmit["ibu_kandung"]) ? $datasubmit["ibu_kandung"] : '') ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="formrow-inputProvinsi" class="form-label">No Hp
                                                        (WA)</label>
                                                    <input type="text" class="form-control" id="formrow-inputProvinsi"
                                                        name="nohp" placeholder="Masukkan No. HP"
                                                        value="<?= (isset($datasubmit["nohape"]) ? $datasubmit["nohape"] : '') ?>"
                                                        required>
                                                </div>
                                                <div class="row">
                                                    <div class="">
                                                        <div class="mb-3">
                                                            <label for="formrow-inputInstansi"
                                                                class="form-label">Instansi
                                                                Asal</label>
                                                            <input type="text" class="form-control"
                                                                id="formrow-inputInstansi" name="instansi"
                                                                placeholder="Masukkan Instansi Asal"
                                                                value="<?= (isset($datasubmit["instansi_asal"]) ? $datasubmit["instansi_asal"] : '') ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="">
                                                        <div class="mb-3">
                                                            <label for="formrow-inputInstansi" class="form-label">Nomor
                                                                Induk Kependudukan (NIK)</label>
                                                            <input type="text" class="form-control"
                                                                id="formrow-inputInstansi" name="nik"
                                                                placeholder="Masukkan Nomor Induk Keluarga (NIK)"
                                                                value="<?= (isset($datasubmit["nik"]) ? $datasubmit["nik"] : '') ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputPendidikan"
                                                            class="form-label">Pendidikan
                                                            Terakhir</label>
                                                        <select class="form-select" id="autoSizingSelect"
                                                            name='pendidikan'>
                                                            <option selected>Pilih...</option>
                                                            <option value="1"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "1" ? 'selected="selected"' : '') ?>>
                                                                SD</option>
                                                            <option value="2"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "2" ? 'selected="selected"' : '') ?>>
                                                                SLTP</option>
                                                            <option value="3"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "3" ? 'selected="selected"' : '') ?>>
                                                                SLTA</option>
                                                            <option value="4"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "4" ? 'selected="selected"' : '') ?>>
                                                                D3</option>
                                                            <option value="5"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "5" ? 'selected="selected"' : '') ?>>
                                                                S1</option>
                                                            <option value="6"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "6" ? 'selected="selected"' : '') ?>>
                                                                D1</option>
                                                            <option value="7"
                                                                <?= (isset($datasubmit["didikakhir"]) && $datasubmit["didikakhir"] == "7" ? 'selected="selected"' : '') ?>>
                                                                D2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Jenis
                                                        RPL</label>
                                                    <select class="form-select" id="jenis_rpl" name='jenis_rpl'
                                                        onchange="findprodi($(this))">
                                                        <option value=''>
                                                            Pilih...</option>
                                                        <option value="1"
                                                            <?= (isset($datasubmit["jenis_rpl"]) && $datasubmit["jenis_rpl"] == "1" ? 'selected="selected"' : '') ?>>
                                                            A1</option>
                                                        <option value="2"
                                                            <?= (isset($datasubmit["jenis_rpl"]) && $datasubmit["jenis_rpl"] == "2" ? 'selected="selected"' : '') ?>>
                                                            A2</option>
                                                        <option value="3"
                                                            <?= (isset($datasubmit["jenis_rpl"]) && $datasubmit["jenis_rpl"] == "3" ? 'selected="selected"' : '') ?>>
                                                            A3</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan" class="form-label">Program
                                                        Studi Pilihan</label>
                                                    <select class="form-select" id="kode_prodi" name='prodi'
                                                        onchange="findkonsentrasi()">
                                                        <option value=''
                                                            <?= (isset($datasubmit["kode_prodi"]) && $datasubmit["kode_prodi"] == "" ? 'selected="selected"' : '') ?>>
                                                            Pilih...</option>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formrow-inputPendidikan"
                                                        class="form-label">Konsentrasi</label>
                                                    <select class="form-select" id="konsentrasi" name='konsentrasi'
                                                        required>


                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <label for="formrow-inputPendidikan" class="form-label">KTP atau
                                                Kartu
                                                Keluarga</label>
                                            <div class="col-md-4">
                                                <a class="button btn btn-primary btn-sm col-md-6" target="_blank"
                                                    href='<?= base_url() . "/uploads/berkas/$noregis/ii$noregis.pdf" ?>'>
                                                    Lihat Identitas</a>
                                                <a class="button btn btn-sm btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target=".modal-edit-identitas">Ubah File</a>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <label for="formrow-inputPendidikan col-md-6"
                                                class="form-label">Ijazah</label>
                                            <div class="col-md-4">
                                                <a target="_blank"
                                                    href='<?= base_url() . "/uploads/berkas/$noregis/i$noregis.pdf" ?>'
                                                    class="button btn btn-primary btn-sm col-md-6"> Lihat
                                                    Ijazah</a>
                                                <a class="button btn btn-sm btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target=".modal-edit-ijazah">Ubah File</a>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <label for="formrow-inputPendidikan" class="form-label">Bukti
                                                Pembayaran</label>
                                            <div class="col-md-4">

                                                <a target="_blank"
                                                    href='<?= base_url() . "/uploads/berkas/$noregis/bb$noregis.pdf" ?>'
                                                    class="button btn btn-primary btn-sm col-md-6"> Lihat Bukti
                                                    Pembayaran</a>
                                                <a class="button btn btn-sm btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target=".modal-edit-bukti-bayar">Ubah File</a>
                                            </div>
                                        </div>

                                        <!-- <div class="row mb-3">
                                            <label class="form-check-label" for="formRadios1">
                                                Upload KTP atau Kartu Keluarga
                                            </label>
                                            <div class="input-group mt-3" id='input-buktibayar'>
                                                <input type="file" class="form-control" name='identitas'
                                                    id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                    accept="application/pdf" aria-label="buktiBayar" required>
                                            </div>
                                            <span class="text-danger">Note: File PDF dengan ukuran maksimal 1
                                                Mb</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-check-label" for="formRadios1">
                                                Upload Ijazah
                                            </label>
                                            <div class="input-group mt-3" id='input-ijazah'>
                                                <input type="file" class="form-control" name='ijazah'
                                                    id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                    accept="application/pdf" aria-label="ijazah" required>
                                            </div>
                                            <span class="text-danger">Note: File PDF dengan ukuran maksimal 1
                                                Mb</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-check-label" for="formRadios1">
                                                Upload Bukti Pembayaran
                                            </label>
                                            <div class="input-group mt-3" id='input-buktibayar'>
                                                <input type="file" class="form-control" name='buktiBayar'
                                                    id="inputGroupFile" aria-describedby="inputGroupFileAddon"
                                                    accept="application/pdf" aria-label="buktiBayar" required>
                                            </div>
                                            <span class="text-danger">Note: File PDF dengan ukuran maksimal 1
                                                Mb</span>
                                        </div> -->


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
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('document').ready(function() {
        $('.select2').select2({
            placeholder: 'Select an option',
            dropdownParent: $('.modal-edit-prop-kot-kab')
        });

        <?php
            if (isset($status_update)) {
                if ($status_update == 1) {
            ?>
        alert("DATA BERHASIL DI UPDATE");
        <?php
                } else {
                ?>
        alert("DATA GAGAL DI UPDATE");

        <?php
                }
            }
            ?>

        getkab();
        ini = $('#jenis_rpl').val();
        findprodi1(ini)
        findkonsentrasi();
    })

    function setProvKab() {
        prov = $('#m-propinsi').val();
        kab = $('#m-kab').val()
        $('#prop').val(prov)
        $('#kotkab').val(kab)
        $('.modal-edit-prop-kot-kab').modal('hide')
    }

    function findkonsentrasi() {
        prodi = $('#kode_prodi').val();
        if (prodi == "") {
            prodi = '<?= (isset($datasubmit["kode_prodi"]) ? $datasubmit['kode_prodi'] : '') ?>';
        }
        url = '<?= base_url("konsentrasi-by-prodi") ?>'

        $.post(url, {
            prodi: prodi
        }, function(data) {
            data = JSON.parse(data)
            $('#konsentrasi').children().remove();
            if (data.length == 0) {

                $('#konsentrasi').prop('required', false)
                $('#konsentrasi').prop('readonly', true)
                $('#konsentrasi').append("<option value=''> Tidak ada pilihan konsentrasi</option>")
            } else {
                $('#konsentrasi').prop('required', true)
                $('#konsentrasi').append("<option value=''> Pilih Konsentrasi.....</option>")

            }

            $.each(data, function(i, row) {
                if ('<?= (isset($datasubmit["kode_konsentrasi"]) ? $datasubmit['kode_konsentrasi'] : '') ?>' ==
                    row['kode_konsentrasi']) {
                    select = "selected";
                } else {
                    select = '';
                }
                $("#konsentrasi").append("<option value='" + row['kode_konsentrasi'] + "'" +
                    select +
                    ">" + row[
                        'konsentrasi'] + "</option>")

            })

        })

    }

    function findprodi1(ini) {

        url = '<?= base_url('getProdiByRpl') ?>'

        jenisrpl = ini
        if (jenisrpl != "") {
            $.post(url, {
                jenis_rpl: jenisrpl
            }, function(data) {
                data = JSON.parse(data)
                $('#kode_prodi').children().remove()
                $('#kode_prodi').append("<option value=''> Pilih Prodi.....</option>")
                $.each(data, function(i, row) {

                    if ('<?= (isset($datasubmit["kode_prodi"]) ? $datasubmit['kode_prodi'] : '') ?>' ==
                        row['kode_prodi']) {
                        select = 'selected';
                    } else {
                        select = ''
                    }
                    $('#kode_prodi').append("<option value='" + row['kode_prodi'] + "' " + select +
                        " >" + row[
                            'nama_prodi'] + "</option>")

                })
            })
        } else {
            $('#kode_prodi').children().remove()
            $('#kode_prodi').append("<option val=''> Pilih Prodi</option>")


        }
    }

    function findprodi(ini) {
        url = '<?= base_url('getProdiByRpl') ?>'
        jenisrpl = ini.val()
        if (jenisrpl != "") {
            $.post(url, {
                jenis_rpl: jenisrpl
            }, function(data) {

                data = JSON.parse(data)

                $('#kode_prodi').children().remove()
                $('#kode_prodi').append("<option value=''> Pilih Prodi.....</option>")


                $.each(data, function(i, row) {
                    $('#kode_prodi').append("<option value='" + row['kode_prodi'] + "'>" + row[
                        'nama_prodi'] + "</option>")

                })

            })
        } else {
            $('#kode_prodi').children().remove()
            $('#kode_prodi').append("<option val=''> Pilih Prodi</option>")


        }
    }

    function getkab() {
        $('#loading').show();
        $('#m-kab').children().remove();
        url = '<?= base_url('getKab') ?>'
        a = $('#m-propinsi option:selected').attr('kdprov');
        $.post(url, {
            "a": a
        }).done(function(data) {
            data = JSON.parse(data)
            // console.log(data);
            setkab(data)
            // $('#loading').hide();


        })
        $('#loading').hide();
    }

    function updatebuktibayar() {


    }

    function setkab(data) {
        var kotkab = '<?= (isset($datasubmit["kotkab"]) ? $datasubmit["kotkab"] : '') ?>'
        $.each(data, async function(index, row) {
            await $('#m-kab').append("<option value='" + row['nama_wilayah'] + "' >" + row[
                    'nama_wilayah'] +
                "</option>")
        })
        $('#m-kab').val(kotkab).trigger('change')
        // alert(kotkab)
        $('#loading').hide();

    }
    </script>
</body>

</html>