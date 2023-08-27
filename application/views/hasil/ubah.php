<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data Hasil Prediksi</h3>
    </div>
    <?php echo form_open('hasil/ubah/' . $hasil['id_hasil']); ?>
    <div class="box-body">
        <?php echo $this->session->flashdata('success'); ?>
        <div class="form-horizontal">
            <div class="form-group">
                <label for="nama_produk" class="col-md-2 control-label">Nama Produk</label>
                <div class="col-md-4">
                    <input readonly name="nama_produk" id="nama_produk" class="form-control" type="text" value="<?php echo set_value('nama_produk', $hasil['nama_produk']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="bulan" class="col-md-2 control-label">Bulan</label>
                <div class="col-md-4">
                    <input readonly name="bulan" id="bulan" class="form-control" type="text" value="<?php echo set_value('bulan', $hasil['bulan']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tahun" class="col-md-2 control-label">Tahun</label>
                <div class="col-md-4">
                    <input readonly name="tahun" id="tahun" class="form-control" type="text" value="<?php echo set_value('tahun', $hasil['tahun']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="orders" class="col-md-2 control-label">Order</label>
                <div class="col-md-4">
                    <input readonly name="orders" id="orders" class="form-control" type="text" value="<?php echo set_value('orders', $hasil['orders']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="shipment" class="col-md-2 control-label">Penjualan</label>
                <div class="col-md-4">
                    <input readonly name="shipment" id="shipment" class="form-control" type="text" value="<?php echo set_value('shipment', $hasil['shipment']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="stok" class="col-md-2 control-label">Stok</label>
                <div class="col-md-4">
                    <input readonly name="stok" id="stok" class="form-control" type="text" value="<?php echo set_value('stok', $hasil['stok']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="produksi_prediksi" class="col-md-2 control-label">Produksi (Prediksi)</label>
                <div class="col-md-4">
                    <input readonly name="produksi_prediksi" id="produksi_prediksi" class="form-control" type="text" value="<?php echo set_value('produksi_prediksi', $hasil['produksi_prediksi']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="produksi_aktual" class="col-md-2 control-label">Produksi (Aktual)</label>
                <div class="col-md-4">
                    <input name="produksi_aktual" id="produksi_aktual" class="form-control" type="number" value="<?php echo set_value('produksi_aktual', $hasil['produksi_aktual']); ?>">
                    <span class="text-danger"><?php echo form_error('produksi_aktual'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-2">
            <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
            <a href="<?php echo site_url('hasil'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php $this->load->view('template/footer'); ?>