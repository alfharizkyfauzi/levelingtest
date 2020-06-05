<?php
session_start();
include "library/config.php";

if( empty($_SESSION['username']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

echo '<h3 class="page-header">Daftar Ujian</h3>';

//Cek jumlah ujian pada tanggal sekarang
$tgl = date('Y-m-d');
$qujian = mysqli_query($mysqli, "SELECT * FROM ujian t1, grup_ujian t2 WHERE t1.tanggal_ujian='$tgl' AND t1.id_ujian=t2.id_ujian AND t2.id_grup='$_SESSION[grup]' AND t2.aktif='Y'");
$tujian = mysqli_num_rows($qujian);
$rujian = mysqli_fetch_array($qujian);

//Jika tidak ada ujian aktif tampilkan pesan
if($tujian < 1){
   echo '<div class="alert alert-info">Belum ada ujian yang aktif saat ini. Silahkan hubungi operator!</div>';
}

//Jika ada satu ujian aktif arahkan ke halaman berikutnya
else if($tujian == 1){
   echo '<script> show_detail('.$rujian['id_ujian'].'); </script>';
}

//Jika ada dua atau lebih ujian aktif tampilkan pada tabel
else{
   echo '<table class="table table-striped"><thead>
   <tr>
      <th>No</th>
      <th>Nama Ujian</th>
      <th>Group</th>
      <th>Jml. Soal</th>
      <th>Waktu</th>
      <th>Aksi</th>
   </tr></thead><tbody>';
	
	$qujian = mysqli_query($mysqli, "SELECT * FROM ujian t1, grup_ujian t2 WHERE t1.tanggal_ujian='$tgl' AND t1.id_ujian=t2.id_ujian AND t2.id_grup='$_SESSION[grup]' AND t2.aktif='Y'");
   $no = 1;
   while($r = mysqli_fetch_array($qujian)){
      
      $grup_ujian = array();
      $qgrup_ujian = mysqli_query($mysqli, "SELECT * FROM grup t1, grup_ujian t2 WHERE  t1.id_grup=t2.id_grup AND t2.id_ujian='$r[id_ujian]'");
      while($rku = mysqli_fetch_array($qgrup_ujian)){
         $grup_ujian[] = $rku['grup'];
      }
		
      echo'<tr>
         <td>'.$no.'</td>
         <td>'.$r['nama_ujian'].'</td>
         <td>'.implode($grup_ujian, ", ").'</td>
         <td>'.$r['jml_soal_ujian'].'</td>
        <td>'.$r['waktu_ujian'].' menit</td>
        <td>';

//Jika nilai sudah ada tampilkan tombol Sudah Mengerjakan, jika belum ada tampilkan tombol Kerjakan
        $qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_ujian='$r[id_ujian]' AND relawan_npm='$_SESSION[npm]'");
        $tnilai = mysqli_num_rows($qnilai);
        $rnilai = mysqli_fetch_array($qnilai);

        if($tnilai>0 and $rnilai['nilai'] != "") echo '<a class="btn btn-danger">Sudah Mengerjakan</a>';
        else echo '<a onclick="show_detail('.$r['id_ujian'].')" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i> Kerjakan</a>';
        echo '</td>
     </tr>';
	 $no++;
  }

   echo '</tbody></table>';
}
?>
