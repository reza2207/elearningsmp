<?php

 session_start();
 if (session_destroy())
 {
 print "<script>alert('Berhasil Keluar');
	 javascript:window.location = 'index';</script>";
}
?>