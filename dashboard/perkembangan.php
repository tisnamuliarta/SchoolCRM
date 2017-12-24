<?php require 'partials/head_guru.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-check-square-o"></i> Penilaian Perkembangan</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-1 pull-right">
              <button type="button" name="add" id="add_perkembangan_button" class="btn form-control btn-success btn-xs">Add</button>
              <br><br>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="perkembanganTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NO</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Sosialisasi</th>
                <th>Motorik</th>
                <th>Daya Ingat</th>
                <th>Keaktifan</th>
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

<div id="perkembanganModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="formPerkembangan">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-user-title"><i class="fa fa-plus"></i> Add Brand</h4>
          <div class="text-danger"></div>
        </div>
        <div class="modal-body" style="padding-left: 60px;">
          <div class="row">
            <div class="col-sm-10"><label>Data siswa : </label><hr></div>
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Nomer Induk Siswa</label>
                  </div>
                  <div class="col-md-6">
                    <select type="text" name="nis" id="nis" class="form-control" required >
                      <option value="">Pilih NIS</option>
                      <?php echo listSiswaNISnotNull($connect) ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Nama</label>
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="nama" id="nama" class="form-control" readonly required />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-10"><label>Nilai Perkembangan : </label><hr></div>
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Sosialisasi</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="sosialisasi" id="sosialisasi" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="sosialisasi" id="sosialisasi" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="sosialisasi" id="sosialisasi" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Motorik</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="motorik" id="motorik" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="motorik" id="motorik" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="motorik" id="motorik" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Daya Ingat</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_ingat" id="daya_ingat" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_ingat" id="daya_ingat" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_ingat" id="daya_ingat" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Keaktifan</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="keaktifan" id="keaktifan" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="keaktifan" id="keaktifan" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="keaktifan" id="keaktifan" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-10">
              <label>Ket.</label>
            </div>
            <div class="col-md-4"><span>A : 75-100</span></div>
            <div class="col-md-4"><span>B : 50-74</span></div>
            <div class="col-md-4"><span>C : 0-49</span></div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_kegiatan" id="id_kegiatan" />
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
      var perkembanganTable = $('#perkembanganTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/data/perkembangan.php",
          type: "POST",
          data:{kegiatan: "ta"}
        },
        "columnDefs":[
          {"targets":0,"width":"5%"},
          {"targets":2,"width":"30%"},
          {"targets":3,"width":"15%"},
          {
            "targets":[0,4,5],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });
      // Add perkembangan button
      $('#add_perkembangan_button').click(function(){
        $('#perkembanganModal').modal('show');
        $('#formPerkembangan')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Tahun Ajaran");
        $('#action').val('Add');
        $('#btn_action').val('Add');
      });
      // on change select nis
      $('#nis').change(function(){
        var nis = $('#nis').val();
        var btn_action = 'load_nama_siswa';
        $.ajax({
          url: '../controller/perkembanganaction.php',
          method: 'POST',
          data: {nis:nis,btn_action:btn_action},
          success: function(data){
            $('#nama').val(data)
          }
        });
      })
    // ============= save data ======
    $(document).on('submit','#formPerkembangan', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/perkembanganaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formPerkembangan')[0].reset();
          $('#perkembanganModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          perkembanganTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-kegiatan',function(){
      var id = $(this).attr("id");
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Tahun Ajaran");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/perkembanganaction.php',
        method: 'POST',
        data: { id:id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#perkembanganModal').modal('show');
          $('#nama').val(data.nama);
          $('#deskripsi').val(data.deskripsi);
          $('#tgl').val(data.tgl);
          $('#id_kegiatan').val(id)
          $('#action').val("Edit");
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
          url: '../controller/perkembanganaction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            perkembanganTable.ajax.reload();
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