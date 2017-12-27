<?php require 'partials/head_guru.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-check-square-o"></i> Penilaian Raport</h3>
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
                <button type="button" name="tampilkan_siswa" id="tampilkan_siswa" class="btn form-control btn-info btn-xs">Tampilkan</button><br><br>
              </div>
              <div class="col-sm-1 pull-right">
                <button type="button" name="add" id="add_perkembangan_button" class="btn form-control btn-success btn-xs">Add</button><br><br>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <table id="perkembanganTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tanggal</th>
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
        <div class="modal-body" style="padding-left: 30px;">
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
            <div class="col-md-10"><label>Nilai Perkembangan : </label><hr></div>
            <div class="col-md-6">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-4"><label>Sosialisasi</label></div>
                <div class="col-md-6">
                  <input type="text" name="sosial" id="sosial" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-4"><label>Daya Ingat</label></div>
                <div class="col-md-6">
                  <input type="text" name="daya_ingat" id="daya_ingat" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-4"><label>Motorik</label></div>
                <div class="col-md-6">
                  <input type="text" name="motorik" id="motorik" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-4"><label>Keaktifan</label></div>
                <div class="col-md-6">
                  <input type="text" name="aktif" id="aktif" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-10"><hr><label>Nilai Raport : </label><hr></div>
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Kesenian</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="kesenian" id="kesenian" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="kesenian" id="kesenian" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="kesenian" id="kesenian" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Mendengarkan</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="mendengarkan" id="mendengarkan" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="mendengarkan" id="mendengarkan" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="mendengarkan" id="mendengarkan" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Membaca</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="membaca" id="membaca" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="membaca" id="membaca" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="membaca" id="membaca" value="C"> C</label></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: -25px;">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Menulis</label>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="menulis" id="menulis" value="A"> A</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="menulis" id="menulis" value="B"> B</label></div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio"><label><input type="radio" name="menulis" id="menulis" value="C"> C</label></div>
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
      getNamaSiswa(nis, btn_action);
    })

    // Fill nama siswa field
    function getNamaSiswa(nis,btn_action) {
      $.ajax({
        url: '../controller/perkembanganaction.php',
        method: 'POST',
        data: {nis:nis,btn_action:btn_action},
        success: function(data){
          $('#nama').val(data)
        }
      });
    }



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
          $('input[name="sosial"][value="'+data.sosial+'"]').prop('checked',true);
          $('input[name="motorik"][value="'+data.motorik+'"]').prop('checked',true);
          $('input[name="aktif"][value="'+data.aktif+'"]').prop('checked',true);
          $('input[name="daya_ingat"][value="'+data.daya_ingat+'"]').prop('checked',true);
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