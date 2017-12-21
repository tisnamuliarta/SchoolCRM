<?php require 'partials/head.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Data Guru</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-1 pull-right">
              <button type="button" name="add" id="add_guru_button" class="btn form-control btn-success btn-xs">Add</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="gurutable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Role</th>
                <th>Status</th>
                <!-- <th></th> -->
                <th></th>
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
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="username" id="username" pattern="[^\s]+" title="Username tidak dapat mengandung spasi!" required/>
                <input type="hidden" name="hiddenUsername" id="hiddenUsername">
                <div class="text-danger" id="usernameError"></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" id="password" name="password"/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Status</label>
            <div class="row">
              <div class="col-md-3">
                <div class="radio">
                  <label><input type="radio" id="active" name="status" value="active" required> Active</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="radio">
                  <label><input type="radio" id="non-active" name="status" value="non-active"> Non Active</label>
                </div>
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
  /**
     * ===================================
     * Guru datatable
     * ===================================
     */
      var guruTable = $('#gurutable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "POST",
          data:{table: "tb_guru"}
        },
        "columnDefs":[
          {
            "targets":[0,8,9,10],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_guru_button').click(function(){
        $('#guruModal').modal('show');
        $('#formGuru')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Guru");
        $('#action').val('Add');
        $('#btn_action').val('Add');
        $('#password').prop('disabled',false);
        $('#username').prop('disabled',false);
        $('#nip').prop('disabled',false);
      });
    // check if guru username is same
    $('#username').on('input', function(e){
      e.preventDefault();
      var guruUsername = $('#username').val();
      $.ajax({
        url: "../controller/helper.php",
        method:"POST",
        data: {guruUsername:guruUsername},
        success: function(data){
          $('#usernameError').html(data)
        }
      });
    });
    // Check if phone is same
    $('#guruTlpn').on('input', function(e){
      e.preventDefault();
      var tlpn = $('#guruTlpn').val();
      $.ajax({
        url: "../controller/helper.php",
        method: "POST",
        data: {tlpn:tlpn},
        success: function(data){
          $('#tlpnError').html(data)
        }
      })
    });
    $('#nip').on('input', function(e){
      e.preventDefault();
      var nip = $('#nip').val();
      $.ajax({
        url: "../controller/helper.php",
        method: "POST",
        data: {nip:nip},
        success: function(data){
          $('#nipError').html(data)
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
          guruTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-guru',function(){
      var nip = $(this).attr("id");
      $('#password').prop('disabled',true);
      $('#username').prop('disabled',true);
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
    $(document).on('click','.delete-guru',function(){
      var user_nip = $(this).attr("id");
      var status = $(this).data("status");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan akan menonaktifkan user ini?")) {
        $.ajax({
          url: '../controller/guruaction.php',
          method: 'POST',
          data: {user_nip: user_nip, status:status, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            guruTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    // ================== Grand as admin
    $(document).on('click','.make-admin',function(){
      var user_nip = $(this).attr("id");
      var type = $(this).data("type");
      var btn_action = 'asAdmin';
      if (confirm("Anda yakin akan akan menjadikan user ini sebagai admin?")) {
        $.ajax({
          url: '../controller/guruaction.php',
          method: 'POST',
          data: {user_nip: user_nip, type:type, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            guruTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    // View data ========================
    $(document).on('click','.view-guru',function(){
      var nip = $(this).attr("id");
      var btn_action = 'guruDetails';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {guru_nip:nip,btn_action:btn_action},
        success: function(data) {
          $('#guruDetailModal').modal('show');
          $('#guruDetails').html(data)
        }
      });
    });

    ////////////////////////
    // End guru datatable //
    ////////////////////////
</script>