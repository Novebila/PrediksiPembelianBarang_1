<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data Training</h3>
    </div>
    <?php echo form_open('training/tambah'); ?>
    <div class="box-body">
        <?php echo $this->session->flashdata('success'); ?>
        <div class="form-horizontal">
            <div class="form-group">
                <label for="id_produk" class="col-md-2 control-label">Produk</label>
                <div class="col-md-4">
                    <select class="form-control" name="id_produk" id="id_produk">
                        <option value="">Pilih...</option>
                        <?php foreach ($produk as $row) : ?>
                            <option value="<?php echo $row->id_produk; ?>" <?php echo set_select('id_produk', $row->id_produk); ?>><?php echo $row->nama_produk; ?></option>
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
                        <option value="JANUARI">Januari</option>
                        <option value="FEBRUARI">Februari</option>
                        <option value="MARET">Maret</option>
                        <option value="APRIL">April</option>
                        <option value="MEI">Mei</option>
                        <option value="JUNI">Juni</option>
                        <option value="JULI">Juli</option>
                        <option value="AGUSTUS">Agustus</option>
                        <option value="SEPTEMBER">September</option>
                        <option value="OKTOBER">Oktober</option>
                        <option value="NOVEMBER">November</option>
                        <option value="DESEMBER">Desember</option>
                    </select>
                    <span class="text-danger"><?php echo form_error('bulan'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="tahun" class="col-md-2 control-label">Tahun</label>
                <div class="col-md-4">
                    <input name="tahun" id="tahun" class="form-control" type="number" value="<?php echo set_value('tahun'); ?>">
                    <span class="text-danger"><?php echo form_error('tahun'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="orders" class="col-md-2 control-label">Order</label>
                <div class="col-md-4">
                    <input name="orders" id="orders" class="form-control" type="number" value="<?php echo set_value('orders'); ?>">
                    <span class="text-danger"><?php echo form_error('orders'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="shipment" class="col-md-2 control-label">Penjualan</label>
                <div class="col-md-4">
                    <input name="shipment" id="shipment" class="form-control" type="number" value="<?php echo set_value('shipment'); ?>">
                    <span class="text-danger"><?php echo form_error('shipment'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="stok" class="col-md-2 control-label">Stok</label>
                <div class="col-md-4">
                    <input name="stok" id="stok" class="form-control" type="number" value="<?php echo set_value('stok'); ?>">
                    <span class="text-danger"><?php echo form_error('stok'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="produksi" class="col-md-2 control-label">Pembelian</label>
                <div class="col-md-4">
                    <input name="produksi" id="produksi" class="form-control" type="number" value="<?php echo set_value('produksi'); ?>">
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