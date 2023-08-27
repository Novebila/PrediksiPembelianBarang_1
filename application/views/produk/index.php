<?php $this->load->view('template/header'); ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Produk</h3>
        <div class="box-tools">
            <a href="<?php echo site_url('produk/tambah'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Produk</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTables1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row['nama_produk']; ?></td>
                            <td>
                                <a href="<?php echo site_url('produk/ubah/' . $row['id_produk']); ?>" class="btn btn-success btn-xs"><span class="fa fa-pencil"></span> Ubah</a>
                                <a href="#" data-href="<?php echo site_url('produk/hapus/' . $row['id_produk']); ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer'); ?>