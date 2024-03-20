<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        // echo $this->include("partials/rpl-horizontal-afterregis-pengguna") 
        ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <!-- <div class="page-content"> -->
            <div class="container-fluid">

                <?php
                // echo $page_title 
                if (isset($dataKlaimAsessor[0])) {
                    foreach ($dataKlaimAsessor as $row) {
                        if ($row->didikakhir == 1) {
                            $pendidikanakhir = 'SD';
                        } else if ($row->didikakhir == 2) {
                            $pendidikanakhir = 'SLPT';
                        } else if ($row->didikakhir == 3) {
                            $pendidikanakhir = 'SLTA';
                        } else if ($row->didikakhir == 4) {
                            $pendidikanakhir = 'D3';
                        } else if ($row->didikakhir == 5) {
                            $pendidikanakhir = 'S1';
                        }

                        if ($row->id_jenjang == 'S1-R') {
                            $jenjang = 'Sarjana (S1)';
                        } else if ($row->id_jenjang == 'S2-R') {
                            $jenjang = 'Magister (S2)';
                        }
                        $nama_mhs = $nama_mhs;
                        $noregis = $row->no_peserta;
                        $instansi_asal = $row->instansi_asal;
                        $didikakhir = $pendidikanakhir;
                        $jenis_rpl = $row->jenis_rpl;
                        $prodi = $row->nama_prodi;
                        $fakultas = $row->nama_fakultas;
                        $progpendidikan = $jenjang;
                    };
                }

                ?>

                <div class="row">
                    <div class="col-xl-12">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">BERITA ACARA REKOGNISI PEMBELAJARAN LAMPAU</h4>

                                <div method="POST" action="">
                                    <div class="mb-3">
                                        <label for="formrow-nama-input" class="form-label">Program Studi
                                            <?= (isset($nm_prodi) ? $nm_prodi : '') ?>
                                        </label>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div>

                                            </div>
                                            <div class="mb-3">
                                                <?php
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-2">Nama</div>
                                                    <div class="col-md-2">: <?= $nama_mhs; ?></div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-2">Program Studi</div>
                                                    <div class="col-md-2">: <?= $nm_prodi; ?></div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-2">Konsentrasi</div>
                                                    <div class="col-md-2">: <?= $konsentrasi; ?></div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-2">Jenis RPL</div>
                                                    <div class="col-md-2">: <?= "A" . $jenis_rpl; ?></div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-2">Asessor</div>
                                                    <div class="col-md-2">: <?= $nm_asessor; ?></div>
                                                </div>


                                                <table class='table table-bordered'>
                                                    <thead class="table-light">
                                                        <tr class="bg-light">
                                                            <th>No</th>
                                                            <th>Kode Matakuliah Unifa</th>
                                                            <th>Nama Matakuliah Unifa</th>
                                                            <th>Jumlah SKS</th>
                                                            <th>Nilai</th>
                                                            <th>Nama Matakuliah Asal</th>
                                                            <th>Jumlah SKS</th>
                                                            <th>Nilai</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody id='tbody-klaim-mk'>
                                                        <?php

                                                        if (isset($dataKlaimAsessorA1)) {
                                                            $kdmk = "";
                                                            $no = 0;
                                                            $totsksvalid = 0;
                                                            $totsksawal = 0;
                                                            foreach ($dataKlaimAsessorA1 as $row) {
                                                                if ($kdmk != $row->kode_matakuliah) {
                                                                    $no++;
                                                                    $totsksvalid = $totsksvalid + floatval($row->sks);
                                                                    $totsksawal = $totsksawal + floatval($row->jumlah_sks);
                                                                    echo "<tr noregis='$row->no_peserta' idklaim='$row->idklaim'
                                                                        kdmk='$row->kode_matakuliah'
                                                                        kdprodi='$row->kode_prodi'
                                                                        nmmk='$row->nama_matakuliah'
                                                                        sks='$row->sks'
                                                                        nilai='$row->nilai'><td rowspan='$row->entry_count'>$no</td><td rowspan='$row->entry_count'>$row->kode_matakuliah</td>
                                                                        <td rowspan='$row->entry_count'>$row->nama_matakuliah</td>
                                                                        <td rowspan='$row->entry_count'>$row->sks</td><td rowspan='$row->entry_count'>$row->nilai</td><td>$row->nama_matakuliah_asal</td><td>$row->jumlah_sks</td><td>$row->nilai_asal</td></tr>";
                                                                    $kdmk = $row->kode_matakuliah;
                                                                } else {

                                                                    echo "<tr noregis='$row->no_peserta' idklaim='$row->idklaim'
                                                                        kdmk='$row->kode_matakuliah'
                                                                        nmmk='$row->nama_matakuliah'
                                                                        sks='$row->sks'
                                                                        kdprodi='$row->kode_prodi'
                                                                        nilai='$row->nilai'>
                                                                        <td>$row->nama_matakuliah_asal</td><td>$row->jumlah_sks</td><td>$row->nilai_asal</td>
                                                                        </tr>";
                                                                }
                                                            }
                                                        }
                                                        echo "<tr><td colspan='3'>Jumlah SKS tervalidasi</td><td>$totsksvalid</td><td colspan='2'>Jumlah SKS Matakuliah asal</td><td>$totsksawal</td></tr>"

                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="row">
                                                    <div class="col-6">
                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                        date_default_timezone_set('Asia/Makassar');

                                                        $now = date('Y-m-d');
                                                        ?>
                                                        <p class='text-center'>Makassar, <?= tgl_indo($now) ?> </p>
                                                        <p class='text-center'>Ketua Program Studi </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>

                                                        <p class='text-center'>
                                                            <?= $dekan ?>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>
                                                        <p class='text-center'>
                                                            <br>
                                                        </p>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                </div>
                                <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- end main content-->

            </div>
            <!-- END layout-wrapper -->
        </div>


        <?= $this->include('partials/vendor-scripts') ?>

        <!-- apexcharts -->
        <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- dashboard init -->
        <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

        <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>

