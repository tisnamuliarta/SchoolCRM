<?php require 'partials/head.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Siswa Baru</h3>
        <input type="hidden" name="id_ortu" id="id_ortu" value="<?php echo $_SESSION['id'] ?>">
        <span class="text-info pull-right">Kuota tersisa untuk siswa baru : <?php echo countTotalKuotaSiswaBaru($connect) ?></span>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <?php $totalKuota = countTotalKuotaSiswaBaru($connect) ?>
            <?php if ($totalKuota = 0): ?>
              <span class="text-success">Kuota Habis</span>
            <?php else: ?>
              <div class="col-sm-1 pull-right">
                <button type="button" name="add" id="add_button" class="btn form-control btn-success btn-xs">Tambah</button>
                <br><br>
              </div>
              <!-- <div class="col-sm-2 pull-right">
                <button type="button" name="konfirmasi_pendaftaran" id="konfirmasi_pendaftaran_btn" class="btn form-control btn-info btn-xs">Konfirmasi Pendaftaran</button>
                <br><br>
              </div> -->
            <?php endif ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="siswatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Lahir</th>
                  <th>Alamat</th>
                  <th>Jumlah Pembayaran</th>
                  <th>Metode Pembayaran</th>
                  <th>Status</th>
                  <th>Update</th>
                  <th>Konfirmasi</th>
                  <th>Keterangan</th>
                </tr>
                </thead>
              </table>
            </div>
          </div>
          
        </div>
      </div>
      <div class="box-footer">
        <span class="text-info">* Untuk transfer bank dapat dilakukan ke nomer rekening <strong> Bank BCA 1922022</strong> Atas Nama <strong>Indah Sri</strong></span>
      </div>
    </div>
  </div>
</div>

<div id="siswaBaruModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="siswaForm" accept="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div id="textDiscount" class="text-success text-center"></div>
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                  <option value="">Pilih tahun ajaran anak anda mendaftar</option>
                  <?php
                    $tahun = date('Y'); 
                    echo listTahunAjatan($connect,$tahun) 
                  ?> 
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama</label>                
                <input type="text" name="nama" id="nama" class="form-control" required />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Kelamin :</label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="radio">
                      <label><input type="radio" id="1" name="jenis_kelamin" value="1" required> Laki-laki</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="radio">
                      <label><input type="radio" id="2" name="jenis_kelamin" value="2"> Perempuan</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Tanggal Lahir :</label>
                    <input class="form-control getDatePicker" name="tgl_lahir" id="tgl_lahir" required/>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Metode Pembayaran</label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="radio">
                      <label><input type="radio" id="tunai" name="metodePembayaran" value="tunai" required> Setor Tunai</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="radio">
                      <label><input type="radio" id="transfer" name="metodePembayaran" value="transfer"> Transfer</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Biaya Pendaftaran</label>
                <input class="form-control" id="biayaPendaftaran" name="biayaPendaftaran" readonly required >
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <label>Upload Kartu Keluarga</label>
              <input type="file" name="kk" id="kk" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_siswa" id="id_siswa" />
          <input type="hidden" name="btn_action" id="btn_action" />
          <input type="hidden" name="diskon" id="diskon">
          <input type="hidden" name="jumlahAnak" id="jumlahAnak">
          <input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo date('Y-m-d') ?>">
          <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Konfirmasi dengan tombol diatas -->
<div id="konfirmasiSiswaModal" class="modal fade">
  <div class="modal-dialog modal-sm">
    <form method="post" id="formKonfirmasiPendaftaran" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-konfirmasi-title"><i class="fa fa-user"></i> Konfirmasi Pendaftaran</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Detail Siswa</label>
            <select name="id_pendaftaran" id="id_pendaftaran" class="form-control" required>
              <option value="">Pilih Siswa</option>
              <?php echo listSiswaByOrtu($connect) ?>
            </select>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Bukti Pembayaran</label>
                <input class="form-control" type="file" name="foto" id="foto" required/>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="pendaftaran_id" id="pendaftaran_id" />
          <input type="hidden" name="btn_action_konfirm" id="btn_action_konfirm" />
          <input type="submit" name="action_konfirm" id="action_konfirm" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Konfirmasi dengan tombol disamping -->
