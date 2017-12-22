<?php require 'partials/head.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
      <h3 class="text-center">Contact US</h3>
      <hr>
      <div class="box">
        <div class="box-body">
          <form class="form-harizontal" method="post">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama</label>
                  <input class="form-control" type="text" name="nama" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Subject</label>
              <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Message</label>
              <textarea class="form-control" name="message"></textarea>
            </div>
            <div class="form-group text-right">
              <button type="submit" name="sent" class="btn btn-primary">Sent</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'partials/footer.php'; ?>