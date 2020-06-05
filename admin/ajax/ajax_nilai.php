<?php
session_start();
include "../../library/config.php";

if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM relawan WHERE id_grup='$_GET[grup]'");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $n = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM nilai WHERE relawan_npm='$r[relawan_npm]' AND id_ujian='$_GET[ujian]'"));
		
      $row = array();
      $row[] = $no;
      $row[] = $r['relawan_npm'];
      $row[] = $r['relawan_nama'];
      $row[] = $n['jml_benar'];		
      $row[] = $n['nilai'];
      $data[] = $row;
   }
   $output = array("data" => $data);
   echo json_encode($output);
}
?>