<script>
    function validprodi() {
        $('#validasi-form').submit()
    }

    function unvalidprodi() {
        $('#unvalidasi-form').submit()

    }
</script>
<?php
function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}
// print_r(search($arr, 'name', 'cat 1'));
function inputnilai($idcpmk, $nilai)
{
    if ($nilai != "") {
        if ($nilai == "B") {
            return "<td for='nilai'>
            <select class='form-select'>
            <option value='' >Pilih</option>    
            <option selected >B</option>    
            <option >C</option>    
            <option >K</option>    
            </select></td>";
        } else if ($nilai == "C") {
            return "<td for='nilai'>
            <select class='form-select'>
            <option value='' >Pilih</option>    
            <option >B</option>    
            <option selected >C</option>    
            <option >K</option>    
            </select></td>";
        } else if ($nilai == "K") {
            return "<td for='nilai'>
            <select class='form-select'>
            <option value='' >Pilih</option>    
            <option >B</option>    
            <option >C</option>    
            <option selected >K</option>    
            </select></td>";
        } else {
            return "<td for='nilai'>
            <select class='form-select'>
            <option value='' selected>Pilih</option>    
            <option >B</option>    
            <option >C</option>    
            <option >K</option>    
            </select></td>";
        }
    } else {
        return "<td for='nilai'>
            <select class='form-select'>
            <option value='' selected>Pilih</option>    
            <option >B</option>    
            <option >C</option>    
            <option >K</option>    
            </select></td>";
    }
}

function getRefmhs($datadok, $refMhs)
{
    if (!empty($refMhs)) {
        // echo "</br>";
        // print_r($refMhs);
        if (isset($datadok)) {
            $pilihdokumen = "";
            foreach ($datadok as $dok) {
                foreach ($refMhs as $row) {
                    $ref = $row['no_dokumen'];
                    if ($dok['no_dokumen'] == $ref) {
                        $selected = "selected";
                        break;
                    } else {
                        $selected = "";
                    }
                }
                $pilihdokumen .= "<option value ='" . $dok['no_dokumen'] . "' $selected>" . $dok['nmfile'] . "</option>";
            }
            $selectboxdok = "<select class='form-select' for='ref' multiple>" . $pilihdokumen . "</select>";
        }
    } else {
        if (isset($datadok)) {
            $pilihdokumen = "";
            foreach ($datadok as $dok) {

                $pilihdokumen .= "<option value ='" . $dok['no_dokumen'] . "' >" . $dok['nmfile'] . "</option>";
            }
            $selectboxdok = "<select class='form-select' for='ref' multiple>" . $pilihdokumen . "</select>";
        }
    }

    return $selectboxdok;
    // $ref = 

}

?>