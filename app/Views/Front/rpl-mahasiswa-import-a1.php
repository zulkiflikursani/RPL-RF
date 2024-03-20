<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        right: 10px;
        left: auto;
    }
    </style>
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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Menyimpan data<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }
                    if (isset($statushapus)) {
                        if ($statushapus == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Menghapus data.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }


                    if (isset($databio[0])) {
                        // print_r($datasubmit-nama);
                        $biodata = $databio[0];
                        $jenis_rpl = $databio[0]['jenis_rpl'];
                        if ($jenis_rpl == 1) {
                            $nm_rpl = "A1";
                        } else if ($jenis_rpl == 2) {
                            $nm_rpl = "A2";
                        } else if ($jenis_rpl == 3) {
                            $nm_rpl = "A3";
                        }
                    } else if (isset($databio['jenis_rpl'])) {
                        $jenis_rpl = $databio['jenis_rpl'];
                        if ($jenis_rpl == 1) {
                            $nm_rpl = "A1";
                        } else if ($jenis_rpl == 2) {
                            $nm_rpl = "A2";
                        } else if ($jenis_rpl == 3) {
                            $nm_rpl = "A3";
                        }
                    }


                    ?>


                    <div class="row">
                        <div class="col-xl-12">


                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title mb-4">Form Matakuliah Transkrip</h4>
                                    <form enctype="multipart/form-data" method="POST"
                                        action="<?= base_url('generatemka1') ?>">
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                                <div class="row">
                                                    <label for="" class='col-md-12'>Perguruan Tinggi</label>
                                                    <div for="" class='col-md-4'>
                                                        <?php
                                                        if (isset($kdptasal)) {
                                                            if ($kdptasal == null) {
                                                                if (isset($ptasal)) {
                                                                    echo "<select class='form-select select2' name='ptasal' id='ptasal'><option value=''></option>";
                                                                    // foreach ($ptasal as $row) {
                                                                    // echo "<option  value='" . $row['nama_perguruan_tinggi'] . "'>" . $row['nama_perguruan_tinggi'] . "</option>";
                                                                    // };
                                                                    echo " </select>";
                                                                }
                                                            } else {
                                                        ?>
                                                        <input type="hidden" id='ptasal' class="form-control"
                                                            name='ptasa' value='<?= $kdptasal ?>' readonly />
                                                        <input type="text" id='nmptasal' class="form-control"
                                                            name='nmptasal' value='<?= $nmptasal ?>' readonly />
                                                        <?php

                                                            }
                                                        } else {
                                                            if (isset($ptasal)) {
                                                                echo "<select class='form-select select2' name='ptasal' id='ptasal'>";
                                                                // foreach ($ptasal as $row) {
                                                                //     echo "<option  value='" . $row['nama_perguruan_tinggi'] . "'>" . $row['nama_perguruan_tinggi'] . "</option>";
                                                                // };
                                                                echo " </select>";
                                                            }
                                                        }
                                                        ?>


                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <!-- <label for="">b</label> -->
                                                </div>
                                            </div>
                                        </div>



                                        <div class=" mt-3">
                                            <label for="">File Import</label>
                                            <input type="file" name="datamka1" class="form-control mb-3" id="">
                                            <span class="text-danger mt-3">Note: File Harus Sesuai dengan Template yang
                                                sudah
                                                disipakan <a href='<?= base_url() . "/template/template-mk-a1.xlsx" ?>'
                                                    target='_blank' class="btn btn-sm btn-danger">Unduh
                                                    Template</a></span>
                                        </div>

                                        <button type="submit" class="btn btn-primary ">Import</button>
                                    </form>
                                    <!-- daftar dokumen -->
                                    <h4 class="text-center">Daftar Matakuliah</h4>
                                    <div>
                                        <table class="table table-border">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="col-1">No</th>
                                                    <th class="col-2">Kode Matakuliah</th>
                                                    <th class="col-5">Nama Matakuliah</th>
                                                    <th class="col-2">SKS</th>
                                                    <th class="col-2">Nilai</th>

                                                </tr>
                                            </thead>
                                            <tbody id='tbody-mk'>
                                                <?php
                                                if (isset($dataGenerate)) {
                                                    echo $dataGenerate;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        if (isset($dataGenerate)) {
                                        ?>
                                        <button class="btn btn-primary" onclick="simpandata()">Simpan</button>
                                        <?php } ?>
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
var url = '<?= base_url('searchtpasal') ?>'
$('.select2').select2({
    ajax: {
        url: url,
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    }
});
$(document).ready(function() {
    // $('.select2').select2();
    $('#formRadios1').click(function() {
        $('#input-url').hide()
        $('#input-upload').show()
    })
    $('#formRadios2').click(function() {
        $('#input-url').show()
        $('#input-upload').hide()
    })

    $('.tambah-matakuliah-modal').on('show.bs.modal', function(e) {
        kdpt = $('#ptasal').val()
        if (kdpt == "") {
            alert('Pilih Perguruan Tinggi')
            // $('.tambah-matakuliah-modal').modal('hide')
            e.preventDefault(); // prevent the modal from being hidden
        } else {
            $('#mkode-pt').val(kdpt);
        }
        // if (someCondition) {}
    })

    $(".delete-matakuliah").on('click', function() {
        b = $(this).attr('kdmk')

        $('#ekdmk').val(b);
    });

})

function simpandata() {
    $('#loading').show()
    <?php if (isset($nmptasal) && $nmptasal != "") {
        ?>
    kdpt = '<?= $kdptasal ?>'
    nmpt = '<?= $nmptasal ?>'
    <?php
        } else {
        ?>
    kdpt = $('#ptasal').val()
    nmpt = $('#ptasal').text()
    <?php
        }
        ?>

    if (kdpt == "") {
        alert('Anda Belum memilih Perguruan Tinggi.')
        $('#loading').hide()

    } else {
        jsonObj = [];
        $('#tbody-mk  > tr').each(function(i, tr) {
            var kdmk = $(this).find("td[for=a]").html()
            var nmmk = $(this).find("td[for=b]").html();
            var sks = $(this).find("td[for=c]").html();
            var nilai = $(this).find("td[for=d]").html();

            item = {}
            item["kdpt"] = kdpt.trim();
            item["nmpt"] = nmpt.trim();
            item["kdmk"] = kdmk.trim();
            item["nmmk"] = nmmk.trim();
            item["sks"] = sks.trim();
            item["nilai"] = nilai.trim();

            jsonObj.push(item);
            // alert(desk);
        });
        url = '<?= base_url('simpanklaimimport') ?>'
        $.post(url, {
            jsonObj
        }).done(function(data) {
            $('#loading').hide()
            if (alert(data)) {} else {
                window.location.replace('<?= base_url('uploada1') ?>')
            };
        }).fail(function() {
            $('#loading').hide()
            alert("error");
        })
    }
}

function showModal(ini) {

    $('#btya').attr('iddokumen', ini)
    $('.confirmasi-modal').modal("show")
}

function hapus(ini) {
    $('#loading').show();
    url = '<?= base_url('deldok') ?>'
    nodokumen = ini.attr('iddokumen');
    $.post(url, {
        nodokumen: nodokumen
    }).done(function(data) {
        $('#loading').hide();
        $('.confirmasi-modal').modal("hide")
        if (alert(data)) {} else {
            window.location.replace('<?= base_url('upload') ?>')
        };

    })
}
</script>