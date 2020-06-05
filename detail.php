<?php
session_start();
include "library/config.php";

if(empty($_SESSION['username']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

$grup = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM grup WHERE id_grup='$_SESSION[grup]'"));
$ujian = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM ujian WHERE id_ujian='$_GET[ujian]'"));

?>

<h3 class="page-header"><i class="glyphicon glyphicon-user"></i> Data Relawan dan Ujian</h3>
<div class="row">
   <div class="col-md-3">NPM</div>
   <div class="col-md-9">: <b><?= $_SESSION['npm']; ?> </b> </div>
</div><br/>
<div class="row">
   <div class="col-md-3">Nama Lengkap</div>
   <div class="col-md-9">: <b><?= $_SESSION['namalengkap']; ?> </b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Group</div>
   <div class="col-md-9">: <b><?= $grup['nama_grup']; ?></b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Nama Ujian</div>
   <div class="col-md-9">: <b><?= $ujian['nama_ujian']; ?></b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Jml. Soal</div>
   <div class="col-md-9">: <b><?= $ujian['jml_soal_ujian']; ?> Buah Soal</b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Waktu Mengerjakan</div>
   <div class="col-md-9">: <b><?= $ujian['waktu_ujian']; ?> menit</b></div>
</div><br/>

<div class="row">
   <div class="col-md-12">

<?php	
//Jika nilai sudah ada tampilkan tombol Sudah Mengerjakan, jika belum ada tampilkan tombol Masuk Ujian
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_ujian='$_GET[ujian]' AND relawan_npm='$_SESSION[npm]'");
$tnilai = mysqli_num_rows($qnilai);
$rnilai = mysqli_fetch_array($qnilai);

if($tnilai>0 and $rnilai['nilai'] != "")  echo '<a class="btn btn-danger disabled"> Sudah mengerjakan </a>';
else echo '<a class="btn btn-primary" onclick="show_petunjuk('.$_GET['ujian'].')">
<i class="glyphicon glyphicon-log-in"></i> Masuk Ujian</a>';
?>
	
   </div>
</div><br/>
