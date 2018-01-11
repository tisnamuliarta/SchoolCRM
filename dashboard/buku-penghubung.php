<?php require 'partials/head.php'; ?>
<div class="row">
  <div class="col-md-10 col-sm-12 col-md-offset-1">
    <div class="row">
      <div class="col-md-3">
        <select name="nama_siswa" id="nama_siswa" class="form-control">
          <?php echo getListSiswaByOrtu($connect,$_SESSION['id']) ?>
        </select>
      </div>
      
      <div class="col-md-2">
        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
          <?php
            echo getAllBukuPenghubungTahunAjaran($connect) 
          ?> 
        </select>
      </div>
      <div class="col-md-2">
        <select name="semester" id="semester" class="form-control">
          <option value="semester 1">Semester 1</option>
          <option value="semester 2">Semester 2</option>
        </select>
      </div>
      <div class="col-md-2">
        <select name="week" id="week" class="form-control">
          <?php  
            $number = 0;
            for ($i=1; $i <=53 ; $i++) { 
              echo "<option value='{$i}''>Minggu ke-{$i}</option>";
            }
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
    <div class="col-sm-12 col-md-8 col-md-offset-2">
      <div id="formLoadRaport">
        <div class="box box-solid">
          <div class="box-header with-border">
            <h2 class="text-center">TK SINAR PRIMA</h2>
          </div>
          <div class="box-body" id="buku_penghubung_content">
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

      $('#tampilkan_siswa').click(function(e){
        e.preventDefault();
        $('#formLoadRaport').load(' #formLoadRaport')
        var nis = $('#nama_siswa').val();
        var tahun_ajaran = $('#tahun_ajaran').val();
        var week = $('#week').val();
        var semester = $('#semester').val();
        var id_ortu = <?php echo $_SESSION['id']; ?>;
        if (nis != '' && tahun_ajaran != '' && week != '') {
          $.ajax({
            url: '../controller/reportAction.php',
            method: 'GET',
            data: {btn_action:'getBukuPenghubung',nis:nis,tahun_ajaran:tahun_ajaran,id_ortu:id_ortu,week:week,semester:semester},
            dataType: 'json',
            success: function(data){
              // var result = $.parseJSON(data);
              
              var content = $('#buku_penghubung_content');
              content.append("<p>Dear Parents,</p>"+"<p>Untuk minggu ke-"+week+" tahun ajaran "+tahun_ajaran+" anak-anak belajar</p>");
              $.each(data, function(idx, elem){
                content.append("<ul><li>"+"<img src='../uploads/kegiatan/"+elem.foto+"' style='width:80px;height:auto' />"+" <strong>"+elem.nama+"</strong>"+ " seperti "+elem.deskripsi+"</li></ul>")
              });
              content.append("<br><br><p>Demikian buku penghubung kegiatan siswa TK SINAR PRIMA. Atas perhatian Bapak/Ibu Orang Tua Siswa, kami ucapkan terima kasih.</p>")
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