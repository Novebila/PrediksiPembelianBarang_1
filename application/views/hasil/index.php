<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Hasil Prediksi</h3>
        <div class="box-tools">
            <a href="<?php echo site_url('hasil/pdf'); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> PDF</a>
        </div>
    </div>
    <div class="box-body">
        <div class="alert bg-info text-center" role="alert">
            <p class="fs-2">Estimasi Nilai Kesalahan (Error) : <?= round($mse, 2) ?>%</p>
            <small>Dihitung dengan rumus <strong>Mean Squared Error (MSE)</strong> dimana semakin kecil nilai maka semakin baik</small>
        </div>
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
                        <th>Prediksi</th>
                        <th>Aktual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hasil as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row['nama_produk']; ?></td>
                            <td><?php echo $row['bulan']; ?></td>
                            <td><?php echo $row['tahun']; ?></td>
                            <td><?php echo $row['orders']; ?></td>
                            <td><?php echo $row['shipment']; ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td><?php echo $row['produksi_prediksi']; ?></td>
                            <td><?php echo $row['produksi_aktual']; ?></td>
                            <td>
                                <a href="<?php echo site_url('hasil/ubah/' . $row['id_hasil']); ?>" class="btn btn-success btn-xs"><span class="fa fa-pencil"></span> Ubah</a>
                                <a href="#" data-href="<?php echo site_url('hasil/hapus/' . $row['id_hasil']); ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer'); ?>