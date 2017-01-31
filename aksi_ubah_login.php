<?php 
if(isset($_POST['ubah'])){
	include("config/koneksi.php");
	$username = $_POST['username'];
	$password = $_POST['password'];
	$nama = ucwords($_POST['nama']);
	$peran = $_POST['peran'];
	$id = $_POST['id'];
	$query = "SELECT * FROM user WHERE username = '$username'";
	$runquery = $connect->query($query);
	$row = mysqli_fetch_array($runquery, MYSQLI_ASSOC);
	$simpan = '';
	if(preg_match('/[0-9]/', $nama)){ //cek ada angka di nama
		$simpan == 2;
		//echo "ada angka";
	}elseif(!preg_match("/^[a-zA-Z0-9]{4,8}$/", $username)){ //batasan input data
	    $simpan == 2;
	    //echo "harus angka dan huruf";
	}elseif(strlen($password) < 6){
		$simpan == 2;
		//echo "kurang dari 6";
	}elseif($runquery->num_rows > 0 && $username!=$id) {
		//print "<script>alert('Username Sudah Terdaftar');
		//javascript:window.location = 'kelolalogin.php?username_ada';</script>";
		$simpan == 3;
	//header('location:kelolalogin.php?username_ada');
	}else{
		$simpan == 1;
	}
echo var_dump($simpan);
	if($simpan==2){
	header("location:ubah_login.php?gagal&username=$id");
	}elseif($simpan==1){
	mysqli_query($connect,"UPDATE user SET username='$username', password='$password', nama='$nama', peran='$peran' WHERE username='$id'");
	print "<script>alert('Berhasil Diubah');
	javascript:window.location = 'kelola_login.php?ubah_success';</script>";
	}elseif($simpan==3){
		print "<script>alert('Username Sudah Terdaftar');
		javascript:window.location = 'ubah_login.php?username_ada&username=$id';</script>";
	}else{
		header("location:ubah_login.php?gagal&username=$id");
		
}
?>