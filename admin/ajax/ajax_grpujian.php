<?php 
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

//Menampilkan data ke tabel
if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM ujian ORDER BY id_user");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $qgrup = mysqli_query($mysqli, "SELECT * FROM grup t1, grup_ujian t2 WHERE t1.id_grup = t2.id_grup AND t2.id_ujian='$r[id_ujian]'");
      $label = "";
      while($rg = mysqli_fetch_array($qgrup)){
        $label .= '<span class="label label-info">'.$rg['nama_grup'].'</span> ';
      }
		
      $row = array();
      $row[] = $no;
      $row[] = $r['judul_ujian'];
      $row[] = $label;
      $row[] = create_action($r['id_ujian'], true, false);
      $data[] = $row;
      $no++;
   }
	
   $output = array("data" => $data);
   echo json_encode($output);
}

//Menampilkan data ke form edit
elseif($_GET['action'] == "form_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM grup_ujian WHERE id_ujian='$_GET[id]'");
   $id_grup = array();
   while($row = mysqli_fetch_array($query)){
      $id_grup[] = $row['id_grup'];
   }
   $data = array();
   $data['nama_grup'] = implode(" ", $id_grup);
   echo json_encode($data);
}

//Mengedit data pada database
elseif($_GET['action'] == "update"){
   mysqli_query($mysqli, "DELETE FROM grup_ujian WHERE id_ujian='$_POST[id]'");
   $grup = $_POST['grup'];
   foreach($grup as $grp){
      mysqli_query($mysqli, "INSERT INTO grup_ujian SET id_ujian='$_POST[id]', id_grup='$grp'");
   }
}
?>