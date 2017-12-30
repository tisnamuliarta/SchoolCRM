<?php require 'partials/head_admin.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <!-- Datatable Galeri -->
  <div class="col-lg-6 col-xs-12">
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Data Galeri</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-4 pull-right">
              <button type="button" name="add" id="add_galeri_button" class="btn form-control btn-success btn-xs">Tambah Galeri</button>
              <br><br>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <table id="galeritable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
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
  <!-- Datatable kelas -->
  <div class="col-lg-6 col-xs-12">
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Data Kelas</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-4 pull-right">
              <button type="button" name="add" id="add_kelas_button" class="btn form-control btn-success btn-xs">Tambah Kelas</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="kelastable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Max Siswa</th>
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
<!-- =============== Galeri Modal ==================== -->
<div id="galeriModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="formGaleri" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-galeri-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required />
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required style="height: 100px;"></textarea>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Foto</label>
                <input class="form-control" type="file" name="foto[]" id="foto" multiple required/>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="galeri_id" id="galeri_id" />
          <input type="hidden" name="nip" id="hiddenNip" value="<?php echo $_SESSION['nip'] ?>">
          <input type="hidden" name="btn_action" id="btn_action" />
          <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- ================ End Galeri Modal ================= -->

<!-- =================== Kelas Modal ================== -->
<div id="kelasModal" class="modal fade">
  <div class="modal-dialog modal-sm">
    <form method="post" id="formKelas" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-kelas-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" id="kelas" placeholder="A" class="form-control" required />
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Max Siswa</label>
            <input class="form-control" id="maximal_siswa" placeholder="30" type="number" name="maximal_siswa" required />
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_kelas" id="id_kelas" />
          <input type="hidden" name="btn_action_kelas" id="btn_action_kelas" />
          <input type="submit" name="action_kelas" id="action_kelas" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- ================== Detail Modal ================== -->
<div id="guruDetailModal" class="modal fade">
  <div class="modal-dialog">
      <form method="post" id="product_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i>Galeri</h4>
              </div>
              <div class="modal-body">
                  <Div id="galeriDetails"></Div>
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
  $(function(){
    $('.item:first').addClass('active');
  })
  /**
     * ===================================
     * Guru datatable
     * ===================================
     */
     // Galeri datatable
    var galeriTable = $('#galeritable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url: "../controller/getData.php",
        type: "POST",
        data:{galeri: "tb_galeri"}
      },
      "columnDefs":[
        {
          "width" : "5%",
          "targets":[2,3,4],
          "orderable":false,
        },
      ],
      "pageLength": 10
    });

    // kelas datatable
    var kelasTable = $('#kelastable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url: "../controller/getData.php",
        type: "POST",
        data:{kelas: "tb_galeri"}
      },
      "columnDefs":[
        {
          "targets":[3,4],
          "orderable":false,
        },
      ],
      "pageLength": 10
    });
    // Add galeri button
    $('#add_galeri_button').click(function(){
      $('#galeriModal').modal('show');
      $('#formGaleri')[0].reset();
      $('.modal-galeri-title').html("<i class='fa fa-plus'></i> Tambah Galeri");
      $('#action').val('Add');
      $('#btn_action').val('Add');
    });
    // Add Kelas Button
    $('#add_kelas_button').click(function(){
      $('#kelasModal').modal('show');
      $('#formKelas')[0].reset();
      $('.modal-kelas-title').html("<i class='fa fa-plus'></i> Tambah Informasi Kelas");
      $('#action_kelas').val('Add');
      $('#btn_action_kelas').val('Add');
    });
    // ============= save data galeri ======
    $(document).on('submit','#formGaleri', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      // var formData = $(this).serialize();
      $.ajax({
        url: "../controller/galeriaction.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data){
          $('#formGaleri')[0].reset();
          $('#galeriModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          galeriTable.ajax.reload();
        }
      })
    });

    // ============= save data kelas ======
    $(document).on('submit','#formKelas', function(e){
      e.preventDefault();
      $('#action_kelas').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/galeriaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formKelas')[0].reset();
          $('#kelasModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action_kelas').attr('disabled', false);
          kelasTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-galeri',function(){
      var id = $(this).attr("id");
      // $('#nip').prop('disabled',true);
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/galeriaction.php',
        method: 'POST',
        data: {id:id, btn_action:btn_action},
        dataType: 'json',
        success: function(data){
          $('#galeriModal').modal('show');
          $('#judul').val(data.judul);
          $('#deskripsi').val(data.deskripsi);
          $('.modal-galeri-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
          $('#action').val("Edit");
          $('#galeri_id').val(id)
          $('#btn_action').val("Edit");
        }
      })
    });
    // ================ Fetch single 
    $(document).on('click','.update-kelas',function(){
      var id = $(this).attr("id");
      var btn_action_kelas = 'fetch_single';
      $.ajax({
        url: '../controller/galeriaction.php',
        method: 'POST',
        data: {id:id, btn_action_kelas:btn_action_kelas},
        dataType: 'json',
        success: function(data){
          $('#kelasModal').modal('show');
          $('#kelas').val(data.kelas);
          $('#maximal_siswa').val(data.maximal_siswa);
          $('.modal-galeri-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
          $('#action_kelas').val("Edit");
          $('#id_kelas').val(id)
          $('#btn_action_kelas').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-galeri',function(){
      var id = $(this).attr("id");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan menghapus foto ini?")) {
        $.ajax({
          url: '../controller/galeriaction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            galeriTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })
    // =================== Delete Kelas
    $(document).on('click','.delete-kelas',function(){
      var id = $(this).attr("id");
      var btn_action_kelas = 'delete';
      if (confirm("Anda yakin akan menghapus data kelas ini?")) {
        $.ajax({
          url: '../controller/galeriaction.php',
          method: 'POST',
          data: {id: id, btn_action_kelas:btn_action_kelas},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            kelasTable.ajax.reload();
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
          url: '../controller/galeriaction.php',
          method: 'POST',
          data: {user_nip: user_nip, type:type, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            galeriTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    // View data ========================
    $(document).on('click','.view-galeri',function(){
      var id = $(this).attr("id");
      var btn_action = 'galeriDetails';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {galeri_id:id,btn_action:btn_action},
        success: function(data) {
          $('#guruDetailModal').modal('show');
          $('#galeriDetails').html(data)
        }
      });
    });

    ////////////////////////
    // End guru datatable //
    ////////////////////////
</script>