<?php require 'partials/head_admin.php'; ?>

<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-6 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Pengaturan Akun Guru</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="gurutable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th></th>
                    <!-- <th></th> -->
                  </tr>
                  </thead>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Pengaturan Akun Orang Tua</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="userstable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Username</th>
                    <th></th>
                    <!-- <th></th> -->
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
      var gurutable = $('#gurutable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "GET",
          data:{manageGuru: "ta"}
        },
        "columnDefs":[
          {"targets":[1,2],"width":"600"},
          {
            "targets":[0],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      var ortuTable = $('#userstable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "GET",
          data:{manageUser: "ta"}
        },
        "columnDefs":[
          {"targets":[1,2],"width":"600"},
          {
            "targets":[0],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });
      //open update password modal    
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

    // ================== delete data
    $(document).on('click','.reset-password-ortu',function(){
      var id = $(this).attr("id");
      var btn_action = 'reset_password_ortu';
      if (confirm("Apa anda mareset password user ini? Default password nanti adalah password.")) {
        $.ajax({
          url: '../controller/pengaturanakunaction.php',
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

    $(document).on('click','.reset-password-guru',function(){
      var id = $(this).attr("id");
      var btn_action = 'reset_password_guru';
      if (confirm("Apa anda mareset password user ini? Default password nanti adalah password.")) {
        $.ajax({
          url: '../controller/pengaturanakunaction.php',
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