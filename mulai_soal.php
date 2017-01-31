<?php include("header.php");
if(isset($_GET['idsoal'])){
	$idsoal = $_GET['idsoal'];
			$data = mysqli_query($connect, "SELECT matapelajaran.namamapel, mastersoal.jumlah_soal, mastersoal.keterangan, COUNT('soal.id_soal') AS jumlah, soal.soal, mastersoal.kelas FROM mastersoal LEFT JOIN soal ON soal.id_soal = mastersoal.id_soal JOIN matapelajaran ON matapelajaran.id_mapel = mastersoal.id_mapel WHERE mastersoal.id_soal LIKE '$idsoal'");
			$hasil = mysqli_fetch_assoc($data);
			$jumlah = $hasil['jumlah'];
			if(is_null($hasil['soal'])){$jumlah = 0;
				}}
				?>
<title>Mulai Soal</title>
	<?php if(!isset($_SESSION["login"])){?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
	</div><?php } elseif($hasil['jumlah_soal'] > $jumlah){
		echo '<div class="alert alert-info alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Warning!</strong> Soal belum siap. Harap pilih soal lain. <a href="daftarsoal">di sini</a>
	</div>';
	}else{?>
	<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
		<ol class="breadcrumb" style="background-color:inherit;">
		<li><a href="index">Beranda</a></li>
		<li><a href="daftar_soal">Daftar Soal</a></li>
		<li class="active"><b>Mulai Soal</b></li>
		</ol>
		<hr />
		<div class="alert alert-info" role="alert">ID Soal: <?php echo $idsoal.' | Matapelajaran: '.$hasil['namamapel'].' | Kelas: '.$hasil['kelas'].' | Jumlah Soal: '.$hasil['jumlah_soal'].' | Keterangan: '.$hasil['keterangan'].'</div>';?>
			<form role="form" action="" method="post">
			<?php 
			$idsoal = $_GET['idsoal'];
			$sql = mysqli_query($connect, "SELECT soal.* , mastersoal.* FROM soal JOIN mastersoal ON mastersoal.id_soal = soal.id_soal WHERE mastersoal.id_soal LIKE '$idsoal' ORDER BY rand()");

				$no = 1;
				while($row = mysqli_fetch_assoc($sql)){
				$jawaban = $row['kunci_jawaban'];
				$id = $row['id_test'];
				$kelas = $row['kelas'];
				;?>
				<div class="list-group"><label><?php echo $no++.'. '.$row['soal'];?></label>
					<div class="radio">
					<input type="hidden" name="jumlah" value="<?php echo $hasil['jumlah'];?>">
					<input type="hidden" name="idmapel" value="<?php echo $row['id_mapel'];?>">
					<input type="hidden" name="kelas" value="<?php echo $kelas;?>">
					<input type="hidden" name="id[]" value="<?php echo $id;?>">
					<input type="hidden" name="idsoal" value="<?php echo $row['id_soal'];?>">
						
					<label>
						<input type="radio" value="A" id="pilihan" name="pilihan[<?php echo $id ?>]">A. <?php echo $row['pil_a']?>
					</label><br>
					<label>
						<input type="radio" value="B" id="pilihan" name="pilihan[<?php echo $id ?>]">B. <?php echo $row['pil_b']?>
					</label><br>
					<label>
						<input type="radio" value="C" id="pilihan" name="pilihan[<?php echo $id ?>]">C. <?php echo $row['pil_c']?>
					</label><br>
					<label>
						<input type="radio" value="D" id="pilihan" name="pilihan[<?php echo $id ?>]">D. <?php echo $row['pil_d']?>
					</label><br>		
					</div>
				</div>
				<?php } ?>
			<input type='submit' name='submit' value='submit jawaban' class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin akan menyimpan Nilai?')">
				</form>
				<br>
<?php }?>
</div>
<br>
<?php include('footer.php')?>

<?php
error_reporting(0);
session_start();
include "config/koneksi.php";

$idtest = $_POST['id'];
$idsoal = $_POST['idsoal'];
$jml = $_POST['jumlah'];
$jawaban  = $_POST['pilihan'];
$iduser = $_SESSION['login'];
$idmapel = $_POST['idmapel'];
$kelas = $_POST['kelas'];
$sql = mysqli_query($connect, "SELECT MAX(id_nilai) as idterakhir FROM nilai");
	$hasil = mysqli_fetch_assoc($sql);
	$ambil= $hasil['idterakhir'];
	$id = $ambil +1;


if(isset($_POST['submit'])){
//jika jawaban ada yang kosong
	if(count($jawaban)=='0'){
		echo "<script>alert('Semua soal belum dikerjakan')</script>";
		echo "<script>javascript:history.go(-1);</script>";
	
	}elseif(count($jawaban)<$jml){
		$kosong = $jml - (count($jawaban));
		echo "<script>alert('Ada $kosong soal yang belum dikerjakan')</script>";
		$benar = 0;
		$salah = 0;
		$kosong = 0;

		for($i = 0; $i < $jml; $i++){

		$nomor = $idtest[$i];
		$jawab = $jawaban[$nomor];
		$db = mysqli_query($connect, "INSERT INTO detailnilai (id_nilai, id_soal, id_test, username, jawaban, tanggal_mulai) VALUES ('$id','$idsoal','$nomor','$iduser', '$jawab', now() )");
		
		if(empty($jawab)){
			$kosong++;
		}

			$query2 = mysqli_query($connect, "SELECT * FROM soal WHERE id_test='$nomor' AND kunci_jawaban = '$jawab'");
			$cek = mysqli_fetch_assoc($query2);

			if($cek){

				$benar++;
			}else{
				$salah++;
			}
		}		

		$score = ($benar *10 ) / $jml ;
		$nilai = substr($score,0,3);

		mysqli_query($connect, "INSERT INTO nilai (id_nilai, id_soal, id_mapel, kelas, username, nilai, benar, salah, tanggal_mulai) VALUES ('$id', '$idsoal', '$idmapel','$kelas','$iduser', '$nilai', '$benar', '$salah', now())");
		echo "<script>document.location.href='lihat_hasil_soal.php'</script>";
		}
		elseif(count($jawaban)==$jml){
			echo "<script>alert('Soal sudah dikerjakan semua, Lihat nilai..')</script>";
			$benar=0;
				$salah=0;
				$kosong=0;

				for ($i = 0; $i < $jml; $i++) {
				$nomor = $idtest[$i];
		$jawab = $jawaban[$nomor];
		mysqli_query($connect, "INSERT INTO detailnilai (id_nilai, id_soal, id_test, username, jawaban, tanggal_mulai) VALUES ('$id','$idsoal','$nomor','$iduser', '$jawab', now() )");
		if (empty($jawab)){
					$kosong++;
		}
		$query2 = mysqli_query($connect, "SELECT * FROM soal WHERE id_test='$nomor' AND kunci_jawaban = '$jawab'");
		$cek = mysqli_fetch_assoc($query2);

		if($cek){
						//jika jawaban cocok (benar)
						$benar++;
					}else{
						//jika salah
						$salah++;
					}
					
				 }
				 $score = ($benar *10 ) / $jml ;
				$nilai = substr($score,0,3);

		mysqli_query($connect, "INSERT INTO nilai (id_nilai, id_soal, id_mapel, kelas, username, nilai, benar, salah, tanggal_mulai) VALUES ('$id', '$idsoal', '$idmapel','$kelas', '$iduser', '$nilai', '$benar', '$salah', now())");
		echo "<script>document.location.href='lihat_hasil_soal.php'</script>";
		}

		}
	?>