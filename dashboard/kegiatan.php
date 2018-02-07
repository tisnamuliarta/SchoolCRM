<?php require 'partials/head_guru.php'; ?>
<span id="alert_action"></span>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-calendar"></i> Daftar Kegiatan</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-md-2 pull-right">
              <div class="btn-group">
                <button type="button" name="add" id="add_tahunajaran_button" class="btn btn-success btn-sm" >Tambah</button>
                <!-- <button type="button" name="terbitkan_buku_penghubung" id="terbitkan_buku_penghubung" class="btn btn-info btn-sm" style="margin-left: 10px;">Terbitkan Buku Penghubung</button> -->
              </div>
              <br><br>
            </div>
          </div>
        </div>
        <div class="row">
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="kegiatanTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th></th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th>Kelas</th>
                  <th>Tanggal</th>
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
</div>

<div id="tahunAjaranModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="formKegiatan" enctype="multipart/form-data">
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
                <label>Nama Kegiatan</label>
                <input type="text" name="nama" id="nama" placeholder="Menulis" class="form-control" required />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" required placeholder="Deskripsi" style="height: 150px;"></textarea>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" id="id_kelas" class="form-control" required>
                  <option value="">Pilih Kelas</option>
                  <?php echo getListKelas($connect) ?>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Kegiatan</label>
                <input type="text" name="tgl" id="tgl" class="form-control displayDatePicker" required />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" id="foto" placeholder="Menulis" class="form-control" required />
              </div>
            </div>
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
                  <h4 class="modal-title"><i class="fa fa-plus"></i>Details </h4>
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

<div id="terbitkanBukuPenghubungModal" class="modal fade">
  <div class="modal-dialog">
      <form method="post" id="buku_penghubung_form">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i>Terbitkan Buku Penghubung</h4>
              </div>
              <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group has-feedback">
                      <label>Pilih Tanggal Kegiatan</label>
                      <input type="text" class="form-control" name="tgl_kegiatan" id="tgl_kegiatan_range">
                      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">         
                  <input type="hidden" name="startDate" id="startDate" />
                  <input type="hidden" name="endDate" id="endDate" />
                  <input type="hidden" name="btn_action_terbitkan" id="btn_action_terbitkan" />         
                  <input type="submit" name="action_terbitkan" id="action_terbitkan" class="btn btn-info" value="Add" />
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </form>
  </div>
</div>

<!--Modal perkembangan-->
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
                                        <input type="text" name="nis" id="nis" class="form-control" readonly required />
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
                                        <input type="text" name="nama" id="nama" class="form-control nama_siswa" readonly required />
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
                                            <input type="text" name="tgl_perkembangan" readonly id="tgl_perkembangan" class="form-control" required />
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
                                        <div class="radio"><label><input type="radio" name="pembiasaan" id="pembiasaan" value="A" required> A</label></div>
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
                                        <div class="radio"><label><input type="radio" name="bahasa" id="bahasa" value="A" required> A</label></div>
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
                                        <div class="radio"><label><input type="radio" name="daya_fikir" id="daya_fikir" value="A" required> A</label></div>
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
                                        <div class="radio"><label><input type="radio" name="motorik" id="motorik" value="A" required> A</label></div>
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
                    <input type="hidden" name="id_kegiatan_siswa" id="id_kegiatan_siswa" />
                    <input type="hidden" name="nis_siswa" id="nis_siswa" />
                    <input type="hidden" name="id_kelas_siswa" id="id_kelas_siswa" />
                    <input type="hidden" name="btn_action_nilai_perkembangan" id="btn_action_nilai_perkembangan" />
                    <input type="submit" name="action_nilai_perkembangan" id="action_nilai_perkembangan" class="btn btn-info" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="listSiswaModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <span id="alert_action_perkembangan"></span>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-list-siswa-title"><i class="fa fa-plus"></i> Add Brand</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="listSiswaTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
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
</div>

<?php require 'partials/footer.php'; ?>
<script type="text/javascript">
  /**
     * ===================================
     * Guru datatable
     * ===================================
     */
      var kegiatanTable = $('#kegiatanTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/getData.php",
          type: "POST",
          data:{kegiatan: "ta"}
        },
        "columnDefs":[
          {
            "targets":[0,6,7],
            "orderable":false,
          },
        ],
        "pageLength": 10
      });

    $('#add_tahunajaran_button').click(function(){
            $('#tahunAjaranModal').modal('show');
            $('#formKegiatan')[0].reset();
            $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Kegiatan");
            $('#action').val('Add');
            $('#btn_action').val('Add');
        });
    $('#terbitkan_buku_penghubung').click(function(){
        $('#terbitkanBukuPenghubungModal').modal('show');
        $('#buku_penghubung_form')[0].reset();
        $('.modal-user-title').html("<i class='fa fa-plus'></i> Terbitkan Buku Penghubung");
        $('#btn_action_terbitkan').val('Add');
      });
    // ============= save data ======
    $(document).on('submit','#formKegiatan', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/kegiatanaction.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data){
          $('#formKegiatan')[0].reset();
          $('#tahunAjaranModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          kegiatanTable.ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-kegiatan',function(){
      var id = $(this).attr("id");
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Kegiatan");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/kegiatanaction.php',
        method: 'POST',
        data: { id:id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#tahunAjaranModal').modal('show');
          $('#nama').val(data.nama);
          $('#deskripsi').val(data.deskripsi);
          $('#tgl').val(data.tgl);
          $('#id_kegiatan').val(id);
          $('select[name="id_kelas"] option[value="'+data.id_kelas+'"]').prop('selected','selected');
          $('#action').val("Edit");
          $('#btn_action').val("Edit");
        }
      })
    });

  // ============= Display list siswa
    $(document).on('click','.add_perkembangan',function(){
      var id = $(this).attr("id");
      var tgl_kegiatan = $(this).data("tgl");
      $('.modal-list-siswa-title').html("<i class='fa fa-plus'></i> List Siswa");
      var btn_action = 'get_list_siswa';
      $.ajax({
          url: '../controller/kegiatanaction.php',
          method: 'POST',
          data: { id:id, btn_action:btn_action,tgl_kegiatan:tgl_kegiatan },
          dataType: 'json',
          success: function(data){
              $('#listSiswaTable').DataTable().destroy();
              $('#listSiswaModal').modal('show');
              $('#listSiswaTable').DataTable({
                  "processing":true,
                  "serverSide":true,
                  "order":[],
                  "ajax":{
                      url: "../controller/getData.php",
                      type: "POST",
                      data:{listSiswaByKegiatan: "ta", id_kegiatan: data.id, id_kelas: data.id_kelas, tgl_kegiatan: data.tgl_kegiatan}
                  },
                  "columnDefs":[
                      {"targets":0,"width":"8%"},
                      {
                          "targets":[0,1],
                          "orderable":false
                      }
                  ],
                  "pageLength": 10
              });
          }
      })
  });

    // ================== delete data
    $(document).on('click','.delete-kegiatan',function(){
      var id = $(this).attr("id");
      var btn_action = 'delete';
      if (confirm("Anda yakin akan menghapus kegiatan ini?")) {
        $.ajax({
          url: '../controller/kegiatanaction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            kegiatanTable.ajax.reload();
          }
        })
      }else {
        return false;
      }
    })

    ////////////////////////
    // End guru datatable //
    ////////////////////////

