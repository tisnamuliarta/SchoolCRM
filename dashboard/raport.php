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
                <button type="button" name="add" id="add_raport_button" class="btn form-control btn-success btn-xs">Tambah</button><br><br>
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
                  <th>Tahun Ajaran</th>
                  <th>Semester</th>
                  <th>Pembiasaan</th>
                  <th>Bahasa</th>
                  <th>Daya Fikir</th>
                  <th>Motorik</th>
                  <th>Nilai Akhir</th>
                  <th>Keterangan</th>
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
            <div class="col-sm-12" id="forNewTahun" >
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

            <div class="col-sm-12" id="forNewNIS" >
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

          <div class="row isHide" id="forEditTahun">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Tahun Ajaran</label>
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="thn_ajaran" id="thn_ajaran" class="form-control" readonly required />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row isHide" id="forEditNIS">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Nomer Induk Siswa</label>
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="no_induk" id="no_induk" class="form-control" readonly required />
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
                <div class="col-md-4"><label>Pembiasaan</label></div>
                <div class="col-md-4">
                  <input type="text" name="pembiasaan" id="pembiasaan" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6 m-l-50">
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-5"><label>Bahasa</label></div>
                <div class="col-md-4">
                  <input type="text" name="bahasa" id="bahasa" class="form-control" readonly>
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
                <div class="col-md-5"><label>Daya Fikir</label></div>
                <div class="col-md-4">
                  <input type="text" name="daya_fikir" id="daya_fikir" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-10"><hr><label>Nilai Raport : </label><hr></div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Keterangan</label>
                  </div>
                  <div class="col-md-6">
                    <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row isHide" id="section_naik_kelas">
            <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Naik Kelas / Tinggal Kelas</label>
                    </div>
                    <div class="col-md-3">
                      <div class="radio"><label><input type="radio" name="naik_kelas" id="naik_kelas" value="1" checked> Naik Kelas</label></div>
                    </div>
                    <div class="col-md-3">
                      <div class="radio"><label><input type="radio" name="naik_kelas" id="naik_kelas" value="0"> Tingggal Kelas</label></div>
                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="row" id="section_naik_semester">
            <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Naik Semester</label>
                    </div>
                    <div class="col-md-3">
                      <div class="radio"><label><input type="radio" name="naik_kelas" id="naik_kelas" value="1" checked> Naik Semester</label></div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-10">
              <hr>
              <label>Ket.</label>
            </div>
            <div class="col-md-3"><span>A : 3.28-4.03</span></div>
            <div class="col-md-3"><span>B : 2.52-3.27</span></div>
            <div class="col-md-3"><span>C : 1.76-2.51</span></div>
            <div class="col-md-3"><span>D : 1.00-1.75</span></div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_raport" id="id_raport" />
          <input type="hidden" name="btn_action" id="btn_action" />
          <input type="hidden" name="semester" id="semester" />
          <input type="hidden" name="post_tahun_ajaran" id="post_tahun_ajaran" />
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
          { "width": "15%", "targets": [1,8] },
          {
            "targets":[9],
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
      $('.modal-user-title').html("<i class='fa fa-plus'></i> Tambah Nilai Raport");
      $('#action').val('Add');
      $('#btn_action').val('Add');

      $('#tahun').attr('required','required');
      $('#nis').attr('required','required');
      $('#forEditTahun').addClass('isHide');
      $('#forEditNIS').addClass('isHide');
      $('#forNewTahun').removeClass('isHide');
      $('#forNewNIS').removeClass('isHide');


    });
    // on change select nis
    $('#tahun').change(function(){
      var semester = $(this).find(':selected').data('semester');
      var tahun_ajaran = $(this).find(':selected').data('tahun');
      var tahun = $('#tahun').val();
      var btn_action = 'load_nis_by_semester';
      getSiswaNISByTahun(tahun, btn_action);
      if (semester == 'semester 1') {
        $('#section_naik_kelas').addClass('isHide')
        $('#section_naik_semester').removeClass('isHide')
      }else {
        $('#section_naik_semester').addClass('isHide')
        $('#section_naik_kelas').removeClass('isHide')
      }
      $('#semester').val(semester);
      $('#post_tahun_ajaran').val(tahun_ajaran);
      $('#nama').val("")
      $('#pembiasaan').val("")
      $('#daya_fikir').val("")
      $('#motorik').val("")
      $('#bahasa').val("")
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
          console.log(result)
          $('#pembiasaan').val(result.pembiasaan)
          $('#bahasa').val(result.bahasa)
          $('#daya_fikir').val(result.daya_fikir)
          $('#motorik').val(result.motorik)
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
      $('#tahun').removeAttr('required');
      $('#nis').removeAttr('required');
      $('#forEditTahun').removeClass('isHide');
      $('#forEditNIS').removeClass('isHide');
      $('#forNewTahun').addClass('isHide');
      $('#forNewNIS').addClass('isHide');
      $.ajax({
        url: '../controller/reportAction.php',
        method: 'POST',
        data: { id:id, btn_action:btn_action },
        dataType: 'json',
        success: function(data){
          $('#raportModal').modal('show');
          $('select[name="tahun"] option[value="'+data.tahun+'"]').prop('selected','selected');
          $('select[name="nis"] option[value="'+data.nis+'"]').prop('selected','selected');
          // $('#nis').val(data.nis);
          $('#thn_ajaran').val(data.tahun_ajaran);
          $('#no_induk').val(data.nis);
          $('#nama').val(data.nama);
          $('#tgl').val(data.tgl);
          $('#pembiasaan').val(data.pembiasaan);
          $('#bahasa').val(data.bahasa);
          $('#motorik').val(data.motorik);
          $('#daya_fikir').val(data.daya_fikir);
          $('input[name="kesenian"][value="'+data.kesenian+'"]').prop('checked',true);
          $('input[name="membaca"][value="'+data.membaca+'"]').prop('checked',true);
          $('input[name="mendengarkan"][value="'+data.mendengarkan+'"]').prop('checked',true);
          $('input[name="menulis"][value="'+data.menulis+'"]').prop('checked',true);
          $('#keterangan').val(data.keterangan);
          $('input[name="naik_kelas"][value="'+data.naik_kelas+'"]').prop('checked',true);
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