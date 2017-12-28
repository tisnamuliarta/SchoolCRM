<?php require 'partials/head_admin.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-calendar"></i> Tahun Ajaran</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-1 pull-right">
              <button type="button" name="add" id="add_tahunajaran_button" class="btn form-control btn-success btn-xs">Add</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="tahunAjaranTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NO</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
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

<div id="tahunAjaranModal" class="modal fade">
  <div class="modal-dialog modal-sm">
    <form method="post" id="formTahunAjaran">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-user-title"><i class="fa fa-plus"></i> Add Brand</h4>
          <div class="text-danger"></div>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun" id="tahun" placeholder="2011/2012" class="form-control" required pattern="[^\s]+" title="Tidak boleh ada spasi!" />
                <!-- <div class="text-danger" id="nipError"></div> -->
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control">
              <option value="semester 1">Semester 1</option>
              <option value="semester 2">Semester 2</option>
            </select>
          </div>

          <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="text" name="tgl_mulai" id="tgl_mulai" placeholder="2017-01-21" class="form-control getDatePicker" required  />
          </div>

          <div class="form-group">
            <label>Tanggal Selesai</label>
            <input type="text" name="tgl_selesai" id="tgl_selesai" placeholder="2017-01-21" class="form-control getDatePicker" required  />
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="ta_id" id="ta_id" />
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
      var tahunAjaranTable = $('#tahunAjaranTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "POST",
          data:{tahunajaran: "ta"}
        },
        "columnDefs":[
          {
            "targets":[0,5],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_tahunajaran_button').click(function(){
        $('#tahunAjaranModal').modal('show');
        $('#formTahunAjaran')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Tahun Ajaran");
        $('#action').val('Add');
        $('#btn_action').val('Add');
      });
    // ============= save data ======
    $(document).on('submit','#formTahunAjaran', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/tahunajaranaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formTahunAjaran')[0].reset();
          $('#tahunAjaranModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          tahunAjaranTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-tahunajaran',function(){
      var ta_id = $(this).attr("id");
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Tahun Ajaran");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/tahunajaranaction.php',
        method: 'POST',
        data: { ta_id:ta_id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#tahunAjaranModal').modal('show');
          $('#tahun').val(data.tahun);
          // $('#semester').val(data.semester);
          $('select[name="semester"] option[value="'+data.semester+'"]').attr('selected','selected');
          $('#tgl_mulai').val(data.tgl_mulai);
          $('#tgl_selesai').val(data.tgl_selesai);
          $('#ta_id').val(ta_id)
          $('#action').val("Edit");
          $('#btn_action').val("Edit");
        }
      })
    });

    ////////////////////////
    // End guru datatable //
    ////////////////////////
</script>