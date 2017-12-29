<?php require 'partials/head.php'; ?>

<div class="container">
<?php  
  $query = "SELECT * FROM tb_faq WHERE status = 'active' ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $idx = 1;

?>
  
<div class="row">
    <div class="col-md-8 col-md-offset-2 col-xs-12">
      <!-- small box -->
      <div class="box box-solid">
        <div class="box-header with-border">
          <p class="box-title">FAQ</p>
        </div>
        <div class="box-body">
          <div class="box-group" id="accordion">
            <?php foreach ($result as $row): ?>
              <div class="panel box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $idx ?>">
                      <?php echo $row['judul'] ?>
                    </a>
                  </h4>
                </div>
                <div id="collapse<?php echo $idx ?>" class="panel-collapse collapse">
                  <div class="box-body">
                    <?php echo $row['kontent'] ?>
                  </div>
                </div>
              </div>
            <?php
              $idx++; 
              endforeach 
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>