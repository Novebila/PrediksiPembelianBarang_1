<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Training</h3>
        <div class="box-tools">
            <a href="<?php echo site_url('training/tambah'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data Training</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTables1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Order</th>
                        <th>Penjualan</th>
                        <th>Stok</th>
                        <th>Pembelian</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($training as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row['nama_produk']; ?></td>
                            <td><?php echo $row['bulan']; ?></td>
                            <td><?php echo $row['tahun']; ?></td>
                            <td><?php echo $row['orders']; ?></td>
                            <td><?php echo $row['shipment']; ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td><?php echo $row['produksi']; ?></td>
                            <td>
                                <a href="<?php echo site_url('training/ubah/' . $row['id_training']); ?>" class="btn btn-success btn-xs"><span class="fa fa-pencil"></span> Ubah</a>
                                <a href="#" data-href="<?php echo site_url('training/hapus/' . $row['id_training']); ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer'); ?>