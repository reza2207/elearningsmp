<?php include("header.php");?>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<?php if(isset($_GET['idtugas'])){
echo '<title>Edit Tugas '.$_GET['idtugas'].'</title>';	
}else{
	header('location:daftar_tugas');}?>

<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
	
	<?php if(!isset($_SESSION["login"])){?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
	</div>
	<?php }?>

	<ol class="breadcrumb" style="background-color:inherit">
	<li><a href="index">Beranda</a></li>
	<li><a href="daftar_tugas">Daftar Tugas</a></li>
	<li class="active"><b>Edit Tugas</b></li>
	<li><a href="lihat_hasil_tugas">Lihat Hasil Tugas</a></li>
	</ol>
	<hr />
	<?php
	$id = $_GET['idtugas'];
	$query = mysqli_query($connect,"select tugas.*, kelas.nama_kelas, matapelajaran.namamapel from tugas JOIN kelas ON kelas.kelas = tugas.kelas JOIN matapelajaran ON matapelajaran.id_mapel=tugas.id_mapel where tugas.id_tugas LIKE '$id'") or die(mysqli_error());
	$data = mysqli_fetch_assoc($query);?>

	<?php
	if(mysqli_num_rows($query) == 0){
		echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Tidak ada data.</strong></div>';
	}elseif(isset($_GET['tanggalerror'])){?>
		<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Input tanggal salah.</strong></div>
		<form role="form" action="" method="post">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
		      		<input type="hidden" class="form-control" name="idtugas" value="<?php echo $id;?>"/>
					<label for="matpel">Mata Pelajaran:</label>
					<select class="form-control" name="matpel" required>
					<option value="<?php echo $data['id_mapel'];?>"><?php echo $data['namamapel'];?></option>
					<?php
						$idmapel= $data['id_mapel'];
						$sql = mysqli_query($connect, "SELECT * FROM matapelajaran namamapel WHERE id_mapel<>'$idmapel'");
					if (mysqli_num_rows($sql) != 0) { 
						while ($row = mysqli_fetch_assoc($sql)){
							echo '<option value='.$row['id_mapel'].'>'.$row['namamapel'].'</option>';
						}
					}?>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
				<?php $tanggal= date('d/m/Y h:i A',strtotime($data['tanggalpembuatan']));
		      		$tgl = date('d/m/Y/H/i', strtotime($data['tanggalpembuatan']));?>
					<label>Tanggal Pembuatan:</label>
					<input type='text' class="form-control" readonly value="<?php echo $tanggal;?>" />
		      		<input type="hidden" class="form-control" name="tglubah" value="<?php echo $tgl;?>"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">

				<?php $tanggalkumpul = date('d/m/Y h:i A',strtotime($data['bataspengumpulan']));?>
    				<label for="tanggal">Batas Pengumpulan:</label>
					<input type='text' class="form-control " id='tanggalkumpul' name="bataskumpul" placeholder="<?php echo $tanggalkumpul;?>">
					<input type='hidden' name="bataskumpul2" value="<?php echo $data['bataspengumpulan'];?>">

    			</div>
    		</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="kelas">Kelas:</label>
					<select class="form-control" name="kelas" required>
					<option value='<?php echo $data['kelas'];?>'><?php echo $data['nama_kelas'];?></option>
					<?php $namakelas = $data['kelas'];
					$query = mysqli_query($connect, "SELECT * FROM kelas WHERE kelas<>'$namakelas'");
					   if(mysqli_num_rows($query)) {
					      while ($baris = mysqli_fetch_assoc($query)) {?>
						     <option value='<?php echo $baris['kelas'];?>'><?php echo $baris['nama_kelas'];?></option>
					      <?php }?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="keterangan">Keterangan:</label>
			<textarea type='text' class="form-control" name="keterangan" maxlength="100" required><?php echo $data['keterangan'];?></textarea>
		</div>
		<div class="form-group">
			<button type="reset" class="btn btn-default" name="reset">Reset</button>
			<button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
		</div>
		</div>
	</form>
		
	
<?php }?>
<?php }else{?>
	<form role="form" method="post">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
		      		<input type="hidden" class="form-control" name="idtugas" value="<?php echo $id;?>"/>
					<label for="matpel">Mata Pelajaran:</label>
					<select class="form-control" name="matpel" required>
					<option value="<?php echo $data['id_mapel'];?>"><?php echo $data['namamapel'];?></option>
					<?php
						$idmapel= $data['id_mapel'];
						$sql = mysqli_query($connect, "SELECT * FROM matapelajaran namamapel WHERE id_mapel<>'$idmapel'");
					if (mysqli_num_rows($sql) != 0) { 
						while ($row = mysqli_fetch_assoc($sql)){
							echo '<option value='.$row['id_mapel'].'>'.$row['namamapel'].'</option>';
						}
					}?>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
				<?php $tanggal= date('d/m/Y h:i A',strtotime($data['tanggalpembuatan']));
						$tanggalkumpul = date('d/m/Y h:i A',strtotime($data['bataspengumpulan']));
		      		$tgl = date('d/m/Y/H/i', strtotime($data['tanggalpembuatan']));?>
					<label>Tanggal Pembuatan:</label>
					<input type='text' class="form-control" readonly value="<?php echo $tanggal;?>" />
		      		<input type="hidden" class="form-control" name="tglubah" value="<?php echo $tgl;?>"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
    				<label for="tanggal">Batas Pengumpulan:</label>
					<input type='text' class="form-control " id='tanggalkumpul' name="bataskumpul" placeholder="<?php echo $tanggalkumpul;?>">
					<input type='hidden' name="bataskumpul2" value="<?php echo $data['bataspengumpulan'];?>">
    			</div>
    		</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="kelas">Kelas:</label>
					<select class="form-control" name="kelas" required>
					<option value='<?php echo $data['kelas'];?>'><?php echo $data['nama_kelas'];?></option>
					<?php $namakelas = $data['kelas'];
					$query = mysqli_query($connect, "SELECT * FROM kelas WHERE kelas<>'$namakelas'");
					   if(mysqli_num_rows($query)) {
					      while ($baris = mysqli_fetch_assoc($query)) {?>
						     <option value='<?php echo $baris['kelas'];?>'><?php echo $baris['nama_kelas'];?></option>
					      <?php }?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="keterangan">Keterangan:</label>
			<textarea type='text' class="form-control" name="keterangan" maxlength="100" required><?php echo $data['keterangan'];?></textarea>
		</div>
		<div class="form-group">
			<button type="reset" class="btn btn-default" name="reset">Reset</button>
			<button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
		</div>
		</div>
	</form>
<br>
<?php }?>
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

<?php include('footer.php')?>

<!--aksi edit tugas-->

<?php 
if(isset($_POST['ubah'])){
	$idmapel = $_POST['matpel'];
	$idguru = $_SESSION['login'];
	$idkelas = $_POST['kelas'];
	$keterangan = ucfirst(addslashes($_POST['keterangan'])); //

	if(empty($_POST['bataskumpul'])){
	$tglkumpul =$_POST['bataskumpul2'];
		}else{
		$ambiltanggal = substr($_POST['bataskumpul'],0, 10);
		$ambiljammenit = substr($_POST['bataskumpul'], 11,5);
		$ambilampm = substr($_POST['bataskumpul'], -2);
		$explode = explode("/",$ambiltanggal);
		$tgl=$explode[0];
		$bln=$explode[1];
		$thn=$explode[2];
		$jammenit = explode(":", $ambiljammenit);
		
		if($ambilampm =='PM'){
			$jam=$jammenit[0]*2;
			$menit=$jammenit[1];
			$tglkumpul= "$thn-$bln-$tgl $jam:$menit:00";

		}else{
			$jam=$jammenit[0];
			$menit=$jammenit[1];
			$tglkumpul= "$thn-$bln-$tgl $jam:$menit:00";
		}
	}
	$tglubah= explode("/",$_POST['tglubah']);
	$tanggal=$tglubah[0];
	$bulan=$tglubah[1];
	$tahun=$tglubah[2];
	$jambuat=$tglubah[3];
	$menitbuat=$tglubah[4];
	$tanggalbuat="$tahun-$bulan-$tanggal $jambuat-$menitbuat-00";

	
	$cek= "T".$tanggal.$bulan.$tahun.$_POST['matpel'];
	$carikode = "SELECT id_tugas FROM tugas WHERE id_tugas LIKE '$cek%'"; 
	$query = mysqli_query($connect, $carikode) or die (mysqli_error()); 
	$datakode = mysqli_fetch_array($query);
	$jmldata = mysqli_num_rows($query);
	$id= $_POST['idtugas'];

	if($datakode){
		//membuat variabel baru untuk mengambil kode id tugas yang dipilih	
		$nilaikode = substr($jmldata[0], 2);
		//menjadikan kode uniq sbg int
		$kode = (int) $nilaikode;
		//ditambah 1
		$kode = $jmldata+1;
		$idtugas = "T".date("dmy").$idmapel.str_pad($kode,2,"0",STR_PAD_LEFT);//00mat 00tg 00bln 00thn 00uniq 10612161
		}else{
		$idtugas = "T".date("dmy").$idmapel."01";//00mat 00tg 00bln 00thn 00uniq 10612161
		}


	if ($tglkumpul<$tanggalbuat) { //mengecek inputan tanggal jika tanggal kumpulnya telah berlalu
	header("location:edit_tugas.php?tanggalerror&idtugas=$id"); 

	}else {
	$update = mysqli_query($connect,"UPDATE tugas SET id_tugas='$idtugas', id_mapel='$idmapel', tanggalpembuatan='$tanggalbuat', bataspengumpulan='$tglkumpul', username='$idguru', kelas='$idkelas', keterangan='$keterangan' WHERE id_tugas='$id'");
			mysqli_query($connect, "UPDATE kumpultugas SET id_mapel='$idmapel', id_tugas='$idtugas' WHERE id_tugas='$id'"); //update ke database
	}
	if(isset($update)) { //jika telah berhasil 
	print "<script>alert('Berhasil!');
	javascript:window.location = 'daftar_tugas.php?ubah_success';</script>";
	} else { //jika gagal input
	echo "<script>alert('Gagal Ubah Data');
	javascript:window.location = 'daftar_tugas.php?ubah_gagal';</script>";
	}
}
	?>