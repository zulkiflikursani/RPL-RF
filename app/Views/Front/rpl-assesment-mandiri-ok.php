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

                    <div id='alert' class="m-0 p-0">
                    </div>
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

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div>

                                                </div>
                                                <div class="modal fade klaim-mahasiswa-modal" role="dialog" z-index=-1 aria-labelledby="mytambah-mahasiswa-modal" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">Klaim
                                                                    Matakuliah</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- content -->
                                                                <form method="POST" action="" enctype="">
                                                                    <div class="mb-3">
                                                                        <label for="" id='label-kd-mk'></label>:
                                                                        <label for="" id='label-nm-mk'></label>
                                                                        <table class="table table-bordered" id='table-cpmk'>
                                                                            <thead>
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

                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <?= getRefmhs($datadok, "") ?>
                                                                    </div>
                                                                    <div cla ss="mb-3">
                                                                        <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                                                            <option value="AL">Alabama</option>

                                                                            <option value="WY">Wyoming</option>
                                                                        </select>
                                                                    </div>

                                                                    <div>
                                                                        <button type="submit" class="btn btn-primary w-md">Simpan</button>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div>
                                                </div><!-- /.modal-dialog -->
                                                <div class="mb-3">

                                                    <table class='table table-bordered'>
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 16.66%">No</th>
                                                                <th style="width: 20%">Kode Matakuliah</th>
                                                                <th style="width: 40%">Nama Matakuliah</th>
                                                                <th style="width: 14.44%">Action</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-klaim-mk'>
                                                            <?php
                                                            if (isset($dataKlaimMhs) && $dataKlaimMhs != null) {
                                                                $dataassmandiri = $dataKlaimMhs;
                                                            } else {
                                                                $dataassmandiri = array();
                                                            }
                                                            if (isset($getMatakuliah)) {
                                                                $i = 0;
                                                                foreach ($getMatakuliah as $row) {
                                                                    $button = '';
                                                                    if ($row->kdmk_klaim == null) {
                                                                        $button = "<a href='" . base_url('form-assesment') . "/" . $row->kode_matakuliah . "'><button class='btn btn-primary btn-sm'>Klaim</button></a>";
                                                                    } else {
                                                                        $button = "<button class='btn btn-primary btn-sm' idklaim='$row->idklaim' onclick='batalklaim($(this))'>Batal Klaim</button><a href='" . base_url('form-assesment') . "/" . $row->kode_matakuliah . "'><button class='btn btn-primary btn-sm mx-2'>Lihat Klaim</button></a>";
                                                                    }

                                                                    $i++;
                                                                    echo "<tr><td>$i</td><td for='kdmk' kode_prodi='$row->kode_prodi'>" . $row->kode_matakuliah . "</td><td for='nmmk'>" . $row->nama_matakuliah . "</td><td>$button</td></tr>";
                                                                }
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>

                                        </div>



                                        <div>
                                            <button type="button" onclick="pengajuan_klaim()" class="btn btn-primary w-md mx-2">Pengajuan</button>
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

    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('.klaim-mahasiswa-modal')
        });
        $('.js-example-basic-multiple').select2();
        <?php if (isset($dataKlaimMhs[0]['statusklaim'])) {
            if ($dataKlaimMhs[0]['statusklaim'] == 2) {
        ?>
                $('select').attr("disabled", true);
                // alert(git'd')
        <?php
            }
        }

        ?>

    })

    function batalklaim(ini) {
        $('#loading').show();
        idklaim = ini.attr("idklaim");
        // nmmk = ini.parent().parent().find("td[for=nmmk]").html();
        url = '<?= base_url('batalklaimmk') ?>'
        $.post(url, {
            idklaim: idklaim
        }, function(data) {
            // alert(data);
            $('#loading').hide();
            window.scrollTo(0, 0);
            $('#alert').children().remove();
            if (data == "Sukses Membatalkan Klaim Matakuliah") {
                $('#alert').append(
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">' + data +
                    '<a href="<?= base_url('assesment-mandiri') ?> "><button type="button" class="btn btn-primary btn-sm mx-3">Refresh</button></a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                );

            } else {
                $('#alert').append(
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">' + data +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                );
            }
        }).fail(function() {
            $('#loading').hide();

            alert("error");
        });

    }

    function pengajuan_klaim() {

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
        return "<td for='nilai'><select class='form-select'><option value='' selected>Pilih</option><option >B</option><option >C</option><option >K</option></select></td>";
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
            $selectboxdok = "<select class='select2 form-control select2-multiple ' for='ref' multiple='multiple' name='ref[]' data-placeholder='Pilih...'>" . $pilihdokumen . "</select>";
        }
    }

    return $selectboxdok;
    // $ref = 

}

?>