<?php require 'partials/head_guru.php'; ?>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-1">
        <select name="kelas" id="kelas" class="form-control">
          <?php echo getListKelas($connect) ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
          <?php
            echo getAllTahunAjaran($connect) 
          ?> 
        </select>
      </div>
      <div class="col-md-2 ">
        <div class="has-feedback">
          <input type="text" placeholder="dari tanggal" name="tgl_perkembangan_mulai" id="tgl_perkembangan_mulai" class="form-control getDatePicker">
          <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
        </div>
      </div>
      <div class="col-md-2 ">
        <div class="has-feedback">
          <input type="text" placeholder="ke tanggal" name="tgl_perkembangan_akhir" id="tgl_perkembangan_akhir" class="form-control getDatePicker">
          <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
        </div>
      </div>
      <div class="col-md-2 ">
        <button type="button" name="tampilkan_siswa" id="tampilkan_siswa" class="btn form-control btn-info btn-xs">Tampilkan</button><br><br>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header">
        <p>Dashboard Guru</p>
      </div>
      <div class="box-body">
        <i class="ion ion-bag"></i>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>