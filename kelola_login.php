<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Kelola Login</title>
</head>
<body>
<?php include("header.php");?>
<?php if(!isset($_SESSION["login"])){?>
<script>javascript:history.go(-1);</script>
<?php } elseif($_SESSION['peran']=='admin') {?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
	<div class="content">
	<ol class="breadcrumb">
	<li><a href="index">Beranda</a></li>
	<li class="active">Kelola Login</li>
	</ol>
	<hr />
			
			<?php
			if(isset($_GET['aksi']) == 'delete'){
				$username = $_GET['username'];
				$cek = mysqli_query($connect, "SELECT * FROM user WHERE username='$username'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info">Data tidak ditemukan.</div>';
				}else{
					$delete = mysqli_query($connect, "DELETE FROM user WHERE username='$username'");
					if($delete){
						echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>User berhasil dihapus.</strong>
	  						</div>';
					}else{
						echo '<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>User gagal dihapus.</strong>
	  						</div>';
					}
				}
			}
			if(isset($_GET['success'])){
				echo '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Login berhasil didaftarkan.</strong>
	  						</div>';
			}elseif(isset($_GET['gagal'])){
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Login tidak berhasil didaftarkan.</strong>
	  						</div>';				
			}elseif(isset($_GET['username_ada'])){
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Username sudah ada.</strong></div>';				
		
			}
			?>
			<div class="row">
			<div class="col-sm-1">
			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="peran" class="form-control" onchange="form.submit()">
						<option value="0">Semua</option>
						<?php $peran = (isset($_GET['peran']) ? strtolower($_GET['peran']) : NULL);  ?>
						<option value="siswa" <?php if($peran == 'siswa'){ echo 'selected'; } ?>>Siswa</option>
						<option value="guru" <?php if($peran == 'guru'){ echo 'selected'; } ?>>Guru</option>
						<option value="admin" <?php if($peran == 'admin'){ echo 'selected'; } ?>>Admin</option>
					</select>
				</div>
			</form>
			</div>
			<div class="col-sm-4">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahdata">[+]Tambah Login</span></button>
			</div>
<!--modal-->
<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="tambahdata">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="gridSystemModalLabel" align="center">Tambah Login</h4>
      	</div>
      	<form role="form" action="" method="POST">
	    	<div class="modal-body">
	      		<div class="container-fluid">
	  				<div class="form-group">
	    				<label for="username">Username:</label>
	    				<input type="text" class="form-control" name="username" maxlength="8" placeholder="Masukkan NIS/NIP..." required>
	    				<p class="help-block">Tidak boleh mengandung spasi.</p>
	 				</div>
	  				<div class="form-group">
		    			<label for="pwd">Password:</label>
		    			<input type="password" class="form-control" name="password" maxlength="8" placeholder="Masukkan Password..." required>
		    			<p class="help-block">Password minimal 6 karakter.</p>
	  				</div>
	  				<div class="form-group">
		    			<label for="nama">Nama Lengkap:</label>
		    			<input type="text" class="form-control" name="nama" maxlength="40" placeholder="Masukkan Nama..." required>
		    			<p class="help-block">Tidak boleh mengandung angka.</p>
	 				</div>
	  				<div class="form-group">
		  				<label for="sel1">Peran:</label>
						<select class="form-control" name="peran">
							<option value="siswa">Siswa</option>
						    <option value="guru">Guru</option>
						    <option value="admin">Admin</option>
						</select>
					</div>
	       		</div>
	       	</div>
	      	<div class="modal-footer">
		    	<button type="reset" class="btn btn-default">Reset</button>
		    	<button type="submit" name="submit" class="btn btn-primary">Tambah</button>
	   </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
<br />
	<div class="table-responsive">
		<table class="table table-striped table-hover dtbl">
			<thead>
			<tr>
				<th>NO.</th>
				<th>USERNAME</th>
				<th>PASSWORD</th>
				<th>NAMA</th>
				<th>PERAN</th>
				<th>AKSI</th>
			</thead>	
			</tr>
			<?php
				if($peran){
					$sql = mysqli_query($connect, "SELECT * FROM user WHERE peran='$peran' ORDER BY username ASC");
				}else{
					$sql = mysqli_query($connect, "SELECT * FROM user ORDER BY username ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$row['username'].'</td>
							<td>'.$row['password'].'</td>
							<td>'.$row['nama'].'</td>
							<td>'.$row['peran'].'</td>
							<td>
								<a href="ubah_login.php?username='.$row['username'].'" class="btn btn-warning btn-sm" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="kelola_login.php?aksi=delete&username='.$row['username'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div>

<?php }else{?>
<script>javascript:history.go(-1);</script>
<?php }?>
<br>
<?php include('footer.php')?>
</body>
</html>

<?php
if(isset($_POST['submit'])){
	include("config/koneksi.php");
	$username = $_POST['username'];
	$password = $_POST['password'];
	$nama = ucwords($_POST['nama']);
	$peran = $_POST['peran'];
	$simpan='';
	$query = "SELECT * FROM user WHERE username = '$username'";
	$runquery = $connect->query($query);
	$row = mysqli_fetch_array($runquery, MYSQLI_ASSOC);

	if (preg_match('/[0-9]/', $nama)){ //cek ada angka di nama
		$simpan = 0;
		//echo "ada angka";
	}elseif(!preg_match("/^[a-zA-Z0-9]{4,8}$/", $username)){ //batasan input data
	    $simpan = 0;
	    //echo "harus angka dan huruf";
	}elseif(strlen($password) < 6){
		$simpan = 0;
		//echo "kurang dari 6";
	}elseif($runquery->num_rows > 0) {
		//print "<script>alert('Username Sudah Terdaftar');
		//javascript:window.location = 'kelolalogin.php?username_ada';</script>";
		$simpan =3;
	//header('location:kelolalogin.php?username_ada');
	}else{
		$simpan = 1;
	}

	if($simpan==0){
	header('location:kelola_login.php?gagal');
	}elseif($simpan==1){
	mysqli_query($connect, "INSERT INTO user (username, password, nama, peran) VALUES ('$username', '$password', '$nama', '$peran')");
	print "<script>alert('Berhasil Didaftarkan');
	javascript:window.location = 'kelola_login.php?success';</script>";
	}elseif($simpan==3){
		print "<script>alert('Username Sudah Terdaftar');
		javascript:window.location = 'kelola_login.php?username_ada';</script>";
	}
		
}
?>
<script type="text/javascript" src="assets/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/datatables/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('table.dtbl').DataTable({
		"pagingType": "full_numbers",        
          "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data"
        }
        });
     
      });
</script>