<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
<!--     <div class="user-panel">
      <div class="pull-left image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div> -->
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <?php if ($_SESSION['status'] == 'admin'): ?>
        <li id="link-sidebar"><a href="index.php"><i class="fa fa-dashboard"></i> 
          <span>Dashboard</span></a>
        </li>
        <li id="link-sidebar"><a href="user.php"><i class="fa fa-user-secret "></i> 
          <span>User</span></a>
        </li>
        <li id="link-sidebar"><a href="guru.php"><i class="fa fa-user"></i> 
          <span>Guru</span></a>
        </li>
        <li id="link-sidebar"><a href="galeri.php"><i class="fa fa-file-picture-o"></i> 
          <span>Galeri & Kelas</span></a>
        </li>
        <li id="link-sidebar"><a href="tahunajaran.php"><i class="fa fa-calendar-plus-o"></i> 
          <span>Tahun Ajaran</span></a>
        </li>
        <li id="link-sidebar"><a href="diskon.php"><i class="fa fa-money"></i> 
          <span>Diskon</span></a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Pengaturan Lain</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="tentangkami.php"><i class="fa fa-circle-o"></i> Tentang Kami</a></li>
            <li><a href="faq.php"><i class="fa fa-circle-o"></i> FAQ</a></li>
          </ul>
        </li>

      <?php elseif($_SESSION['status'] == 'guru'): ?>
        <li id="link-sidebar"><a href="guru-index.php"><i class="fa fa-home"></i> 
          <span>Home</span></a>
        </li>
        <li id="link-sidebar"><a href="dashboard-guru.php"><i class="fa fa-dashboard"></i> 
          <span>Dashboard</span></a>
        </li>
        <li id="link-sidebar"><a href="siswa.php"><i class="fa fa-users"></i> 
          <span>Siswa Baru</span></a>
        </li>
        <li id="link-sidebar"><a href="daftar-siswa.php"><i class="fa fa-users"></i> 
          <span>Data Siswa</span></a>
        </li>
        <li id="link-sidebar"><a href="kegiatan.php"><i class="fa fa-check-square"></i> 
          <span>Kegiatan</span></a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Penilaian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="perkembangan.php"><i class="fa fa-circle-o"></i> Perkembangan</a></li>
            <li><a href="raport.php"><i class="fa fa-circle-o"></i> Raport</a></li>
          </ul>
        </li>
      <?php elseif($_SESSION['status'] == 'ortu'): ?>
        <li id="link-sidebar"><a href="index-ortu.php"><i class="fa fa-home"></i> 
          <span>Home</span></a>
        </li>
        <li id="link-sidebar"><a href="dashboard-ortu.php"><i class="fa fa-dashboard"></i> 
          <span>Dashboard</span></a>
        </li>
        <li id="link-sidebar"><a href="siswa-baru.php"><i class="fa fa-users"></i> 
          <span>Daftar Siswa Baru</span></a>
        </li>
        <li id="link-sidebar"><a href="hasil-belajar.php"><i class="fa fa-book"></i> 
          <span>Buku Penghubung</span></a>
        </li>
        <li id="link-sidebar"><a href="buku-penghubung.php"><i class="fa fa-star"></i> 
          <span>Hasil Belajar</span></a>
        </li>
        <li id="link-sidebar"><a href="pengaturan-akun.php"><i class="fa fa-gears"></i> 
          <span>Pengaturan Akun</span></a>
        </li>
        <li id="link-sidebar"><a href="../logout.php"><i class="fa fa-sign-out"></i> 
          <span>Logout</span></a>
        </li>
      <?php endif ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>