//    Perkembangan
  // Add perkembangan button

  $('button.add_nilai_perkembangan[data-toggle=modal]').click(function(){
      $('#perkembanganModal').modal('show');
      $('#formPerkembangan')[0].reset();
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Nilai Perkembangan");
      $('#action').val('Add');
      $('#btn_action').val('Add');
      var nis = $(this).data.nis;
      var nama = $(this).data.nama;
      console.log(nis)
  });
  $('#guruDetailModal').on('show.bs.modal', function (event) {
      var zindex = 1041 + (10 * $('.modal:visible').length);
      $(this).css('z-index',zindex);
      setTimeout(function () {
         $('.modal-backdrop').not('.modal-stack').css('z-index',zindex - 2).addClass('modal-stack')
      });
      var button = $(event.relatedTarget);
      var nis = button.data('nis');
      var kegiatan = button.data('kegiatan');
      var btn_action = 'nilaiPerkembanganSiswa';
      $.ajax({
          url: '../controller/helper.php',
          method: 'POST',
          data: {nis:nis,btn_action:btn_action,kegiatan:kegiatan},
          success: function(data) {
              $('#guruDetails').html(data)
          }
      });
  });

  $('#perkembanganModal').on('show.bs.modal', function (event) {
      var zindex = 1041 + (10 * $('.modal:visible').length);
      $(this).css('z-index',zindex);
      setTimeout(function () {
          $('.modal-backdrop').not('.modal-stack').css('z-index',zindex - 2).addClass('modal-stack')
      });
      var button = $(event.relatedTarget);
      var nis = button.data('nis');
      var name = button.data('name');
      var kegiatan = button.data('kegiatan');
      var tglkegiatan = button.data('tglkegiatan');
      var now = new Date();

      var modal = $(this);
      $('#formPerkembangan')[0].reset();
      modal.find('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Nilai Perkembangan");
      $('input#nis').val(nis);
      $('input#nama').val(name);
      $('input#id_kegiatan_siswa').val(kegiatan);
      $('input#tgl_perkembangan').val(tglkegiatan);
      modal.find('.modal-footer input#action_nilai_perkembangan').val('Tambah');
      modal.find('.modal-footer input#btn_action_nilai_perkembangan').val('Add');
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
              $('#alert_action_perkembangan').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
              $('#action_nilai_perkembangan').attr('disabled', false);
              $('#listSiswaTable').DataTable().ajax.reload();
          }
      })
  });
  // ============= Display single data and update
  $(document).on('click','.update_nilai_perkembangan',function(){
      var nis = $(this).attr("id");
      var id_kelas = $(this).data("kelas");
      var id_kegiatan = $(this).data('kegiatan');
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Perkembangan Siswa");
      var btn_action_nilai_perkembangan = 'fetch_single';
      $.ajax({
          url: '../controller/perkembanganaction.php',
          method: 'POST',
          data: { nis:nis, btn_action_nilai_perkembangan:btn_action_nilai_perkembangan,id_kelas:id_kelas,id_kegiatan:id_kegiatan },
          dataType: 'json',
          success: function(data){
              $('#perkembanganModal').modal('show');
              $('#nis').val(data.nis);
              $('.nama_siswa').val(data.nama);
              $('#tgl_perkembangan').val(data.tgl);
              $('input[name="pembiasaan"][value="'+data.pembiasaan+'"]').prop('checked',true);
              $('input[name="bahasa"][value="'+data.bahasa+'"]').prop('checked',true);
              $('input[name="daya_fikir"][value="'+data.daya_fikir+'"]').prop('checked',true);
              $('input[name="motorik"][value="'+data.motorik+'"]').prop('checked',true);
              $('#id_kegiatan_siswa').val(id_kegiatan);
              $('#nis_siswa').val(nis);
              $('#id_kelas_siswa').val(id_kelas);
              $('#action_nilai_perkembangan').val("Edit");
              $('#btn_action_nilai_perkembangan').val("Edit");
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
  });


</script>