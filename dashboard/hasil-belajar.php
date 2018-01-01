<?php require 'partials/head.php'; ?>
<div class="row">
  <div class="col-md-8 col-sm-12 col-md-offset-2">
    <div class="row">
      <div class="col-md-4">
        <select name="nama_siswa" id="nama_siswa" class="form-control">
          <?php echo getListSiswaByOrtu($connect,$_SESSION['id']) ?>
        </select>
      </div>
      <div class="col-md-4">
        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
          <?php
            echo getAllTahunAjaran($connect) 
          ?> 
        </select>
      </div>
      <div class="col-md-2 ">
        <button type="button" name="tampilkan_siswa" id="tampilkan_siswa" class="btn form-control btn-info btn-xs">Tampilkan</button><br><br>
      </div>
    </div>
  </div>
</div>

<div class="contentHasilBelajar">
  <div class="row">
    <div class="col-md-12">
      <h2 class="text-center">TK SINAR PRIMA</h2>
    </div>
    <div class="col-sm-12 col-md-8 col-md-offset-2">
      <div id="formLoadRaport">
        <div class="box box-solid">
          <div class="box-body">
            <div class="">
              <table class="table table-striped table-bordered" id="siswatable">
                <thead>
                  <tr>
                    <th width="80%" style="text-align: center;top: 0">Kompetensi Dasar</th>
                    <th width="20%" style="text-align: center;">Hasil Belajar</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<span id="alert_action"></span>

<?php require 'partials/footer.php'; ?>
<script type="text/javascript">
  // ================== User datatable =============
      // fetchData('no');

      // function fetchData(isSearch,nis='',tahun_ajaran='') {
      //   var id_ortu = <?php echo $_SESSION['id']; ?>;
      //   var userTable = $('#siswatable').DataTable({
      //     "paging":false,
      //     "searching":false,
      //     "ordering":false,
      //     "info":false,
      //     "processing":true,
      //     "serverSide":true,
      //     "order":[],
      //     "ajax":{
      //       url: "../controller/getData.php",
      //       data: {isSearch:isSearch,hasilBelajar: "siswa-baru",id_ortu:id_ortu,nis:nis,tahun_ajaran:tahun_ajaran},
      //       type: "GET"
      //     },
      //     "columnDefs":[
      //       {
      //         "targets":[0,1],
      //         "orderable":false,
      //       },
      //     ],
      //     "pageLength": 10
      //   });
      // }

      $('#tampilkan_siswa').click(function(e){
        e.preventDefault();
        $('#formLoadRaport').load(' #formLoadRaport')
        var nis = $('#nama_siswa').val();
        var tahun_ajaran = $('#tahun_ajaran').val();
        var id_ortu = <?php echo $_SESSION['id']; ?>;
        if (nis != '' && tahun_ajaran != '') {
          // $('#siswatable').DataTable().destroy();
          // fetchData('yes',nis,tahun_ajaran);
          $.ajax({
            url: '../controller/reportAction.php',
            method: 'GET',
            data: {btn_action:'getHasilBelajar',nis:nis,tahun_ajaran:tahun_ajaran,id_ortu:id_ortu},
            dataType: 'json',
            success: function(data){
              var result;
              var table = $('#siswatable tbody');
              $.each(data, function(idx, elem){
                table.append("<tr><td>"+elem.kompetensi+"</td><td>"+elem.nilai+"</td> </tr>");
              })
            }
          });
        }
      })

      // add button clicked
      $('#add_button').click(function(){
        $('#siswaBaruModal').modal('show');
        $('#siswaForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Tambah Siswa");
        $('#action').val('Add');
        $('#btn_action').val('Add');
        var idOrtu = <?php echo $_SESSION['id']; ?>;
        var jumlahAnak = $.ajax({
            url: '../controller/helper.php',
            data: {id_ortu:idOrtu},
            method: 'POST',
            success: function(data){
              $('#jumlahAnak').val(data)
            }
          });
      });
      // konfirmasi pembayaran button clicked
      $('#konfirmasi_pendaftaran_btn').click(function(){
        $('#konfirmasiSiswaModal').modal('show');
        $('.modal-title').html("<i class='fa fa-plus'></i> Tambah Siswa");
        $('#action_konfirm').val('Konfirm');
        $('#btn_action_konfirm').val('Konfirm');
      });
    // ============= save data
    $(document).on('submit','#siswaForm', function(e){
      e.preventDefault();
      $('#action').attr('disabled','disabled');
      var formData = $(this).serialize();
      $.ajax({
        url: "../controller/siswaaction.php",
        method: "POST",
        data: formData,
        success: function(data){
          $('#siswaForm')[0].reset();
          $('#siswaBaruModal').modal('hide');
          $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
          $('#action').attr('disabled', false);
          userTable.ajax.reload();
          window.location.reload(true);
        }
      })
    });

    // View data ========================
    $(document).on('click','.view-user',function(){
      var id_siswa = $(this).attr("id");
      var btn_action = 'user_details';
      $.ajax({
        url: '../controller/helper.php',
        method: 'POST',
        data: {id_siswa:id_siswa,btn_action:btn_action},
        success: function(data) {
          $('#userDetailModal').modal('show');
          $('#userDetails').html(data)
        }
      });
    });
</script>