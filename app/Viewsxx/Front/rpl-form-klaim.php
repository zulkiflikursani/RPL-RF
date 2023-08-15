<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

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
                                    <div>
                                        <div class="mb-3">
                                            <label for="formrow-nama-input" class="form-label">Program Studi
                                                <?= (isset($nm_prodi) ? $nm_prodi : '') ?>
                                            </label>

                                        </div>
                                        <?php if (isset($dataKlaimMhs) && $dataKlaimMhs != null) {
                                            $nilai = array();
                                            foreach ($dataKlaimMhs as $a) {
                                                $nilai[$a['idcpmk']] = $a['klaim'];
                                                $deksripsi = $a['desk'];
                                                $ref = $a['no_dokumen'];
                                            }
                                        } ?>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div>

                                                </div>

                                                <div class="mb-3">

                                                    <div class="">
                                                        <!-- content -->
                                                        <form action="">
                                                            <div class="mb-3">
                                                                <div class="mb-2">
                                                                    <Table class="col-md-6">
                                                                        <tr>
                                                                            <td class="col-md-1">Kode Matakuliah</td>
                                                                            <td class="col-md-4">:
                                                                                <?= (isset($kdmk) ? $kdmk : '') ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Nama Matakuliah</td>
                                                                            <td>:
                                                                                <?= (isset($nama_matakuliah) ? $nama_matakuliah : '') ?>
                                                                            </td>
                                                                        </tr>
                                                                    </Table>

                                                                </div>
                                                                <div class="mb-2">
                                                                    <h4 class="text-center">Capaian Pembelajaran
                                                                        Matakuliah</h4>
                                                                </div>
                                                                <table class="table table-bordered" id='table-cpmk'>
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th style="width: 15%">No</th>
                                                                            <th style="width: 20%">Kode CPMK
                                                                            </th>
                                                                            <th style="width: 35%">Nama CPMK
                                                                            </th>
                                                                            <th style="width: 15%">Penguasaan
                                                                            </th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tbody-cpmk">
                                                                        <?php
                                                                        if (isset($dataCpmk)) {
                                                                            $i = 0;
                                                                            foreach ($dataCpmk as $b) {
                                                                                $i++;
                                                                                if (isset($nilai)) {
                                                                                    // $klaim = "";
                                                                                    $klaim = inputnilai($b->idcpmk, $nilai[$b->idcpmk]);
                                                                                } else {
                                                                                    $klaim = inputnilai($b->idcpmk);
                                                                                }
                                                                                echo "<tr >
                                                                                        <td>$i</td>
                                                                                        <td for='idcpmk'>$b->idcpmk</td>
                                                                                        <td for='cpmk'>$b->cpmk</td>
                                                                                        " . $klaim . "
                                                                                        </tr>";
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <div class="mb-3">
                                                                <p class="fw-bold mb-0">Keterangan :</p>
                                                                <p>Penguasaan B=Baik, C=Cukup,
                                                                    K=Kurang, T=Tidak</p>


                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="formrow-nama-input" class="form-label">Desrkipsi</label>
                                                                <textarea class="form-control" id="desk" name="deskripsi" placeholder="Deskripsi" required><?= (isset($deksripsi) ? $deksripsi : '') ?></textarea>
                                                            </div>
                                                            <div class="mb-3 col-md-12">
                                                                <label for="formrow-nama-input" class="form-label">Dokumen Referensi</label>
                                                                <?= getRefmhs($datadok, "") ?>
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>



                                        <!-- <div>
                                            <button type="button" onclick="simpan_klaim()" class="btn btn-outline-danger w-md">Simpan</button>
                                            <button type="button" onclick="pengajuan_klaim()" class="btn btn-primary w-md mx-2">Pengajuan</button>
                                        </div> -->

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
    $(document).ready(function() {
        $('.select2').select2();

        $('.js-example-basic-multiple').select2();
        <?php if (isset($ref)) {
        ?>
            $('.select2').val(<?= $ref ?>).change();;
            <?php
        }
        if (isset($dataKlaimMhs[0]['statusklaim'])) {


            if ($dataKlaimMhs[0]['statusklaim'] == 2) {
            ?>
                $('select').attr("disabled", true);
                // alert(git'd')
        <?php
            }
        }

        ?>

        $('form').on('submit', function(e) {
            pengajuan_klaim()
            return false
        })
    })


    function pengajuan_klaim() {
        $('#loading').show()
        jsonObj = [];
        $('#tbody-cpmk  > tr').each(function(i, tr) {
            if ($(this).find("td[for=nilai]").find(":selected").val() != "") {
                var kdmk = '<?= (isset($kdmk) ? $kdmk : '') ?>';
                var nmmk = '<?= (isset($nama_matakuliah) ? $nama_matakuliah : '') ?>';
                var sks = '<?= (isset($sks) ? $sks : '') ?>'
                var idcmpk = $(this).find("td[for=idcpmk]").html()
                var cpmk = $(this).find("td[for=cpmk]").html();
                var nilai = $(this).find("td[for=nilai]").find(":selected").val();
                var desk = $('textarea#desk').val();
                var ref = $('#ref_klaim').val();

                item = {}
                item["kdmk"] = kdmk;
                item["nmmk"] = nmmk;
                item["idcpmk"] = idcmpk;
                item["sks"] = sks;
                item["cpmk"] = cpmk;
                item["nilai"] = nilai;
                item["desk"] = desk;
                item["ref"] = ref;

                jsonObj.push(item);
                // alert(desk);
            }
        });
        url = '<?= base_url('simpanklaimmk') ?>'
        $.post(url, {
            jsonObj
        }).done(function(data) {
            $('#loading').hide()
            if (alert(data)) {} else {
                window.location.replace('<?= base_url('assesment-mandiri') ?>')
            };
        }).fail(function() {
            $('#loading').hide()
            alert("error");
        })
    }
</script>
<?php
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
function inputnilai($idcpmk, $nilai = "")
{
    if ($nilai != "") {
        if ($nilai == "B") {
            return "<td for='nilai' idcmk='$idcpmk'>
            <select class='form-select' required>
            <option value='' >Pilih</option>    
            <option selected >B</option>    
            <option >C</option>    
            <option >K</option>    
            <option >T</option>    
            </select></td>";
        } else if ($nilai == "C") {
            return "<td for='nilai' idcmk='$idcpmk'>
            <select class='form-select' required>
            <option value='' >Pilih</option>    
            <option >B</option>    
            <option selected >C</option>    
            <option >K</option>
            <option >T</option>    
            </select></td>";
        } else if ($nilai == "K") {
            return "<td for='nilai' idcmk='$idcpmk'>
            <select class='form-select' required>
            <option value='' >Pilih</option>    
            <option >B</option>    
            <option >C</option>    
            <option selected >K</option>
            <option >T</option>    
            </select></td>";
        } else if ($nilai == "T") {
            return "<td for='nilai' idcmk='$idcpmk'>
            <select class='form-select' required>
            <option value='' >Pilih</option>    
            <option >B</option>    
            <option >C</option>    
            <option >K</option>
            <option selected >T</option>    
            </select></td>";
        } else {
            return "<td for='nilai' idcmk='$idcpmk'>
            <select class='form-select' required>
            <option value='' selected>Pilih</option>    
            <option >B</option>    
            <option >C</option>    
            <option >K</option>    
            <option >T</option>    
            </select></td>";
        }
    } else {
        return "<td for='nilai' idcmk='$idcpmk'><select class='form-select' required><option value='' selected>Pilih</option><option >B</option><option >C</option><option >K</option><option >T</option>  </select></td>";
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
            $selectboxdok = "<select class='select2 form-control select2-multiple' for='ref' multiple='multiple' name='ref[]' width='100%'>" . $pilihdokumen . "</select>";
        }
    } else {
        if (isset($datadok)) {
            $pilihdokumen = "";
            foreach ($datadok as $dok) {

                $pilihdokumen .= "<option value ='" . $dok['no_dokumen'] . "' >" . $dok['nmfile'] . "</option>";
            }
            // $pilihdokumen .= "</optgroup>";
            $selectboxdok = "<select class='select2 form-control select2-multiple ' for='ref' id='ref_klaim' multiple='multiple' name='ref[]' data-placeholder='Pilih...' required><optgroup label='Pilih Dokumen'>" . $pilihdokumen . "</optgroup></select>";
        }
    }

    return $selectboxdok;
    // $ref = 

}

?>