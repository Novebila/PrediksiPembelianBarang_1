<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> Ubah Password</h3>
    </div>
    <?php echo form_open('password'); ?>
    <div class="box-body">
        <?php echo $this->session->flashdata('success'); ?>
        <div class="form-horizontal">
            <div class="form-group <?php echo form_error('password') != '' ? 'has-error' : ''; ?>">
                <label for="password" class="col-md-2 control-label">Password Lama</label>
                <div class="col-md-4">
                    <input name="password" id="password" class="form-control" type="password" value="<?php echo set_value('password'); ?>">
                    <span class="help-block"><?php echo form_error('password'); ?></span>
                </div>
            </div>
            <div class="form-group <?php echo form_error('password_baru') != '' ? 'has-error' : ''; ?>">
                <label for="password_baru" class="col-md-2 control-label">Password Baru</label>
                <div class="col-md-4">
                    <input name="password_baru" id="password_baru" class="form-control" type="password" value="<?php echo set_value('password_baru'); ?>">
                    <span class="help-block"><?php echo form_error('password_baru'); ?></span>
                </div>
            </div>
            <div class="form-group <?php echo form_error('ulangi') != '' ? 'has-error' : ''; ?>">
                <label for="ulangi" class="col-md-2 control-label">Ulangi Password Baru</label>
                <div class="col-md-4">
                    <input name="ulangi" id="ulangi" class="form-control" type="password" value="<?php echo set_value('ulangi'); ?>">
                    <span class="help-block"><?php echo form_error('ulangi'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-2">
            <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php $this->load->view('template/footer'); ?>