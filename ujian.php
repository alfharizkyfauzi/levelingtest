<script type="text/javascript" src="js/ujian.js"></script>
<?php
error_reporting(1);
session_start();
include "library/config.php"; 

if(empty($_SESSION['username']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

//1 Update status siswa dan membuat array data untuk dimasukkan ke tabel nilai
mysqli_query($mysqli, "UPDATE relawan SET relawan_status='mengerjakan' WHERE relawan_npm='$_SESSION[npm]'");

$rujian = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM ujian WHERE id_ujian='$_GET[ujian]'"));
$qsoal = mysqli_query($mysqli, "SELECT * FROM soal WHERE id_ujian='$_GET[ujian]' ORDER BY rand() LIMIT $rujian[jml_soal_ujian]");

if(mysqli_num_rows($qsoal)==0) die('<div class="alert alert-warning">Belum ada soal pada ujian ini</div>');

$arr_soal = array();
$arr_jawaban = array();
while($rsoal = mysqli_fetch_array($qsoal)){
   $arr_soal[] = $rsoal['id_soal'];
   $arr_jawaban[] = 0;
}

$acak_soal = implode(",", $arr_soal);
$jawaban = implode(",", $arr_jawaban);

//2 Memasukkan data ke tabel nilai jika data nilai belum ada
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE relawan_npm='$_SESSION[npm]' AND id_ujian='$_GET[ujian]'");
if(mysqli_num_rows($qnilai) < 1){
   mysqli_query($mysqli, "INSERT INTO nilai SET relawan_npm='$_SESSION[npm]', id_ujian='$_GET[ujian]', acak_soal='$acak_soal', jawaban='$jawaban', sisa_waktu='$rujian[waktu_ujian]:00'");
}

//3 Menampilkan judul mapel dan sisa waktu
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE relawan_npm='$_SESSION[npm]' AND id_ujian='$_GET[ujian]'");
$rnilai = mysqli_fetch_array($qnilai);
$sisa_waktu = explode(":", $rnilai['sisa_waktu']);

echo '<h3 class="page-header"><b>Ujian: '.$rujian['nama_ujian'].' <span class="pull-right"> Sisa Waktu : <span class="menit">'.$sisa_waktu[0].'</span> : <span class="detik"> '.$sisa_waktu[0].' </span></span></b></h3>

<input type="hidden" id="ujian" value="'.$_GET['ujian'].'">
<input type="hidden" id="sisa_waktu">';
   
echo '<div class="row">
   <div class="col-md-8"><div class="konten-ujian">'; 

//4 Mengambil data soal dari database
$arr_soal = explode(",", $rnilai['acak_soal']);
$arr_jawaban = explode(",", $rnilai['jawaban']);
$arr_class = array();

for($s=0; $s<count($arr_soal); $s++){
   $rsoal = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM soal WHERE id_soal='$arr_soal[$s]'"));

//5 Menampilkan no. soal dan soal   
   $no = $s+1;
   $soal = str_replace("../media", "media", $rsoal['soal']);
   $active = ($no==1) ? "active" : "";
   echo '<div class="blok-soal soal-'.$no.' '.$active.'">
<div class="box">
<div class="row">
   <div class="col-xs-1"><div class="nomor">'.$no.'</div></div>
   <div class="col-xs-11"><div class="soal">'.$soal.'</div> </div>
</div>';

//6 Membuat array pilihan dan mengacak pilihan
   $arr_pilihan = array();
   $arr_pilihan[] = array("no" => 1, "pilihan" => $rsoal['pilihan_1']);
   $arr_pilihan[] = array("no" => 2, "pilihan" => $rsoal['pilihan_2']);
   $arr_pilihan[] = array("no" => 3, "pilihan" => $rsoal['pilihan_3']);
   $arr_pilihan[] = array("no" => 4, "pilihan" => $rsoal['pilihan_4']);
   $arr_pilihan[] = array("no" => 5, "pilihan" => $rsoal['pilihan_5']);
   shuffle($arr_pilihan);

//7 Menampilkan pilihan 
   $arr_huruf = array("A","B","C","D","E");  
   $arr_class[$no] = ($arr_jawaban[$s]!=0) ? "green" : "";
   for($i=0; $i<=4; $i++){
      $checked = ($arr_jawaban[$s] == $arr_pilihan[$i]['no']) ? "checked" : "";
      $pilihan = str_replace("../media", "media", $arr_pilihan[$i]['pilihan']);
      echo '<div class="row pilihan">
<div class="col-xs-1 col-xs-offset-1">
   <input type="radio" name="jawab-'.$no.'" id="huruf-'.$no.'-'.$i.'" '.$checked.'>
   <label for="huruf-'.$no.'-'.$i.'" class="huruf" onclick="kirim_jawaban('.$s.', '.$arr_pilihan[$i]['no'].')"> '.$arr_huruf[$i].' </label>
</div>
<div class="col-xs-10">
   <div class="teks">'.$pilihan.' </div> 
</div>
</div>';
   }

//8 Menampilkan tombol sebelumnya, ragu-ragu dan berikutnya
   echo '</div><br/><div class="row"><div class="col-md-3">';
   
   $sebelumnya = $no-1;
   if($no != 1) echo '<a class="btn btn-primary btn-blockl" onclick="tampil_soal('.$sebelumnya.')">Sebelumnya</a>';
   echo '</div>
   <div class="col-md-4 col-md-offset-1"><label class="btn btn-warning btn-block"> <input type="checkbox" autocomplete="off" onchange="ragu_ragu('.$no.')"> Ragu-ragu </label></div>   
<div class="col-md-3 col-md-offset-1">';
   
   $berikutnya = $no+1;
   if($no != count($arr_soal)) echo '<a class="btn btn-primary btn-block" onclick="tampil_soal('.$berikutnya.')"> Berikutnya </a>';
   else echo '<a class="btn btn-danger btn-block" onclick="selesai()"> Selesai </a>';

   echo '</div></div></div>';
}

echo '</div></div>
   <div class="col-md-4"><div class="nomor-ujian">';

//9 Menampilkan nomor ujian
for($j=1; $j<=$s; $j++){
   echo '<div class="blok-nomor"><div class="box"> <a class="tombol-nomor tombol-'.$j.' '.$arr_class[$j].'" onclick="tampil_soal('.$j.')">'.$j.'</a></div></div>';
}
echo '</div></div></div>';

//10 Menampilkan modal ketika selesai ujian
echo '<div class="modal fade" id="modal-selesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg">
   <div class="modal-content">
   <form  onsubmit="return selesai_ujian('.$_GET['ujian'].')">
      
<div class="modal-header">
  <h3 class="modal-title">Selesai Ujian</h3>
</div>
      
<div class="modal-body">
   <p>Pastikan semua soal telah dikerjakan sebelum mengklik selesai. Setelah klik selesai Anda tidak dapat mengerjakan ujian lagi. Yakin akan menyelesaikan ujian? </p>
   <div class="chekbox-selesai"><input type="checkbox" required> Saya yakin akan menyelesaikan ujian.</div>
</div>
      
<div class="modal-footer">
   <button type="submit" class="btn btn-danger" onclick="return selesai_ujian('.$_GET['ujian'].')"> Selesai </button>
   <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal </button>
</div>
      
</form></div></div></div>';
?>
