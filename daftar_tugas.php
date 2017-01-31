<?php include("header.php");
require_once("config/koneksi.php");?>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<title>Daftar Tugas</title>
	<?php if(!isset($_SESSION["login"])){?>
	<div class="container alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
	</div>
	<?php } else {?>
	<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
	<ol class="breadcrumb" style="background-color:inherit;">
	<li><a href="index">Beranda</a></li>
	<li class="active"><b>Daftar Tugas</b></li>
	<li><a href="lihat_hasil_tugas">Lihat Hasil Tugas</a></li>
	</ol>
	<hr />
	
	<?php
		if(isset($_GET['aksi']) == 'delete'){
			$idtugas = $_GET['id_tugas'];
			$cek = mysqli_query($connect, "SELECT *	 FROM tugas WHERE id_tugas='$idtugas'");
			if(mysqli_num_rows($cek) == 0){
				echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Data tidak ditemukan.</strong></div>';
			}else{
				$folder="uploads/";
				$queryfile = mysqli_query($connect,"SELECT datatugas FROM kumpultugas WHERE id_tugas='$idtugas'");
				if (mysqli_num_rows($queryfile) != 0) { 
					while ($row = mysqli_fetch_assoc($queryfile)){
					$data = $row['datatugas'];
					//echo'<pre>'; print_r($data); echo'</pre>'; exit;
					unlink("$folder$data");
					}
				}
				$deletekumpul = mysqli_query($connect, "DELETE FROM kumpultugas WHERE id_tugas='$idtugas'");
					$hapus = mysqli_query($connect, "DELETE FROM tugas WHERE id_tugas='$idtugas'");
				if($hapus){
				echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Tugas berhasil dihapus.</strong></div>';
				}else{
				echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Tugas gagal dihapus.</strong></div>';
				}
			}
		}
	?>
	<?php if(isset($_GET['data'])=='blank'){
		echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Ada data yang kosong.</strong></div>';
	} elseif (isset($_GET['tanggalerror'])){
		echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Input tanggal Salah. Mohon cek input tanggal dan jamnya</strong></div>';
	} elseif (isset($_GET['gagal'])){
		echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Data gagal ditambah.</strong></div>';
	} elseif (isset($_GET['success'])){
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Data berhasil ditambah.</strong></div>';
	} elseif(isset($_GET['ubah_success'])){
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Data berhasil diubah.</strong></div>';

	} elseif(isset($_GET['ubah_gagal'])){
		echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Data gagal diubah.</strong></div>';
	}

	;?>
	<div class="row">
		<div class="col-sm-1">
			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="kelas" class="form-control" onchange="form.submit()">
						<option value="0">Semua</option>
						<?php $kelas = (isset($_GET['kelas']) ? $_GET['kelas'] : NULL);  ?>
						<option value="7" <?php if(substr($kelas, 0,1) == '7'){ echo 'selected'; } ?>>VII</option>
						<option value="8" <?php if(substr($kelas, 0,1) == '8'){ echo 'selected'; } ?>>VIII</option>
						<option value="9" <?php if(substr($kelas, 0,1) == '9'){ echo 'selected'; } ?>>IX</option>
					</select>
				</div>
			</form>
		</div>
		<?php if($_SESSION['peran']!='siswa'){
		echo '<div class="col-sm-1">
			<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#tambahdata">[+]Tambah Data</span></button>
		</div>';
		};?>
	</div>
	<br />
	<!--modal-->
	<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="tambahdata">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="gridSystemModalLabel" align="center">Tambah Tugas</h4>
	      	</div>
	      	<form role="form" method="post">
		    	<div class="modal-body">
		      		<div class="container-fluid">
		      			<div class="row">
		      				<div class="col-sm-6">
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
		      				<div class="col-sm-6">
		      					<div class="form-group">
		      					<?php $tanggal=date('d/m/Y h:i A');?>
		      					<?php $tgl = date('d/m/Y/H/i')?>
		      						<label>Tanggal Pembuatan:</label>
		      						<input type='text' class="form-control" readonly value="<?php echo $tanggal;?>" />
		      						<input type="hidden" class="form-control" name="tglbuat" value="<?php echo $tgl;?>"/>
		      					</div>
		      				</div>
		      			</div>
		 				<div class="row">
		 					<div class="col-sm-6">
				  				<div class="form-group">
					    				<label for="tanggal">Batas Pengumpulan:</label>
										<input type='text' class="form-control " id='datepicker' name="bataskumpul" placeholder="Masukkan Tanggal" required>
			            		</div>
			            	</div>
	            			<div class="col-sm-6">
			  					<div class="form-group">
				    				<label for="kelas">Kelas:</label>
				    				<select class="form-control" name="kelas" required>
				    				<option value="">--Pilih Kelas--</option>
				    				<?php 
										$sql = mysqli_query($connect, "SELECT * FROM kelas");
									if (mysqli_num_rows($sql) != 0) { 
										while ($row = mysqli_fetch_assoc($sql)){?>
									<option value='<?php echo $row['kelas'];?>'><?php echo $row['nama_kelas'];?></option><?php }}?>
									</select>
			 					</div>
			 				</div>
			 			</div>
			 			<div class="form-group">
			 				<label for="keterangan">Keterangan:</label>
			 				<textarea type='text' class="form-control" name="keterangan" placeholder="Masukkan Keterangan" maxlength="100" required></textarea>
			 			</div>
		       		</div>
		       	</div>
		      	<div class="modal-footer">
			    	<button type="reset" class="btn btn-default" name="reset">Reset</button>
			    	<button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
		   </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="table-responsive">
		<table class="table table-striped table-hover dtbl">
			<thead>
			<tr>
				<th>NO.</th>
				<th>ID. TUGAS</th>
				<th>MATA PELAJARAN</th>
				<th>TANGGAL </br>PEMBUATAN</th>
				<th>BATAS </br>PENGUMPULAN</th>
				<th>NAMA GURU</th>
				<th>KELAS</th>
				<th>KETERANGAN</th>
				<th>OPSI</th>
			</tr>
			</thead>
			<?php
				if($kelas){
					$sql = mysqli_query($connect, "SELECT tugas.*,user.nama, matapelajaran.namamapel FROM tugas JOIN matapelajaran ON matapelajaran.id_mapel=tugas.id_mapel JOIN user on user.username = tugas.username WHERE tugas.kelas LIKE '$kelas%'");
				}else{
					$sql = mysqli_query($connect, "SELECT tugas.*, user.nama, matapelajaran.namamapel FROM tugas JOIN matapelajaran ON matapelajaran.id_mapel=tugas.id_mapel JOIN user on user.username = tugas.username");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
				}else{
					$no = 1;
				while($row = mysqli_fetch_assoc($sql)){
					$tglbuat = date("d F Y - H:i",strtotime($row['tanggalpembuatan']));
					$tglkumpul = date("d F Y - H:i",strtotime($row['bataspengumpulan']));
					$idtugas = $row['id_tugas'];
					$username = $_SESSION['login'];
					$cek= mysqli_query($connect, "SELECT * FROM kumpultugas where id_tugas='$idtugas' AND username='$username'");
					
					echo '
					<tr>
						<td>'.$no++.'</td>
						<td>'.$row['id_tugas'].'</td>
						<td>'.$row['namamapel'].'</td>
						<td>'.$tglbuat.'</td>
						<td>'.$tglkumpul.'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['kelas'].'</td>
						<td>'.$row['keterangan'].'</td>
						';
						if($_SESSION['peran']=='siswa'and strtotime($row['bataspengumpulan'])<strtotime('now')){
						echo '<td><a href="unggah_tugas.php?idtugas='.$row['id_tugas'].'" class="btn btn-primary btn-sm disabled" role="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span></a>
						</td>
							';
						}elseif(mysqli_num_rows($cek)>0){
						echo '<td><span class="btn btn-primary btn-sm glyphicon glyphicon-ok"></span></td>';
						}
						elseif($_SESSION['peran']=='siswa'and strtotime($row['bataspengumpulan'])>strtotime('now')){
							echo '<td><a href="unggah_tugas.php?idtugas='.$row['id_tugas'].'" class="btn btn-primary btn-sm" role="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span></a>
						</td>
							';
					}else{
						echo '<td><a href="edit_tugas.php?idtugas='.$row['id_tugas'].'" class="btn btn-warning btn-sm" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a><a href="daftar_tugas.php?aksi=delete&id_tugas='.$row['id_tugas'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
						</td>
					</tr>
						';
					}
				}
			}
				?>
			</table>			
			</div>
		</div>
		<br>
	</div>
	<!-- script datepicker -->
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<script src="assets/js/jQuery.js"></script>
		<script src="assets/js/moment.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$('#datepicker').datetimepicker({
					format:'DD/MM/YYYY hh:mm A'});
			});
		</script>

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

