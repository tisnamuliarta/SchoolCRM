<?php require 'partials/head_admin.php'; ?>
<?php  
  $content = '';
  $selectTentang = "SELECT * FROM tb_tentang";
  $statement = $connect->prepare($selectTentang);
  $statement->execute();
  $count = $statement->rowCount();

  if (isset($_POST['simpan'])) {
    if ($count > 0) {
      $queryDelete = "DELETE FROM tb_tentang";
      $sDelete = $connect->prepare($queryDelete);
      $sDelete->execute();

      $q = "INSERT INTO tb_tentang (content) VALUES (:tentang)";
      $s = $connect->prepare($q);
      $s->execute(array(
        ':tentang' => $_POST['content']
      ));
    }else {
      $q = "INSERT INTO tb_tentang (content) VALUES (:tentang)";
      $s = $connect->prepare($q);
      $s->execute(array(
        ':tentang' => $_POST['content']
      ));
    }
  }

?>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="box">
      <div class="box-header  with-border">
        <h3 class="box-title"><i class="fa fa-circle-o"></i> Tentang Kami</h3>
      </div>
      <div class="box-body">
        <form method="post">
          <div class="form-group">
            <label>Tentang Kami</label>
            <textarea class="form-control" id="content" name="content" style="height: 150px;" row="50" autofocus required></textarea>
          </div>
          <div class="modal-footer">
              <button type="submit" name="simpan" id="simpan" class="btn btn-info" >Simpan</button>
            </div>
          </div>
        </form>
      </div>

  </div>
</div>
<?php require 'partials/footer.php'; ?>