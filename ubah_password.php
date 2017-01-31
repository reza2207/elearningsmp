<?php include("header.php");?>
<title>Ubah Password</title>
<?php if(!isset($_SESSION["login"])){?>
<div class="container alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
</div><?php } else {?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
<ol class="breadcrumb">
		<li><a href="index">Beranda</a></li>
		<li class="active">Ubah Password</li>
		</ol>
		<hr />
		<?php 
			$username = $_SESSION["login"];
			$sql = mysqli_query($connect, "SELECT * FROM user WHERE username='$username'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: index");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['ubah'])){
				$password = $_POST['password'];
				$konfpass = $_POST['konfpassword'];
				$username = $_POST['username'];
				if($password!=$konfpass){
					echo "<script>alert('Password tidak sama');</script>";
					echo '<div class="alert alert-danger">Password tidak sama. Silahkan coba lagi.</div>';
				}else{
				$update = mysqli_query($connect, "UPDATE user SET password='$password' WHERE username='$username'") or die(mysqli_error());
				}
				if(isset($update)){
					echo '<div class="alert alert-success">Ubah password berhasil.</div>';
				}else{
					echo '<div class="alert alert-danger">Data gagal disimpan, silahkan coba lagi.</div>';
				}
			}
			?>
			<form class="form-horizontal" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">Username</label>
					<div class="col-sm-5">
						<input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="username" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Password Baru</label>
					<div class="col-sm-5">
						<input type="password" name="password" class="form-control" maxlength="8" required placeholder="Masukkan Password Baru">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Konfirmasi Password</label>
					<div class="col-sm-5">
						<input type="password" name="konfpassword" class="form-control" maxlength="8" required placeholder="Ulangi Lagi">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
					<button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
					</div>
				</div>
			</form>
</div>
<?php }?>
<?php include('footer.php')?>