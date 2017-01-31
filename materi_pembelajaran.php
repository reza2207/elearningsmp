<?php include("header.php");?>
<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<title>Daftar Tugas</title>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
<ol class="breadcrumb" style="background-color:inherit;">
<li><a href="index">Beranda</a></li>
<li class="active"><b>Materi Pembelajaran</b></li>
</ol>
<hr />
<?php if(isset($_SESSION["login"])){?>
<?php
	if(isset($_GET['aksi']) == 'delete'){
		$id = $_GET['id'];
		$cek = mysqli_query($connect, "SELECT *	 FROM materi WHERE id_materi='$id'");
		if(mysqli_num_rows($cek) == 0){
			echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data tidak ditemukan.</strong></div>';
		}else{
		$folder="materi/";
		$data = $_GET['file'];
		//echo'<pre>'; print_r($data); echo'</pre>'; exit;
		unlink("$folder$data");
		$delete = mysqli_query($connect, "DELETE FROM materi WHERE id_materi='$id'");
		if($delete){
			echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Materi berhasil dihapus.</strong></div>';
		}else{
			echo '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Tugas gagal dihapus.</strong></div>';
		}
		}
	}
?>
<?php if (isset($_GET['success'])){
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data Berhasil Ditambah.</strong></div>';
} elseif(isset($_GET['ubah_success'])){
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data Berhasil Diubah.</strong></div>';
} elseif(isset($_GET['ubah_gagal'])){
	echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data Gagal Diubah.</strong></div>';
}elseif(isset($_GET['editsuccess'])){
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Data Berhasil Diubah.</strong></div>';	
}
if(isset($_GET['status'])){
			switch ($_GET['status']) {
				case '5':
					echo '<div class="alert alert-danger">File belum dipilih</div>';
					break;
				case '4':
					echo '<div class="alert alert-danger">Format harus benar</div>';
					break;
				case '2':
					echo '<div class="alert alert-danger">Ukuran file kebesaran</div>';
					break;
				case '3':
					echo '<div class="alert alert-danger">Maaf file sudah ada</div>';
				case '6':
					echo '<div class="alert alert-danger">Terjadi error saat mengunggah</div>';
					break;
			}				
		}
;?>
<div class="row">
<?php if(isset($_SESSION['peran'])){
	if($_SESSION['peran']!='siswa'){
	echo '<div class="col-sm-1">
		<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#tambahdata">[+]Tambah Data</span></button>
	</div>';
	}
	};?>
</div>
<br />
<!--modal-->
<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="tambahdata">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="gridSystemModalLabel" align="center">Tambah Materi Pembelajaran</h4>
      	</div>
      	<form role="form" action="" method="post" enctype="multipart/form-data">
	    	<div class="modal-body">
	      		<div class="container-fluid">
	      			<div class="row">
	      				<div class="col-sm-6">
			  				<div class="form-group"> 
			    				<label for="judul">Judul Materi:</label>
			    				<input type='text' class="form-control" name="judulmateri" placeholder="Masukkan Judul" required/>
			 				</div>
			 			</div>
	      				<div class="col-sm-6">
	      					<div class="form-group">
	      					<?php $tanggal=date('d/m/Y h:i A');?>
	      						<label>Tanggal Unggah:</label>
	      						<input type='text' class="form-control" readonly value="<?php echo $tanggal;?>" />
	      					</div>
	      				</div>
	      			</div>
		 			<div class="form-group">
		 				<label for="keterangan">Keterangan:</label>
		 				<textarea type='text' class="form-control" name="keterangan" placeholder="Masukkan Keterangan" maxlength="100" required></textarea>
		 			</div>	
		 			<div class="form-group">
					    <label for="unggah">Pilih File</label>
					    <input type="file" id="fileupload" name="fileupload" required>
		  			</div>
					<p class="bg-warning">Info: Format yang diperbolehkan pdf/xls/doc/ppt/jpg. Tidak boleh lebih dari 2mb.</p>
	       		</div>
	       	</div>
	      	<div class="modal-footer">
		    	<button type="reset" class="btn btn-default" name="reset">Reset</button>
		    	<button type="submit" name='unggah' class="btn btn-primary" name="unggah">Unggah</button>

		    </div>
	   </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="table-responsive">
	<table class="table table-bordered table-hover dtbl">
	<thead>
		<tr>
			<th width="3%">NO.</th>
			<th>Judul</th>
			<th>Keterangan</th>
			<th width="17%">Tanggal Unggah</th>
			<th width="5%">Ukuran File</th>
			<th width="12%">OPSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
				$sql = mysqli_query($connect, "SELECT * FROM materi");
			
			if(mysqli_num_rows($sql) == 0){
				echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
			}else{	
				$no = 1;
			while($row = mysqli_fetch_assoc($sql)){
				$tglunggah=date("d F Y - H:i",strtotime($row['tanggalunggah']));
				$ukuran = ceil($row['ukuran_file']/1024);
				echo '
				<tr>
					<td>'.$no++.'</td>
					<td>'.$row['judul_materi'].'</td>
					<td>'.$row['keterangan'].'</td>
					<td>'.$tglunggah.'</td>
					<td>'.$ukuran.' kb</td>
					';
					if($_SESSION['peran']!='siswa'){
					echo '<td><a href="edit_materi.php?id='.$row['id_materi'].'" class="btn btn-warning btn-sm" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					<a href="unduh_materi.php?id_materi='.$row['id_materi'].'&file='.$row['nama_file'].'" class="btn btn-primary btn-sm" role="button"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
					<a href="materi_pembelajaran.php?aksi=delete&id='.$row['id_materi'].'&file='.$row['nama_file'].'" onclick="return confirm(\'Yakin?\')" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
					</td>
						';
					}else{
						echo '<td><a href="unduh_materi.php?id_materi='.$row['id_materi'].'&file='.$row['nama_file'].'" class="btn btn-primary btn-sm" role="button"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
					</td></tbody>
		</table>
						';
					}
					}
			}
			?>
			
		</div>
	</div>
</div>

<?php } else {?>
<div class="table-responsive">
	<table class="table table-bordered table-hover dtbl">
	<thead>
		<tr>
			<th>NO.</th>
			<th>Judul</th>
			<th>Keterangan</th>
			<th>Tanggal Unggah</th>
			<th>Ukuran File</th>
			<th>OPSI</th>
		</tr>
		</thead>
	<tbody>
		<?php
				$sql = mysqli_query($connect, "SELECT * FROM materi");
			
			if(mysqli_num_rows($sql) == 0){
				echo '<tr><td colspan="8">Tidak ada data.</td></tr>';
			}else{	
				$no = 1;
			while($row = mysqli_fetch_assoc($sql)){
				$tglunggah=date("d F Y - H:i",strtotime($row['tanggalunggah']));
				$ukuran = ceil($row['ukuran_file']/1024);
				echo '
				<tr>
					<td>'.$no++.'</td>
					<td>'.$row['judul_materi'].'</td>
					<td>'.$row['keterangan'].'</td>
					<td>'.$tglunggah.'</td>
					<td>'.$ukuran.' kb</td>
					<td><a href="unduh_materi.php?id_materi='.$row['id_materi'].'&file='.$row['nama_file'].'" class="btn btn-primary btn-sm col-sm-10" role="button"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
					</td>
						';
					}
					}
			}
			?>
			</tbody>
		</table>
		</div>
	</div>
