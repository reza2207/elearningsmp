<?php include("header.php");?>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<?php if(isset($_GET['username'])){
echo '<title>Ubah login '.$_GET['username'].'</title>';	
}else{
	echo '<title>Ubah Login</title>';}?>
	<?php if(!isset($_SESSION["login"])){?>
	<div class="container alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
	</div>
	<?php } elseif(!isset($_GET['username'])) {
		header('location:index');}
		else{?>
	<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
	<ol class="breadcrumb">
	<li><a href="index">Beranda</a></li>
	<li><a href="kelola_login">Kelola Login</a></li>
	<li class="active">Ubah Login</li>
	</ol>
	<hr />

	<?php
	$id = $_GET['username'];
	$query = mysqli_query($connect,"SELECT * FROM user where username = '$id'") or die(mysqli_error());
	$data = mysqli_fetch_assoc($query);}?>
	<?php
	
	if(isset($_GET['success'])){
		echo '<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Login berhasil diubah.</strong>
						</div>';
	}elseif(isset($_GET['gagal'])){
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Login tidak berhasil diubah.</strong>
						</div>';				
	}elseif(isset($_GET['username_ada'])){
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Username sudah ada.</strong></div>';
	}
	if(mysqli_num_rows($query) == 0){
		echo '<div class="alert alert-danger">Tidak ada data. </div>';
	}else{?>
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<label for="username" class="col-sm-4 control-label">Username:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="username" value="<?php echo $id;?>"/>
				<input type="hidden" class="form-control" name="id" value="<?php echo $id;?>"/>
			</div>
		</div>
		<div class="form-group">
      		<label for="password lama" class="col-sm-4 control-label">Password Baru:</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" name="password" value="<?php echo $data['password'];?>">
	      	</div>
		</div>
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="nama" maxlength="40" value="<?php echo $data['nama'];?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="peran" class="col-sm-4 control-label">Peran:</label>
			<div class="col-sm-2">
				<select class="form-control" name="peran">
					<option value="siswa">Siswa</option>
				    <option value="guru">Guru</option>
				    <option value="admin">Admin</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8 control-label">
				<button type="reset" class="btn btn-default" name="reset">Reset</button>
				<button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
			</div>
		</div>
	</form>
<?php }?>
</div>
<!-- script datepicker -->
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<script src="assets/js/jQuery.js"></script>
		<script src="assets/js/moment.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$('#tanggalkumpul').datetimepicker({
					format:'DD/MM/YYYY hh:mm A'});
			});
		</script>
<!-- script datepicker -->
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<script src="assets/js/jQuery.js"></script>
		<script src="assets/js/moment.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$('#tanggalkumpul').datetimepicker({
					format:'DD/MM/YYYY hh:mm A'});
			});
		</script>
		<br>		
<?php include('footer.php')?>
<?php 
if(isset($_POST['ubah'])){
	include("config/koneksi.php");
	$username = $_POST['username'];
	$password = $_POST['password'];
	$nama = ucwords($_POST['nama']);
	$peran = $_POST['peran'];
	$id = $_POST['id'];
	$simpan='';
	$query = "SELECT * FROM user WHERE username = '$username'";
	$runquery = $connect->query($query);
	$row = mysqli_fetch_array($runquery, MYSQLI_ASSOC);
	$simpan = '';
	if(preg_match('/[0-9]/', $nama)){ //cek ada angka di nama
		$simpan = 2;
		//echo "ada angka";
	}elseif(!preg_match("/^[a-zA-Z0-9]{4,8}$/", $username)){ //batasan input data
	    $simpan = 2;
	    //echo "harus angka dan huruf";
	}elseif(strlen($password) < 6){
		$simpan = 2;
		//echo "kurang dari 6";
	}elseif($runquery->num_rows > 0 && $username!=$id) {
		//print "<script>alert('Username Sudah Terdaftar');
		//javascript:window.location = 'kelolalogin.php?username_ada';</script>";
		$simpan = 3;
	//header('location:kelolalogin.php?username_ada');
	}else{
		$simpan = 1;
	}

	if($simpan==2){
	print "<script>javascript:window.location = 'ubah_login.php?gagal&username=$id';</script>";
	}elseif($simpan==1){
	mysqli_query($connect,"UPDATE user SET username='$username', password='$password', nama='$nama', peran='$peran' WHERE username='$id'");
	print "<script>alert('Berhasil Diubah');
	javascript:window.location = 'kelola_login.php?ubah_success';</script>";
	}elseif($simpan==3){
		print "<script>alert('Username Sudah Terdaftar');
		javascript:window.location = 'ubah_login.php?username_ada&username=$id';</script>";
	}
		
}
?>