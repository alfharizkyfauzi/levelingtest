<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">

<script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="script/script_ujian.js"></script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
	header('location:../login.php');
}

//include library yang dibutuhkan
include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

//Membuat judul dan tombol tambah user
create_title("edit", "Manajemen Ujian");
create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");

//membuat header dan footer tabel
create_table(array("Judul", "Nama Ujian", "Tanggal", "Waktu", "Jml. Soal", "Pengampu", "Aksi"));

//membuat form tambah dan edit user
open_form("modal_ujian", "return save_data()");
	create_textbox("Judul", "judul", "text", 4, "", "required");
	create_textbox("Nama Ujian", "ujian", "text", 4, "", "required");
	create_textbox("Tanggal", "tanggal", "text", 4, "datepicker", "required");
	create_textbox("Waktu (menit)", "waktu", "number", 2, "", "required");
	create_textbox("Jml. Soal", "jml_soal", "number", 2, "", "required");

	$quser = mysqli_query($mysqli, "SELECT * FROM user WHERE level='asisten'");
	$list = array();
	while($ru = mysqli_fetch_array($quser)){
		$list[] = array($ru['id_user'], $ru['nama']);
	}
	create_combobox("Pengampu", "pengampu", $list, 4, "", "required");
close_form();
?>
