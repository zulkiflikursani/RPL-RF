<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>


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

                    if (isset($basenilai)) {
                        $oknilai = "";
                        foreach ($basenilai as $row) {
                            $oknilai .= "<option value='" . $row['kode_nilai'] . "'>" . $row['kode_nilai'] . "</option>";
                        }
                    }


                    ?>


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
                                                    <table class='table table-bordered'>
                                                        <thead class=" table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>No regis</th>
                                                                <th>Nama Peserta</th>
                                                                <th>Nama Matakuliah</th>
                                                                <th>SKS</th>
                                                                <th>CPMK</th>
                                                                <th>Penguasaan</th>
                                                                <th>Deskripsi</th>
                                                                <th>Ref</th>
                                                                <th>Tanggapan</th>
                                                                <th style="width:100px">Nilai</th>
                                                                <th>Keterangan Tanggapan</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id='tbody-klaim-mk'>
                                                            <?php
                                                            print_r($dataKlaimMhs);

                                                            if (isset($dataKlaimMhs)) {
                                                                $namamatakulia = "";
                                                                $nopeserta = "";
                                                                $idcpmk = "";
                                                                $i = 0;
                                                                $jumlahdata = count($dataKlaimMhs);
                                                                $hitdata = 0;
                                                                foreach ($dataKlaimMhs as $row) {
                                                                    $hitdata++;
                                                                    if ($nopeserta == "") {
                                                                        $nopeserta = $row['no_peserta'];
                                                                        if ($namamatakulia == "") {
                                                                            $i++;
                                                                            $html = "";
                                                                            $namamatakulia = $row['nama_matakuliah'];
                                                                            $cpmk = $row['cpmk'];
                                                                            if ($row['jenis_matakuliah'] != NULL) {
                                                                                if ($row['jenis_matakuliah'] == '3') {
                                                                                    $jenismk = '(Wajib Prodi)';
                                                                                } else if ($row['jenis_matakuliah'] == '4') {
                                                                                    $jenismk = '(Wajib konsentrasi atau peminatan)';
                                                                                } else if ($row['jenis_matakuliah'] == '5') {
                                                                                    $jenismk = '(Pilihan)';
                                                                                } else if ($row['jenis_matakuliah'] == '6') {
                                                                                    $jenismk = '(Skripsi/thesis)';
                                                                                } else if ($row['jenis_matakuliah'] == '7') {
                                                                                    $jenismk = '(MBKM)';
                                                                                } else if ($row['jenis_matakuliah'] == '1') {
                                                                                    $jenismk = '(Umum)';
                                                                                } else if ($row['jenis_matakuliah'] == '2') {
                                                                                    $jenismk = '(Universitas)';
                                                                                } else {
                                                                                    $jenismk = "(" . $row['jenis_matakuliah'] . ")";
                                                                                }
                                                                            } else {
                                                                                $jenismk = "";
                                                                            }
                                                                            $count = 1;
                                                                            $html1 = [
                                                                                "kd_mk" => $row['kode_matakuliah'],
                                                                                "noregis" => $row['no_peserta'],
                                                                                "nama" => $row['nama'],
                                                                                "nama_matakuliah" => $row['nama_matakuliah'],
                                                                                "idcpmk" => $row['idcpmk'],
                                                                                "cpmk" => $row['cpmk'],
                                                                                "idklaim" => $row['idklaim'],
                                                                                "klaim" => $row['klaim'],
                                                                                "desk" => $row['desk'],
                                                                                "no_dokumen" => json_decode($row['no_dokumen']),
                                                                                "kode_matakuliah" => $row['kode_matakuliah'],
                                                                                "sks" => $row['sks'],
                                                                                'jenismk' => $jenismk,
                                                                                'ket_tanggapan' => $row['ket_tanggapan'],
                                                                                'tanggapan' => $row['tanggapan'],
                                                                                'nilai' => $row['nilai'],
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
                                                                                $html .= "</tr>";
                                                                            } else {
                                                                                $ref = "<td for='ref' nodok='" . $row['no_dokumen'] . "' rowspan='$count'>";
                                                                                foreach ($html1['no_dokumen'] as $a) {
                                                                                    $dataref = getnamafile($a);

                                                                                    $ref .= "<a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $dataref->nmfile_asli . "' target='_blank'><button class='btn btn-sm btn-warning mb-2'>" . $dataref->nmfile . "</button></a><br>";
                                                                                }
                                                                                $ref .= "</td>";
                                                                                echo "<tr noregis='" . $html1['noregis'] . "' idklaim='" . $html1['idklaim'] . "' idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "' kdprodi='" . $row['kode_prodi'] . "' >
                                                                                        <td for='namamk' rowspan='$count'>" . $i . "</td>
    
                                                                                        <td for='namamk' rowspan='$count'>" . $html1['noregis'] . "</td>
                                                                                        <td for='nama' rowspan='$count'>" . $html1['nama'] . "</td>
                                                                                        <td rowspan='$count'>" . $html1['nama_matakuliah']  . " " . $html1['jenismk'] . "</td>
                                                                                        <td rowspan='$count'>" . $html1['sks'] . "</td>
                                                                                        <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                        <td for='nilai' >" . $html1['klaim'] . "</td>
                                                                                        <td for='desk' rowspan='$count'> " . $html1['desk'] . "
                                                                                        </td>$ref<td for='tanggapan'  rowspan='$count' kdmk='" . $html1['kode_matakuliah'] . "'> " . $html1['tanggapan'] . "
                                                                                        </td>
                                                                                        <td rowspan='$count'>
                                                                                        " . $html1['nilai'] . "
                                                                                        </td>
                                                                                        <td for='kettanggapan' rowspan='$count'>
                                                                                        " . $html1['ket_tanggapan'] . "
                                                                                        </td>
                                                                                        </tr>" . $html;
                                                                                $i++;
                                                                                $html = "";
                                                                                $count = 1;
                                                                                $namamatakulia = $row['nama_matakuliah'];
                                                                                if ($row['jenis_matakuliah'] != NULL) {
                                                                                    if ($row['jenis_matakuliah'] == '3') {
                                                                                        $jenismk = '(Wajib Prodi)';
                                                                                    } else if ($row['jenis_matakuliah'] == '4') {
                                                                                        $jenismk = '(Wajib konsentrasi atau peminatan)';
                                                                                    } else if ($row['jenis_matakuliah'] == '5') {
                                                                                        $jenismk = '(Pilihan)';
                                                                                    } else if ($row['jenis_matakuliah'] == '6') {
                                                                                        $jenismk = '(Skripsi/thesis)';
                                                                                    } else if ($row['jenis_matakuliah'] == '7') {
                                                                                        $jenismk = '(MBKM)';
                                                                                    } else if ($row['jenis_matakuliah'] == '1') {
                                                                                        $jenismk = '(Umum)';
                                                                                    } else if ($row['jenis_matakuliah'] == '2') {
                                                                                        $jenismk = '(Universitas)';
                                                                                    } else {
                                                                                        $jenismk = "(" . $row['jenis_matakuliah'] . ")";
                                                                                    }
                                                                                } else {
                                                                                    $jenismk = "";
                                                                                }
                                                                                $html1 = [
                                                                                    "kd_mk" => $row['kode_matakuliah'],
                                                                                    "noregis" => $row['no_peserta'],
                                                                                    "nama" => $row['nama'],
                                                                                    "nama_matakuliah" => $row['nama_matakuliah'],
                                                                                    "idklaim" => $row['idklaim'],
                                                                                    "idcpmk" => $row['idcpmk'],
                                                                                    "cpmk" => $row['cpmk'],
                                                                                    "desk" => $row['desk'],

                                                                                    "klaim" => $row['klaim'],
                                                                                    "no_dokumen" => json_decode($row['no_dokumen']),
                                                                                    "kode_matakuliah" => $row['kode_matakuliah'],
                                                                                    "sks" => $row['sks'],
                                                                                    'jenismk' => $jenismk,
                                                                                    'ket_tanggapan' => $row['ket_tanggapan'],
                                                                                    'tanggapan' => $row['tanggapan'],
                                                                                    'nilai' => $row['nilai'],

                                                                                ];
                                                                            }

                                                                            if ($hitdata == $jumlahdata) {
                                                                                $ref = "<td for='ref' nodok='" . $row['no_dokumen'] . "' rowspan='$count'>";
                                                                                // $dokaarray = json_decode($html1['no_dokumen']);
                                                                                foreach ($html1['no_dokumen'] as $a) {
                                                                                    $dataref = getnamafile($a);

                                                                                    $ref .= "<a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $dataref->nmfile_asli . "' target='_blank'><button class='btn btn-sm btn-warning mb-2'>" . $dataref->nmfile . "</button></a><br>";
                                                                                }
                                                                                $ref .= "</td>";
                                                                                echo "<tr noregis='$noregis' idklaim='" . $html1['idklaim'] . "' idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "' kdprodi='" . $row['kode_prodi'] . "'>
                                                                                <td for='namamk' rowspan='$count'>" . $i . "</td>
                                                                                 <td for='namamk' rowspan='$count'>" . $html1['noregis'] . "</td> <td for='namamk' rowspan='$count'>" . $html1['nama'] . "</td>
                                                                                        <td rowspan='$count'>" . $html1['nama_matakuliah'] . " " . $html1['jenismk'] . "</td>
                                                                                        <td rowspan='$count'>" . $html1['sks'] . "</td>
                                                                                        <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                        <td for='nilai' >" . $html1['klaim'] . "</td>
                                                                                        <td for='desk' rowspan='$count'><textarea style='border: none; width: 100%;  height: 100%;resize: vertical;min-height:200px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;' readonly>" . $html1['desk'] . "
                                                                                        </textarea>
                                                                                        </td>$ref
                                                                                        <td for='tanggapan' rowspan='$count' >
                                                                                        <select class='form-select' onchange='setnilaiAsFromStatus($(this))'>
                                                                                        <option value=''>Pilih</option required>
                                                                                        <option value='0'>Ok</option>
                                                                                        <option value='1'>Butuh Tindakan</option>
                                                                                        </select></td><td for='nilaiAs'  rowspan='$count'>
                                                                                        <select class='form-select' onchange='gantinilai()' required>
                                                                                        <option value='' selected >Pilih</option>    
                                                                                        $oknilai    
                                                                                        </select></td>
                                                                                        <td for='kettanggapan' rowspan='$count'><textarea style='border: none; width: 100%;  height: 100%;resize: vertical;min-height:200px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;' required> </textarea>
                                                                                        </td>
                                                                                        </tr>" . $html;
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($nopeserta == $row['no_peserta']) {
                                                                            if ($namamatakulia == "") {
                                                                                $i++;
                                                                                $html = "";
                                                                                $namamatakulia = $row['nama_matakuliah'];
                                                                                $cpmk = $row['cpmk'];
                                                                                if ($row['jenis_matakuliah'] != NULL) {
                                                                                    if ($row['jenis_matakuliah'] == '3') {
                                                                                        $jenismk = '(Wajib Prodi)';
                                                                                    } else if ($row['jenis_matakuliah'] == '4') {
                                                                                        $jenismk = '(Wajib konsentrasi atau peminatan)';
                                                                                    } else if ($row['jenis_matakuliah'] == '5') {
                                                                                        $jenismk = '(Pilihan)';
                                                                                    } else if ($row['jenis_matakuliah'] == '6') {
                                                                                        $jenismk = '(Skripsi/thesis)';
                                                                                    } else if ($row['jenis_matakuliah'] == '7') {
                                                                                        $jenismk = '(MBKM)';
                                                                                    } else if ($row['jenis_matakuliah'] == '1') {
                                                                                        $jenismk = '(Umum)';
                                                                                    } else if ($row['jenis_matakuliah'] == '2') {
                                                                                        $jenismk = '(Universitas)';
                                                                                    } else {
                                                                                        $jenismk = "(" . $row['jenis_matakuliah'] . ")";
                                                                                    }
                                                                                } else {
                                                                                    $jenismk = "";
                                                                                }
                                                                                $count = 1;
                                                                                $html1 = [
                                                                                    "kd_mk" => $row['kode_matakuliah'],
                                                                                    "noregis" => $row['no_peserta'],
                                                                                    "nama" => $row['nama'],
                                                                                    "nama_matakuliah" => $row['nama_matakuliah'],
                                                                                    "idcpmk" => $row['idcpmk'],
                                                                                    "cpmk" => $row['cpmk'],
                                                                                    "idklaim" => $row['idklaim'],
                                                                                    "klaim" => $row['klaim'],
                                                                                    "desk" => $row['desk'],
                                                                                    "no_dokumen" => json_decode($row['no_dokumen']),
                                                                                    "kode_matakuliah" => $row['kode_matakuliah'],
                                                                                    "sks" => $row['sks'],
                                                                                    'jenismk' => $jenismk,
                                                                                    'ket_tanggapan' => $row['ket_tanggapan'],
                                                                                    'tanggapan' => $row['tanggapan'],
                                                                                    'nilai' => $row['nilai'],
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
                                                                                    $html .= "</tr>";
                                                                                } else {
                                                                                    $ref = "<td for='ref' nodok='" . $row['no_dokumen'] . "' rowspan='$count'>";
                                                                                    foreach ($html1['no_dokumen'] as $a) {
                                                                                        $dataref = getnamafile($a);

                                                                                        $ref .= "<a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $dataref->nmfile_asli . "' target='_blank'><button class='btn btn-sm btn-warning mb-2'>" . $dataref->nmfile . "</button></a><br>";
                                                                                    }
                                                                                    $ref .= "</td>";
                                                                                    echo "<tr noregis='" . $html1['noregis'] . "' idklaim='" . $html1['idklaim'] . "' idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "' kdprodi='" . $row['kode_prodi'] . "' >
                                                                                            <td for='namamk' rowspan='$count'>" . $i . "</td>
        
                                                                                            <td for='namamk' rowspan='$count'>" . $html1['noregis'] . "</td>
                                                                                            <td for='nama' rowspan='$count'>" . $html1['nama'] . "</td>
                                                                                            <td rowspan='$count'>" . $html1['nama_matakuliah']  . " " . $html1['jenismk'] . "</td>
                                                                                            <td rowspan='$count'>" . $html1['sks'] . "</td>
                                                                                            <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                            <td for='nilai' >" . $html1['klaim'] . "</td>
                                                                                            <td for='desk' rowspan='$count'> " . $html1['desk'] . "
                                                                                            </td>$ref<td for='tanggapan'  rowspan='$count' kdmk='" . $html1['kode_matakuliah'] . "'> " . $html1['tanggapan'] . "
                                                                                            </td>
                                                                                            <td rowspan='$count'>
                                                                                            " . $html1['nilai'] . "
                                                                                            </td>
                                                                                            <td for='kettanggapan' rowspan='$count'>
                                                                                            " . $html1['ket_tanggapan'] . "
                                                                                            </td>
                                                                                            </tr>" . $html;
                                                                                    $i++;
                                                                                    $html = "";
                                                                                    $count = 1;
                                                                                    $namamatakulia = $row['nama_matakuliah'];
                                                                                    if ($row['jenis_matakuliah'] != NULL) {
                                                                                        if ($row['jenis_matakuliah'] == '3') {
                                                                                            $jenismk = '(Wajib Prodi)';
                                                                                        } else if ($row['jenis_matakuliah'] == '4') {
                                                                                            $jenismk = '(Wajib konsentrasi atau peminatan)';
                                                                                        } else if ($row['jenis_matakuliah'] == '5') {
                                                                                            $jenismk = '(Pilihan)';
                                                                                        } else if ($row['jenis_matakuliah'] == '6') {
                                                                                            $jenismk = '(Skripsi/thesis)';
                                                                                        } else if ($row['jenis_matakuliah'] == '7') {
                                                                                            $jenismk = '(MBKM)';
                                                                                        } else if ($row['jenis_matakuliah'] == '1') {
                                                                                            $jenismk = '(Umum)';
                                                                                        } else if ($row['jenis_matakuliah'] == '2') {
                                                                                            $jenismk = '(Universitas)';
                                                                                        } else {
                                                                                            $jenismk = "(" . $row['jenis_matakuliah'] . ")";
                                                                                        }
                                                                                    } else {
                                                                                        $jenismk = "";
                                                                                    }
                                                                                    $html1 = [
                                                                                        "kd_mk" => $row['kode_matakuliah'],
                                                                                        "noregis" => $row['no_peserta'],
                                                                                        "nama" => $row['nama'],
                                                                                        "nama_matakuliah" => $row['nama_matakuliah'],
                                                                                        "idklaim" => $row['idklaim'],
                                                                                        "idcpmk" => $row['idcpmk'],
                                                                                        "cpmk" => $row['cpmk'],
                                                                                        "desk" => $row['desk'],

                                                                                        "klaim" => $row['klaim'],
                                                                                        "no_dokumen" => json_decode($row['no_dokumen']),
                                                                                        "kode_matakuliah" => $row['kode_matakuliah'],
                                                                                        "sks" => $row['sks'],
                                                                                        'jenismk' => $jenismk,
                                                                                        'ket_tanggapan' => $row['ket_tanggapan'],
                                                                                        'tanggapan' => $row['tanggapan'],
                                                                                        'nilai' => $row['nilai'],

                                                                                    ];
                                                                                }

                                                                                if ($hitdata == $jumlahdata) {
                                                                                    $ref = "<td for='ref' nodok='" . $row['no_dokumen'] . "' rowspan='$count'>";
                                                                                    // $dokaarray = json_decode($html1['no_dokumen']);
                                                                                    foreach ($html1['no_dokumen'] as $a) {
                                                                                        $dataref = getnamafile($a);

                                                                                        $ref .= "<a href='" . base_url() . "/uploads/berkas/" . $row['no_peserta'] . "/" . $dataref->nmfile_asli . "' target='_blank'><button class='btn btn-sm btn-warning mb-2'>" . $dataref->nmfile . "</button></a><br>";
                                                                                    }
                                                                                    $ref .= "</td>";
                                                                                    echo "<tr noregis='$noregis' idklaim='" . $html1['idklaim'] . "' idcpmk='" . $html1['idcpmk'] . "' kdmk='" . $html1['kd_mk'] . "' namamk='" . $html1['nama_matakuliah'] . "' sks='" . $html1['sks'] . "' kdprodi='" . $row['kode_prodi'] . "'>
                                                                                    <td for='namamk' rowspan='$count'>" . $i . "</td>
                                                                                     <td for='namamk' rowspan='$count'>" . $html1['noregis'] . "</td> <td for='namamk' rowspan='$count'>" . $html1['nama'] . "</td>
                                                                                            <td rowspan='$count'>" . $html1['nama_matakuliah'] . " " . $html1['jenismk'] . "</td>
                                                                                            <td rowspan='$count'>" . $html1['sks'] . "</td>
                                                                                            <td for='cpmk' >" . $html1['cpmk'] . "</td>
                                                                                            <td for='nilai' >" . $html1['klaim'] . "</td>
                                                                                            <td for='desk' rowspan='$count'><textarea style='border: none; width: 100%;  height: 100%;resize: vertical;min-height:200px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;' readonly>" . $html1['desk'] . "
                                                                                            </textarea>
                                                                                            </td>$ref
                                                                                            <td for='tanggapan' rowspan='$count' >
                                                                                            <select class='form-select' onchange='setnilaiAsFromStatus($(this))'>
                                                                                            <option value=''>Pilih</option required>
                                                                                            <option value='0'>Ok</option>
                                                                                            <option value='1'>Butuh Tindakan</option>
                                                                                            </select></td><td for='nilaiAs'  rowspan='$count'>
                                                                                            <select class='form-select' onchange='gantinilai()' required>
                                                                                            <option value='' selected >Pilih</option>    
                                                                                            $oknilai    
                                                                                            </select></td>
                                                                                            <td for='kettanggapan' rowspan='$count'><textarea style='border: none; width: 100%;  height: 100%;resize: vertical;min-height:200px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;' required> </textarea>
                                                                                            </td>
                                                                                            </tr>" . $html;
                                                                                }
                                                                            }
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



                                        <div class="d-flex justify-content-between ">

                                            <button type="button" onclick="" id="btn-simpan"
                                                class="btn btn-primary w-md">Simpan</button>
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
