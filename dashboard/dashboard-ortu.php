<?php require 'partials/head.php'; ?>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-4">
        <select name="nama-siswa" id="nama-siswa" class="form-control">
          <?php echo getListSiswaByOrtu($connect,$_SESSION['id']) ?>
        </select>
      </div>
      <div class="col-md-3">
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

  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <section class="content-header">
      <h1 >Grafik Perkembangan Nilai Siswa</h1>
    </section>
    <hr>
    <div>
      <div class="box-body">
        <div class="row">

          <div class="col-md-8">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Grafik Hasil Belajar</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartHasilBelajar" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>
<script type="text/javascript">
  $('#tampilkan_siswa').click(function(){
    var nis = $('#nama-siswa').val();
    var tahun_ajaran = $('#tahun_ajaran').val();
    $('#perkembanganTable').DataTable().destroy();
    fetchDataMotorik('yes',nis,tahun_ajaran,'hasil');
  })

  function fetchDataMotorik(isSearch,nis,idTahunAjaran,lesson) {
    $.ajax({
      url: '../controller/ajax/getGrafikHasilBelajar.php',
      data: {chartType:lesson, isSearch:isSearch,nis:nis,idTahunAjaran:idTahunAjaran},
      method: 'GET',
      success: function(data){
        console.log(data);
        var id = [];
        var nilai = [];
        var toJSON = $.parseJSON(data);

        $.each(toJSON, function(k,v){
          id.push(v.id);
          nilai.push(v.nilai);
        })

        var ctx = $("#barChart"+lesson);
        var barGraph = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: id,
            datasets: [{
              label: 'Jumlah data '+lesson,
              data: nilai,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true
                }
              }]
            }
          }
        });
      }
    });
  }
</script>