<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data Training</h3>
    </div>
    <?php echo form_open('training/ubah/' . $training['id_training']); ?>
    <div class="box-body">
        <?php echo $this->session->flashdata('success'); ?>
        <div class="form-horizontal">
            <div class="form-group">
                <label for="id_produk" class="col-md-2 control-label">Produk</label>
                <div class="col-md-4">
                    <select class="form-control" name="id_produk" id="id_produk">
                        <option value="">Pilih...</option>
                        <?php foreach ($produk as $row) : ?>
                            <option value="<?php echo $row->id_produk; ?>" <?php echo set_select('id_produk', $row->id_produk, $training['id_produk'] == $row->id_produk ? TRUE : FALSE); ?>><?php echo $row->nama_produk; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('id_produk'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="bulan" class="col-md-2 control-label">Bulan</label>
                <div class="col-md-4">
                    <select class="form-control" name="bulan" id="bulan">
                        <option value="">Pilih...</option>
                        <option value="JANUARI" <?= $training['bulan'] == 'JANUARI' ? 'selected' : '' ?>>Januari</option>
                        <option value="FEBRUARI" <?= $training['bulan'] == 'FEBRUARI' ? 'selected' : '' ?>>Februari</option>
                        <option value="MARET" <?= $training['bulan'] == 'MARET' ? 'selected' : '' ?>>Maret</option>
                        <option value="APRIL" <?= $training['bulan'] == 'APRIL' ? 'selected' : '' ?>>April</option>
                        <option value="MEI" <?= $training['bulan'] == 'MEI' ? 'selected' : '' ?>>Mei</option>
                        <option value="JUNI" <?= $training['bulan'] == 'JUNI' ? 'selected' : '' ?>>Juni</option>
                        <option value="JULI" <?= $training['bulan'] == 'JULI' ? 'selected' : '' ?>>Juli</option>
                        <option value="AGUSTUS" <?= $training['bulan'] == 'AGUSTUS' ? 'selected' : '' ?>>Agustus</option>
                        <option value="SEPTEMBER" <?= $training['bulan'] == 'SEPTEMBER' ? 'selected' : '' ?>>September</option>
                        <option value="OKTOBER" <?= $training['bulan'] == 'OKTOBER' ? 'selected' : '' ?>>Oktober</option>
                        <option value="NOVEMBER" <?= $training['bulan'] == 'NOVEMBER' ? 'selected' : '' ?>>November</option>
                        <option value="DESEMBER" <?= $training['bulan'] == 'DESEMBER' ? 'selected' : '' ?>>Desember</option>
                    </select>
                    <span class="text-danger"><?php echo form_error('bulan'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="tahun" class="col-md-2 control-label">Tahun</label>
                <div class="col-md-4">
                    <input name="tahun" id="tahun" class="form-control" type="number" value="<?php echo set_value('tahun', $training['tahun']); ?>">
                    <span class="text-danger"><?php echo form_error('tahun'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="orders" class="col-md-2 control-label">Order</label>
                <div class="col-md-4">
                    <input name="orders" id="orders" class="form-control" type="number" value="<?php echo set_value('orders', $training['orders']); ?>">
                    <span class="text-danger"><?php echo form_error('orders'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="shipment" class="col-md-2 control-label">Penjualan</label>
                <div class="col-md-4">
                    <input name="shipment" id="shipment" class="form-control" type="number" value="<?php echo set_value('shipment', $training['shipment']); ?>">
                    <span class="text-danger"><?php echo form_error('shipment'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="stok" class="col-md-2 control-label">Stok</label>
                <div class="col-md-4">
                    <input name="stok" id="stok" class="form-control" type="number" value="<?php echo set_value('stok', $training['stok']); ?>">
                    <span class="text-danger"><?php echo form_error('stok'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="produksi" class="col-md-2 control-label">Pembelian</label>
                <div class="col-md-4">
                    <input name="produksi" id="produksi" class="form-control" type="number" value="<?php echo set_value('produksi', $training['produksi']); ?>">
                    <span class="text-danger"><?php echo form_error('produksi'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-2">
            <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
            <a href="<?php echo site_url('training'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php $this->load->view('template/footer'); ?>