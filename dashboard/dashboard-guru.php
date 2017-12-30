<?php require 'partials/head_guru.php'; ?>

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
            echo getAllTahunAjaran($connect) 
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
    var kelas = $('#kelas').val();
    var tahun_ajaran = $('#tahun_ajaran').val();
    var tgl_perkembangan_mulai = $('#tgl_perkembangan_mulai').val();
    var tgl_perkembangan_akhir = $('#tgl_perkembangan_akhir').val();
    if (tgl_perkembangan_mulai != '' && tgl_perkembangan_akhir != '') {
      $('#perkembanganTable').DataTable().destroy();
      fetchDataMotorik('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir,'motorik');
      fetchDataMotorik('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir,'pembiasaan');
      fetchDataMotorik('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir,'bahasa');
      fetchDataMotorik('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir,'daya_fikir');
    }else{
      alert("Tanggal diperlukan untuk pencarian data");
    }
  })

  function fetchDataMotorik(isSearch,idKelas,idTahunAjaran,startDate,endDate,lesson) {
    $.ajax({
      url: '../controller/ajax/guruDashboardData.php',
      data: {chartType:lesson, isSearch:isSearch,idKelas:idKelas,idTahunAjaran:idTahunAjaran,startDate:startDate,endDate:endDate},
      method: 'GET',
      success: function(data){
        // console.log(data);
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