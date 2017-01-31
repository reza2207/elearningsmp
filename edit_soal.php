<?php include("header.php");?>
<title>Daftar Soal</title>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
<?php if(!isset($_SESSION["login"])){?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
</div><?php } else {?>
	<ol class="breadcrumb" style="color:inherit">
	<li><a href="index">Beranda</a></li>
	<li><a href="daftar_soal">Daftar Soal</a></li>
	<li class="active">Edit Soal</li>
	</ol>
	<hr />
	<div class="row">
		<div class="col-sm-4">
		<?php $idsoal = $_GET['idsoal'];
		$data = mysqli_query($connect, "SELECT matapelajaran.namamapel, mastersoal.id_soal, soal.id_test, mastersoal.keterangan, mastersoal.jumlah_soal, COUNT('soal.id_soal') AS jumlah, mastersoal.kelas FROM mastersoal left JOIN soal ON soal.id_soal = mastersoal.id_soal JOIN matapelajaran ON matapelajaran.id_mapel = mastersoal.id_mapel WHERE mastersoal.id_soal LIKE '$idsoal'");

		$hasil = mysqli_fetch_assoc($data);
		if(is_null($hasil['id_test'])){$hasiljml = 0;}else{$hasiljml = $hasil['jumlah'];}
		//cek nanti jumlahnya sudah sesuai belum?>
		<span>
		</div>
	</div><br>

	<?php if(isset($_POST['tambah'])){
	if($hasil['jumlah_soal'] > $hasiljml || $hasil['jumlah']==0){
		$idsoal= ucfirst($_POST['idsoal']);
	$soal= ucfirst(addslashes($_POST['soal']));
	$pil_a= ucfirst(addslashes($_POST['pil_a']));
	$pil_b= ucfirst(addslashes($_POST['pil_b']));
	$pil_c= ucfirst(addslashes($_POST['pil_c']));
	$pil_d= ucfirst(addslashes($_POST['pil_d']));
	$kunci= $_POST['kunci'];

	$tambah = mysqli_query($connect, "INSERT INTO soal (id_soal, soal, pil_a, pil_b, pil_c, pil_d, kunci_jawaban) 
							VALUES ('$idsoal','$soal','$pil_a','$pil_b','$pil_c','$pil_d','$kunci')");
	
	if($tambah){
		print "<script>alert('Berhasil');
		window.location.href = 'edit_soal.php?success&idsoal=$idsoal';</script>";
		echo '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Soal berhasil ditambahkan.</strong>
	  						</div>';
	  					}else{
		print "<script>alert('Gagal');
	javascript:window.location = 'edit_soal.php?gagal&idsoal=$idsoal';</script>";
		echo " <meta http-equiv=\"refresh\" content=\"0\" /> ";
	  		}
		}
	}?>
	<?php
	if(isset($_GET['aksi']) == 'delete'){
	$id = $_GET['id'];
	$cek = mysqli_query($connect, "SELECT * FROM soal WHERE id_test	='$id'");
		if(mysqli_num_rows($cek) == 0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Soal tidak ditemukan.</strong></div>';
		}else{
			$delete = mysqli_query($connect, "DELETE FROM soal WHERE id_test='$id'");
			echo '<script>window.location.href=window.location.href;</script>';
			if($delete){

				print "<script>alert('Soal terhapus')</script>";
				echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Soal berhasil dihapus.</strong></div>';
			}else{
			echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Soal gagal dihapus.</strong></div>';
			}
		}
	}
	?>
	<?php if(isset($_GET['ubahsuccess'])){
		echo '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Soal berhasil diubah.</strong>
	  						</div>'
	  				;}?>
	
			<script>
			$(document).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip();
			});
			</script>
		<div class="alert alert-info" role="alert" align="center">ID Soal: <?php echo $idsoal.' <br> Matapelajaran: '.$hasil['namamapel'].' <br> Kelas: '.$hasil['kelas'].' <br> Jumlah Soal Maksimal: '.$hasil['jumlah_soal'].' <br> Jumlah Soal Sekarang: '.$hasiljml.' <br> Keterangan: '.$hasil['keterangan'].'<br>';
		if($hasil['jumlah_soal'] > $hasil['jumlah'] || $hasiljml==0){
		echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahdata"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</span></button>
			';}else{echo '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Soal sudah memenuhi jumlah maksimal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</span></button>';}
		echo '&nbsp<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ubahmastersoal"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah Master Soal</button>
			'?></div>
	<br />
	<!--modal tambah soal-->
<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="tambahdata">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="gridSystemModalLabel" align="center">Tambah Soal</h4>
	      	</div>
	      	<form role="form" method="post">
		    <div class="modal-body">
	      		<div class="container-fluid">
  					<div class="form-group"> 
  						<input type="hidden" name="idsoal" value="<?php echo $idsoal;?>">
	    				<label for="soal">Soal:</label>
	    				<textarea type="text" name="soal" class="form-control" required></textarea>
	 				</div>
 					<div class="form-group">
  						<label for="pil_a">Pilihan A:</label>
  						<input type="text" name="pil_a" class="form-control" required> 
				    	</select>
  					</div>
	  				<div class="form-group">
  						<label for="pil_b">Pilihan B:</label>
  						<input type="text" name="pil_b" class="form-control" required> 
				    	</select>
  					</div>
  					<div class="form-group">
  						<label for="pil_c">Pilihan C:</label>
  						<input type="text" name="pil_c" class="form-control" required> 
				    	</select>
  					</div>
  					<div class="form-group">
  						<label for="pil_d">Pilihan D:</label>
  						<input type="text" name="pil_d" class="form-control" required> 
				    	</select>
  					</div>
  					<div class="form-group">
  						<label for="kunci">Kunci Jawaban:</label>
  						<select class="form-control" name="kunci" required>
									<option value="a">A</option>
								    <option value="b">B</option>
								    <option value="c">C</option>
								    <option value="d">D</option>
						</select>
  					</div>
		       	</div>
		      	<div class="modal-footer">
			    	<button type="reset" class="btn btn-default" name="reset">Reset</button>
			    	<button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
		   	</form>
	      	</div>
	      </div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--modal edit master soal-->
<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="ubahmastersoal">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="gridSystemModalLabel" align="center">Ubah Master Soal</h4>
	      	</div>
	      	<form role="form" method="post" >
		    <div class="modal-body">
	      		<div class="container-fluid">
  					<div class="form-group"> 
  						<input type="hidden" name="idsoal" value="<?php echo $idsoal;?>">
	    				<label for="soal">Keterangan:</label>
	    				<textarea type="text" name="keterangan" class="form-control" required><?php echo $hasil['keterangan'];?></textarea>
	 				</div>
 					<div class="form-group">
  						<label for="Jumlah">Jumlah Soal:</label>
  						<select class="form-control" name="jmlsoal" required;>
  						<option value="<?php $hasil['jumlah_soal'];?>"><?php echo $hasil['jumlah_soal'];?></option>
						<?php for($jml=1; $jml<=100; $jml++): ?>
				     	<option value="<?=$jml?>"><?=$jml?></option>
				     	<?php endfor; ?>
				    	</select>
		  			</div>
		       	</div>
		      	<div class="modal-footer">
			    	<button type="reset" class="btn btn-default" name="reset">Reset</button>
			    	<button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
		   	</form>
	      	</div>
	      </div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php if(isset($_POST['ubah'])){
	$id = $_POST['idsoal'];
	$keterangan = $_POST['keterangan'];
	$jumlahsoal = $_POST['jmlsoal'];
		$ubah = mysqli_query($connect, "UPDATE mastersoal SET tanggalperubahan= now(), keterangan='$keterangan', jumlah_soal='$jumlahsoal' WHERE id_soal='$id'"); //update ke database
		if($ubah){
			echo '<script>window.location.href=window.location.href;</script>';
			echo '<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Soal berhasil diubah.</strong>
				</div>'
			;}else{ 
				echo '<script>window.location.href=window.location.href;</script>';
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Soal gagal diubah.</strong>
				</div>';
			}
			}if($hasil['jumlah_soal'] < $hasil['jumlah']){ //14 < 10 
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Jumlah soal yang diinput lebih dari batasan maksimal jumlah soal. Silahkan ubah master soal / hapus salah satu soal</strong>
					</div>';}elseif($hasil['jumlah_soal'] > $hasil['jumlah']){
						echo '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Jumlah soal yang diinput belum memenuhi batasan maksimal jumlah soal. Silahkan masukkan soal lagi / ubah master soal</strong>
					</div>';}?>


			<?php 
			$idsoal = $_GET['idsoal'];
			$sql = mysqli_query($connect, "SELECT soal.* , mastersoal.* FROM soal JOIN mastersoal ON mastersoal.id_soal = soal.id_soal WHERE mastersoal.id_soal LIKE '$idsoal'");

			if(mysqli_num_rows($sql) == 0){
				echo '<div class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Tidak ada data.</strong>
					</div>';
			}else{
				$no = 1;
				while($row = mysqli_fetch_assoc($sql)){
				$jawaban = $row['kunci_jawaban'];
				echo '';
				if($jawaban=='A'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan" checked>A. '.$row['pil_a'].'
					</label><br>
							<label>
								<input type="radio" value="b" name="pilihan">B. '.$row['pil_b'].'
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan">C. '.$row['pil_c'].'
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan">D. '.$row['pil_d'].'
							</label><br>'
					;}
				elseif($jawaban=='B'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan">A. '.$row['pil_a'].'
							</label><br>
							<label>
								<input type="radio" value="b" name="pilihan" checked>B. '.$row['pil_b'].'
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan">C. '.$row['pil_c'].'
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan">D. '.$row['pil_d'].'
							</label><br>';}
				elseif($jawaban=='C'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan">A. '.$row['pil_a'].'
							</label><br>
							<label>
								<input type="radio" value="b" name="pilihan">B. '.$row['pil_b'].'
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan" checked>C. '.$row['pil_c'].'
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan">D. '.$row['pil_d'].'
							</label><br>';}
				else{echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan">A. '.$row['pil_a'].'
							</label><br>
							<label>
								<input type="radio" value="b" name="pilihan">B. '.$row['pil_b'].'
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan">C. '.$row['pil_c'].'
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan" checked>D. '.$row['pil_d'].'
							</label><br>';}
							echo '<label class="alert">
								Jawabannya adalah: '.$row['kunci_jawaban'].'
								<a href="edit_detail_soal.php?idsoal='.$row['id_soal'].'&id='.$row['id_test'].'" class="btn btn-warning btn-sm" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="edit_soal.php?aksi=delete&idsoal='.$row['id_soal'].'&id='.$row['id_test'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</label>
						</div>
					</div></form>'
				;}?>

<?php }?>
<?php }?>
</div>
<br>
<?php include('footer.php')?>
