<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data Produk</h3>
    </div>
    <?php echo form_open('produk/tambah'); ?>
    <div class="box-body">
        <?php echo $this->session->flashdata('success'); ?>
        <div class="form-horizontal">
            <div class="form-group">
                <label for="nama_produk" class="col-md-2 control-label">Nama Produk</label>
                <div class="col-md-4">
                    <input name="nama_produk" id="nama_produk" class="form-control" type="text" value="<?php echo set_value('nama_produk'); ?>">
                    <span class="text-danger"><?php echo form_error('nama_produk'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-2">
            <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
            <a href="<?php echo site_url('produk'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php $this->load->view('template/footer'); ?>