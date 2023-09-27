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
                        if (count($dataerror) == 0) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo 'Data tidak ditemukan';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            foreach ($dataerror as $error) {

                                echo $error . "</br>";
                            };
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                        }
                    }

                    if (isset($status)) {
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Reset Password. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Pengguna</h4>

                                    <div class="col-12">
                                        <div class="row">
                                            <form method="POST" action="<?= base_url("resetmhs") ?>" class="col-md-6">

                                                <div class="mb-3">
                                                    <label for="formrow-nama-input" class="form-label">No
                                                        Registrasi/Nama Mahasiswa </label>
                                                    <input list="suggestionList" id="mkInput" class='form-control' autocomplete="off">
                                                    <datalist id="suggestionList" class="col-md-12" style="width: 100%;">
                                                        <?php
                                                        if (isset($dataMhs)) {
                                                            foreach ($dataMhs as $row) {
                                                                echo "<option data-value='" . $row['no_peserta'] . "' email='" . $row['email'] . "' >" . $row['no_peserta'] . " : " . $row['nama'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <option data-value="45">1032 : 345sdfg</option> -->
                                                    </datalist>
                                                </div>
                                                <div class="mb-3">

                                                    <label for="formrow-nama-input" class="form-label">No
                                                        Registrasi </label>
                                                    <input type="text" class="form-control" name="noregis" id="mkInput-noregis" readonly>
                                                </div>
                                                <div class="mb-3">

                                                    <label for="formrow-nama-input" class="form-label">Email </label>
                                                    <input type="text" class="form-control" name="eemail" id="mkInput-email" readonly>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-primary mb-3">Reset Password</button>
                                                    <a class="btn btn-primary mb-3" onclick="editbiodate()">Edit
                                                        Biodata</a>
                                                </div>

                                            </form>
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

    <script>
        document.querySelector('input[list]').addEventListener('input', function(e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                noregis = document.getElementById(input.getAttribute('id') + '-noregis'),
                email = document.getElementById(input.getAttribute('id') + '-email'),
                inputValue = input.value;

            noregis.value = inputValue;
            email.value = inputValue;
            // alert(inputValue)
            if (noregis.value == email.value) {
                noregis.value = "";
                email.value = "";
            }


            for (var i = 0; i < options.length; i++) {
                var option = options[i];

                if (option.innerText === inputValue) {
                    noregis.value = option.getAttribute('data-value');
                    email.value = option.getAttribute('email');
                    if (noregis.value == email.value) {
                        alert("Silahkan klik opsi mahasiswa.! data tidak ditemukan")
                        noregis.value = "";
                        email.value = "";
                    }
                    break;
                }
            }


        });

        function editbiodate() {
            nopeserta = $('#mkInput-noregis').val()
            if (nopeserta == "") {
                alert("Silahkan Pilih Mahasiswa terlebih dahulu !")
            } else {
                window.location.href = '<?= base_url("biodata-mahasiswa") ?>/' + nopeserta;
            }

        }
    </script>
</body>

</html>