<?php include("header.php");?>
<title>Unggah Tugas</title>
	<?php if(!isset($_SESSION["login"])){?>
		<div class="container alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Warning!</strong> ANDA HARUS LOGIN TERLEBIH DAHULU.
		</div>
	<?php } elseif (empty($_GET['idtugas']) and !isset($_GET['success'])){
	echo '<div class="container alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Harus memilih tugas terlebih dahulu. klik di <a href="daftar_tugas">sini</strong></div>'; 
	}else {?>
	<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">

		<ol class="breadcrumb">
		<li><a href="index">Beranda</a></li>
		<li><a href="daftar_tugas">Daftar Tugas</a></li>
		<li class="active">Unggah Tugas</li>
		</ol>
		<hr />
		<?php $id = $_GET['idtugas'];
			$query = mysqli_query($connect, "SELECT * FROM tugas WHERE id_tugas='$id'") or die(mysqli_error());
			$data = mysqli_fetch_array($query);
			$iddata = $data['id_tugas'];
			$idmapel = $data['id_mapel'];
			$username = $_SESSION['login'];
			$querykumpul = mysqli_query($connect, "SELECT id_tugas FROM kumpultugas WHERE id_tugas = '$iddata' and username = '$username'");

			if(isset($_GET['success']) && mysqli_num_rows($query)==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Tidak ada data.</strong></div>';
			}elseif(mysqli_num_rows($query)==0){
			echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Tidak ada data.</strong></div>';
			}

			if(isset($_GET['status']) or isset($_GET['file'])){
				switch ($_GET['status']) {
									case '5':
										echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>File belum dipilih</strong></div>';
										break;
									case '4':
										echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Format harus benar</strong></div>';
										break;
									case '2':
										echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Ukuran file kebesaran</strong></div>';
										break;
									case '3':
										echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Maaf file sudah ada</strong></div>';
									case '6':
										echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Terjadi error saat mengunggah</strong></div>';
										break;
								}				
							}
		?>
		<?php if(mysqli_num_rows($querykumpul)>0 && !isset($_GET['success'])){ //tambahin kalo sudah sukses
			echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data sudah dikumpulkan. Klik di <a href="lihat_hasil_tugas">sini</a></strong></div>';
	  }if(mysqli_num_rows($querykumpul)>0 && isset($_GET['success'])){//tambahin kalo sudah sukses
			echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data sudah dikumpulkan. Klik di <a href="lihat_hasil_tugas">sini</a></strong></div>';
	  }elseif(mysqli_num_rows($querykumpul)==0){?>
			<form method="post" enctype="multipart/form-data">
			<div class="row">
			  	<div class="form-group col-sm-2">
				    <label for="idtugas">ID TUGAS</label>
				    <input type='text' class="form-control" readonly value="<?php echo $iddata ;?>" />
				    <input type='text' class="form-control sr-only" name="idtugas" value="<?php echo $iddata ;?>">
				    <input type='text' class="form-control sr-only" name="idmapel" value="<?php echo $idmapel ;?>">
				</div>
			  	<div class="form-group col-sm-2">
				    <label for="nama">Nama</label>
				    <input type="text" class="form-control" name="nama" readonly value="<?php echo $_SESSION['nama'];?>" />
			  	</div>
			  	<div class="form-group col-sm-4	">
				    <label for="nama">Keterangan</label>
				    <textarea input type="text" class="form-control" name="nama" readonly><?php echo $data['keterangan'];?></textarea>
			  	</div>
				<?php $keterangan = "Format yang diperbolehkan pdf/xls/doc/ppt/jpg. Tidak boleh lebih dari 2mb. Format nama file harus idtugas_nik";?>
			  	<div class="form-group col-sm-2">
				    <label for="unggah">Pilih File</label>
				    <input type="file" id="fileupload" name="fileupload" data-toggle="tooltip" required data-placement="bottom" title="<?php echo $keterangan;?>">
			  	</div>
				<div class="form-group col-sm-2">
				  <button type="submit" name = "submit" class="btn btn-primary" value="unggah">Unggah</button>
				</div>
			</div>
			</form>

			<script>
			$(document).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip('show');
			});
			</script>
			<?php }?>
<!--akhir dari class container-->
<?php }?>
</div>
<?php include("footer.php")?>

<?php
if(isset($_POST['idtugas'])){

	$idtugas = $_POST['idtugas'];
	$username = $_SESSION['login'];
	$nama = $_SESSION['nama'];
	$idmapel = $_POST['idmapel'];
	$target_dir = "uploads/";
	$idupload = $idtugas.'_'.$username;
	$uploadname = basename($_FILES["fileupload"]["name"]);
	$direktori = $target_dir . $uploadname;
	$imageFileType = strtolower(pathinfo($direktori,PATHINFO_EXTENSION));
	$ukuran = basename($_FILES["fileupload"]["size"]);
	$oldname = $uploadname.'.'.$imageFileType;
	$newname = str_replace($uploadname,$idupload,$oldname);
	$target_file = $target_dir.$newname;
	$status = 1;


	if(!is_uploaded_file($_FILES["fileupload"]["tmp_name"])){
	$status = 5;
	header("location:unggah_tugas.php?status=$status&idtugas=$idtugas");
	}

	// Check if file already exists
	if (file_exists($target_file)) {
	    //echo "Maaf, file sudah ada.";
	    $status = 3;
	}
	// Check file size
	if ($_FILES["fileupload"]["size"] > 2000000) {
	    //echo "Maaf, ukuran file terlalu besar. ";
	    $status = 2;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !="jpeg"
	&& $imageFileType != "gif" && $imageFileType != "xls" && $imageFileType !="xlsx" && $imageFileType !="doc" && $imageFileType !="docx" && $imageFileType != "ppt" && $imageFileType !="pptx" && $imageFileType !="pdf") {
	    //echo "Maaf, hanya JPG, JPEG, PNG, GIF, DOC, PPT, XLS, PDF files yang diperbolehkan.";
	    $status = 4;
	}
	// Check if $uploadOk is set to 0 by an error

	if ($status == 2 || $status == 3 || $status == 4 || $status == 5 && is_uploaded_file($_FILES["fileupload"]["tmp_name"])) {
	    header("location:unggah_tugas.php?status=$status&idtugas=$idtugas");
	// if everything is ok, try to upload file
	} elseif (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
	        $query = mysqli_query($connect, "insert into kumpultugas (id_kumpultugas, id_tugas, id_mapel, username, nama, datatugas, datatugaslama, tipefile, ukuran, tanggalupload) values ('$idupload', '$idtugas', '$idmapel', '$username','$nama', '$newname','$uploadname','$imageFileType', '$ukuran', now())");
	        print "<script>alert('Berhasil!');
	javascript:window.location = 'unggah_tugas.php?success&idtugas=$idtugas';</script>";
	  } else {
	    $status = 6;
	    header("location:unggah_tugas.php?status=$status&idtugas=$idtugas");
	        //echo "Terjadi error saat mengunggah file.";
    }
}
?> 