</div>
<br>
<?php include('footer.php')?>
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



<!-- aksi unggah materi -->
<?php
if(isset($_POST["unggah"])){

	$query = "SELECT MAX(id_materi) AS idtertinggi FROM materi"; 
	$result = mysqli_query($connect, $query);


	$hasil = $result->fetch_object()->idtertinggi;
	$id = $hasil+1;
	$judul = ucfirst(stripslashes($_POST['judulmateri']));
	$keterangan = ucfirst(stripslashes($_POST['keterangan']));
	$namafile = basename($_FILES['fileupload']['name']);
	$target_dir = "materi/";
	$direktori = $target_dir . $namafile;
	$imageFileType = strtolower(pathinfo($direktori,PATHINFO_EXTENSION));
	$ukuran = basename($_FILES["fileupload"]["size"]);
	$oldname = $namafile;
	$newname = 'file_'.$id.'.'.$imageFileType;

	//$newname = preg_replace('/\s+/','_',$oldname);
	$target_file = $target_dir.$newname;
	$status = '1';
	// Check if file already exists


	if(!is_uploaded_file($_FILES["fileupload"]["tmp_name"])){
	$status = '5';
	}elseif ($_FILES["fileupload"]["size"] > 2000000) {
	$status = '2';
	}elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !="jpeg"
	&& $imageFileType != "gif" && $imageFileType != "xls" && $imageFileType !="xlsx" && $imageFileType !="doc" && $imageFileType !="docx" && $imageFileType != "ppt" && $imageFileType !="pptx" && $imageFileType !="pdf") {
    //echo "Maaf, hanya JPG, JPEG, PNG, GIF, DOC, PPT, XLS, PDF files yang diperbolehkan.";
    $status = '4';
	}
	// Check if $uploadOk is set to 0 by an error
	if($status == 5 || $status == 4 || $status == 2) {
    header("location:materi_pembelajaran.php?status=$status&id=$id");
	// if everything is ok, try to upload file
	}elseif (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)){
        $query = mysqli_query($connect, "INSERT INTO materi (id_materi, judul_materi, keterangan, tanggalunggah, nama_file, tipefile, ukuran_file) VALUES ('$id', '$judul', '$keterangan', now(),'$newname','$imageFileType', '$ukuran')");
       //print "<script>alert('Berhasil!');
	print "<script>javascript:window.location = 'materi_pembelajaran.php?success&id=$id';</script>";
	} else {
    $status = 6;
        //header("location:materipembelajaran.php?status=$status&id=$id");
        //echo "Terjadi error saat mengunggah file.";
    }
}

?> 