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
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-1">
                <select name="kelas" id="kelas" class="form-control">
                  <?php echo getListKelas($connect) ?>
                </select>
              </div>
              <div class="col-md-3">
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                  <?php
                    $tahun = date('Y'); 
                    echo listTahunAjatan($connect,$tahun) 
                  ?> 
                </select>
              </div>
              <div class="col-md-2 ">
                <div class="has-feedback">
                  <input type="text" placeholder="dari tanggal" name="tgl_perkembangan_mulai" id="tgl_perkembangan_mulai" class="form-control getDatePicker">
                  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                </div>
              </div>
              <div class="col-md-2 ">
                <div class="has-feedback">
                  <input type="text" placeholder="ke tanggal" name="tgl_perkembangan_akhir" id="tgl_perkembangan_akhir" class="form-control getDatePicker">
                  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                </div>
              </div>
              <div class="col-md-2 ">
                <button type="button" name="tampilkan_siswa" id="tampilkan_siswa" class="btn form-control btn-info btn-xs">Tampilkan</button><br><br>
              </div>
              <div class="col-sm-1 pull-right">
                <button type="button" name="add" id="add_perkembangan_button" class="btn form-control btn-success btn-xs">Add</button><br><br>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="perkembanganTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Tanggal</th>
                  <th>Pembiasaan</th>
                  <th>Bahasa</th>
                  <th>Daya Fikir</th>
                  <th>Motorik</th>
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
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Tanggal</label>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group has-feedback">
                      <input type="text" name="tgl" id="tgl" class="form-control getDatePicker" required />
                      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    </div>
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
                    <label>Pembiasaan</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="pembiasaan" id="pembiasaan" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="pembiasaan" id="pembiasaan" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="pembiasaan" id="pembiasaan" value="C"> C</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="pembiasaan" id="pembiasaan" value="D"> D</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Bahasa</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="bahasa" id="bahasa" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="bahasa" id="bahasa" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="bahasa" id="bahasa" value="C"> C</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="bahasa" id="bahasa" value="D"> D</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Daya Fikir/Daya Cipta</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_fikir" id="daya_fikir" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_fikir" id="daya_fikir" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_fikir" id="daya_fikir" value="C"> C</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="daya_fikir" id="daya_fikir" value="D"> D</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Fisik/Motorik</label>
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
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="motorik" id="motorik" value="D"> D</label></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
          <div class="row">
            <div class="col-sm-10">
              <label>Ket.</label>
            </div>
            <div class="col-md-3"><span>A : 3.28-4.03</span></div>
            <div class="col-md-3"><span>B : 2.52-3.27</span></div>
            <div class="col-md-3"><span>C : 1.76-2.51</span></div>
            <div class="col-md-3"><span>D : 1.00-1.75</span></div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_perkembangan" id="id_perkembangan" />
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
    fetchData('no');
    function fetchData(isSearch,kelas='',tahunAjaran='',tgl_perkembangan_mulai='',tgl_perkembangan_akhir=''){
      var perkembanganTable = $('#perkembanganTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/data/perkembangan.php",
          type: "POST",
          data:{kegiatan: "ta",isSearch:isSearch,kelas:kelas,tahunAjaran:tahunAjaran,tgl_perkembangan_mulai:tgl_perkembangan_mulai,tgl_perkembangan_akhir:tgl_perkembangan_akhir}
        },
        "columnDefs":[
          {"targets":1,"width":"20%"},
          {
            "targets":[8],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });
    }

    $('#tampilkan_siswa').click(function(){
      var kelas = $('#kelas').val();
      var tahun_ajaran = $('#tahun_ajaran').val();
      var tgl_perkembangan_mulai = $('#tgl_perkembangan_mulai').val();
      var tgl_perkembangan_akhir = $('#tgl_perkembangan_akhir').val();
      if (kelas != '' && tahun_ajaran != '') {
        $('#perkembanganTable').DataTable().destroy();
        fetchData('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir);
      }else{
        alert("Tanggal diperlukan untuk pencarian data");
      }
    })

      // Add perkembangan button
      $('#add_perkembangan_button').click(function(){
        $('#perkembanganModal').modal('show');
        $('#formPerkembangan')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Nilai Perkembangan");
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
          $('#perkembanganTable').DataTable().ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-perkembangan',function(){
      var id = $(this).attr("id");
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Perkembangan Siswa");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/perkembanganaction.php',
        method: 'POST',
        data: { id:id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#perkembanganModal').modal('show');
          $('#nis').val(data.nis);
          $('#nama').val(data.nama);
          $('#tgl').val(data.tgl);
          $('input[name="pembiasaan"][value="'+data.pembiasaan+'"]').prop('checked',true);
          $('input[name="bahasa"][value="'+data.bahasa+'"]').prop('checked',true);
          $('input[name="daya_fikir"][value="'+data.daya_fikir+'"]').prop('checked',true);
          $('input[name="motorik"][value="'+data.motorik+'"]').prop('checked',true);
          $('#id_perkembangan').val(id)
          $('#action').val("Edit");
          $('#btn_action').val("Edit");
        }
      })
    });

    // ================== delete data
    $(document).on('click','.delete-perkembangan',function(){
      var id = $(this).attr("id");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan menghapus data ini?")) {
        $.ajax({
          url: '../controller/perkembanganaction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            $('#perkembanganTable').DataTable().ajax.reload();
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