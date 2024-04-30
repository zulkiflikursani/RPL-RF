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

                    if (isset($validstatus)) {
                        if ($validstatus != "") {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">' . $validstatus . '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                        }
                    }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Assesment RPL</h4>
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
                                                            $jumlahklaimsks = 0;

                                                            if (isset($dataKlaimAsessorA1)) {

                                                                $kdmk = "";
                                                                $no = 0;
                                                                foreach ($dataKlaimAsessorA1 as $row) {
                                                                    $jumlahklaimsks = floatval($jumlahklaimsks) + floatval($row->sks);
                                                                    if ($kdmk != $row->kode_matakuliah) {
                                                                        $no++;
                                                                        $kdmk = $row->kode_matakuliah;
                                                                        echo "<tr noregis='$row->no_peserta' idklaim='$row->idklaim'
                                                                        kdmk='$row->kode_matakuliah'
                                                                        kdprodi='$row->kode_prodi'
                                                                        nmmk='$row->nama_matakuliah'
                                                                        sks='$row->sks'
                                                                        nilai='$row->nilai'>
                                                                        <td rowspan='$row->entry_count'>$no</td><td rowspan='$row->entry_count'>$row->kode_matakuliah</td>
                                                                        <td rowspan='$row->entry_count'>$row->nama_matakuliah</td>
                                                                        <td rowspan='$row->entry_count'>$row->sks</td><td rowspan='$row->entry_count'>$row->nilai</td><td >$row->nama_matakuliah_asal</td><td>$row->jumlah_sks</td><td>$row->nilai_asal</td>
                                                                        </tr>";
                                                                    } else {

                                                                        echo "<tr noregis='$row->no_peserta' idklaim='$row->idklaim'
                                                                        kdmk='$row->kode_matakuliah'
                                                                        nmmk='$row->nama_matakuliah'
                                                                        sks='$row->sks'
                                                                        kdprodi='$row->kode_prodi'
                                                                        nilai='$row->nilai'>
                                                                        <td>$row->nama_matakuliah_asal</td><td>$row->jumlah_sks</td><td>$row->nilai_asal</td></tr>";
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                    if ($dodi == 0) {

                                                        echo "Jumlah Klaim Matakuliah : <span id='julmahSksValid'></span> SKS dari $maxsksrekognisi maksimum SKS Rekognisi";
                                                        echo "<p  class='text-danger bold statusSks'></p>";
                                                    } else {
                                                        echo "Jumlah Klaim Matakuliah : <span id='julmahSksValid'></span> SKS (status mahasiswa dodi)";
                                                    }

                                                    ?>
                                                </div>
                                            </div>

                                        </div>



                                        <div>
                                            <form action="<?= base_url('setvalidprodi') ?>" method="post"
                                                id='validasi-form' target="">
                                                <input type="hidden" name="noregis" value='<?= $noregis ?>'>
                                            </form>
                                            <form action="<?= base_url('setunvalidprodi') ?>" method="post"
                                                id='unvalidasi-form' target="">
                                                <input type="hidden" name="noregis" value='<?= $noregis ?>'>
                                            </form>
                                            <?php if ($status == 1) {
                                                echo "<button type='button' onclick='validprodi()' class='btn btn-primary w-md'>Validasi</button>";
                                            } else if ($status == 2) {
                                                echo '<button type="button" onclick="unvalidprodi()" class="btn btn-primary w-md mx-3">Unvalidasi</button>';
                                            } else if ($status == 3) {
                                                echo "<button type='button' onclick='validprodi()' class='btn btn-primary w-md'>Validasi</button>";
                                            } else if ($status == 4) {
                                                echo '<button type="button" onclick="unvalidprodi()" class="btn btn-primary w-md mx-3">Unvalidasi</button>';
                                            } else if ($status == 5) {
                                                echo "<button type='button' onclick='validprodi()' class='btn btn-primary w-md'>Validasi</button>";
                                            } else if ($status == 6) {
                                                echo "<button type='button' onclick='validprodi()' class='btn btn-primary w-md'>Validasi</button>";
                                            } else if ($status == 7) {
                                                echo "<button type='button' onclick='validprodi()' class='btn btn-primary w-md'>Validasi</button>";
                                            }
                                            ?>
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
    $('#loading').show()
    noregis = '<?= $noregis ?>'
    url = '<?= base_url('getDataKlaimAsessor') ?>'
    $.post(url, {
        noregis: noregis
    }, function(data) {
        data = JSON.parse(data)
        console.log(data);
        count = data.length;

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

                    if (count === i + 1) {
                        klaimsksass()
                    }


                }
            })
            $('textarea').attr('readonly', 'readonly');
            $('select').attr('disabled', 'disabled');
            $('#loading').hide()

        })
    }).fail(function() {
        alert("error");
        $('#loading').hide()
    });
})

function klaimsksass() {

    klaimsks = 0;
    $('#tbody-klaim-mk  > tr').each(function(i, tr) {
        // tanggapan = $(this).find('td[for=tanggapan]').children().val();
        nilai = $(this).attr('nilai');
        sks = $(this).attr('sks');
        if (nilai != "E") {
            klaimsks = parseFloat(klaimsks) + parseFloat(sks)
        }
    })
    // alert(klaimsks)
    $('#julmahSksValid').html(klaimsks)
    if (klaimsks > <?= $maxsksrekognisi ?>) {
        $(".statusSks").html("Jumlah SKS Melebihi Batas Rekognisi")
    }
    // return klaimsks;
}

function validprodi() {
    $('#validasi-form').submit()
}

function unvalidprodi() {
    $('#unvalidasi-form').submit()

}
</script>
<?php
function getnamafile($no_dokumen)
{
    if (session()->get('id')) {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from dok_portofolio where no_dokumen='$no_dokumen'")->getRow();
        return $result;
    }
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