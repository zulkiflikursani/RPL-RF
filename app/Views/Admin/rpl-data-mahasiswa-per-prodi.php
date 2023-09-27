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
                        // if ($row->didikakhir == 1) {
                        //     $pendidikanakhir = 'SD';
                        // } else if ($row->didikakhir == 2) {
                        //     $pendidikanakhir = 'SLPT';
                        // } else if ($row->didikakhir == 3) {
                        //     $pendidikanakhir = 'SLTA';
                        // } else if ($row->didikakhir == 4) {
                        //     $pendidikanakhir = 'D3';
                        // } else if ($row->didikakhir == 5) {
                        //     $pendidikanakhir = 'S1';
                        // }

                        if ($row->id_jenjang == 'S1-R') {
                            $jenjang = 'Sarjana (S1)';
                        } else if ($row->id_jenjang == 'S2-R') {
                            $jenjang = 'Magister (S2)';
                        }
                        $nama_mhs = $row->nama;
                        $nama_prodi = $row->nama_prodi;
                        $ta_akademik = $row->ta_akademik;
                        $noregis = $row->no_peserta;
                        $instansi_asal = $row->instansi_asal;
                        // $didikakhir = $pendidikanakhir;
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
                                <h4 class="card-title mb-4 text-center">DAFTAR PESERTA REKOGNISI PRODI
                                    <?= (isset($nama_prodi) ? strtoupper($nama_prodi) : '') ?>
                                </h4>
                                <div>
                                    <div class="row">
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()"
                                                    class="btn btn-success waves-effect waves-light me-1"><i
                                                        class="fa fa-print"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                            date_default_timezone_set('Asia/Makassar');
                                            $now = date('Y-m-d');
                                            ?>

                                            <table class="col-md-12 mb-2" style="font-size: 12px;">
                                                <tr>
                                                    <td style='width:2% ; vertical-align: top ;'>Nomor</td>
                                                    <td style='width:1%; ;'>:</td>
                                                    <td style='width:23%; '> </td>

                                                </tr>
                                                <tr>
                                                    <td style='width:2% ; vertical-align: top ;'>Tanggal</td>
                                                    <td>: </td>
                                                    <td><?= tgl_indo($now) ?></td>


                                                </tr>
                                                <tr>
                                                    <td style='width:2% ; vertical-align: top ;'>Tentang</td>
                                                    <td style="vertical-align: top ">:</td>
                                                    <td>Pengakuan Kelulusan Matakuliah pada Proses Asesment Program
                                                        Rekognisi Pembelajaran Lampau (RPL) Program Studi
                                                        <?= (isset($nama_prodi) ? strtoupper($nama_prodi) : '') ?> Tahun
                                                        Akademik <?= (isset($ta_akademik) ? $ta_akademik : '') ?></td>
                                                </tr>


                                            </table>
                                            <span class="text-primary">Note : Klik Nama atau Nomor Peserta untuk
                                                meilihat
                                                Berita
                                                Acara</span>
                                            <table class='table table-bordered table-responsive table-sm border-dark'>
                                                <thead class="">
                                                    <tr>
                                                        <th width='5%'>No</th>
                                                        <th>Nama</th>
                                                        <th>No Peserta</th>
                                                        <th>Kode Matakuliah</th>
                                                        <th>Nama Matakuliah</th>
                                                        <th width='7%'>Nilai</th>
                                                        <th width='7%'>SKS</th>
                                                        <th width='7%'>Status Rekognisi</th>
                                                    </tr>

                                                </thead>
                                                <tbody id='tbody-klaim-mk'>
                                                    <?php
                                                    if (isset($dataKlaimAsessor)) {
                                                        $i = 0;
                                                        $ii = 0;
                                                        $iii = 0;
                                                        $countdata = count($dataKlaimAsessor);
                                                        $jumlahsks = 0;
                                                        $noregis2 = "";
                                                        foreach ($dataKlaimAsessor as $row) {
                                                            $i++;

                                                            if ($row->jenis_rpl == 1) {
                                                                $statusrpl = "Konversi";
                                                            } else if ($row->jenis_rpl == 2) {
                                                                $statusrpl = "Rekognisi";
                                                            } else if ($row->jenis_rpl == 3) {
                                                                $statusrpl = "Rekognisi";
                                                            }
                                                            if ($row->no_peserta != $noregis2) {
                                                                $ii++;
                                                                $iii = 1;

                                                                if ($row->jenis_rpl == 1) {
                                                                    $urlberitaacara = base_url('bamahasiswaa1/' . $row->no_peserta);
                                                                } else {
                                                                    $urlberitaacara = base_url('bamahasiswa/' . $row->no_peserta);
                                                                }


                                                                echo "<tr>
                                                                <td rowspan='$row->jbaris'>$ii</td>        
                                                                <td rowspan='$row->jbaris'><a href='$urlberitaacara' target='_blank'>$row->nama</a></td>        
                                                                <td rowspan='$row->jbaris'><a href='$urlberitaacara' target='_blank'>$row->no_peserta</a> </td>        
                                                                <td>$row->kode_matakuliah</td>        
                                                                <td>$row->nama_matakuliah</td>        
                                                                <td class='text-center'>$row->nilai</td>          
                                                                <td class='text-center'>$row->sks</td>          
                                                                <td class='text-center'>$statusrpl</td>          
                                                                </tr>";
                                                                $noregis2 = $row->no_peserta;
                                                                $jumlahsks = 0;
                                                                $jumlahsks = $jumlahsks + floatval($row->sks);
                                                            } else {
                                                                $iii++;

                                                                // $ii++;
                                                                echo "<tr>      
                                                                <td>$row->kode_matakuliah</td>        
                                                                <td>$row->nama_matakuliah</td>        
                                                                <td class='text-center'>$row->nilai</td>  
                                                                <td class='text-center'>$row->sks</td>          
                                                                <td class='text-center'>$statusrpl</td>          
                                                                </tr>";
                                                                $jumlahsks = $jumlahsks + floatval($row->sks);
                                                                if ($iii == $row->jbaris) {
                                                                    echo "<tr>
                                                                    <td colspan='6' class='text-center'>Jumlah SKS</td>
                                                                    <td class='text-center'>$jumlahsks</td>
                                                                    </tr>";
                                                                }
                                                            }
                                                        }
                                                    }


                                                    ?>

                                                </tbody>

                                            </table>
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
                                                        <p class='text-center'>Dekan </p>
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
                                                        <?php
                                                        for ($x = 0; $x <= $i / 5; $x++) {
                                                            echo " <p class='text-center'>
                                                            <br>
                                                        </p>";
                                                        }
                                                        ?>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- end row -->






                    <!-- </div> container-fluid -->

                    <!-- End Page-content -->



                    <?php
                    //  echo $this->include('partials/rpl-footer')
                    ?>
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