<li <?php echo ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'home') ? 'class="active"' : ''; ?>><a href="<?php echo site_url(); ?>"> <span>Home</span></a></li>
<li <?php echo $this->uri->segment(1) == 'produk' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('produk'); ?>"> <span>Data Produk</span></a></li>
<li <?php echo $this->uri->segment(1) == 'training' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('training'); ?>"> <span>Data Training</span></a></li>
<li <?php echo $this->uri->segment(1) == 'prediksi' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('prediksi'); ?>"> <span>Prediksi</span></a></li>
<li <?php echo $this->uri->segment(1) == 'hasil' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('hasil'); ?>"> <span>Hasil</span></a></li>
<li <?php echo $this->uri->segment(1) == 'admin' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('admin'); ?>"> <span>Data Admin</span></a></li>
<li <?php echo $this->uri->segment(1) == 'password' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('password'); ?>"> <span>Ubah Password</span></a></li>
<li><a href="<?php echo site_url('login/logout'); ?>"> <span>Logout</span></a></li>