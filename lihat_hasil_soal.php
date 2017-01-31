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
	<li><a href="daftar_soal">Daftar Soal/Kuis</a></li>
	<li class="active">Lihat Hasil Soal</li>
	</ol>
	<hr />
	<?php
		if(!isset($_GET['file'])===0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>File tidak ada.</strong></div>';
		}elseif(isset($_GET['aksi']) == 'delete'){
			$id = $_GET['id_nilai'];
			$cek = mysqli_query($connect, "SELECT *	 FROM nilai WHERE id_nilai='$id'");

			if(mysqli_num_rows($cek) == 0){
				echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Data tidak ditemukan.</strong></div>';
			}else{
			$delete = mysqli_query($connect, "DELETE FROM nilai WHERE id_nilai='$id'");
			$delete2 = mysqli_query($connect, "DELETE FROM detailnilai WHERE id_nilai='$id'");
			if($delete && $delete2){
				echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Nilai berhasil dihapus</strong></div>';
			}else{
				echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Data gagal dihapus.</strong></div>';
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
				<th>ID Soal</th>
				<th>Nama</th>
				<th>NIK</th>
				<th>Mata Pelajaran</th>
				<th>Kelas</th>
				<th>Tanggal Pengerjaan</th>
				<th>Nilai</th>
				<?php if($_SESSION['peran']!='siswa'){
				echo '
				<th>Opsi</th>';
				}?>
			</tr>
			</thead>
			<?php
				if($kelas){
					$sql = mysqli_query($connect, "SELECT nilai.*, user.nama, matapelajaran.namamapel FROM nilai JOIN matapelajaran ON matapelajaran.id_mapel=nilai.id_mapel JOIN user on user.username = nilai.username WHERE nilai.kelas LIKE '$kelas%' ORDER BY tanggal_mulai ASC");
				}else{
					$sql = mysqli_query($connect, "SELECT nilai.*, user.nama, matapelajaran.namamapel FROM nilai JOIN matapelajaran ON matapelajaran.id_mapel=nilai.id_mapel JOIN user on user.username = nilai.username ORDER BY tanggal_mulai ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
					if($_SESSION['peran']!='siswa'){
					echo '
					<tr>
						<td>'.$no++.'</td>
						<td>'.$row['id_soal'].'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['username'].'</td>
						<td>'.$row['namamapel'].'</td>
						<td>'.$row['kelas'].'</td>
						<td>'.$row['tanggal_mulai'].'</td>
						<td>'.$row['nilai'].'</td>
						<td>

							<a href="detail_pengerjaan.php?id_nilai='.$row['id_nilai'].'" class="btn btn-primary btn-sm" role="button"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
							<a href="lihat_hasil_soal.php?aksi=delete&id_nilai='.$row['id_nilai'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
						</td>
					</tr>
						';
					}elseif($row['username']==$_SESSION['login']){
						echo '
					<tr>
						<td>'.$no++.'</td>
						<td>'.$row['id_soal'].'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['username'].'</td>
						<td>'.$row['namamapel'].'</td>
						<td>'.$row['kelas'].'</td>
						<td>'.$row['tanggal_mulai'].'</td>
						<td>'.$row['nilai'].'</td>
						<td><a href="detail_pengerjaan.php?id_nilai='.$row['id_nilai'].'" class="btn btn-primary btn-sm" role="button"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
						</td>
					</tr>
						';
					}else{
						echo '
					<tr>
						<td>'.$no++.'</td>
						<td>'.$row['id_soal'].'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['username'].'</td>
						<td>'.$row['namamapel'].'</td>
						<td>'.$row['kelas'].'</td>
						<td>'.$row['tanggal_mulai'].'</td>
						<td>'.$row['nilai'].'</td>
					</tr>
						';
					}
					}
				}
				?>
			</table>
			</div>
		</div>
	</div>
	<br>
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