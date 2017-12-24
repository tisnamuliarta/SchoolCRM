<?php 
  require 'partials/head_admin.php'; 
?>


<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-money"></i> Tahun Diskon</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-1 pull-right">
              <button type="button" name="add" id="add_diskon_button" class="btn form-control btn-success btn-xs">Add</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="diskonTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NO</th>
                <th>Tahun Ajaran</th>
                <th>Diskon (%)</th>
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

<div id="diskonModal" class="modal fade">
  <div class="modal-dialog modal-sm">
    <form method="post" id="formDiskon">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-user-title"><i class="fa fa-plus"></i> Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                  <option value="">Pilih tahun ajaran</option>
                  <?php echo listAllTa($connect); ?>
                </select>
                <!-- <div class="text-danger" id="nipError"></div> -->
              </div>
            </div>
          </div>
          
          <div class="form-group has-feedback">
            <label>Diskon</label>
            <input type="text" name="diskon" id="diskon" placeholder="10%" class="form-control" required  />
            <span class="fa fa-percent form-control-feedback"></span>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="diskon_id" id="diskon_id" />
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
      var diskonTable = $('#diskonTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "POST",
          data:{diskon: "diskon"}
        },
        "columnDefs":[
          {
            "targets":[0,3],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_diskon_button').click(function(){
        $('#diskonModal').modal('show');
        $('#formDiskon')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Diskon");
        $('#action').val('Add');
        $('#btn_action').val('Add');
      });
    // ============= save data ======
    $(document).on('submit','#formDiskon', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/diskonaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formDiskon')[0].reset();
          $('#diskonModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          diskonTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-diskon',function(){
      var diskon_id = $(this).attr("id");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/diskonaction.php',
        method: 'POST',
        data: {id:diskon_id, btn_action:btn_action},
        dataType: 'json',
        success: function(data){
          $('#diskonModal').modal('show');
          $('#tahun_ajaran').val(data.tahun_ajaran);
          $('#diskon').val(data.diskon);
          $('#diskon_id').val(diskon_id)
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
          url: '../controller/diskonaction.php',
          method: 'POST',
          data: {user_nip: user_nip, status:status, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            diskonTable.ajax.reload();
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