<div id="konfirmasiSiswaModalSamping" class="modal fade">
  <div class="modal-dialog modal-sm">
    <form method="post" id="formKonfirmasiSiswa" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-konfirmasi-title"><i class="fa fa-user"></i> Konfirmasi Pendaftaran</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" name="nama_konfirmasi_siswa" id="nama_konfirmasi_siswa" class="form-control">
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Bukti Pembayaran</label>
                <input class="form-control" type="file" name="fotoBukti" id="fotoBukti" required/>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_konfirmasi_pendaftaran" id="id_konfirmasi_pendaftaran" />
          <input type="hidden" name="btn_action_konfirmasi" id="btn_action_konfirmasi" />
          <input type="submit" name="action_konfirmasi" id="action_konfirmasi" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="userDetailModal" class="modal fade">
  <div class="modal-dialog">
      <form method="post" id="product_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Details data user</h4>
              </div>
              <div class="modal-body">
                  <Div id="userDetails"></Div>
              </div>
              <div class="modal-footer">
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </form>
  </div>
</div>



<?php require 'partials/footer.php'; ?>
<script type="text/javascript">
  /**
       * ==========================
       * User table 
       * =========================
       */
  // ================== User datatable =============
      var id_ortu = <?php echo $_SESSION['id']; ?>;
      var userTable = $('#siswatable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          data: {siswaBaru: "siswa-baru",id_ortu:id_ortu},
          type: "POST"
        },
        "columnDefs":[
          {"width":"20px","targets":0},
          {"width":"20%","targets":[2,5,7]},
          {
            "targets":[0,8,9],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });
      // add button clicked
      $('#add_button').click(function(){
        $('#siswaBaruModal').modal('show');
        $('#siswaForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Tambah Siswa");
        $('#action').val('Add');
        $('#btn_action').val('Add');
        var idOrtu = <?php echo $_SESSION['id']; ?>;
        var jumlahAnak = $.ajax({
            url: '../controller/helper.php',
            data: {id_ortu:idOrtu},
            method: 'POST',
            success: function(data){
              $('#jumlahAnak').val(data)
            }
          });
      });
      // konfirmasi pembayaran button clicked
      $('#konfirmasi_pendaftaran_btn').click(function(){
        $('#konfirmasiSiswaModal').modal('show');
        $('.modal-title').html("<i class='fa fa-plus'></i> Tambah Siswa");
        $('#action_konfirm').val('Konfirm');
        $('#btn_action_konfirm').val('Konfirm');
      });

    $('#tahun_ajaran').change(function(){
      var idTahunAjaran = $('#tahun_ajaran').val();
      var diskonNumber,diskonValue,total,textDiskon;
      var txtBiayaDaftar = $(this).find(':selected').data('biayadaftar');
      $('#biayaPendaftaran').val(txtBiayaDaftar);
      var biayaDaftar = $('#biayaPendaftaran').val();

      $.ajax({
        method: 'POST',
        data: {idTahunAjaran:idTahunAjaran},
        url: '../controller/helper.php',
        success: function(data){
          // biayaDaftar = 100000;
          textDiskon = $('#diskon').val(data);
          if ($('#jumlahAnak').val() > 0) {
            diskonNumber = $('#diskon').val();
            diskonValue = (diskonNumber/100) * biayaDaftar;
            total = biayaDaftar - diskonValue;
            $('#biayaPendaftaran').val(total)
          }
        }
      });
    });
    // check if username is same
    $('#username').on('input', function(e){
      e.preventDefault();
      var username = $('#username').val();
      $.ajax({
        url: "../controller/checkusername.php",
        method:"POST",
        data: {username:username},
        success: function(data){
          $('#usernameError').html(data)
        }
      });
    });

    // Check if email same
    $('#email').on('input', function(e){
      e.preventDefault();
      var email = $('#email').val();
      $.ajax({
        url: "../controller/helper.php",
        method:"POST",
        data: {email:email},
        success: function(data){
          $('#emailError').html(data)
        }
      });
    });
    // Check if phone is same
    $('#tlpn').on('input', function(e){
      e.preventDefault();
      var tlpn = $('#tlpn').val();
      $.ajax({
        url: "../controller/checkTlpn.php",
        method: "POST",
        data: {tlpn:tlpn},
        success: function(data){
          $('#tlpnError').html(data)
        }
      })
    });
    // ============= save data
    $(document).on('submit','#siswaForm', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/siswaaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#siswaForm')[0].reset();
          $('#siswaBaruModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          userTable.ajax.reload();
          window.location.reload(true);
        }
      })
    });
    // Upload Bukti pembayaran
    $(document).on('submit','#formKonfirmasiPendaftaran', function(e){
      e.preventDefault();
      $('#action_konfirm').attr('disabled','disabled');
      $.ajax({
        url: "../controller/siswaaction.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data){
          $('#konfirmasiSiswaModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action_konfirm').attr('disabled', false);
          userTable.ajax.reload();
          window.location.reload(true);
        }
      })
    });

    $(document).on('submit','#formKonfirmasiSiswa', function(e){
      e.preventDefault();
      $('#action_konfirmasi').attr('disabled','disabled');
      $.ajax({
        url: "../controller/siswaaction.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data){
          $('#konfirmasiSiswaModalSamping').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action_konfirmasi').attr('disabled', false);
          userTable.ajax.reload();
          // window.location.reload(true);
        }
      })
    });

    // Konfirmasi Siswa button clicked
    $(document).on('click','.konfirmasi-siswa',function(){
      var id = $(this).attr("id");
      var nama = $(this).data("nama");
      var btn_action = 'fetch_konfirmasi_siswa';
      $('#konfirmasiSiswaModalSamping').modal('show');
      $('#nama_konfirmasi_siswa').val(nama);
      $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Konfirmasi");
      $('#action_konfirmasi').val("Konfirmasi Pendaftaran");
      $('#id_konfirmasi_pendaftaran').val(id)
      $('#btn_action_konfirmasi').val("konfirmasi_pendaftaran");
    });

    // ============= Display single data and update
    $(document).on('click','.update-siswa',function(){
      var id = $(this).attr("id");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/siswaaction.php',
        method: 'POST',
        data: {id:id, btn_action:btn_action},
        dataType: 'json',
        success: function(data){
          $('#siswaBaruModal').modal('show');
          $('#nama').val(data.nama);
          $('#tgl_lahir').val(data.tgl_lahir);
          $('#alamat').val(data.alamat);
          $('#tahun_ajaran').val(data.id_tahun_ajaran);
          $('#biayaPendaftaran').val(data.jumlah_bayar);
          $('input[name="jenis_kelamin"][value="'+data.jenis_kelamin+'"]').prop('checked',true);
          $('input[name="metodePembayaran"][value="'+data.cara_bayar+'"]').prop('checked',true);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Siswa");
          $('#action').val("Edit");
          $('#id_siswa').val(id)
          $('#btn_action').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-user',function(){
      var id_siswa = $(this).attr("id");
      var status = $(this).data("status");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan akan menonaktifkan user ini?")) {
        $.ajax({
          url: '../controller/siswaaction.php',
          method: 'POST',
          data: {id_siswa: id_siswa, status:status, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            userTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    // View data ========================
    $(document).on('click','.view-user',function(){
      var id_siswa = $(this).attr("id");
      var btn_action = 'user_details';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {id_siswa:id_siswa,btn_action:btn_action},
        success: function(data) {
          $('#userDetailModal').modal('show');
          $('#userDetails').html(data)
        }
      });
    });
</script>