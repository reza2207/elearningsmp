<?php include("header.php");?>
<title>Detail Pengerjaan</title>
<?php if(!isset($_SESSION["login"])){?>
<div class="container alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
</div><?php } else {?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
		<ol class="breadcrumb" style="background-color:inherit;">
		<li><a href="index">Beranda</a></li>
		<li><a href="daftar_soal">Daftar Soal</a></li>
		<li><a href="lihat_hasil_soal">Hasil Pengerjaan Soal</a></li>
		<li class="active">Detail Pengerjaan</li>
		</ol>
		<hr />
		<div class="row">
			<div class="col-sm-4">
			<?php $id = $_GET['id_nilai'];
			$data = mysqli_query($connect, "SELECT mastersoal.id_soal, detailnilai.jawaban, soal.*, mastersoal.keterangan, mastersoal.kelas, matapelajaran.namamapel, mastersoal.jumlah_soal FROM detailnilai LEFT JOIN soal ON soal.id_test = detailnilai.id_test JOIN mastersoal ON mastersoal.id_soal = detailnilai.id_soal JOIN matapelajaran ON matapelajaran.id_mapel = mastersoal.id_mapel WHERE detailnilai.id_nilai LIKE '$id'");
			$hasil = mysqli_fetch_assoc($data);
			//cek nanti jumlahnya sudah sesuai belum?>
			<span>
			</div>
		</div><br>

		<div class="alert alert-info" role="alert" align="center">ID Soal: <?php echo $hasil['id_soal'].' <br> Matapelajaran: '.$hasil['namamapel'].' <br> Kelas: '.$hasil['kelas'].' <br> Jumlah Soal: '.$hasil['jumlah_soal'].' <br> Keterangan: '.$hasil['keterangan'].'<br>';?></div>
	<br />

<?php 
			$sql = mysqli_query($connect, "SELECT mastersoal.id_soal, detailnilai.jawaban, soal.*, mastersoal.keterangan, mastersoal.kelas, matapelajaran.namamapel, mastersoal.jumlah_soal FROM detailnilai LEFT JOIN soal ON soal.id_test = detailnilai.id_test JOIN mastersoal ON mastersoal.id_soal = detailnilai.id_soal JOIN matapelajaran ON matapelajaran.id_mapel = mastersoal.id_mapel WHERE detailnilai.id_nilai LIKE '$id'");

			if(mysqli_num_rows($sql) == 0){
				echo '<script>javascript:history.go(-1);</script>';
			}else{
				$no = 1;
				while($row = mysqli_fetch_assoc($sql)){
				$pilihan = strtoupper($row['jawaban']);
				$jawaban = $row['kunci_jawaban'];
				echo '';
				if($pilihan=='A'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan" checked><b style="color:red;">A. '.$row['pil_a'].'
					</b></label><br>
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
				elseif($pilihan=='B'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan">A. '.$row['pil_a'].'
							</label><br>
							<label>
								<input type="radio" value="b" name="pilihan" checked><b style="color:red;">B. '.$row['pil_b'].'</b>
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan">C. '.$row['pil_c'].'
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan">D. '.$row['pil_d'].'
							</label><br>';}
				elseif($pilihan=='C'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan">A. '.$row['pil_a'].'
							</label><br>
							<label>
								<input type="radio" value="b" name="pilihan">B. '.$row['pil_b'].'
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan" checked><b style="color:red;">C. '.$row['pil_c'].'</b>
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan">D. '.$row['pil_d'].'
							</label><br>';}
				elseif($pilihan=='D'){echo'<form><div class="list-group"><label>'.$no++.'. '.$row['soal'].'</label><div class="radio"><label><input type="radio" value="a" name="pilihan">A. '.$row['pil_a'].'
							</label><br>
							<label>
								<input type="radio" value="b" name="pilihan">B. '.$row['pil_b'].'
							</label><br>
							<label>
								<input type="radio" value="c" name="pilihan">C. '.$row['pil_c'].'
							</label><br>
							<label>
								<input type="radio" value="d" name="pilihan" checked><b style="color:red;">D. '.$row['pil_d'].'</b>
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
					<input type="radio" value="d" name="pilihan">D. '.$row['pil_d'].'
				</label><br>';}
							if($pilihan == $jawaban and !empty($pilihan)){echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Anda benar';}elseif($pilihan!=$jawaban and !empty($pilihan)){ echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Anda salah, jawaban anda adalah '.$pilihan.' seharusnya adalah '.$jawaban;}else{echo 'Anda tidak memilih jawaban apapun';}echo '
							</label>
						</div>
					</form>'
				;}?>
				</div>
</div>
<?php }?>
<?php }?>
<br>
<?php include('footer.php')?>