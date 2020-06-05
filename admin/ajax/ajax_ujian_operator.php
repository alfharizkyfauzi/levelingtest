<?php
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

//Menampilkan data ke tabel
if($_GET['action'] == "table_data"){
   $tgl = date('Y-m-d');
   $query = mysqli_query($mysqli, "SELECT * FROM ujian WHERE tanggal_ujian='$tgl' ORDER BY id_user");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
		
      $qgrup = mysqli_query($mysqli, "SELECT * FROM grup t1, grup_ujian t2 WHERE t1.id_grup=t2.id_grup AND t2.id_ujian='$r[id_ujian]'");
      $label = "";
      while($rg = mysqli_fetch_array($qgrup)){
         if($rg['aktif']=='Y') $class = 'btn-danger';
         else $class = 'btn-success';
         $label .= '<a class="btn btn-sm '.$class.'" onclick="edit_data('.$rg['id_grup'].','.$rg['id_ujian'].')">'.$rg['nama_grup'].'</a> ';
      }
      
      $row = array();
      $row[] = $no;
      $row[] = $r['judul_ujian'];
      $row[] = $label;
      $data[] = $row;
      $no++;
   }
	
   $output = array("data" => $data);
   echo json_encode($output);
}

//Mengaktifkan atau menonaktifkan grup ujian
elseif($_GET['action'] == "update"){
   $cek = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM grup_ujian WHERE id_ujian='$_GET[ujian]' AND id_grup='$_GET[grup]'"));
   $aktif = ($cek['aktif']=='Y') ? 'N' : 'Y';
   mysqli_query($mysqli, "UPDATE grup_ujian set aktif='$aktif' WHERE id_ujian='$_GET[ujian]' AND id_grup='$_GET[grup]'");
}
?>
