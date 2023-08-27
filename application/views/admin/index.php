<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Admin</h3>
        <div class="box-tools">
            <a href="<?php echo site_url('admin/tambah'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Admin</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTables1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row->nama_lengkap; ?></td>
                            <td><?php echo $row->username; ?></td>
                            <td>
                                <a href="<?php echo site_url('admin/ubah/' . $row->id_admin); ?>" class="btn btn-success btn-xs" title="Ubah"><span class="fa fa-pencil"></span> Ubah</a>
                                <?php if ($row->username != $this->session->userdata('username')) { ?>
                                    <a href="#" data-href="<?php echo site_url('admin/hapus/' . $row->id_admin); ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs" title="Hapus"><span class="fa fa-trash"></span> Hapus</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer'); ?>