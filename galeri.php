<?php require 'partials/head.php'; ?>
<?php  
  $query = "SELECT * FROM tb_galeri WHERE status = 'active'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
?>

<div class="container">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <!-- small box -->

      <div class="row">
        <?php foreach ($result as $row): ?>
          <?php  
            // Select galeri detail
            $query = "SELECT * FROM tb_galeri_detail WHERE id_galeri = :id_galeri";
            $galeri = $connect->prepare($query);
            $galeri->execute(array(':id_galeri' => $row['id']));
            $galeriResult = $galeri->fetchAll();
            $idx = 1;
          ?>

          <div class="col-sm-4">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo $row['judul'] ?></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div id="carousel-example-generic<?php echo $row['id'] ?>" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-example-generic<?php echo $row['id'] ?>" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-example-generic<?php echo $row['id'] ?>" data-slide-to="1" class=""></li>
                      <li data-target="#carousel-example-generic<?php echo $row['id'] ?>" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner">
                      <?php 
                      $i=0;
                      foreach ($galeriResult as $key){ 
                        $i++;
                        ?>
                          <div class="item <?php echo ($i==1)?'active':''?> " >
                            <img src="uploads/<?php echo $key['foto'] ?>" >
                          </div>
                        <?php 
                          $idx++;
                        } 
                      ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic<?php echo $row['id'] ?>" data-slide="prev">
                      <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic<?php echo $row['id'] ?>" data-slide="next">
                      <span class="fa fa-angle-right"></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>
      </div>

  </div>
  
</div>


<?php require 'partials/footer.php'; ?>