<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>


</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Lembar Kerja Assesment</h4>
                                    <div>
                                        <div class="mb-3">
                                            <label for="formrow-nama-input" class="form-label">Tahun Akademik
                                                <?= (isset($ta_akademik) ? $ta_akademik : '') ?>
                                            </label> <br />
                                            <label for="formrow-nama-input" class="form-label">Program Studi
                                                <?= (isset($nm_prodi) ? $nm_prodi : '') ?>
                                            </label>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div>

                                                </div>
                                                <div class="mb-3">
                                                    <table
                                                        class='table table-bordered table-responsive table-sm border-dark'
                                                        style="font-size: 10px;">
                                                        <thead class=" table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>No regis</th>
                                                                <th>Nama Peserta</th>
                                                                <th>Kode Matakuliah</th>
                                                                <th>Nama Matakuliah</th>
                                                                <th>SKS</th>
                                                                <th width='15%'>CPMK</th>
                                                                <th>Penguasaan</th>
                                                                <th width='5%'>Deskripsi</th>
                                                                <th width='10%'>Ref</th>
                                                                <!--<th>Tanggapan</th>-->
                                                                <th>Nilai</th>
                                                                <th>Keterangan Tanggapan</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-klaim-mk'>
                                                            <?php
                                                            // print_r($dataKlaimMhs);

                                                            //inisilize no regis
                                                            $last_no_registrasi = '';
                                                            $last_mata_kuliah = '';
                                                            $registrasi_count = array_count_values(array_column($dataKlaimMhs, "no_peserta"));
                                                            $mata_kuliah_count = [];
                                                            foreach ($dataKlaimMhs as $row) {
                                                                $key = $row['no_peserta'] . '-' . $row['kode_matakuliah'];
                                                                if (!isset($mata_kuliah_count[$key])) {
                                                                    $mata_kuliah_count[$key] = 0;
                                                                }
                                                                $mata_kuliah_count[$key]++;
                                                            }
                                                            $firstrow = true;
                                                            $i=1;
                                                            foreach ($dataKlaimMhs as $key => $row) {
                                                                echo "<tr>";

                                                                // Check if no_registrasi is the same as the last one
                                                                if ($last_no_registrasi != $row['no_peserta']) {
                                                                    // Output the no_registrasi and nama with rowspan
                                                                    echo "<td rowspan='{$registrasi_count[$row['no_peserta']]}'>".$i++."</td>";
                                                                    echo "<td rowspan='{$registrasi_count[$row['no_peserta']]}'>{$row['no_peserta']}</td>";
                                                                    echo "<td rowspan='{$registrasi_count[$row['no_peserta']]}'>{$row['nama']}</td>";
                                                                    $last_no_registrasi = $row['no_peserta'];
                                                                    $firstrow=true;
                                                                }

                                                                // Check if mata_kuliah is the same as the last one
                                                                $mata_kuliah_key = $row['no_peserta'] . '-' . $row['kode_matakuliah'];
                                                                if ($last_mata_kuliah != $row['kode_matakuliah']) {
                                                                    // Output mata_kuliah with rowspan
                                                                    echo "<td rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>{$row['kode_matakuliah']}</td>";
                                                                    echo "<td rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>{$row['nama_matakuliah']}</td>";
                                                                    echo "<td rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>{$row['sks']}</td>";
                                                                    $last_mata_kuliah = $row['kode_matakuliah'];
                                                                    $firstrow=true;
                                                                }

                                                                // Output sub_mata_kuliah and nilai
                                                                
                                                                
                                                                                
                                                                echo "<td>{$row['cpmk']}</td>";
                                                                echo "<td>{$row['klaim']}</td>";
                                                                echo "<td>{$row['desk']}</td>";
                                                                // echo "<td>{$row['no_dokumen']}</td>";
                                                                 if ($last_mata_kuliah == $row['kode_matakuliah']) {
                                                                    // Output mata_kuliah with rowspan
                                                                    if($firstrow== true){
                                                                    $dokument = json_decode($row['no_dokumen']);
                                                                    $ref = "<td for='ref' rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>";
                                                                    foreach ($dokument as $a) {
                                                                    $dataref = getnamafile($a);
    
                                                                    $ref .= "<a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $dataref->nmfile_asli . "' target='_blank'><button class='btn btn-sm btn-warning mb-2'>" . $dataref->nmfile . "</button></a><br>";
                                                                                    }
                                                                    $ref .= "</td>";
                                                                    echo  $ref;
                                                                    // echo "<td rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>{$row['tanggapan']}</td>";
                                                                    echo "<td rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>{$row['nilai']}</td>";
                                                                    echo "<td rowspan='{$mata_kuliah_count[$mata_kuliah_key]}'>{$row['ket_tanggapan']}</td>";
                                                                    $firstrow= false;
                                                                    }
                                                      
                                                                }
                                                               
                                                                
                                                                
                                                                echo "</tr>";
                                                            }

                                                            echo "</tbody></table>";


                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>



                                        <div class="d-flex justify-content-between ">

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
                    </div>

                </div>
                <!-- end row -->






            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->




    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?= $this->include('partials/vendor-scripts') ?>

    <!-- apexcharts -->
    <!-- <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script> -->

    <!-- dashboard init -->
    <!-- <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script> -->

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>

<script>
</script>
<?php
function inputnilai($idcpmk, $nilai)
{
    if ($nilai != "") {
        if ($nilai == "A") {
            return "<td for='nilai'>
    <select class='form-select'>
        <option value=''>Pilih</option>
        <option selected>A</option>
        <option>B</option>
        <option>E</option>
    </select>
</td>";
        } else if ($nilai == "B") {
            return "<td for='nilai'>
    <select class='form-select'>
        <option value=''>Pilih</option>
        <option>A</option>
        <option selected>B</option>
        <option>E</option>
    </select>
</td>";
        } else if ($nilai == "E") {
            return "<td for='nilai'>
    <select class='form-select'>
        <option value=''>Pilih</option>
        <option>A</option>
        <option>B</option>
        <option selected>E</option>
    </select>
</td>";
        } else {
            return "<td for='nilai'>
    <select class='form-select'>
        <option value='' selected>Pilih</option>
        <option>A</option>
        <option>B</option>
        <option>E</option>
    </select>
</td>";
        }
    } else {
        return "<td for='nilai'>
    <select class='form-select'>
        <option value='' selected>Pilih</option>
        <option>B</option>
        <option>C</option>
        <option>K</option>
    </select>
</td>";
    }
}
function getnamafile($no_dokumen)
{
    if (session()->get('id')) {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from dok_portofolio where no_dokumen='$no_dokumen'")->getRow();
        return $result;
    }
}