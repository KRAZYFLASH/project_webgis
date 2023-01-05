<?= $this->extend('home') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<?= $this->include('dashboard/header') ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <!-- Small boxes (Stat box) -->
      <?= $this->include('dashboard/boxInfo') ?>

        <!-- Main row -->
        <?= $this->include('dashboard/mainRow') ?>
        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?= $this->endSection() ?>