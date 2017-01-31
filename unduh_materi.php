<?php
include ("config/koneksi.php");
if(!isset($_GET['file'])){
	header('location:materi_pembelajaran');
	}else{
if(isset($_GET['file'])){
$file = 'materi/'.$_GET['file'];
}if(file_exists($file)){
$id= $_GET['id_materi'];
$data = $_GET['file'];
$query = "SELECT * FROM materipembelajaran WHERE id_materi='$id'";
$runquery = $connect->query($query);
$row = mysqli_fetch_array($runquery, MYSQLI_ASSOC);

$filename = 'materi/'.$data;

header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='.basename($filename));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      ob_clean();
      flush();
      readfile($file);
      exit;
}else{
 echo "file {$_GET['file']} sudah tidak ada.";
}}
?>