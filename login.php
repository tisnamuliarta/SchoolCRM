<?php 
include 'connection.php';
// include 'controller/Login.php';
// createGuru($connect);
// createOrtu($connect);
if (isset($_SESSION['logged_id'])) {
  header("location: dashboard/index.php");
}
$message = "";
$oldUsername = "";
if (isset($_POST['login'])) {
  $_SESSION['oldUsername'] = $_POST['username'];
  $oldUsername = $_POST['username'];
  $query = "SELECT * FROM tb_guru WHERE username = :username";
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
          $_SESSION['nip'] = $row['nip'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['nama'] = $row['nama'];
          $_SESSION['status'] = $row['type'];
          header("location: dashboard/index.php");
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

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TK SINAR PRIMA | LOGIN</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="dashboard/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dashboard/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dashboard/plugins/iCheck/square/blue.css">
  <style type="text/css">
    body {
      height: auto;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:void(0)"><b>TK SINAR PRIMA</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
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
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="dashboard/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="dashboard/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="dashboard/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
