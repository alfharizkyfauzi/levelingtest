<?php
session_start();
include "../../library/config.php";
include "../../library/function_date.php";

$query = mysqli_query($mysqli, "SELECT * FROM ujian WHERE id_user='$_SESSION[iduser]' ORDER BY tanggal_ujian");
$data = array();
$no = 1;
while($r = mysqli_fetch_array($query)){

//Membuat tombol edit soal		
   $qsoal = mysqli_query($mysqli, "SELECT * FROM soal WHERE id_ujian='$r[id_ujian]'");
   $btn_soal = '<a class="btn btn-primary btn-sm" onclick="show_soal('.$r['id_ujian'].')"><i class="glyphicon glyphicon-edit"></i> Edit &nbsp;&nbsp;<span class="label label-warning">'.mysqli_num_rows($qsoal).'</span></a>';

//Membuat tombol grup untuk melihat nilai	
   $qgrup = mysqli_query($mysqli, "SELECT * FROM grup t1, grup_ujian t2 WHERE t1.id_grup=t2.id_grup AND t2.id_ujian='$r[id_ujian]'");
   $label = "";
   while($rg = mysqli_fetch_array($qgrup)){
      $jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM nilai t1, relawan t2 WHERE t1.id_ujian='$rg[id_ujian]' AND t1.relawan_npm=t2.relawan_npm AND t2.id_grup='$rg[id_grup]'"));
      $label .= '<a class="btn btn-xs btn-info" style="margin-bottom: 5px" onclick="show_nilai('.$rg['id_grup'].','.$rg['id_ujian'].')">'.$rg['nama_grup'].' &nbsp;&nbsp; <span class="label label-warning">'.$jml.'</span></a> ';
   }
		
   $row = array();
   $row[] = $no;
   $row[] = $r['judul_ujian'];
   $row[] = $r['nama_ujian'];
   $row[] = tgl_indonesia($r['tanggal_ujian']);
   $row[] = $r['jml_soal_ujian'];
   $row[] = $btn_soal;
   $row[] = $label;
   $data[] = $row;
   $no++;
}
	
$output = array("data" => $data);
echo json_encode($output);
?>