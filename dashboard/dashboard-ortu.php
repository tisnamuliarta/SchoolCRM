<?php require 'partials/head.php'; ?>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-2">
        <select name="nama-siswa" id="nama-siswa" class="form-control">
          <?php echo getListSiswaByOrtu($connect,$_SESSION['id']) ?>
        </select>
      </div>
      <div class="col-md-2">
        <select name="month" id="month" class="form-control">
          <?php 
            for ($m=1; $m<=12; $m++) {
             $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
             echo "<option value='{$m}'>{$month}</option>";
             }
          ?>
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

          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Motorik</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartmotorik" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Pembiasaan</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartpembiasaan" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Daya Fikir</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartdaya_fikir" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Bahasa</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartbahasa" style="height:230px"></canvas>
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
    var month = $('#month').val();
    $('#perkembanganTable').DataTable().destroy();
    fetchDataPerkembanganSiswa('yes',nis,tahun_ajaran,month,'motorik');
    fetchDataPerkembanganSiswa('yes',nis,tahun_ajaran,month,'pembiasaan');
    fetchDataPerkembanganSiswa('yes',nis,tahun_ajaran,month,'bahasa');
    fetchDataPerkembanganSiswa('yes',nis,tahun_ajaran,month,'daya_fikir');
  })

  function fetchDataPerkembanganSiswa(isSearch,nis,idTahunAjaran,month,lesson) {
    $.ajax({
      url: '../controller/ajax/getGrafikPerkembanganSiswa.php',
      data: {chartType:lesson, isSearch:isSearch,nis:nis,idTahunAjaran:idTahunAjaran,month:month},
      method: 'GET',
      success: function(data){
        var minggu = [];
        var nilai = [];
        var huruf = [];
        var toJSON = $.parseJSON(data);

        var arr = $.each(toJSON, function(k,v){
          minggu.push(v.minggu);
          nilai.push(v.nilai);
          huruf.push(v.huruf);
        })

        // console.log(toJSON)

        var ctx = $("#barChart"+lesson);
        var barGraph = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: minggu,
            datasets: [{
              label: 'Nilai ',
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
            legend: {
                display: true,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                },
                text: 'Legend',
            },
            scales: {
              xAxes:[{
                scaleLabel: {
                    display: true,
                    labelString: 'Minggu Ke'
                }
              }],
              yAxes: [{
                  ticks: {
                    beginAtZero:true
                  },
                  scaleLabel: {
                      display: true,
                      labelString: '1=>D, 2=>C, 3=>C, 4=>A '
                  }
              }]
            }
          }
        });
      }
    });
  }
</script>