<?php }?>
</div>
<?php include('footer.php')?>
<!-- aksi daftar tugas -->

<?php
if(isset($_POST['simpan'])){
	$idmapel = $_POST['matpel'];
	$ambiltanggal = substr($_POST['bataskumpul'],0, 10);
	$ambiljammenit = substr($_POST['bataskumpul'], 11,5);
	$ambilampm = substr($_POST['bataskumpul'], -2);

	$jammenit = explode(":", $ambiljammenit);
	if($ambilampm =='PM'){
		$jam=$jammenit[0]*2;
		$menit=$jammenit[1];
	}else{
		$jam=$jammenit[0];
		$menit=$jammenit[1];
	};
	$explode = explode("/",$ambiltanggal);
	$tgl=$explode[0];
	$bln=$explode[1];
	$thn=$explode[2];

	$tglbuat= explode("/",$_POST['tglbuat']);
	$tanggal=$tglbuat[0];
	$bulan=$tglbuat[1];
	$tahun=$tglbuat[2];
	$jambuat=$tglbuat[3];
	$menitbuat=$tglbuat[4];
	$tanggalbuat="$tahun-$bulan-$tanggal $jambuat-$menitbuat-00";

	$tglkumpul= "$thn-$bln-$tgl $jam:$menit:00";
	$username = $_SESSION['login'];
	$idkelas = $_POST['kelas'];
	$keterangan = $_POST['keterangan'];

	$cek= "T".date("dmy").$_POST['matpel'];
	$carikode = "SELECT id_tugas FROM tugas WHERE id_tugas LIKE '$cek%'"; 
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
	$idtugas = "T".date("dmy").$idmapel.str_pad($kode,2,"0",STR_PAD_LEFT);//00mat 00tg 00bln 00thn 00uniq 10612161
	}else{
	$idtugas = "T".date("dmy").$idmapel."01";//00mat 00tg 00bln 00thn 00uniq 10612161
	};
		

	if ($tglkumpul<$tanggalbuat) { //mengecek inputan tanggal jika tanggal kumpulnya telah berlalu
	//echo $tanggalbuat.','.$tglkumpul.' ini ('.$_POST['bataskumpul'].')'.$ambiltanggal.'kk-ini'.$ambiljammenit;
	echo "<script>alert('Input tanggal salah');
	javascript:window.location = 'daftar_tugas?tanggalerror';</script>";
	
	}else {
	$simpan = mysqli_query($connect,"INSERT INTO tugas (id_tugas, id_mapel, tanggalpembuatan, bataspengumpulan, username, kelas, keterangan)	VALUES('$idtugas','$idmapel','$tanggalbuat','$tglkumpul','$username','$idkelas','$keterangan')"); //masuk ke database
	};
	if(isset($simpan)) { //jika telah berhasil 
	print "<script>alert('Berhasil!');
	javascript:window.location = 'daftar_tugas.php?success';</script>";
	} else { //jika gagal input
	echo "<script>alert('Gagal Input Data');
	javascript:window.location = 'daftar_tugas.php?gagal';</script>";
	}
}
?>