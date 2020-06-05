<?php
session_start();
include "../../library/config.php";

//menampilkan data ke tabel
if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM relawan ORDER BY relawan_npm");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $grup = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM grup WHERE id_grup='$r[id_grup]'"));
      $jurusan = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM jurusan WHERE id_jurusan='$r[relawan_jurusan]'"));
      $domisili = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM domisili WHERE id_domisili='$r[relawan_domisili]'"));

      if($r['relawan_status'] == "login") $status = '<b class="text-primary">login</b>';
      elseif($r['relawan_status'] == "mengerjakan") $status = '<b class="text-danger">mengerjakan</b>';
      else $status = '<b class="text-muted">off</b>';

      $row = array();
      $row[] = $no;
      $row[] = $r['relawan_npm'];
      $row[] = $r['relawan_nama'];
      $row[] = substr(md5($r['relawan_npm']),0,5);
      $row[] = $r['relawan_kelas'];
      $row[] = $jurusan['jurusan'];
      $row[] = $r['relawan_semester'];
      $row[] = $r['relawan_telpon'];
      $row[] = $r['relawan_email'];
      $row[] = $domisili['domisili'];
      $row[] = $grup['nama_grup'];
      $row[] = $status;
      $row[] = '<a class="btn btn-danger" onclick="reset_login('.$r['relawan_npm'].')"><i class="glyphicon glyphicon-off"></i> Reset Login</a>';
      $data[] = $row;
      $no++;
   }
   $output = array("data" => $data);
   echo json_encode($output);
}

//Reset login
elseif($_GET['action'] == "reset_login"){
   mysqli_query($mysqli, "UPDATE relawan set relawan_status='off' WHERE relawan_npm='$_GET[relawan_npm]'");
}
?>