<?php 
require 'partials/head.php'; ?>
<?php 
if (isset($_SESSION['logged_id'])) {
  header("location: dashboard/auth-ortu.php");
}
$message = "";
$oldUsername;
if (isset($_POST['register'])) {
  $query = "SELECT * FROM tb_ortu";
  $statement =  $connect->prepare($query);
  $statement->execute();
  $noTelepon = substr($_POST['tlpn'],0,2);
  // if there are any user data on database
  if ($statement->rowCount() > 0) {
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      if ($row['username'] == $_POST['username']) {
        $message .= "Username tidak boleh sama!" ."<br>";
      }else if($row['tlpn'] == $_POST['tlpn']){
        $message .= "Nomer telepon tidak boleh sama!" ."<br>";
      }else if($row['email'] == $_POST['email']) {
        $message .= "Email tidak boleh sama!" ."<br>";
      }else if (($noTelepon != "62") ) {
        $message .= "Nomer telepon harus valid dan diawali dengan 62!" ."<br>";
      }
      else {
        $query = "INSERT INTO tb_ortu (nama,email,username,password,tgl_lahir,alamat,jenis_kelamin,tlpn,status) 
          VALUES (:nama,:email,:username,:password,:tgl_lahir,:alamat,:jenis_kelamin,:tlpn,:status)";
        $statement = $connect->prepare($query);
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $statement->execute(
          array(
            ':nama'     => $_POST['nama'],
            ':email'    => $_POST['email'],
            ':username'   => $_POST['username'],
            ':password'   => $password,
            ':tgl_lahir'  => $_POST['tgl_lahir'],
            ':alamat'   => $_POST['alamat'],
            ':jenis_kelamin'=> $_POST['jenis_kelamin'],
            ':tlpn'     => $_POST['tlpn'],
            ':status'   => 'active'
          )
        );
        header("location: auth-ortu.php");
      }
    }
  }else {
    $query = "INSERT INTO tb_ortu (nama,email,username,password,tgl_lahir,alamat,jenis_kelamin,tlpn,status) 
          VALUES (:nama,:email,:username,:password,:tgl_lahir,:alamat,:jenis_kelamin,:tlpn,:status)";
    $statement = $connect->prepare($query);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $statement->execute(
      array(
        ':nama'     => $_POST['nama'],
        ':email'    => $_POST['email'],
        ':username'   => $_POST['username'],
        ':password'   => $password,
        ':tgl_lahir'  => $_POST['tgl_lahir'],
        ':alamat'   => $_POST['alamat'],
        ':jenis_kelamin'=> $_POST['jenis_kelamin'],
        ':tlpn'     => $_POST['tlpn'],
        ':status'   => 'active'
      )
    );
    header("location: auth-ortu.php");
  }
}
?>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="box">
      <div class="login-logo">
        <a href="javascript:void(0)"><b>Register</b></a>
        <hr>
      </div>
      <!-- /.login-logo -->
      <div class="box-body">
        <div class="">
          <form method="post" id="formRegister">
            <?php if ($message != ""): ?>
              <div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $message; ?></div>
            <?php endif ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" id="email" class="form-control" required />
                  <div class="text-danger" id="emailError"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" required></textarea>
            </div>
            <div class="form-group">
              <label>Jenis Kelamin</label>
              <div class="row">
                <div class="col-md-6">
                  <div class="radio">
                    <label><input type="radio" id="1" name="jenis_kelamin" value="1" required> Laki-laki</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="radio">
                    <label><input type="radio" id="2" name="jenis_kelamin" value="2"> Perempuan</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group has-feedback">
                  <label>Tanggal Lahir</label>
                  <input class="form-control getDatePicker" name="tgl_lahir" id="tgl_lahir" required/>
                  <span class="fa fa-calendar form-control-feedback"></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Handphone</label>
                  <input type="number" class="form-control" name="tlpn" id="tlpn" required value="62" title="Nomer handphone tidak mengandung spasi!" />
                  <div class="text-danger" id="tlpnError"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Username</label>
                  <input class="form-control" name="username" id="username" pattern="^[A-Za-z0-9_]{1,15}$" title="Username tidak mengandung spasi!" required/>
                  <input type="hidden" name="hiddenUsername" id="hiddenUsername">
                  <div class="text-danger" id="usernameError"></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Password</label>
                  <input class="form-control" type="password" required id="password" name="password"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
              </div>
              <div class="col-xs-4">
                <button type="submit" name="register" id="btn-action" class="btn btn-primary btn-block btn-flat">Register</button>
              </div>
            </div>
          </form>
        </div>
         <span>Sudah punya akun? <a href="auth-ortu.php" class="text-center">Login</a></span>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>
<script src="dashboard/plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').change(function(e){
      e.preventDefault();
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });

    $('#errorMessage').change(function(e){
      e.preventDefault();
      $(this).empty();
    });

    $('#register').click(function(event){
      event.preventDefault();
      login();
    });

    // Check
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    $('#btn-action').attr('disabled',false);

    // check if username is same
    $('#username').on('input', function(e){
      e.preventDefault();
      var username = $('#username').val();
      $.ajax({
        url: "controller/checkusername.php",
        method:"POST",
        data: {username:username},
        success: function(data){
          $('#usernameError').html(data);
        }
      });
    });

    // Check if email same
    $('#email').on('input', function(e){
      e.preventDefault();
      var email = $('#email').val();
      $.ajax({
        url: "controller/helper.php",
        method:"POST",
        data: {email:email},
        success: function(data){
          $('#emailError').html(data)
        }
      });
    });
    // Check if phone is same
    $('#tlpn').on('input', function(e){
      e.preventDefault();
      var tlpn = $('#tlpn').val();
      $.ajax({
        url: "controller/checkTlpn.php",
        method: "POST",
        data: {tlpn:tlpn},
        success: function(data){
          $('#tlpnError').html(data)
        }
      })
    });
  });

</script>
