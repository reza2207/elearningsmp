<?php include("header.php");?>
<title>Daftar Soal</title>
<?php if(!isset($_SESSION["login"])){?>
<div class="container alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
</div><?php } else {?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
		<ol class="breadcrumb" style="color:inherit;">
		<li><a href="index">Beranda</a></li>
		<li class="active">Daftar Soal</li>
		</ol>
		<hr />
	
<?php
	if(isset($_GET['aksi']) == 'delete'){
	$idsoal = $_GET['id_soal'];
		$cek = mysqli_query($connect, "SELECT *	 FROM mastersoal WHERE id_soal='$idsoal'");
			if(mysqli_num_rows($cek) == 0){
				echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data tidak ditemukan.</strong></div>';
			}else{
				$delete = mysqli_query($connect, "DELETE FROM mastersoal WHERE id_soal='$idsoal'");
						  mysqli_query($connect, "DELETE FROM soal where id_soal = '$idsoal'");
			if($delete){
				echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Soal berhasil dihapus.</strong></div>';
			}else{
				echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Soal gagal dihapus.</strong></div>';
			}
			}
			}
			?>
			<?php if (isset($_GET['gagal'])){
			echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data gagal ditambah.</strong></div>';
			} elseif (isset($_GET['blank'])){
			echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Ada data yang kosong.</strong></div>';
			}?>

			<?php if (isset($_GET['success'])){
			echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Master soal berhasil ditambah.</strong></div>';
			}?>

<div class="row">
	<div class="col-sm-1">
		<form class="form-inline" method="get">
			<div class="form-group">
				<select name="kelas" class="form-control" onchange="form.submit()">
					<option value="0">Semua</option>
					<?php $kelas = (isset($_GET['kelas']) ? strtolower($_GET['kelas']) : NULL);  ?>
					<option value="7" <?php if($kelas == '7'){ echo 'selected'; } ?>>VII</option>
					<option value="8" <?php if($kelas == '8'){ echo 'selected'; } ?>>VIII</option>
					<option value="9" <?php if($kelas == '9'){ echo 'selected'; } ?>>IX</option>
				</select>
			</div>
		</form>
	</div>
	<div class="col-sm-4">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahdata">[+]Tambah Data</span></button>
	</div>
</div>
	<br />
	<!--modal-->
<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="tambahdata">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="gridSystemModalLabel" align="center">Tambah Soal</h4>
	      	</div>
	      	<form role="form" action="" method="post">
		    <div class="modal-body">
	      		<div class="container-fluid">
	      			<div class="row">
	      				<div class="col-sm-5">
			  				<div class="form-group"> 
			    				<label for="matpel">Mata Pelajaran:</label>
			    				<select class="form-control" name="matpel" required>
			    				<option value="">--Pilih Mata Pelajaran--</option>
									<?php 
										$sql = mysqli_query($connect, "SELECT * FROM matapelajaran order by namamapel ASC");
									if (mysqli_num_rows($sql) != 0) { 
										while ($row = mysqli_fetch_assoc($sql)){
											echo '<option value='.$row['id_mapel'].'>'.$row['namamapel'].'</option>';
										}
									}
									?>
								</select>
			 				</div>
			 			</div>
	        			<div class="col-sm-4">
		  					<div class="form-group">
			    				<label for="kelas">Kelas:</label>
			    				<select class="form-control" name="kelas" required>
									<option value="">--Pilih Kelas--</option>
									<option value="7">VII</option>
								    <option value="8">VIII</option>
								    <option value="9">IX</option>
								</select>
		 					</div>
		 				</div>
		 				<div class="col-sm-3">
		  					<div class="form-group">
		  						<label for="Jumlah">Jumlah Soal:</label>
		  						<select class="form-control" name="jmlsoal" required;>
								<?php for($jml=1; $jml<=100; $jml++): ?>
						     	<option value="<?=$jml?>"><?=$jml?></option>
						     	<?php endfor; ?>
						    	</select>
		  					</div>
		  				</div>
		  			</div>	
	 				<div class="form-group">
			 				<label for="keterangan">Keterangan:</label>
			 				<textarea type='text' class="form-control" name="keterangan" placeholder="Masukkan Keterangan" maxlength="100" required></textarea>
			 		</div>
		       	</div>
		      	<div class="modal-footer">
			    	<button type="reset" class="btn btn-default" name="reset">Reset</button>
			    	<button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
		   	</form>
	      	</div>
	      </div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<div class="table-responsive">
		<table class="table table-striped table-hover dtbl">
			<thead>
			<tr>
				<th>NO.</th>
				<th>ID. SOAL</th>
				<th>MATA PELAJARAN</th>
				<th>KELAS</th>
				<th style="text-align: center">TANGGAL<br>PEMBUATAN</th>
				<th style="text-align: center">TANGGAL UPDATE</th>
				<th>NAMA GURU</th>
				<th>KETERANGAN</th>
				<th style="text-align: center">JUMLAH<br>SOAL</th>
				<th>OPSI</th>
			</tr>
			</thead>
			<tbody>
			<?php
				if($kelas){
					$sql = mysqli_query($connect, "SELECT mastersoal.*, user.nama, matapelajaran.namamapel FROM mastersoal JOIN matapelajaran ON matapelajaran.id_mapel=mastersoal.id_mapel JOIN user on user.username = mastersoal.id_guru WHERE mastersoal.kelas LIKE '$kelas%'");
				}else{
					$sql = mysqli_query($connect, "SELECT mastersoal.*, user.nama, matapelajaran.namamapel FROM mastersoal JOIN matapelajaran ON matapelajaran.id_mapel=mastersoal.id_mapel JOIN user on user.username = mastersoal.id_guru ORDER BY tanggalpembuatan");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
				}else{
					$no = 1;
				while($row = mysqli_fetch_assoc($sql)){
					date_default_timezone_set("Asia/Jakarta");
					$tglbuat=date("d F Y - H:i",strtotime($row['tanggalpembuatan']));
					$tglubah=date("d F Y - H:i",strtotime($row['tanggalperubahan']));
					echo '
					<tr style="text-align: center">
						<td>'.$no++.'</td>
						<td>'.$row['id_soal'].'</td>
						<td>'.$row['namamapel'].'</td>
						<td>'.$row['kelas'].'</td>
						<td>'.$tglbuat.'</td>
						<td>'.$tglubah.'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['keterangan'].'</td>
						<td>'.$row['jumlah_soal'].'</td>
						<td>
							<a href="mulai_soal.php?idsoal='.$row['id_soal'].'" class="btn btn-success btn-sm" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
							<a href="edit_soal.php?idsoal='.$row['id_soal'].'" class="btn btn-warning btn-sm" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
							<a href="daftar_soal.php?aksi=delete&id_soal='.$row['id_soal'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
						</td>
					</tr>
						';
					}
				}
				?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
	<br>
<?php }?>
</div>
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
<?php include('footer.php')?>


