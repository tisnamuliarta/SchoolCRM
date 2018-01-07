<?php require 'partials/head_admin.php'; ?>

<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Pengaturan Akun</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="userstable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th></th>
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

<div id="guruModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="formGuru">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-user-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" id="nip" class="form-control" required />
                <div class="text-danger" id="nipError"></div>
              </div>
            </div>
            <div class="col-sm-6">
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
          <div class="form-group">
            <label>Jenis Kelamin</label>
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
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <input class="form-control getDatePicker" name="tgl_lahir" id="tgl_lahir" required/>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Telepon</label>
                <input class="form-control" name="tlpn" id="guruTlpn" required />
                <div class="text-danger" id="tlpnError"></div>
                <input class="form-control" type="hidden" name="status" value="active" />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="user_nip" id="user_nip" />
          <input type="hidden" name="btn_action" id="btn_action" />
          <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="updatePasswordModal" class="modal fade">
  <div class="modal-dialog modal-sm">
      <form method="post" id="update_password_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i>Update Password</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="usernameUpdatePassword" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="update_password" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                      <label>Konfirmasi Password</label>
                      <input type="password" name="c_password" id="c_update_password" class="form-control" required="required">
                    </div>
              </div>
              <div class="modal-footer">                  
                  <input type="hidden" name="user_id_update" id="user_id_update" />
                  <input type="hidden" name="btn_action_update_password" id="btn_action_update_password" />
                  <input type="submit" name="action_update_password" id="action_update_password" class="btn btn-info" value="Add" />
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </form>
  </div>
</div>

<div id="guruDetailModal" class="modal fade">
  <div class="modal-dialog">
      <form method="post" id="product_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i>Details data guru</h4>
              </div>
              <div class="modal-body">
                  <Div id="guruDetails"></Div>
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
  var password = document.getElementById("update_password")
    , confirm_password = document.getElementById("c_update_password");

  function validatePassword(){
    if(password.value != confirm_password.value) {
      confirm_password.setCustomValidity("Passwords not match");
    } else {
      confirm_password.setCustomValidity('');
    }
  }

  password.onchange = validatePassword;
  confirm_password.onkeyup = validatePassword;
  /**
     * ===================================
     * Guru datatable
     * ===================================
     */
      var ortuTable = $('#userstable').DataTable({
        "processing":true,
        "serverSide":true,
        "paging":false,
        "searching":false,
        "ordering":false,
        "info":false,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "POST",
          data:{pengaturanakunguru: "ta"}
        },
        "columnDefs":[
          {"targets":[1,2],"width":"600"},
          {
            "targets":[0,4,5],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_tahunajaran_button').click(function(){
        $('#tahunAjaranModal').modal('show');
        $('#formKegiatan')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Tahun Ajaran");
        $('#action').val('Add');
        $('#btn_action').val('Add');
      });
      //open update password modal
      $(document).on('click','.update-password',function(){
        var id = $(this).attr("id");
        $('#updatePasswordModal').modal('show');
        $('#update_password_form')[0].reset();
        $('#action_update_password').val('Update Password');
        $('#btn_action_update_password').val('update_password_guru');
        $('#user_id_update').val(id);
      });
    // ============= save data ======
    $(document).on('submit','#update_password_form', function(e){
      e.preventDefault();
      $('#action_update_password').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/pengaturanakunaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#update_password_form')[0].reset();
          $('#updatePasswordModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action_update_password').attr('disabled', false);
          ortuTable.ajax.reload();
        }
      })
    });

   // ============= save data ======
    $(document).on('submit','#formGuru', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/guruaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formGuru')[0].reset();
          $('#guruModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          ortuTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-guru',function(){
      var nip = $(this).attr("id");
      // $('#nip').prop('disabled',true);
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/guruaction.php',
        method: 'POST',
        data: {nip:nip, btn_action:btn_action},
        dataType: 'json',
        success: function(data){
          $('#guruModal').modal('show');
          $('#nip').val(data.nip);
          $('#nama').val(data.nama);
          $('#tgl_lahir').val(data.tgl_lahir);
          $('#alamat').val(data.alamat);
          $('input[type="radio"]#'+data.jenis_kelamin+'').prop('checked',true);
          $('#'+data.status+'').prop('checked',true);
          $('#guruTlpn').val(data.tlpn);
          $('.modal-user-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
          $('#action').val("Edit");
          $('#user_nip').val(nip)
          $('#btn_action').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-kegiatan',function(){
      var id = $(this).attr("id");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan menghapus kegiatan ini?")) {
        $.ajax({
          url: '../controller/kegiatanaction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            ortuTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    ////////////////////////
    // End guru datatable //
    ////////////////////////
</script>