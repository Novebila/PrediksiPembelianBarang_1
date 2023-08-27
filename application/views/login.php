<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('title'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <p class="text-center">LOGIN</p>
            <br>
            <form action="<?php echo site_url('login/cek'); ?>" method="post">
                <div class="form-group has-feedback <?php echo form_error('username') != '' ? 'has-error' : ''; ?>">
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>">
                    <span class="fa fa-user form-control-feedback"></span>
                    <span class="help-block"><?php echo form_error('username'); ?></span>
                </div>
                <div class="form-group has-feedback <?php echo form_error('password') != '' ? 'has-error' : ''; ?>">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>">
                    <span class="fa fa-lock form-control-feedback"></span>
                    <span class="help-block"><?php echo form_error('password'); ?></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Login</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="text-center">
                <?php echo $this->session->flashdata('error'); ?>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>

</html>