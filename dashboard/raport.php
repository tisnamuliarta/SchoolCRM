<?php require 'partials/head_guru.php'; ?>
<style type="text/css">
  @media screen and (min-width: 992px) {
    .m-l-50 {
      margin-left: -50px;
    }
  }
</style>


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
                <button type="button" name="add" id="add_raport_button" class="btn form-control btn-success btn-xs">Add</button><br><br>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="raportTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Sosialisasi</th>
                  <th>Motorik</th>
                  <th>Daya Ingat</th>
                  <th>Keaktifan</th>
                  <th>Kesenian</th>
                  <th>Mendengarkan</th>
                  <th>Membaca</th>
                  <th>Menulis</th>
                  <th>Nilai Akhir</th>
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

<div id="raportModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="formRaport">
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
                    <label>Tahun Ajaran</label>
                  </div>
                  <div class="col-md-6">
                    <select name="tahun" id="tahun" class="form-control" required>
                      <option value="">Pilih Tahun Ajaran</option>
                      <?php
                        $tahun = date('Y'); 
                        echo listTahunAjatan($connect,$tahun) 
                      ?> 
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Nomer Induk Siswa</label>
                  </div>
                  <div class="col-md-6">
                    <select type="text" name="nis" id="nis" class="form-control" required >
                      <option value="">Pilih NIS</option>
                      <!-- <?php echo listSiswaNISnotNull($connect) ?> -->
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
                <div class="col-md-4">
                  <input type="text" name="sosial" id="sosial" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6 m-l-50">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-5"><label>Daya Ingat</label></div>
                <div class="col-md-4">
                  <input type="text" name="daya_ingat" id="daya_ingat" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-4"><label>Motorik</label></div>
                <div class="col-md-4">
                  <input type="text" name="motorik" id="motorik" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6 m-l-50">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-5"><label>Keaktifan</label></div>
                <div class="col-md-4">
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
                    <div class="radio"><label><input required type="radio" name="kesenian" id="kesenian" value="A"> A</label></div>
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
                    <div class="radio"><label><input required type="radio" name="mendengarkan" id="mendengarkan" value="A"> A</label></div>
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
                    <div class="radio"><label><input required type="radio" name="membaca" id="membaca" value="A"> A</label></div>
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
                    <div class="radio"><label><input required type="radio" name="menulis" id="menulis" value="A"> A</label></div>
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
            <div class="col-md-4"><span>A : 2.4-3.0</span></div>
            <div class="col-md-4"><span>B : 1.7-2.3</span></div>
            <div class="col-md-4"><span>C : 1.0-1.6</span></div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_raport" id="id_raport" />
          <input type="hidden" name="btn_action" id="btn_action" />
          <input type="hidden" name="tgl" id="tgl" value="<?php echo date('Y-m-d') ?>">
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
    function fetchData(isSearch,kelas='',tahunAjaran=''){
      var raportTable = $('#raportTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url: "../controller/data/dataraport.php",
          type: "GET",
          data:{kegiatan: "ta",isSearch:isSearch,kelas:kelas,tahunAjaran:tahunAjaran}
        },
        "columnDefs":[
          { "width": "20%", "targets": 0 },
          {
            "targets":[12],
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
        $('#raportTable').DataTable().destroy();
        fetchData('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir);
      }else{
        alert("Tanggal diperlukan untuk pencarian data");
      }
    })

    // Add perkembangan button
    $('#add_raport_button').click(function(){
      $('#raportModal').modal('show');
      $('#formRaport')[0].reset();
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Nilai Perkembangan");
      $('#action').val('Add');
      $('#btn_action').val('Add');
    });
    // on change select nis
    $('#tahun').change(function(){
      var tahun = $('#tahun').val();
      var btn_action = 'load_nis_by_semester';
      getSiswaNISByTahun(tahun, btn_action);
      $('#nama').val("")
      $('#sosial').val("")
      $('#daya_ingat').val("")
      $('#motorik').val("")
      $('#aktif').val("")
    })

    $('#nis').change(function(){
      var tahun = $('#tahun').val();
      var nis = $('#nis').val();
      var btn_action = 'load_nama_siswa';
      getNamaSiswa(nis, btn_action);
      fillTheBlankInput(nis,'fill_blank_input',tahun);
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

    function getSiswaNISByTahun(tahun,btn_action) {
      $.ajax({
        url: '../controller/reportAction.php',
        method: 'GET',
        data: {tahun:tahun,btn_action:btn_action},
        success: function(data){
          $('#nis').html("<option value=''>Pilih NIS</option>"+data)
        }
      });
    }

    function fillTheBlankInput(nis, btn_action,tahun){
      $.ajax({
        url: '../controller/reportAction.php',
        method: 'GET',
        data: {nis:nis,btn_action:btn_action,tahun:tahun},
        success: function(data) {
          var result = $.parseJSON(data);
          $('#sosial').val(result.sosialisasi)
          $('#daya_ingat').val(result.daya_ingat)
          $('#motorik').val(result.motorik)
          $('#aktif').val(result.keaktifan)
        }
      });
    }

    // ============= save data ======
    $(document).on('submit','#formRaport', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/reportAction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#formRaport')[0].reset();
          $('#raportModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          $('#raportTable').DataTable().ajax.reload();
        }
      })
    });
    // ============= Display single data and update
    $(document).on('click','.update-raport',function(){
      var id = $(this).attr("id");
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Edit Raport");
      var btn_action = 'fetch_single';
      $.ajax({
        url: '../controller/reportAction.php',
        method: 'POST',
        data: { id:id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#raportModal').modal('show');
          $('select[name="tahun"] option[value="'+data.tahun+'"]').prop('selected','selected');
          getSiswaNISByTahun(data.tahun, 'load_nis_by_semester');
          $('select[name="nis"] option[value="'+data.nis+'"]').prop('selected','selected');
          // $('#nis').val(data.nis);
          $('#nama').val(data.nama);
          $('#tgl').val(data.tgl);
          $('#sosial').val(data.sosial);
          $('#motorik').val(data.motorik);
          $('#aktif').val(data.aktif);
          $('#daya_ingat').val(data.daya_ingat);
          $('input[name="kesenian"][value="'+data.kesenian+'"]').prop('checked',true);
          $('input[name="membaca"][value="'+data.membaca+'"]').prop('checked',true);
          $('input[name="mendengarkan"][value="'+data.mendengarkan+'"]').prop('checked',true);
          $('input[name="menulis"][value="'+data.menulis+'"]').prop('checked',true);
          $('#id_raport').val(id)
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
          url: '../controller/reportAction.php',
          method: 'POST',
          data: {id: id, btn_action:btn_action},
          success: function(data) {
            $('#alert_action').fadeIn().html('<div class="alert alert-info alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>')
            $('#raportTable').DataTable().ajax.reload();
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