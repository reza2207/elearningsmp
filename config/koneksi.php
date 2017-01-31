<?php 
//koneksi untuk ke web
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'smpn88jakarta';
//menghubungkan ke MYSQL
$connect = mysqli_connect($host, $user, $pass, $db);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

