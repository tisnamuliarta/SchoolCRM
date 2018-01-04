<?php require 'partials/head.php'; ?>

<?php  
$message = "";
$oldUsername = "";
if (isset($_POST['login'])) {
  $_SESSION['oldUsername'] = $_POST['username'];
  $oldUsername = $_POST['username'];
  $query = "SELECT * FROM tb_ortu WHERE username = :username";
  $statement = $connect->prepare($query);
  $statement->execute([
    'username' => $_POST['username']
  ]);
  $count = $statement->rowCount();
  if ($count > 0) {
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      if ($row['status'] == 'active') {
        if (password_verify($_POST['password'], $row['password'])) {
          $_SESSION['logged_id'] = true;
          $_SESSION['id'] = $row['id'];
          $_SESSION['nama_ayah'] = $row['nama_ayah'];
          $_SESSION['nama_ibu'] = $row['nama_ibu'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['status'] = 'ortu';
          header("location: dashboard/index-ortu.php");
        }else {
          $message = "<label class='text-danger'>Password salah!</label>";
        }
      }else {
        $message = "<label class='text-danger'>Akun anda telah di nonaktifkan</label>";
      }
    }
  }else {
    $message = "<label class='text-danger'>Username salah!</label>";
  }
}

?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <box class="box box-solid">
        <div class="box-body">
          <div class="jumbotron container-fluid">
            <h1>TK SINAR PRIMA</h1> 
            <p>Ayo sekolah di TK Sinar Prima.</p> 
          </div>
        </div>
      </box>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-3">
      <div class="box box-solid">
        <div class="box-header">
          <span class="box-title">Login</span>
        </div>
        <div class="box-body">
          <form method="post">
            <?php echo $message; ?>
            <div class="form-group has-feedback">
              <input type="text" name="username" required class="form-control" placeholder="Username" >
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">
              </div>
              <div class="col-xs-4">
                <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="box box-solid">
        <div class="box-header with-border">
          <div class="box-title"><h2>Kegiatan</h2></div>
        </div>
        <div class="box-body">
          <?php  
            // Cek apakah terdapat data page pada URL
            $page = (isset($_GET['page']))? $_GET['page'] : 1;
            $limit = 5; // Jumlah data per halamannya
            // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
            $limit_start = ($page - 1) * $limit;
            $query = "SELECT tb_kegiatan.*, DATE_FORMAT(tb_kegiatan.tgl,'%d %M %Y') as tanggal_kegiatan FROM tb_kegiatan LIMIT ".$limit_start.",".$limit;
            $statement = $connect->prepare($query);
            $statement->execute();
            $kegiatan = $statement->fetchAll();
          ?>
          <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <ul class="timeline">
                  <?php foreach ($kegiatan as $row): ?>
                    <li class="time-label">
                      <span class="bg-red">
                        <?php echo $row['tanggal_kegiatan'] ?>
                      </span>
                    </li>
                    <li>
                      <div class="timeline-item">
                        <h3 class="timeline-header"><?php echo $row['nama'] ?></h3>
                        <div class="timeline-body">
                          <?php echo $row['deskripsi'] ?>
                        </div>
                      </div>
                    </li>
                  <?php endforeach ?>
                  </ul>
              </div>
              <div class="col-md-12">
                <ul class="pagination">
                  <!-- LINK FIRST AND PREV -->
                  <?php
                  if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
                  ?>
                    <li class="disabled"><a href="#">First</a></li>
                    <li class="disabled"><a href="#">&laquo;</a></li>
                  <?php
                  }else{ // Jika page bukan page ke 1
                    $link_prev = ($page > 1)? $page - 1 : 1;
                  ?>
                    <li><a href="index.php?page=1">First</a></li>
                    <li><a href="index.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                  <?php
                  }
                  ?>
                  
                  <!-- LINK NUMBER -->
                  <?php
                  // Buat query untuk menghitung semua jumlah data
                  $sql2 = $connect->prepare("SELECT COUNT(*) AS jumlah FROM tb_kegiatan");
                  $sql2->execute(); // Eksekusi querynya
                  $get_jumlah = $sql2->fetch();
                  
                  $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                  $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                  $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
                  $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                  
                  for($i = $start_number; $i <= $end_number; $i++){
                    $link_active = ($page == $i)? ' class="active"' : '';
                  ?>
                    <li<?php echo $link_active; ?>><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php
                  }
                  ?>
                  
                  <!-- LINK NEXT AND LAST -->
                  <?php
                  // Jika page sama dengan jumlah page, maka disable link NEXT nya
                  // Artinya page tersebut adalah page terakhir 
                  if($page == $jumlah_page){ // Jika page terakhir
                  ?>
                    <li class="disabled"><a href="#">&raquo;</a></li>
                    <li class="disabled"><a href="#">Last</a></li>
                  <?php
                  }else{ // Jika Bukan page terakhir
                    $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                  ?>
                    <li><a href="index.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                    <li><a href="index.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </section>

        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>