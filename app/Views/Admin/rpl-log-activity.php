<!doctype html>
<html lang="en">

<head>
    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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


                    // if (isset($status)) {
                    //     if ($status == true) {
                    //         echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                    //     aria-label="Close"></button></div>';
                    //     }
                    // }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Log Aktivitas Pengguna</h4>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <select name="month" id='month' class="form-select">
                                                <?php
                                                // Array of months with corresponding numeric values
                                                $months = array(
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'October',
                                                    11 => 'Nopember',
                                                    12 => 'Desember'
                                                );

                                                // Loop through each month and create an option element for it
                                                foreach ($months as $monthNumber => $monthName) {
                                                    echo "<option value='$monthNumber'>$monthName</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class='col-md-3'>
                                            <select name="year" id='year' class="form-select">
                                                <?php
                                                // Array of months with corresponding numeric values


                                                // Loop through each month and create an option element for it

                                                // Get the current year
                                                $currentYear = date('Y');

                                                // Generate options for the current year and the two years before and after
                                                for ($i = $currentYear - 2; $i <= $currentYear + 2; $i++) {
                                                    if ($i == $currentYear) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo "<option value='$i' $selected>$i</option>";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary mb-3" onclick="tampilkan()">Tampilkan</button>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered table-log ">
                                                <thead class="align-middle text-center table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Email</th>
                                                        <th>Jenis Aktivitas</th>
                                                        <th>Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tbody'>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="card-title mb-4">Data Status Klaim Mahasiswa</h4>
                                    <div class="row">
                                        <div class="col-lg-12">

                                        </div>
                                    </div>   -->
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
    <!-- data-table -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- Responsive examples -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            table = $('.table-log').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            })
        })

        function tampilkan() {
            month = $('#month').val();
            year = $('#year').val();
            url = '<?= base_url('getlog') ?>'
            table = $('.table-log').DataTable()
            table.clear().draw();


            // alert(year + ' ' + month)
            $.post(url, {
                month: month,
                year: year
            }, function(data) {
                console.table(data)
                data = JSON.parse(data)
                $.each(data, function(i, v) {
                    no = 1 + i;
                    if (v['jenis_activity'] == 1) {
                        jenis_aktivity = 'Login'
                    } else {
                        jenis_aktivity = ''
                    }
                    table.row.add([no, v['user_id'], jenis_aktivity, v['tgl_activity']]).draw()

                })


            });

        }
    </script>
</body>

</html>