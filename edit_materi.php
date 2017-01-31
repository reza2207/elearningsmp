<?php include("header.php");?>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<?php if(isset($_GET['id'])){
echo '<title>Edit Materi '.$_GET['id'].'</title>';	
}else{
	echo '<title>Edit Materi</title>';}?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
	<?php if($_SESSION["peran"]=='siswa'){
	echo '<script>javascript:history.go(-1);</script>';;
	}elseif(!isset($_GET['id'])){
	echo '<script>javascript:history.go(-1);</script>';;
	}elseif(!isset($_SESSION['login'])){
	header('location:materi_pembelajaran');
	}else{?>
	
	<ol class="breadcrumb">
	<li><a href="index">Beranda</a></li>
	<li><a href="materi_pembelajaran">Materi Pembelajaran</a></li>
	<li class="active">Edit Materi Pembelajaran</li>
	</ol>
	<hr />
	<?php
	$id = $_GET['id'];
	$query = mysqli_query($connect,"SELECT * FROM materi where id_materi='$id'") or die(mysqli_error());
	$data = mysqli_fetch_assoc($query);}?>

	<?php
	if(isset($_GET['status'])){
			switch ($_GET['status']) {
				case '4':
					echo '<div class="alert alert-danger">Format harus benar</div>';
					break;
				case '2':
					echo '<div class="alert alert-danger">Ukuran file kebesaran</div>';
					break;
				}				
		}?>
	<?php if(mysqli_num_rows($query) == 0){
		echo '<div class="alert alert-danger">Tidak ada data.</div>';
	}else{?>
	<form class="form-horizontal" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $data['id_materi'];?>">
			
		<div class="form-group">
	    	<label for="tanggal" class="col-sm-2 control-label">Judul Materi:</label>
			<div class="col-sm-10">
				<input type="hidden" name="namafile" value='<?php echo $data['nama_file'];?>'>
				<input type='text' class="form-control " name='judul' value='<?php echo $data['judul_materi'];?>' required>
			</div>
		</div>
		<div class="form-group">
			<label for="keterangan" class="col-sm-2 control-label">Keterangan:</label>
			<div class="col-sm-10">
				<textarea type='text' class="form-control" name="keterangan" maxlength="100" required><?php echo $data['keterangan'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="keterangan" class="col-sm-2 control-label">Pilih Data Baru:</label>
			<div class="col-sm-10">
				<input type='file' name="fileupload"/>
			</div>
    	<div class="col-sm-10 help-block">Bila data tidak ingin diganti, tidak perlu dipilih data baru lagi
		</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="reset" class="btn btn-default" name="reset" class="col-sm-2 control-label">Reset</button>
				<button type="submit" class="btn btn-primary" name="ubah" class="col-sm-2 control-label">Ubah</button>
			</div>
		</div>
	</form>
</div>
<br>
<?php }?>
</div>
<?php include('footer.php')?>

<!-- aksi edit materi -->
<?php
if(isset($_POST['ubah'])){

	$id = $_POST['id'];
	$judul = ucfirst(stripslashes($_POST['judul']));
	$keterangan = ucfirst(stripslashes($_POST['keterangan']));
	$namafile = basename($_FILES['fileupload']['name']);
	$target_dir = "materi/";
	$direktori = $target_dir . $namafile;
	$imageFileType = strtolower(pathinfo($direktori,PATHINFO_EXTENSION));
	$ukuran = basename($_FILES["fileupload"]["size"]);
	$nama = 'file_'.$id.'.'.$imageFileType;
	$filelama = $_POST['namafile'];
	//$newname = preg_replace('/\s+/','_',$oldname);
	$target_file = $target_dir.$nama;
	$status = '1';
	// Check if file already exists


	if(is_uploaded_file($_FILES["fileupload"]["tmp_name"])){
	    if ($_FILES["fileupload"]["size"] > 2000000) {
	$status = '2';
	    }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !="jpeg"
	    && $imageFileType != "gif" && $imageFileType != "xls" && $imageFileType !="xlsx" && $imageFileType !="doc" && $imageFileType !="docx" && $imageFileType != "ppt" && $imageFileType !="pptx" && $imageFileType !="pdf") {
	        //echo "Maaf, hanya JPG, JPEG, PNG, GIF, DOC, PPT, XLS, PDF files yang diperbolehkan.";
	        $status = '4';
	    }
	}
	// Check if $uploadOk is set to 0 by an error
	if($status == 4 || $status == 2) {
	    header("location:edit_materi.php?status=$status&id=$id");
	// if everything is ok, try to upload file
	}elseif(move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)){
	        unlink($target_dir.$filelama);
	        $query = mysqli_query($connect, "UPDATE materi SET judul_materi='$judul', keterangan='$keterangan', tanggalunggah=now(), nama_file='$nama', tipefile='$imageFileType', ukuran_file='$ukuran' WHERE id_materi='$id'");
	       print "<script>alert('Berhasil!');
	javascript:window.location = 'materi_pembelajaran.php?editsuccess&id=$id';</script>";
	}else{
	       mysqli_query($connect, "UPDATE materi SET judul_materi='$judul', keterangan='$keterangan' WHERE id_materi='$id'");
	       print "<script>alert('Berhasil!');
	        javascript:window.location = 'materi_pembelajaran.php?editsuccess&id=$id';</script>";
	}
}
?>