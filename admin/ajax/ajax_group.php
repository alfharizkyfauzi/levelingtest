<?php
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

//menampilkan data ke tabel
if($_GET['action'] == "table_data"){
	$query = mysqli_query($mysqli, "SELECT * FROM grup ORDER BY id_grup DESC");
	$data = array();
	$no = 1;
	while($r = mysqli_fetch_array($query)){
		$row = array();
		$row[] = $no;
		$row[] = $r['nama_grup'];
		$row[] = create_action($r['id_grup']);
		$data[] = $row;
		$no++;
	}
	$output = array("data" => $data);
	echo json_encode($output);
}

//menampilkan data ke form
elseif ($_GET['action'] == "form_data") {
	$query = mysqli_query($mysqli, "SELECT * FROM grup WHERE id_grup='$_GET[id]'");
	$data = mysqli_fetch_array($query);
	echo json_encode($data);
}

//menambah data
elseif ($_GET['action'] == "insert") {
	$password = md5($_POST['password']);
	mysqli_query($mysqli, "INSERT INTO grup SET
							nama_grup 		= '$_POST[grup]'");
}

//mengedit data
elseif ($_GET['action'] == "update") {
	$password = md5($_POST['password']);
	mysqli_query($mysqli, "UPDATE grup SET
							nama_grup 		= '$_POST[grup]'
							WHERE id_grup	= '$_POST[id]'");
}

//menghapus data
elseif ($_GET['action'] == "delete") {
	mysqli_query($mysqli, "DELETE FROM grup WHERE id_grup='$_GET[id]'");
}
?>