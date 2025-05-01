<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('admin/head') ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <?php $this->load->view('admin/navbar'); ?>
        <!-- /.navbar -->

        <?php $this->load->view('admin/sidebar'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid p-1">


                    <?php $this->load->view($content) ?>

                </div>
            </section>
        </div>

        <?php $this->load->view('admin/footer'); ?>

    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('admin/js'); ?>
</body>

</html>