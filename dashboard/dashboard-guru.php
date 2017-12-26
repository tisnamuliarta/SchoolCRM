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
                  <canvas id="barChartMotorik" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Daya Ingat</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartDayaIngat" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Keaktifan</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartKeaktifan" style="height:230px"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Sosialisasi</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartSosialisasi" style="height:230px"></canvas>
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
      fetchDataMotorik('yes',kelas,tahun_ajaran,tgl_perkembangan_mulai,tgl_perkembangan_akhir);
    }else{
      alert("Tanggal diperlukan untuk pencarian data");
    }
  })

  function fetchDataMotorik(isSearch,idKelas,idTahunAjaran,startDate,endDate) {
    $.ajax({
      url: '../controller/ajax/guruDashboardData.php',
      data: {chartType:'motorik', isSearch:isSearch,idKelas:idKelas,idTahunAjaran:idTahunAjaran,startDate:startDate,endDate:endDate},
      method: 'GET',
      success: function(data){
        // console.log(data);
        var id = [];
        var nilai = [];
        console.log(data.length)
        for(var i in data) {
          console.log(data[i].id);
          id.push("Nilai " + data[i].id);
          nilai.push(data[i].nilai);
        }

        // var chartdata = {
        //   labels: id,
        //   datasets : [
        //     {
        //       label: 'Nilai Motorik',
        //       backgroundColor: 'rgba(200, 200, 200, 0.75)',
        //       borderColor: 'rgba(200, 200, 200, 0.75)',
        //       hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
        //       hoverBorderColor: 'rgba(200, 200, 200, 1)',
        //       data: nilai
        //     }
        //   ]
        // };

        // var ctx = $("#barChartMotorik");

        // var barGraph = new Chart(ctx, {
        //   type: 'bar',
        //   data: chartdata
        // });
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
</script>