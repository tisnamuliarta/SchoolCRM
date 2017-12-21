<?php require 'partials/head.php'; ?>

<div class="container">`
  <div class="row">
    <div class="col-lg-12 col-xs-12">
      <!-- small box -->
      <div class="box">
        <div class="box-header">
          <p class="box-title">About Us</p>
          <hr>
        </div>
        <div class="box-body">
          <?php  
            $query = "SELECT * FROM tb_tentang";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
          ?>

          <?php foreach ($result as $row): ?>
            <section><?php echo $row['content']; ?></section>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</div>



<?php require 'partials/footer.php'; ?>