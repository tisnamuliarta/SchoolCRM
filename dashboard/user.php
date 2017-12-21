<?php require 'partials/head.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Data User</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-1 pull-right">
              <button type="button" name="add" id="add_button" class="btn form-control btn-success btn-xs">Add</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="userstable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Status</th>
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

<div id="userModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="user_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control" required />
                <div class="text-danger" id="emailError"></div>
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
                <input class="form-control" name="tlpn" id="tlpn" required />
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
          <input type="hidden" name="user_id" id="user_id" />
          <input type="hidden" name="btn_action" id="btn_action" />
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
      var userTable = $('#userstable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/user_fetch.php",
          type: "POST"
        },
        "columnDefs":[
          {
            "targets":[0,7,8,9],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_button').click(function(){
        $('#userModal').modal('show');
        $('#user_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Tambah User");
        $('#action').val('Add');
        $('#btn_action').val('Add');
        $('#password').prop('disabled',false);
        $('#username').prop('disabled',false);
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
    $(document).on('submit','#user_form', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/useraction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#user_form')[0].reset();
          $('#userModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          userTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-user',function(){
      var id = $(this).attr("id");
      $('#password').prop('disabled',true);
      $('#username').prop('disabled',true);
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/useraction.php',
        method: 'POST',
        data: {id:id, btn_action:btn_action},
        dataType: 'json',
        success: function(data){
          $('#userModal').modal('show');
          $('#nama').val(data.nama);
          $('#tgl_lahir').val(data.tgl_lahir);
          $('#alamat').val(data.alamat);
          $('#email').val(data.email);
          $('input[name="jenis_kelamin"][value="'+data.jenis_kelamin+'"]').prop('checked',true);
          $('#'+data.status+'').prop('checked',true);
          $('#tlpn').val(data.tlpn);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
          $('#action').val("Edit");
          $('#user_id').val(id)
          $('#btn_action').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-user',function(){
      var user_id = $(this).attr("id");
      var status = $(this).data("status");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan akan menonaktifkan user ini?")) {
        $.ajax({
          url: '../controller/useraction.php',
          method: 'POST',
          data: {user_id: user_id, status:status, btn_action:btn_action},
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
</script>