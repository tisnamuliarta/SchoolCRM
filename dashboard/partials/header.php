<?php if ($_SESSION['status'] == 'admin'): ?>
  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TK</b>SP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TK SINAR PRIMA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-user"></i> <?= $_SESSION['username']  ?></a>
          </li>
          <li>
            <a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

<?php else: ?>
  <header class="main-header">
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TK</b>SP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TK SINAR PRIMA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li><a href="../index.php" target="_blank">Home <span class="sr-only">(current)</span></a></li>
          <li><a href="../about.php" target="_blank">About Us</a></li>
          <li><a href="../contact.php" target="_blank">Contact</a></li>
          <li><a href="../galeri.php" target="_blank">Gallery</a></li>
          <li><a href="../faq.php" target="_blank">FAQ</a></li>
        </ul>
      </div>
    </nav>


    
  </header>
<?php endif ?>