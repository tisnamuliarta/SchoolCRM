<?php require 'partials/head_admin.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-circle-o"></i> FAQ</h3>
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
            <table id="faqTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NO</th>
                <th>Judul</th>
                <th>Content</th>
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

<div id="FAQModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="formFAQ">
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
                <label>Judul</label>
                <input type="text" name="judul" id="judul" placeholder="Apa itu TK?" class="form-control" required />
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Kontent</label>
            <textarea name="kontent" id="kontent" class="form-control" style="height: 150px;" required></textarea>
          </div>

          <div class="form-group" id="statusfaq">
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
          <input type="hidden" name="faq_id" id="faq_id" />
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
      var faqTable = $('#faqTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "POST",
          data:{faq: "ta"}
        },
        "columnDefs":[
          {
            "width":"8%",
            "targets":[0,3,4,5],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

      $('#add_tahunajaran_button').click(function(){
        $('#FAQModal').modal('show');
        $('#formFAQ')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah FAQ");
        $('#action').val('Add');
        $('#btn_action').val('Add');
      });
    // ============= save data ======
    $(document).on('submit','#formFAQ', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/faqaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formFAQ')[0].reset();
          $('#FAQModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          faqTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-faq',function(){
      var faq_id = $(this).attr("id");
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Tahun Ajaran");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/faqaction.php',
        method: 'POST',
        data: { faq_id:faq_id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#FAQModal').modal('show');
          $('#judul').val(data.judul);
          $('#kontent').val(data.kontent);
          $('input[type="radio"]#'+data.status+'').prop('checked',true);
          $('#faq_id').val(faq_id)
          $('#action').val("Edit");
          $('#btn_action').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-faq',function(){
      var id = $(this).attr("id");
      var status = $(this).data("status");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan menghapus faq ini?")) {
        $.ajax({
          url: '../controller/faqaction.php',
          method: 'POST',
          data: {id: id, status:status, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            galeriTable.ajax.reload();
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