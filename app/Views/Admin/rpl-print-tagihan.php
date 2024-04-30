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
                        } else {
                            $pendidikanakhir = '';
                        }

                        if ($row->id_jenjang == 'S1-R') {
                            $jenjang = 'Sarjana (S1)';
                            $sksmaxrekognisiok = $sksmaxrekognisi;
                            $ket = "<div class='row mb-1' style='font-size: 10px;'>
                            <p class='mb-0'>KETERANGAN</p>
                            <p class='mb-0'>- Semester III s/d VIII hanya membayar BPP dengan tarif normal</p>
                            <p class='mb-0'>- Semester IX dan seterusnya hanya membayar BPP 50% dari tarif normal jika yang diprogmkan Tugas Akhir dan maximum 2 mata kuliah akhir</p>
                            <p class='mb-0'>- Semester IX dan seterusnya  membayar BPP dengan tarif normal jika yang diprogramkan tugas akhir dan lebih 2 matakuliah</p>
                            <p>⁠⁠Kirim bukti pembayaran ke Biro Keuangan (cp: 0853-3333-4681)</p>

                            </div>
                            ";
                        } else if ($row->id_jenjang == 'S2-R') {
                            $jenjang = 'Magister (S2)';
                            $sksmaxrekognisiok = $sksmaxrekognisi;
                            $ket = "<div class='row mb-2'  style='font-size: 10px;'>
                            <p class='mb-0'>KETERANGAN</p>
                            <p class='mb-0'>- Semester II s/d IV membayar BPP dengan tarif normal</p>
                            <p class='mb-0'>- Semester V dan seterusnya hanya membayar BPP 50% dari tarif normal jika yang diprogmkan Tugas Akhid dan maximum 2 mata kuliah akhir</p>
                            <p class='mb-0'>- Semester V dan seterusnya  membayar BPP dengan tarif normal jika yang diprogramkan tugas akhir dan lebih 2 matakuliah</p>
                            <p class='mb-0'>- Alumni sarjana UNIFA yang melanjukan pendidikan pada pascasarjana UNIFA diberi potongan pembayaran BPP sebesar 25%</p>
                            <p>- ⁠⁠Kirim bukti pembayaran ke Biro Keuangan (cp: 0853-3333-4681)</p>



                            </div>";
                        }
                        $nama_mhs = $nama_mhs;
                        $noregis = $row->no_peserta;
                        $instansi_asal = $row->instansi_asal;
                        $didikakhir = $pendidikanakhir;
                        $jenis_rpl = $row->jenis_rpl;
                        $prodi = $row->nama_prodi;
                        $fakultas = $row->nama_fakultas;
                        $progpendidikan = $jenjang;
                        $jenjang_singkat = $row->id_jenjang;
                    };
                }

                ?>

                <div class="row">
                    <div class="col-xl-12">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4 text-center">TRANSKRIP NILAI REKOGNISI
                                </h4>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="col-md-12 " style="font-size: 10px;">
                                                <tr>
                                                    <td style='width:17%; ;'>Nama Calan Mahasiswa</td>
                                                    <td style='width:23%; '>: <?= $nama_mhs; ?></td>
                                                    <td style='width:15%; '>Fakultas</td>
                                                    <td style='width:25%; '>: <?= $fakultas; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Peserta</td>
                                                    <td>: <?= $noregis; ?></td>
                                                    <td>Program Studi</td>
                                                    <td>: <?= $nm_prodi; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Instansi Asal</td>
                                                    <td>: <?= $instansi_asal ?></td>
                                                    <td>Program Pendidikan</td>
                                                    <td>: <?= $progpendidikan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis RPL</td>
                                                    <td>: <?= "A" . $jenis_rpl; ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>


                                            </table>
                                            <table class='table table-bordered table-responsive table-sm border-dark'
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
                                            <?php
                                            if ($dodi == 0) {
                                                if ($jumlahsks > $sksmaxrekognisiok) {
                                                    echo "<a class='text-danger fw-bold'>Jumlah sks maksimal yang dapat diakui dalam proses rekognisi adalah $sksmaxrekognisiok SKS.</a>";

                                                    $jumlahsks = $sksmaxrekognisiok;
                                                }
                                            }
                                            ?>
                                            <div class='col-12' style="font-size: 10px;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        Total SKS yang wajib dilulus untuk program studi yang terpilih
                                                    </div>
                                                    <div class="col-6">
                                                        : <?= $maxsks ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        Total SKS yang dilulusi melalui program rekognisi:

                                                    </div>
                                                    <div class="col-6">
                                                        : <?= $jumlahsks ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        Sisa SKS yang harus ditempuh:

                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                        $sisasks = floatval($maxsks) - floatval($jumlahsks);
                                                        ?>
                                                        : <?= $sisasks ?>
                                                    </div>
                                                </div>
                                                <div class="row" class='fa-bold'>
                                                    <div class="col-4">
                                                        <!-- <p class='mb-1'>Tagihan</p> -->
                                                        <p class='fw-bold mb-0'>Tagihan (Hanya saat rekognisi)</p>
                                                        <p class='fw-bold mb-0'>Pra Akademik/Matrikulasi (Hanya di
                                                            semester
                                                            awal)</p>
                                                        <p class='fw-bold mb-0'>SPP (Hanya di semester awal)</p>
                                                        <p class='fw-bold mb-0'>BPP (Setiap semester)</p>
                                                        <p class='fw-bold'>Total</p>
                                                    </div>
                                                    <div class="col-2 " style="text-align:right">
                                                        <p class='fw-bold mb-0 '>
                                                            <?= "(" . $jumlahsks . " x " . number_format($tarifrpl, 0, ',', '.') . ")" ?>
                                                        </p>
                                                        <p class='fw-bold mb-0'></p>
                                                        <p class='fw-bold mb-0'></p>
                                                        <p class='fw-bold mb-0'></p>
                                                        <p class='fw-bold mb-0'></p>

                                                    </div>
                                                    <div class="col-6 mb-0">
                                                        <?php
                                                        if ($dodi == 1) {
                                                            $tarifdodi = $tarifdodi;

                                                            $praakademik = 0;
                                                            $spp = 0;
                                                            $tagihan = floatval($jumlahsks) * floatval($tarifdodi);
                                                        } else {
                                                            $tagihan = floatval($jumlahsks) * floatval($tarifrpl);
                                                        }

                                                        ?>
                                                        <p class=' fw-bold mb-0 '>
                                                            :
                                                            <?= "  Rp " . number_format($tagihan, 0, ',', '.') ?>
                                                        </p>

                                                        <p class='fw-bold mb-0 '>
                                                            :
                                                            <?= " Rp " . number_format($praakademik, 0, ',', '.') ?>
                                                        </p>
                                                        <p class='fw-bold mb-0 '>
                                                            :
                                                            <?= " Rp " . number_format($spp, 0, ',', '.') ?>
                                                        </p>
                                                        <p class='fw-bold mb-0 '>
                                                            <u>
                                                                :
                                                                <?= " Rp " . number_format($bpp, 0, ',', '.') ?></u>
                                                        </p>
                                                        <p class='fw-bold mb-0 '>
                                                            <?php $total = floatval($tagihan) + floatval($praakademik) + floatval($spp) + floatval($bpp) ?>
                                                            <u>
                                                                :
                                                                <?= " Rp " . number_format($total, 0, ',', '.') ?></u>
                                                            <?php
                                                            if (isset($batasPembayaran)) {
                                                                // $formattedDate = date("d-m-Y", strtotime($batasPembayaran));
                                                                $formattedDate = tgl_indo($batasPembayaran);
                                                                echo "<span class='text-danger mx-2'>( Batas akhir pembayaran tanggal $formattedDate) </span>";
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                            <?php
                                            echo $ket;
                                            ?>
                                            <div class="col-12 " style="font-size: 10px;">
                                                <div class="row">
                                                    <div class="col-6">
                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                        date_default_timezone_set('Asia/Makassar');

                                                        $now = date('Y-m-d');
                                                        ?>
                                                        <p class=' text-center'>Makassar, <?= tgl_indo($now) ?> </p>
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

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()"
                                                    class="btn btn-success waves-effect waves-light me-1"><i
                                                        class="fa fa-print"></i></a>
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