<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

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



                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Assesment RPL</h4>
                                    <form method="POST" action="<?= base_url("Front/Insertbiodata") ?>">
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

                                                        <div class="col-md-2">Jenis RPL</div>
                                                        <div class="col-md-2">: <?= "A" . $jenis_rpl; ?></div>
                                                    </div>

                                                    <table class='table table-bordered'>
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Matakuliah</th>
                                                                <th>CPMK</th>
                                                                <th>Penguasaan</th>
                                                                <th>Ref</th>
                                                                <th>Nilai</th>
                                                                <th>Tanggapan</th>
                                                                <th>Keterangan Tanggapan</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-klaim-mk'>
                                                            <?php
                                                            // print_r($dataKlaimMhs);
                                                            if (isset($dataKlaimMhs)) {
                                                                $namamatakulia = "";
                                                                $idcpmk = "";
                                                                $i = 0;
                                                                $jumlahdata = count($dataKlaimMhs);
                                                                $hitdata = 0;
                                                                foreach ($dataKlaimMhs as $row) {
                                                                    $hitdata++;
                                                                    if ($namamatakulia == "") {
                                                                        $i++;
                                                                        $html = "";
                                                                        $namamatakulia = $row['nama_matakuliah'];
                                                                        $cpmk = $row['cpmk'];
                                                                        $count = 1;
                                                                        $html1 = [
                                                                            "kd_mk" => $row['kode_matakuliah'],
                                                                            "nama_matakuliah" => $row['nama_matakuliah'],
                                                                            "idcpmk" => $row['idcpmk'],
                                                                            "cpmk" => $row['cpmk'],
                                                                            "idklaim" => $row['idklaim'],
                                                                            "klaim" => $row['klaim'],
                                                                            "no_dokumen" => $row['no_dokumen'],
                                                                            "nmfile_asli" => $row['nmfile_asli'],
                                                                            "nmfile" => $row['nmfile'],
                                                                            "kode_matakuliah" => $row['kode_matakuliah'],
                                                                            "sks" => $row['sks'],
                                                                        ];
                                                                    } else {
                                                                        if ($namamatakulia == $row['nama_matakuliah']) {
                                                                            $count++;
                                                                            $html .= "<tr idcpmk='" . $row['idcpmk'] . "' kdmk='" . $row['kode_matakuliah'] . "' namamk='" . $row['nama_matakuliah'] . "' 
                                                                            sks='" . $row['sks'] . "'>";
                                                                            if ($row['entry_count'] > 1) {
                                                                                if ($idcpmk != $row['idcpmk']) {

                                                                                    $idcpmk = $row["idcpmk"];
                                                                                    $html .=    "<td for='cpmk' rowspan='" . $row['entry_count'] . "'>" . $row['cpmk'] . "</td>
                                                                                    <td rowspan='" . $row['entry_count'] . "'>" . $row['klaim'] . "</td>";
                                                                                }
                                                                            } else {
                                                                                $html .=    "<td for='cpmk'>" . $row['cpmk'] . "</td>
                                                                                <td>" . $row['klaim'] . "</td>";
                                                                            }
                                                                            $html .= "<td for='ref' nodok='" . $row['no_dokumen'] . "'><a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $row['nmfile_asli'] . "' target='_blank'>" . $row['nmfile'] . "</a></td>
                                                                                        </tr>";
                                                                        } else {
                                                                            echo "<tr noregis='$noregis' idklaim='" . $html1['idklaim'] . "' idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "' kdprodi='" . $row['kode_prodi'] . "' >
                                                                                    <td for='namamk' rowspan='$count'>" . $i . "</td>
                                                                                    <td rowspan='$count'>" . $html1['nama_matakuliah'] . "</td>
                                                                                    <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                    <td for='nilai' >" . $html1['klaim'] . "</td>
                                                                                    <td for='ref' nodok='" . $html1['no_dokumen'] . "'><a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $html1['nmfile_asli'] . "' target='_blank'>" . $html1['nmfile'] . "</a></td>
                                                                                    <td for='tanggapan'  rowspan='$count' kdmk='" . $html1['kode_matakuliah'] . "'>
                                                                                    <select class='form-select'>
                                                                                    <option value=''>Pilih</option>
                                                                                    <option value='0'>Ok</option>
                                                                                    <option value='1'>Butuh Tindakan</option>
                                                                                    </select></td><td for='nilaiAs'  rowspan='$count'>
                                                                                    <select class='form-select'>
                                                                                    <option value='' selected>Pilih</option>    
                                                                                    <option value='B'>B</option>    
                                                                                    <option value='C' >C</option>    
                                                                                    <option value='K'>K</option>  
                                                                                    </select></td>
                                                                                    <td for='kettanggapan' rowspan='$count'><textarea style='border: none; width: 100%;  height: 100%;resize: vertical;min-height:200px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'> </textarea>
                                                                                    </td>
                                                                                    </tr>" . $html;
                                                                            $i++;
                                                                            $html = "";
                                                                            $count = 1;
                                                                            $namamatakulia = $row['nama_matakuliah'];
                                                                            $html1 = [
                                                                                "kd_mk" => $row['kode_matakuliah'],
                                                                                "nama_matakuliah" => $row['nama_matakuliah'],
                                                                                "idklaim" => $row['idklaim'],
                                                                                "idcpmk" => $row['idcpmk'],
                                                                                "cpmk" => $row['cpmk'],
                                                                                "klaim" => $row['klaim'],
                                                                                "no_dokumen" => $row['no_dokumen'],
                                                                                "nmfile_asli" => $row['nmfile_asli'],
                                                                                "nmfile" => $row['nmfile'],
                                                                                "kode_matakuliah" => $row['kode_matakuliah'],
                                                                                "sks" => $row['sks'],
                                                                            ];
                                                                        }

                                                                        if ($hitdata == $jumlahdata) {
                                                                            echo "<tr noregis='$noregis' idklaim='" . $html1['idklaim'] . "' idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "' kdprodi='" . $row['kode_prodi'] . "'>
                                                                            <td for='namamk' rowspan='$count'>" . $i . "</td>
                                                                                    <td rowspan='$count'>" . $html1['nama_matakuliah'] . "</td>
                                                                                    <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                    <td for='nilai' >" . $html1['klaim'] . "</td>
                                                                                    <td for='ref' nodok='" . $html1['no_dokumen'] . "'><a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $html1['nmfile_asli'] . "' target='_blank'>" . $html1['nmfile'] . "</a></td>
                                                                                    <td for='tanggapan' rowspan='$count'>
                                                                                    <select class='form-select'>
                                                                                    <option value=''>Pilih</option>
                                                                                    <option value='0'>Ok</option>
                                                                                    <option value='1'>Butuh Tindakan</option>
                                                                                    </select></td><td for='nilaiAs'  rowspan='$count'>
                                                                                    <select class='form-select'>
                                                                                    <option value='' selected>Pilih</option>    
                                                                                    <option value='B'>B</option>    
                                                                                    <option value='C' >C</option>    
                                                                                    <option value='K'>K</option>    
                                                                                    </select></td>
                                                                                    <td for='kettanggapan' rowspan='$count'><textarea style='border: none; width: 100%;  height: 100%;resize: vertical;min-height:200px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'> </textarea>
                                                                                    </td>
                                                                                    </tr>" . $html;
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
                                            <button type="button" onclick="simpan_klaim_asessor()"
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
$(document).ready(function() {
    noregis = '<?= $noregis ?>'
    url = '<?= base_url('getDataKlaimAsessor') ?>'
    $.post(url, {
        noregis: noregis
    }, function(data) {
        data = JSON.parse(data)
        console.log(data);
        $.each(data, function(index, value) {
            $('#tbody-klaim-mk  > tr').each(function(i, tr) {
                if ($(this).attr('noregis') == noregis && $(this).attr('idklaim') ==
                    value['idklaim']) {
                    // alert('jalan')
                    $(this).find('td[for=tanggapan]').children().val(value[
                        'tanggapan']);
                    $(this).find('td[for=nilaiAs]').children().val(value[
                        'nilai']);
                    $(this).find('td[for=kettanggapan]').children()
                        .val(value['ket_tanggapan']);

                }
            })

        })
    }).fail(function() {
        alert("error");
    });
})

function simpan_klaim_asessor() {
    jsonObj = [];
    statusdata = 0;
    $('#tbody-klaim-mk  > tr').each(function(i, tr) {

        if ($(this).attr('noregis') != undefined) {
            idklaim = $(this).attr('idklaim')
            no_peserta = $(this).attr('noregis')
            kdprodi = $(this).attr('kdprodi')
            kdmk = $(this).attr('noregis')
            tanggapan = $(this).find('td[for=tanggapan]').children().val();
            nilai = $(this).find('td[for=nilaiAs]').children().val();
            kettanggapan = $(this).find('td[for=kettanggapan]').children().val();


            if (idklaim != "" && no_peserta != "" && kdmk != "" && tanggapan != "" && nilai != "" &&
                kettanggapan != "") {
                item = {}
                item["idklaim"] = idklaim;
                item["noregis"] = no_peserta;
                item["kdmk"] = kdmk;
                item["kdprodi"] = kdprodi;
                item["tanggapan"] = tanggapan;
                item["nilai"] = nilai;
                item["kettanggapan"] = kettanggapan;

                jsonObj.push(item);

            } else {
                statusdata = 1
            }
        }

    })
    if (statusdata == 1) {
        alert("Silahkan Lengkapi Tanggapan Anda !")
    } else {
        url = '<?= base_url('klaimmkAsessor') ?>'
        $.post(url, {
            jsonObj
        }, function(data) {
            alert(data);
        }).fail(function() {
            alert("error");
        });
    }

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