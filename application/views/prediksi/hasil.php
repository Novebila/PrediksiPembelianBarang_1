<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Hasil Prediksi</h3>
    </div>
    <div class="box-body">
        <table class="table">
            <tr>
                <th>Produk</th>
                <th>Bulan</th>
                <th>Order</th>
                <th>Penjualan</th>
                <th>Stok</th>
                <th>Prediksi Jumlah Pembelian</th>
            </tr>
            <tr>
                <td><?= $nama_produk ?></td>
                <td><?= $bulan . ' ' . $tahun ?></td>
                <td><?= $order ?></td>
                <td><?= $shipment ?></td>
                <td><?= $stok ?></td>
                <td><?= $prediksi ?></td>
            </tr>
        </table>
        <br>
        <p>
            <a href="<?php echo site_url('prediksi'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#perhitungan">
                <i class="fa fa-check"></i> Perhitungan
            </button>
        </p>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="perhitungan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h3 class="modal-title">Perhitungan Fuzzy Tsukamoto</h3>
            </div>
            <div class="modal-body">
                <?= $perhitungan ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer'); ?>