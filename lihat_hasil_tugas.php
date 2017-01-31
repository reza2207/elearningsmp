<?php include("header.php");?>
<title>Lihat Hasil Tugas</title>
	<?php if(!isset($_SESSION["login"])){?>
	<div class="container alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
	</div>
	<?php } else {?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
	<ol class="breadcrumb" style="background-color: inherit;">
	<li><a href="index">Beranda</a></li>
	<li><a href="daftar_tugas">Daftar Tugas</a></li>
	<li class="active"><b>Lihat Hasil Tugas</b></li>
	</ol>
	<hr />
	<?php
		if(!isset($_GET['file'])===0){
			echo '<div class="alert alert-danger">File tidak ada.</div>';
		}elseif(isset($_GET['aksi']) == 'delete'){
			$id = $_GET['id_kumpultugas'];
			$cek = mysqli_query($connect, "SELECT *	 FROM kumpultugas WHERE id_kumpultugas='$id'");

			if(mysqli_num_rows($cek) == 0){
				echo '<div class="alert alert-info">Data tidak ditemukan.</div>';
			}else{
			$folder="uploads/";
			$data = $_GET['file'];
			//echo'<pre>'; print_r($data); echo'</pre>'; exit;
			unlink("$folder$data");
			$delete = mysqli_query($connect, "DELETE FROM kumpultugas WHERE id_kumpultugas='$id'");
			if($delete){
				echo '<div class="alert alert-danger">Data berhasil dihapus.</div>';
			}else{
				echo '<div class="alert alert-info">Data gagal dihapus.</div>';
			}
			}
		}
	?>
	<div class="row">
		<div class="col-sm-1">
			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="kelas" class="form-control" onchange="form.submit()">
						<option value="0">Semua</option>
						<?php $kelas = (isset($_GET['kelas']) ? $_GET['kelas'] : NULL);  ?>
						<option value="7" <?php if($kelas == '7'){ echo 'selected'; } ?>>VII</option>
						<option value="8" <?php if($kelas == '8'){ echo 'selected'; } ?>>VIII</option>
						<option value="9" <?php if($kelas == '9'){ echo 'selected'; } ?>>IX</option>
					</select>
				</div>
			</form>
		</div>
	</div>
	</br>
	<div class="table-responsive">
		<table class="table table-striped table-hover dtbl">
		<thead>
			<tr>
				<th>NO.</th>
				<th>ID Tugas</th>
				<th>Nama</th>
				<th>NIK</th>
				<th>Kelas</th>
				<th>Mata Pelajaran</th>
				<th>Tanggal Tugas Dikumpul</th>
				<?php if($_SESSION['peran']!='siswa'){
				echo '
				<th>Ukuran</th>
				<th>Opsi</th>';
				}?>
			</tr>
		</thead>
			<?php
				if($kelas){
					$sql = mysqli_query($connect, "SELECT kumpultugas.* , tugas.kelas, matapelajaran.namamapel FROM kumpultugas JOIN matapelajaran ON matapelajaran.id_mapel=kumpultugas.id_mapel JOIN tugas on tugas.id_tugas = kumpultugas.id_tugas WHERE tugas.kelas LIKE '$kelas%' ORDER BY id_kumpultugas ASC");
				}else{
					$sql = mysqli_query($connect, "SELECT kumpultugas.* , tugas.kelas, matapelajaran.namamapel FROM kumpultugas JOIN matapelajaran ON matapelajaran.id_mapel=kumpultugas.id_mapel JOIN tugas on tugas.id_tugas = kumpultugas.id_tugas ORDER BY tanggalpembuatan ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
					$ukuran = ceil($row['ukuran']/1024);
					echo '
					<tr>
						<td>'.$no++.'</td>
						<td>'.$row['id_tugas'].'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['username'].'</td>
						<td>'.$row['kelas'].'</td>
						<td>'.$row['namamapel'].'</td>
						<td>'.$row['tanggalupload'].'</td>';
					if($_SESSION['peran']!='siswa'){
					echo'
						<td>'.$ukuran. ' kb</td>
						<td>

							<a href="unduh_tugas.php?id_kumpultugas='.$row['id_kumpultugas'].'&file='.$row['datatugas'].'" class="btn btn-primary btn-sm" role="button"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
							<a href="lihat_hasil_tugas.php?aksi=delete&id_kumpultugas='.$row['id_kumpultugas'].'&file='.$row['datatugas'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
						</td>
					</tr>
						';
					}
					}
				}
				?>
			</table>
		</div>
	
<?php }?>
</div>
<?php include("footer.php")?>
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