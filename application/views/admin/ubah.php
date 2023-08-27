<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Admin</h3>
    </div>
    <?php echo form_open('admin/ubah/' . $admin['id_admin']); ?>
    <?php echo form_hidden('username_tmp', $admin['username']); ?>
    <div class="box-body">
        <?php echo $this->session->flashdata('success'); ?>
        <div class="form-horizontal">
            <div class="form-group">
                <label for="nama_lengkap" class="col-md-2 control-label">Nama Lengkap</label>
                <div class="col-md-4">
                    <input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text" value="<?php echo set_value('nama_lengkap', $admin['nama_lengkap']); ?>">
                    <span class="text-danger"><?php echo form_error('nama_lengkap'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-md-2 control-label">Username</label>
                <div class="col-md-4">
                    <input name="username" id="username" class="form-control" type="text" value="<?php echo set_value('username', $admin['username']); ?>">
                    <span class="text-danger"><?php echo form_error('username'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-2">
            <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
            <a href="<?php echo site_url('admin'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php $this->load->view('template/footer'); ?>