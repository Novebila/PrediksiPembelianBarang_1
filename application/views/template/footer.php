</section><!-- /.content -->
</div><!-- /.container -->
</div><!-- /.content-wrapper -->
<!-- Main Footer -->
<footer class="main-footer">
    <div class="container">
        <strong>Copyright &copy; <?php echo date('Y'); ?> - <a href="#"><?php echo $this->config->item('title_footer'); ?></a></strong>
    </div>
</footer>
</div><!-- ./wrapper -->

<!-- delete modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p>Anda yakin akan menghapus data ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                <a class="btn btn-danger btn-ok"><span class="fa fa-trash"></span> Hapus</a>
            </div>
        </div>
    </div>
</div>

</body>

</html>