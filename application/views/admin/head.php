<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>
    <?php if(!empty($title)){ echo $title; } ?>
</title>
<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>AdminLTE_3/dist/img/AdminLTELogo.png">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url() ?>AdminLTE_3/plugins/fontawesome-free/css/all.min.css" />

<script src="<?= base_url() ?>AdminLTE_3/plugins/jquery/jquery.min.js"></script>

<?php if(!empty($template_css)){foreach($template_css as $css){ echo '<link rel="stylesheet" href="'.base_url().'AdminLTE_3/plugins/'.$css.'">';} } ?>

<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url() ?>AdminLTE_3/plugins/toastr/toastr.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url() ?>AdminLTE_3/dist/css/adminlte.min.css" />
<!-- Custom CSS -->
<link rel="stylesheet" href="<?= base_url() ?>SmartBrain/css/style.css" />


<!-- JS -->
<script src="<?= base_url() ?>AdminLTE_3/plugins/toastr/toastr.min.js"></script>