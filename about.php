<?php require 'partials/head.php'; ?>

<div class="container">`
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-xs-12">
      <div class="box-header">
        <h2 class="text-center">About Us</h2>
        <hr>
      </div>
      <!-- small box -->
      <div class="box">
        <div class="box-body">
          <section class="content">
            <?php  
              $query = "SELECT * FROM tb_tentang";
              $statement = $connect->prepare($query);
              $statement->execute();
              $result = $statement->fetchAll();
            ?>

            <?php foreach ($result as $row): ?>
              <section><span><?php echo $row['content']; ?></span></section>
            <?php endforeach ?>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>



<?php require 'partials/footer.php'; ?>