<?php 
if(isset($_POST['simpan'])){
	$idmapel = $_POST['matpel'];
	$idkelas = $_POST['kelas'];
	$idguru = $_SESSION['login'];
	$keterangan = ucfirst(stripslashes($_POST['keterangan']));
	$jumlahsoal = $_POST['jmlsoal'];
	$cek= 'S'.date("dmy").$idmapel;
	$carikode = "SELECT id_soal FROM mastersoal WHERE id_soal LIKE '$cek%'"; 
	$query = mysqli_query($connect, $carikode) or die (mysqli_error()); 
	$datakode = mysqli_fetch_array($query);
	$jmldata = mysqli_num_rows($query);
	if($datakode){
	//membuat variabel baru untuk mengambil kode id tugas yang dipilih	
	$nilaikode = substr($jmldata[0], 2);
	//menjadikan kode uniq sbg int
	$kode = (int) $nilaikode;
	//ditambah 1
	$kode = $jmldata+1;
	$idsoal = 'S'.date("dmy").$idmapel.str_pad($kode,2,"0",STR_PAD_LEFT);//00mat 00tg 00bln 00thn 00uniq 10612161
	}else{
	$idsoal = 'S'.date("dmy").$idmapel."01";//00mat 00tg 00bln 00thn 00uniq 10612161
	};
		

	if(empty($idmapel)|| empty($idkelas)){ //jika mapel, kelas, keterangan dikosongkan
	echo "<script>alert('Harus diisi semua fieldnya');
	javascript:window.location = 'daftar_soal.php?blank';</script>";

	} else {
	$simpan = mysqli_query($connect,"INSERT INTO mastersoal (id_soal, id_mapel, kelas, tanggalpembuatan, tanggalperubahan, id_guru, keterangan, jumlah_soal)VALUES('$idsoal','$idmapel','$idkelas', now(),now(), '$idguru', '$keterangan', '$jumlahsoal')");
	};
	if(isset($simpan)) {
	print "<script>alert('Berhasil');
	javascript:window.location = 'daftar_soal.php?success';</script>";

	} else{
	header('location:daftar_soal.php?gagal');
	}
	
}
?>