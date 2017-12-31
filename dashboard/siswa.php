<?php require 'partials/head_guru.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Siswa Baru</h3>
        <span class="text-info pull-right">Kuota siswa baru : <?php echo getKuotaKelas($connect,'A') ?></span><br>
        <span class="text-info pull-right"> Siswa baru terdaftar : <?php echo getCountKuotaSiswaBaru($connect,'A') ?></span>
      </div>
      <div class="box-body">
        <div class="row">
          <!-- <div class="col-sm-12">
            <div class="col-sm-1 pull-right">
              <button type="button" name="add" id="add_button" class="btn form-control btn-success btn-xs">Tambah</button>
              <br><br>
            </div>
          </div> -->
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="siswatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Nama Ayah</th>
                  <th>Nama Ibu</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Lahir</th>
                  <th>Alamat</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="siswaBaruModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="siswaForm">
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
                <input class="form-control" id="biayaPendaftaran" name="biayaPendaftaran" readonly required value="100000">
              </div>
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

<div id="userDetailModal" class="modal fade">
  <div class="modal-dialog">
      <form method="post" id="product_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Details Pembayaran</h4>
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
      var dataSiswaTable = $('#siswatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'print',
            exportOptions: {
              columns: [ 1,2,3,4,5,6 ]
            }
          },
          {
            extend: 'pdf',
            exportOptions: {
              columns: [ 1,2,3,4,5,6 ]
            }
          }
        ],
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          data: {datasiswa: "siswa-baru"},
          type: "POST"
        },
        "columnDefs":[
          {
            "width":"8%",
            "targets":[0,7,8],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_button').click(function(){
        $('#siswaBaruModal').modal('show');
        $('#siswaForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Tambah User");
        $('#action').val('Add');
        $('#btn_action').val('Add');
      });

    $('#tahun_ajaran').change(function(){
      var idTahunAjaran = $('#tahun_ajaran').val();
      var diskonNumber,diskonValue,total,textDiskon;
      var biayaDaftar = $('#biayaPendaftaran').val();
      $.ajax({
        method: 'POST',
        data: {idTahunAjaran:idTahunAjaran},
        url: '../controller/helper.php',
        success: function(data){
          biayaDaftar = 100000;
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
          dataSiswaTable.ajax.reload();
        }
      })
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
          $('#jumlah_bayar').val(data.jumlah_bayar);
          $('input[name="jenis_kelamin"][value="'+data.jenis_kelamin+'"]').prop('checked',true);
          $('input[name="metodePembayaran"][value="'+data.cara_bayar+'"]').prop('checked',true);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Siswa");
          $('#action').val("Edit");
          $('#id_siswa').val(id)
          $('#btn_action').val("Edit");
        }
      })
    });

    // View data ========================
    $(document).on('click','.view-user',function(){
      var user_id = $(this).attr("id");
      var btn_action = 'user_details';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {user_id:user_id,btn_action:btn_action},
        success: function(data) {
          $('#userDetailModal').modal('show');
          $('#userDetails').html(data)
        }
      });
    });
    // View data konfirmasi pendaftaran
    $(document).on('click','.view-data-konfirmasi',function(){
      var pendaftaran_id = $(this).attr("id");
      var btn_action = 'data_konfirmasi_pendaftaran';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {pendaftaran_id:pendaftaran_id,btn_action:btn_action},
        success: function(data) {
          $('#userDetailModal').modal('show');
          $('#userDetails').html(data)
        }
      });
    });

    // Konfirmasi Pembayaran
    $(document).on('click','.konfirmasi-siswa',function(){
      var id_pendaftaran = $(this).attr("id");
      var id_siswa = $(this).data("status");
      var btn_action = 'konfirmasi_pembayaran';
      if (confirm("Apakah data konfirmasi yang di upload sudah benar?")) {
        $.ajax({
          url: '../controller/siswaaction.php',
          method: 'POST',
          data: {id_pendaftaran: id_pendaftaran, id_siswa: id_siswa, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            dataSiswaTable.ajax.reload();
            window.location.reload(true);
          }
        })
      }else {
        return false;
      }
    })
</script>
