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
            $kegiatan = getActivity($connect);
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
              </div>
            </section>

        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>