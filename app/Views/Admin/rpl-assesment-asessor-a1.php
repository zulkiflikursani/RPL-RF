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

                    <div class="modal fade batal-klaim-modal" tabindex="-1" role="dialog"
                        aria-labelledby="batal-klaim-modal" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content col-12">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Konfirmasi
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- content -->
                                    <div>
                                        <div class="row">
                                            <label for="">Pembatalan ajuan peserta RPL akan menyebabkan klaim asessor
                                                yang sudah dilakukan sebelum TERHAPUS, lanjut batalkan ajuan?</label>
                                        </div>
                                        <input type="hidden" id='enoregis' name='noregis' value='<?= $noregis ?>'
                                            readonly>
                                        <div>
                                            <button type="button" onclick="batalklaimdoka1()"
                                                class="btn btn-primary w-md">Ya</button>
                                            <button type="button" class="btn btn-primary w-md" data-bs-dismiss="modal"
                                                aria-label="Close"> Tidak</button>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Form Assesment RPL</h4>
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
                                                    <div class="row">

                                                        <div class="col-md-2">Dokumen Referensi</div>
                                                        <div class="col-md-2">:
                                                            <?= $data_dok[0] ?
                                                                "<a class='btn btn-sm btn-warning' href='" . base_url() . "/" . $data_dok[0]['lokasi_file'] . "/" . $data_dok[0]['nmfile_asli'] . "' target='_blank'>" . $data_dok[0]['nmfile'] . "</a>" :  'Tidak ada Dokumen Referensi'; ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-1">
                                                        <div class="col-md-2">Matakuliah Klaim</div>
                                                        <div class="col-md-2">:
                                                            <?= $noregis ?
                                                                "<a class='btn btn-sm btn-primary' href='" . base_url() . "/print-klaim-a1/$noregis' target='_blank'>Lihat</a>" :  'Tidak ada Dokumen Referensi'; ?>
                                                            <button class="btn btn-danger btn-sm "
                                                                onclick="showmodal()">Batal Klaim</button>
                                                        </div>


                                                    </div>


                                                    <h3>Matakuliah Asal</h3>
                                                    <div class="row col-md-12">
                                                        <label class="col-md-2">Nama Perguruan Tinggi</label>
                                                        <label class="col-md-3">:
                                                            <?php echo $datamatakuliah[0]['nama_perguruan_tinggi'] ?></label>

                                                    </div>


                                                    <div class="row col-md-12 mb-3">
                                                        <div class="col-md-2">
                                                            <label for="">Kode Matakuliah</label>
                                                            <select for="" id='kdmka' class="form-select select2">
                                                                <option value=''>Pilih Matakuliah Asal</option>
                                                                <?php

                                                                if (isset($datamatakuliah)) {
                                                                    foreach ($datamatakuliah as $row) {
                                                                        echo "<option value='" . $row['kode_matakuliah'] . "' sks='" . $row['jumlah_sks'] . "' nilai='" . $row['nilai'] . "' nmmk='" . $row['nama_matakuliah'] . "'>" . $row['kode_matakuliah'] . ":" . $row['nama_matakuliah'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="">Nama Matakuliah</label>
                                                            <input for="" class="form-control" readonly id="nmmka" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Jumlah SKS</label>
                                                            <input for="" class="form-control" readonly id="sksa" />

                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Nilai</label>
                                                            <input for="" class="form-control" readonly id="nilaia" />

                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="" class="col-md-2"></label>
                                                            <button onclick='tambahkan()'
                                                                class="btn btn-primary col-md-12 mt-2">Tambahakan</button>
                                                        </div>
                                                    </div>
                                                    <table class='table table-bordered'>
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kode Matakuliah</th>
                                                                <th>Nama Matakuliah</th>
                                                                <th>SKS</th>
                                                                <th>Nilai</th>
                                                                <th>Aksi</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-mk-asal'>
                                                            <?php
                                                            // print_r($dataKlaimMhs);

                                                            ?>
                                                        </tbody>
                                                    </table>

                                                    <div class="row">
                                                        <h3>Matakuliah Unifa</h3>
                                                        <div class="col-md-6 row mt-2 mb-2">
                                                            <div class="row">
                                                                <label for="" class="label form-label col-md-4">Kode
                                                                    Matakuliah</label>
                                                                <div class="col-md-8">
                                                                    <select for="" id='kdmk'
                                                                        class="form-select select2 col-3">
                                                                        <option value=''>Pilih Matakuliah </option>

                                                                        <?php
                                                                        if (isset($mkrplprodi)) {

                                                                            foreach ($mkrplprodi as $row) {

                                                                                echo "<option value ='$row->kode_matakuliah' nmmk='$row->nama_matakuliah' sks='$row->sks' >$row->kode_matakuliah : $row->nama_matakuliah</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <label for="" class="label form-label col-md-4">Nama
                                                                    Matakuliah</label>
                                                                <div class="col-md-8">
                                                                    <input for="" class="form-control" readonly
                                                                        id="nmmk" />

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row mt-2 mb-2">
                                                            <!-- <h3>Matakuliah Asal</h3> -->
                                                            <div class="row ">

                                                                <label for="" class="col-md-2">Jumlah SKS</label>
                                                                <div class="col-md-6">
                                                                    <input for="" class="form-control" readonly
                                                                        id="sks" />

                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">

                                                                <label for="" class="col-md-2">Nilai</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="nilai" id="nilai"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="button" onclick="simpan_klaim_asessor()"
                                                            class="btn btn-primary w-md">Klaim Matakuliah</button>

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
                                                                <th>Aksi</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-klaim-mk'>
                                                            <?php


                                                            if (isset($dataKlaimAsessorA1)) {
                                                                $kdmk = "";
                                                                $no = 0;
                                                                $jumlahklaimsks = 0;
                                                                foreach ($dataKlaimAsessorA1 as $row) {
                                                                    $jumlahklaimsks = floatval($jumlahklaimsks) + floatval($row->sks);
                                                                    if ($kdmk != $row->kode_matakuliah) {
                                                                        $no++;
                                                                        echo "<tr noregis='$row->no_peserta' idklaim='$row->idklaim'
                                                                        kdmk='$row->kode_matakuliah'
                                                                        kdprodi='$row->kode_prodi'
                                                                        nmmk='$row->nama_matakuliah'
                                                                        sks='$row->sks'
                                                                        nilai='$row->nilai'><td rowspan='$row->entry_count'>$no</td><td rowspan='$row->entry_count'>$row->kode_matakuliah</td>
                                                                        <td rowspan='$row->entry_count'>$row->nama_matakuliah</td>
                                                                        <td rowspan='$row->entry_count'>$row->sks</td><td rowspan='$row->entry_count'>$row->nilai</td><td >$row->nama_matakuliah_asal</td><td>$row->jumlah_sks</td><td>$row->nilai_asal</td><td rowspan='$row->entry_count'><button class='btn btn-sm btn-warning' 
                                                                        idklaim='$row->idklaim'
                                                                        onclick='batalklaima1($(this))'>Batal Klaim</button></td></tr>";
                                                                        $kdmk = $row->kode_matakuliah;
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
                                                                // echo $jumlahklaimsks . " ," . $maxsksrekognisi;
                                                                echo "Jumlah Klaim Matakuliah : $jumlahklaimsks SKS dari $maxsksrekognisi maksimum SKS Rekognisi";
                                                                if (floatval($jumlahklaimsks) > floatval($maxsksrekognisi)) {
                                                                    echo "<p class='text-danger bold'>Klaim Matakuliah Mahasiswa Melebihi Batas Klaim Rekognisi</p>";
                                                                };
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>



                                        <div>
                                            <button type="button" onclick="submit_klaim_asessor()"
                                                class="btn btn-primary w-md">Submit</button>

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
    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>

<script>
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

function showmodal() {
    // alert('s')
    $('.batal-klaim-modal').modal("show");
}
$(document).ready(function() {

    $('.select2').select2({
        placeholder: "Pilih Kode Matakuliah",

    })

    $('#kdmk').on("change", function(e) {
        nmmk = $(this).find('option:selected').attr('nmmk');
        sks = $(this).find('option:selected').attr('sks');

        $('#nmmk').val(nmmk)
        $('#sks').val(sks)
    });
    $('#kdmka').on("change", function(e) {
        nmmk = $(this).find('option:selected').attr('nmmk');
        sks = $(this).find('option:selected').attr('sks');
        nilai = $(this).find('option:selected').attr('nilai');

        $('#nmmka').val(nmmk)
        $('#sksa').val(sks)
        $('#nilaia').val(nilai)
    });

    // $('#loading').show()
    // noregis = '<?= $noregis ?>'
    // url = '<?= base_url('getDataKlaimAsessor') ?>'
    // $.post(url, {
    //     noregis: noregis
    // }, function(data) {
    //     data = JSON.parse(data)
    //     console.log(data);
    //     $.each(data, function(index, value) {
    //         $('#tbody-klaim-mk  > tr').each(function(i, tr) {
    //             if ($(this).attr('noregis') == noregis && $(this).attr(
    //                     'idklaim') ==
    //                 value['idklaim']) {
    //                 // alert('jalan')
    //                 $(this).find('td[for=tanggapan]').children().val(value[
    //                     'tanggapan']);
    //                 $(this).find('td[for=nilaiAs]').children().val(value[
    //                     'nilai']);
    //                 $(this).find('td[for=kettanggapan]').children()
    //                     .val(value['ket_tanggapan']);

    //             }
    //         })
    //     })
    //     $('#loading').hide()
    // }).fail(function() {
    //     alert("error");
    // });
})

function batalklaimdoka1() {
    noregis = $('#enoregis').val();
    url = '<?= base_url('batalklaimdokA1') ?>'
    $.post(url, {
        noregis: noregis
    }, function(data) {
        $('#loading').hide()
        if (alert(data)) {} else {
            window.location.reload()
        };
    }).fail(function() {
        $('#loading').hide()
        if (alert("Gagal Membatalkan Klaim")) {} else {
            window.location.reload()
        };
    });
}

function batalklaima1(a) {
    idklaim = a.attr('idklaim')

    url = '<?= base_url('batalklaimmkAsessorA1') ?>'
    $.post(url, {
        idklaim: idklaim
    }, function(data) {
        $('#loading').hide()
        if (alert(data)) {} else {
            window.location.reload()
        };
    }).fail(function() {
        $('#loading').hide()
        if (alert("Gagal Melakukan Klaim")) {} else {
            window.location.reload()
        };
    });
}

function remove(ini) {
    ini.parent().parent().remove();
}

function tambahkan() {
    $('#loading').show()

    kdmk = $('#kdmka').val()
    nmmk = $('#nmmka').val()
    sks = $('#sksa').val()
    nilai = $('#nilaia').val()
    no = $('#tbody-mk-asal tr').length + 1;
    flag = 0;
    $('#tbody-mk-asal tr').each(function() {
        a = $(this).find("td[for='kdmk']").html()
        // alert(a + ":" + kdmk);
        if (a == kdmk) {
            flag = 1;
        }
    })
    if (flag == 0) {
        $('#tbody-mk-asal').append("<tr><td for=''>" + no + "</td><td for='kdmk'>" + kdmk +
            "</td><td for='nmmk'>" +
            nmmk +
            "</td><td for='sks'>" + sks + "</td><td for='nilai'>" + nilai +
            "</td><td><button onclick='remove($(this))' class='btn btn-sm btn-warning'>Hapus</button></a></td></tr>"
        )
        $('#kdmka').val(null).trigger("change");
        $('#nmmka').val("")
        $('#sksa').val("")
        $('#nilaia').val("")
        $('#loading').hide()

    } else {
        alert("Kode Matakuliah yang anda pilih sudah ditambahkan")
        $('#loading').hide()

    }
}

function simpan_klaim_asessor() {
    $('#loading').show()
    kdmk = $('#kdmk').val()
    nmmk = $('#nmmk').val()
    sks = $('#sks').val()
    nilai = $('#nilai').val()

    klaimsks = '<?= $jumlahklaimsks ?>'
    klaimsksmax = '<?= $maxsksrekognisi ?>'

    sksakandiklaim = parseFloat(klaimsks) + parseFloat(sks);


    jsonObj = [];
    statusdata = 0;
    $('#tbody-mk-asal > tr').each(function(i, tr) {
        kdmka = $(this).find('td[for=kdmk]').html();
        nmmka = $(this).find('td[for=nmmk]').html();
        sksa = $(this).find('td[for=sks]').html();
        nilaia = $(this).find('td[for=nilai]').html();
        if (kdmk != "" && nmmk != "" && sks != "" && nilai != "" && kdmka != "" &&
            nmmka != "" && sksa != "" && nilaia != "") {
            item = {}
            item["noregis"] = '<?= $noregis ?>';
            item["kdmk"] = kdmk;
            item["nmmk"] = nmmk;
            item["sks"] = sks;
            item["nilai"] = nilai.toUpperCase();
            item["kdmka"] = kdmka;
            item["nmmka"] = nmmka;
            item["sksa"] = sksa;
            item["nilaia"] = nilaia;

            jsonObj.push(item);

        } else {
            statusdata = 1
        }
    })
    if (statusdata == 1) {
        alert("Silahkan Lengkapi Tanggapan Anda !")
        $('#loading').hide()
    } else if (sksakandiklaim > parseFloat(klaimsksmax)) {
        alert("Klaim Matakuliah Melebihi batas maksimum sks rekognisi Prodi")
        $('#loading').hide()
    } else {
        // console.log(jsonObj)
        url = '<?= base_url('klaimmkAsessorA1') ?>'
        $.post(url, {
            jsonObj: jsonObj
        }, function(data) {
            $('#loading').hide()
            if (alert("Berhasil Melakukan Klaim")) {} else {
                window.location.reload()
            };
        }).fail(function() {
            $('#loading').hide()
            if (alert("Gagal Melakukan Klaim. Data matakuliah asal belum ditambahkan")) {} else {
                window.location.reload()
            };
        });
    }
}

function submit_klaim_asessor() {
    $('#loading').show()
    jsonObj = [];
    statusdata = 0;
    $('#tbody-klaim-mk  > tr').each(function(i, tr) {

        if ($(this).attr('noregis') != undefined) {
            idklaim = $(this).attr('idklaim')
            no_peserta = $(this).attr('noregis')
            kdprodi = $(this).attr('kdprodi')
            kdmk = $(this).attr('kdmk')
            nilai = $(this).attr('nilai')
            tanggapan = "0"
            kettanggapan = "ok";
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
        $('#loading').hide()
    } else {
        url = '<?= base_url('klaimmkAsessor') ?>'
        $.post(url, {
            jsonObj
        }, function(data) {
            $('#loading').hide()
            if (alert("Berhasil melakukan submit")) {} else {
                window.location.replace('<?= base_url('Admin') ?>')
            };
        }).fail(function() {
            $('#loading').hide()
            if (alert("error")) {} else {
                window.location.replace('<?= base_url('Admin') ?>')
            };
        });
    }
}
</script>