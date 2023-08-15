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
                                <h4 class="card-title mb-1 text-center">MATAKULIAH KLAIM MAHASISWA
                                </h4>
                                <h4 class="card-title mb-4 text-center"> <?= $noregis ?>
                                </h4>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <table class='table table-bordered table-responsive table-sm border-dark'
                                                style="font-size: 10px;">
                                                <thead class="">
                                                    <tr>
                                                        <th width='3%'>No</th>
                                                        <th width='11%'>Kode Matakuliah</th>
                                                        <th>Nama Matakuliah</th>
                                                        <th width='7%'>SKS</th>
                                                        <th width='7%'>Nilai</th>
                                                    </tr>

                                                </thead>
                                                <tbody id='tbody-klaim-mk'>
                                                    <?php
                                                    if (isset($data_mkA1)) {
                                                        $i = 0;
                                                        $countdata = count($data_mkA1);
                                                        $jumlahsks = 0;
                                                        foreach ($data_mkA1 as $row) {
                                                            $i++;
                                                            echo "<tr>
                                                                <td>$i</td>        
                                                                <td>" . $row['kode_matakuliah'] . "</td>        
                                                                <td class='text-left'>" . $row['nama_matakuliah'] . "</td>        
                                                                <td class='text-center'>" . $row['jumlah_sks'] . "</td>          
                                                                <td class='text-center'>" . $row['nilai'] . "</td>          
                                                            </tr>";
                                                            $jumlahsks = floatval($jumlahsks) + floatval($row['jumlah_sks']);

                                                            if ($i == $countdata) {
                                                                echo "<tr>
                                                                            <td colspan='3' class='text-center'> Jumlah</td>        
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
                                        <div class="d-print-none">
                                            <!-- <div class="float-end" title="Convert Excel">
                                                <a href="<?= base_url('convert-excel/' . $noregis) ?>"
                                                    class="btn btn-success waves-effect waves-light me-1"><i
                                                        class="fa fa-file-excel"></i></a>
                                            </div> -->
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