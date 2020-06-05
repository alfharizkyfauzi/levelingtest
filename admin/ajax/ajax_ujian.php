<?php
session_start();

include "../../library/config.php";
include "../../library/function_date.php";
include "../../library/function_view.php";

//menampilkan data ke tabel
if($_GET['action'] == "table_data"){
	$query = mysqli_query($mysqli, "SELECT * FROM ujian ORDER BY id_ujian DESC");
	$data = array();
	$no = 1;
	while($r = mysqli_fetch_array($query)){
		$user = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM user WHERE id_user='$r[id_user]'"));
		$row = array();
		$row[] = $no;
		$row[] = $r['judul_ujian'];
		$row[] = $r['nama_ujian'];
		$row[] = tgl_indonesia($r['tanggal_ujian']);
		$row[] = $r['waktu_ujian'].'menit';
		$row[] = $r['jml_soal_ujian'];
		$row[] = $user['nama'];
		$row[] = create_action($r['id_ujian']);
		$data[] = $row;
		$no++;
	}
	$output = array("data" => $data);
	echo json_encode($output);
}

//menampilkan data ke form
elseif ($_GET['action'] == "form_data") {
	$query = mysqli_query($mysqli, "SELECT * FROM ujian WHERE id_ujian='$_GET[id]'");
	$data = mysqli_fetch_array($query);
	echo json_encode($data);
}

//menambah data
elseif ($_GET['action'] == "insert") {
	mysqli_query($mysqli, "INSERT INTO ujian SET
							judul_ujian 	= '$_POST[judul]',
							nama_ujian 		= '$_POST[ujian]',
							tanggal_ujian 	= '$_POST[tanggal]',
							waktu_ujian 	= '$_POST[waktu]',
							jml_soal_ujian 	= '$_POST[jml_soal]',
							id_user 		= '$_POST[pengampu]'");
}

//mengedit data
elseif ($_GET['action'] == "update") {
	mysqli_query($mysqli, "UPDATE ujian SET
							judul_ujian 	= '$_POST[judul]',
							nama_ujian 		= '$_POST[ujian]',
							tanggal_ujian 	= '$_POST[tanggal]',
							waktu_ujian 	= '$_POST[waktu]',
							jml_soal_ujian 	= '$_POST[jml_soal]',
							id_user 		= '$_POST[pengampu]'
							WHERE id_ujian	= '$_POST[id]'");
}

//menghapus data
elseif ($_GET['action'] == "delete") {
	mysqli_query($mysqli, "DELETE FROM ujian WHERE id_ujian='$_GET[id]'");
}
?>