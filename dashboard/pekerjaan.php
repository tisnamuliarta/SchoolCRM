<?php require 'partials/head_admin.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <!-- Datatable pekerjaan -->
  <div class="col-lg-6 col-xs-12">
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Data Pekerjaan</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-4 pull-right">
              <button type="button" name="add" id="add_pekerjaan_button" class="btn form-control btn-success btn-xs">Tambah Pekerjaan</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="pekerjaanTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Pekerjaan</th>
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
<!-- =============== pekerjaan Modal ==================== -->
<div id="pekerjaanModal" class="modal fade">
  <div class="modal-dialog modal-sm">
    <form method="post" id="formPekerjaan" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-pekerjaan-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required />
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <input type="hidden" name="pekerjaan_id" id="pekerjaan_id" />
          <input type="hidden" name="btn_action" id="btn_action" />
          <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- ================ End pekerjaan Modal ================= -->
<!-- ================== Detail Modal ================== -->
<div id="guruDetailModal" class="modal fade">
  <div class="modal-dialog">
      <form method="post" id="product_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i>pekerjaan</h4>
              </div>
              <div class="modal-body">
                  <Div id="pekerjaanDetails"></Div>
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
     // pekerjaan datatable
    var pekerjaanTable = $('#pekerjaanTable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url: "../controller/getData.php",
        type: "POST",
        data:{pekerjaan: "tb_pekerjaan"}
      },
      "columnDefs":[
        {
          "width" : "5%",
          "targets":[0,2,3],
          "orderable":false,
        },
      ],
      "pageLength": 10
    });

    // Add pekerjaan button
    $('#add_pekerjaan_button').click(function(){
      $('#pekerjaanModal').modal('show');
      $('#formPekerjaan')[0].reset();
      $('.modal-pekerjaan-title').html("<i class='fa fa-plus'></i> Tambah Pekerjaan");
      $('#action').val('Add');
      $('#btn_action').val('Add');
    });
    // ============= save data pekerjaan ======
    $(document).on('submit','#formPekerjaan', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      // var formData = $(this).serialize();
      $.ajax({
        url: "../controller/pekerjaanaction.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data){
          $('#formPekerjaan')[0].reset();
          $('#pekerjaanModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          pekerjaanTable.ajax.reload();
        }
      })
    });

    // ============= Display single data and update
    $(document).on('click','.update-pekerjaan',function(){
      var id = $(this).attr("id");
      // $('#nip').prop('disabled',true);
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/pekerjaanaction.php',
        method: 'POST',
        data: {id:id, btn_action:btn_action},
        dataType: 'json',
        success: function(data){
          $('#pekerjaanModal').modal('show');
          $('#pekerjaan').val(data.pekerjaan);
          $('.modal-pekerjaan-title').html("<i class='fa fa-pencil-square-o'></i> Edit Pekerjaan");
          $('#action').val("Edit");
          $('#pekerjaan_id').val(id)
          $('#btn_action').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-pekerjaan',function(){
      var id = $(this).attr("id");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan menghapus pekerjaan ini?")) {
        $.ajax({
          url: '../controller/pekerjaanaction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            pekerjaanTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    // View data ========================
    $(document).on('click','.view-pekerjaan',function(){
      var id = $(this).attr("id");
      var btn_action = 'pekerjaanDetails';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {pekerjaan_id:id,btn_action:btn_action},
        success: function(data) {
          $('#guruDetailModal').modal('show');
          $('#pekerjaanDetails').html(data)
        }
      });
    });

    ////////////////////////
    // End guru datatable //
    ////////////////////////
</script>