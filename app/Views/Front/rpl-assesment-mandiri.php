<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

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

                    if (isset($status)) {
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Memperbaharui data.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    if (isset($datasubmit)) {

                        if (isset($datasubmit["jenis_rpl"])) {
                            $datadok = $datasubmit[0];
                            $biodata = $databio;
                        } else {

                            $datadok = $datasubmit[0];
                            $biodata = $databio[0];
                        }
                    }

                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Assesment Mandiri RPL</h4>
                                    <form method="POST" action="<?= base_url("Front/Insertbiodata") ?>">
                                        <div class="mb-3">
                                            <label for="formrow-nama-input" class="form-label">Program Studi
                                                <?= (isset($nm_prodi) ? $nm_prodi : '') ?>
                                            </label>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div>
                                                    <p>Note : Untuk Memilih lebih dari 1 Dokumen Referensi tekan Ctrl +
                                                        Klik Ref </p>
                                                </div>
                                                <div class="mb-3">
                                                    <table class='table table-bordered'>
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Matakuliah</th>
                                                                <th>CPMK</th>
                                                                <th>Penguasaan</th>
                                                                <th>Ref</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-klaim-mk'>
                                                            <?php
                                                            if (isset($datadok)) {
                                                                $pilihdokumen = "";
                                                                foreach ($datadok as $dok) {
                                                                    $pilihdokumen .= "<option value ='" . $dok['no_dokumen'] . "'>" . $dok['nmfile'] . "</option>";
                                                                }
                                                                $selectboxdok = "<select class='form-select' for='ref' multiple>" . $pilihdokumen . "</select>";
                                                            }
                                                            if (isset($getMatakuliah)) {
                                                                $i = 0;
                                                                $namamatakulia = "";
                                                                foreach ($getMatakuliah as $row) {

                                                                    if ($namamatakulia == "") {
                                                                        $i++;
                                                                        $html = "";
                                                                        $namamatakulia = $row->nama_matakuliah;
                                                                        $cpmk = $row->cpmk;
                                                                        $count = 1;
                                                                        $html1 = [
                                                                            "kd_mk" => $row->kode_matakuliah,
                                                                            "nama_matakuliah" => $row->nama_matakuliah,
                                                                            "idcpmk" => $row->idcpmk,
                                                                            "cpmk" => $row->cpmk,
                                                                            "sks" => $row->sks,
                                                                        ];
                                                                    } else {
                                                                        if ($namamatakulia == $row->nama_matakuliah) {
                                                                            $count++;
                                                                            $html .= "<tr idcpmk='$row->idcpmk' kdmk='$row->kode_matakuliah' namamk='$row->nama_matakuliah' 
                                                                            sks='$row->sks'>
                                                                                        <td for='cpmk'>$row->cpmk</td>
                                                                                        <td for='nilai'><select class='form-select'>
                                                                                        <option value='' selected>Pilih</option>    
                                                                                        <option >B</option>    
                                                                                        <option >C</option>    
                                                                                        <option >K</option>    
                                                                                        </select></td>
                                                                                        <td for='ref'>" . $selectboxdok . "</td>
                                                                                        </tr>";
                                                                        } else {

                                                                            echo "<tr idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "'>
                                                                                    <td for='namamk' rowspan='$count'>" . $i . "</td>
                                                                                    <td rowspan='$count'>" . $html1['nama_matakuliah'] . "</td>
                                                                                    <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                    <td for='nilai'><select class='form-select'>
                                                                                    <option value='' selected>Pilih</option>    
                                                                                    <option>B</option>    
                                                                                    <option>C</option>    
                                                                                    <option>K</option>    
                                                                                    </select></td>
                                                                                    <td for='ref'>" . $selectboxdok . "</td>
                                                                                    </tr>" . $html;
                                                                            $i++;
                                                                            $html = "";
                                                                            $count = 1;
                                                                            $namamatakulia = $row->nama_matakuliah;
                                                                            $html1 = [
                                                                                "kd_mk" => $row->kode_matakuliah,
                                                                                "nama_matakuliah" => $row->nama_matakuliah,
                                                                                "idcpmk" => $row->idcpmk,
                                                                                "cpmk" => $row->cpmk,
                                                                                "sks" => $row->sks,
                                                                            ];
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>



                                        <div>
                                            <button type="button" onclick="simpan_klaim()"
                                                class="btn btn-primary w-md">Submit</button>
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

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>

<script>
function simpan_klaim() {
    jsonObj = [];
    $('#tbody-klaim-mk  > tr').each(function(i, tr) {
        if ($(this).find("td[for=nilai]").find(":selected").val() != "") {
            var kdmk = $(this).attr("kdmk");
            var nmmk = $(this).attr("namamk");
            var sks = $(this).attr("sks");
            var idcmpk = $(this).attr("idcpmk");
            var cpmk = $(this).find("td[for=cpmk]").html();
            var nilai = $(this).find("td[for=nilai]").find(":selected").val();
            var ref = $(this).find("td[for=ref]").find("select").val();

            item = {}
            item["kdmk"] = kdmk;
            item["nmmk"] = nmmk;
            item["idcpmk"] = idcmpk;
            item["sks"] = sks;
            item["cpmk"] = cpmk;
            item["nilai"] = nilai;
            item["ref"] = ref;

            jsonObj.push(item);
        }
    });

    // console.log(jsonObj)
    url = '<?= base_url('klaimmk') ?>'
    $.post(url, {
        jsonObj
    }, function(data) {
        alert(data);
    }).fail(function() {
        alert("error");
    });
}
</script>