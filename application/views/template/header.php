<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('title'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">

    <script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/app.min.js'); ?>"></script>

    <script>
        $(document).ready(function() {
            var t = $('#dataTables1').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "responsive": true,
                "bLengthChange": true,
                "bInfo": true,
                "oLanguage": {
                    "sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
                    "sLengthMenu": "_MENU_ &nbsp;&nbsp;data per halaman",
                    "sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
                    "sInfoEmpty": "",
                    "sInfoFiltered": "(difilter dari _MAX_ total data)",
                    "sZeroRecords": "Pencarian tidak ditemukan",
                    "sEmptyTable": "Tidak ada data"
                }
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });

        });
    </script>

</head>

<body class="hold-transition skin-purple-light layout-top-nav">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="<?php echo site_url(); ?>" class="navbar-brand"><b><?php echo $this->config->item('title'); ?></b></a>
                    </div>
                </div>
            </nav>

            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php $this->load->view('template/menu'); ?>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">