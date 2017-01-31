<?php include("config/koneksi.php");
session_start();
?>
<!doctype html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">

<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/js/jQuery.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/datatables/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/datatables/css/jquery.dataTables.css">
<script src="assets/js/bootstrap.min.js"></script>
<link href='gambar/favicon.ico' rel='shortcut icon'>
<style>
  /* Note: Try to remove the following lines to see the effect of CSS positioning */
  .affix {
      top: 0;
      width: 100%;
  }

  .affix + .container-fluid {
      padding-top: 70px;
  }
</style>
<div class="container-fluid" style="background-color:#FCC43A;color:#00008B;">
	<div class="row" style="font-family:courier;color:#00008B">
    <div class="col-sm-2"><img src="gambar/88.png">
    </div>
      <h1>SMP NEGERI 88 JAKARTA</h1>
  	  <h2>Jl. Anggrek Garuda Slipi Jakarta Barat</h2>
      <?php  /* script menentukan hari */  
      $array_hr= array(1=>"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
      $hr = $array_hr[date('N')];  
      $tgl= date('j');/* script menentukan tanggal */ 
      $array_bln = array(1=>"Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
      $bln = $array_bln[date('n')];/* script menentukan bulan */
      /* script menentukan tahun */ 
      $thn = date('Y');
      /* script perintah keluaran*/ 
      date_default_timezone_set("Asia/Jakarta");
      echo "<h4>".$hr . ", " . $tgl . " " . $bln . " " . $thn . " " . date('H:i')."</h4>";
      ?>  
  </div>
  <div class="row">
    <div class="col-sm-2"></div>
      <?php if(isset($_SESSION["login"])){?>
      <?php echo "<marquee>"."Selamat datang "."<b>".$_SESSION["nama"]."</b> di Elearning SMP Negeri 88 Jakarta"."</marquee>"?>
      <?php } else {?>
      <?php echo"<marquee>"."Selamat datang di Elearning SMP Negeri 88 Jakarta"."</marquee>"?> 
      <?php }?>    
  </div>
</div>

<div><nav class="navbar navbar-default" style="background-color:#F0E68C">
	<div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <span class="navbar-brand">SMP Negeri 88 Jakarta</span>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
    	<ul class="nav navbar-nav">
      	<li><a href="index">Beranda<span class="sr-only"></span></a></li>
      	<li class="dropdown">
        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Soal/Kuis<span class="caret"></span></a>
        	<ul class="dropdown-menu">
            <li><a href="daftar_soal">Daftar Soal/Kuis</a></li>
            <li><a href="lihat_hasil_soal">Lihat Hasil</a></li>
         	</ul>
      	</li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tugas<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="daftar_tugas">Daftar Tugas</a></li>
            <li><a href="lihat_hasil_tugas">Lihat Hasil</a></li>
  	      </ul>
        </li>
        <li><a href="materi_pembelajaran">Materi Pembelajaran</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profil Sekolah<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="sejarah_sekolah">Sejarah Sekolah</a></li>
            <li><a href="visimisi">Visi dan Misi</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if(!isset($_SESSION["login"])){?>
          <form class="form-inline" method="post" action="">
            <div class="form-group">
              <label class="sr-only">Username</label>
              <input type="text" class="form-control input-lg" placeholder="Username" name="username" maxlength="8" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label class="sr-only">Password</label>
              <input type="password" class="form-control input-lg" placeholder="Password" name="password" autocomplete="off" maxlength="10" required>
            </div>
            <button type="submit" class="btn btn-success btn-lg" name="login">Sign in</button>
          </form>
		  </ul>
      </div>
    </div>
    </nav></div>
   			  <?php } else {?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false">
            <i class="glyphicon glyphicon-th-list"></i> Pengaturan<span class="caret"></span>
            </a>
        	<ul class="dropdown-menu">
            <?php if($_SESSION['peran']=='admin'){?>
            <li><a href="kelola_login"><i class="glyphicon glyphicon-wrench"></i> Kelola Login</a></li>
            <li><a href="ubah_password"><i class="glyphicon glyphicon-edit"></i> Ubah Password</a></li>
            <li><a href="logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
            <?php } else {?>
            <li><a href="ubah_password"><i class="glyphicon glyphicon-edit"></i> Ubah Password</a></li>
            <li><a href="logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
            <?php } ?>
          </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav></div>
<?php } ?>

<body style="background-color: #696969">
<?php
if(isset($_POST['login'])){
  $username = mysqli_real_escape_string($connect, trim($_POST['username']));
  $password = mysqli_real_escape_string($connect, $_POST['password']);
  $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
  $runquery = $connect->query($query);
  $row = mysqli_fetch_array($runquery, MYSQLI_ASSOC);

  if($runquery->num_rows > 0) {
    $_SESSION['login'] = $username;
     $_SESSION['nama'] = $row['nama']; 
    $_SESSION['peran'] = $row['peran'];
    $nama = $_SESSION['nama'];
    #print '<script>
   #   swal({
   #         title: "Berhasil",
   #         text: "Klik ok",
   #         type: "success",
   #         showConfirmButton: true,
   #         closeOnConfirm: false,
   #     }, function() {
   #         window.location.href=window.location.href;})</script>';
    print "<script>alert('Selamat Datang $nama');window.location.href=window.location.href;</script>";
  } else {
    print "<script>alert('Maaf, username dan password salah');window.location.href=window.location.href;</script>";
     }

}
?>