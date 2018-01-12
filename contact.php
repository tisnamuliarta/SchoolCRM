<?php require 'partials/head.php'; ?>
<?php  
  $select = $connect->prepare("SELECT * FROM tb_tentang");
  $select->execute();
  $result = $select->fetch(PDO::FETCH_ASSOC);

?>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h3 class="text-center">Contact US</h3>
      <hr>
      <div class="box box-solid">
        <div class="box-body">
            <div class="col-12">
              <div class="row">
                <div class="col-md-6">
                  <p><i class="fa fa-map-marker"></i>Jalan Jayagiri XXIV A, Denpasar, Bali</p>
                  <p><i class="fa fa-phone"></i> <a href="telp:+6281238123456">081238123456</a></p>
                  <p>Jam Operasional</p>
                  <p><i class="fa fa-clock"></i>Senin-Jumat: 08:00 - 12:00 WITA</p>
                </div>
                <div class="col-md-6">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.3333109522428!2d115.2263685143306!3d-8.659816093777478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2408f653df637%3A0x75c53c643f72a583!2sJalan+Jaya+Giri+Utara+XXIV%2C+Sumerta+Kelod%2C+Denpasar+Tim.%2C+Kota+Denpasar%2C+Bali+80234!5e0!3m2!1sen!2sid!4v1515721439136" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


<?php require 'partials/footer.php'; ?>