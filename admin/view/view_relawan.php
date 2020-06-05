<script type="text/javascript" src="script/script_relawan.js"></script>
<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
	header('location:../login.php');
}

//include library yang dibutuhkan
include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

//Membuat judul dan tombol 
create_title("list-alt", "Manajemen Relawan");
create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");
create_button("primary", "import", "Import", "btn-add", "form_import()");
create_button("info", "print", "Cetak Kartu", "btn-add", "form_print()");

//membuat header dan footer tabel
create_table(array("NPM", "Nama Relawan", "Password", "Kelas", "Jurusan", "Fakultas", "Semester", "Email", "Gender", "Domisili", "Alamat", "Pernah Ikut?", "No.Tlp", "Group", "File", "Aksi"));

//membuat form tambah dan edit data
open_form("modal_relawan", "return save_data()");
	create_textbox("NPM", "npm", "text", 6, "", "required");
	create_textbox("Nama Relawan", "nama", "text", 6, "", "required");
	create_textbox("Kelas", "kelas", "text", 6, "", "required");

	$qjurusan = mysqli_query($mysqli, "SELECT * FROM jurusan");
	$list = array();
	while($rj = mysqli_fetch_array($qjurusan)){
		$list[] = array($rj['id_jurusan'], $rj['jurusan']);
	}
	create_combobox("Jurusan", "jurusan", $list, 6, "", "required");

	$qfakultas = mysqli_query($mysqli, "SELECT * FROM fakultas");
	$list = array();
	while($rf = mysqli_fetch_array($qfakultas)){
		$list[] = array($rf['id_fakultas'], $rf['fakultas']);
	}
	create_combobox("Fakultas", "fakultas", $list, 6, "", "required");

	create_textbox("Semester", "semester", "text", 6, "", "required");
	create_textbox("Email", "email", "text", 6, "", "required");

	$qgender = mysqli_query($mysqli, "SELECT * FROM gender");
	$list = array();
	while($rgd = mysqli_fetch_array($qgender)){
		$list[] = array($rgd['id_gender'], $rgd['gender']);
	}
	create_combobox("Jenis Kelamin", "gender", $list, 6, "", "required");

	$qdomisili = mysqli_query($mysqli, "SELECT * FROM domisili");
	$list = array();
	while($rdm = mysqli_fetch_array($qdomisili)){
		$list[] = array($rdm['id_domisili'], $rdm['domisili']);
	}
	create_combobox("Domsili", "domisili", $list, 6, "", "required");

	create_textarea("Alamat", "alamat", "textarea", 6, "","required");

	$qikut = mysqli_query($mysqli, "SELECT * FROM ikut_tidak");
	$list = array();
	while($rik = mysqli_fetch_array($qikut)){
		$list[] = array($rik['id_ikut'], $rik['tidak_ikut']);
	}
	create_combobox("Pernah Ikut Relawan Pajak ?", "ikut", $list, 6, "", "required");

	create_textbox("No.Telpon", "tlp", "text", 6, "", "required");

	$qgrup = mysqli_query($mysqli, "SELECT * FROM grup");
	$list = array();
	while($rg = mysqli_fetch_array($qgrup)){
		$list[] = array($rg['id_grup'], $rg['nama_grup']);
	}
	create_combobox("Group", "grup", $list, 6, "", "required");

	create_textbox("Berkas", "berkas", "file", 6, "", "required");
	echo "<p class='container'><b>*Note :</b> Upload Berkas Max.8 MB <br> Pas Photo, CV, Rangkuman Nilai dimasukan dalam rar/ zip NAMA_NPM_KELAS_RelawanPajak2020.rar";
close_form();

//membuat form cetak kartu
open_form("modal_print", "return print_data()");
	$qgrup = mysqli_query($mysqli, "SELECT * FROM grup");
	$list = array();
	while($rg = mysqli_fetch_array($qgrup)){
		$list[] = array($rg['id_grup'], $rg['nama_grup']);
	}
	create_combobox("Group", "grup_print", $list, 4, "", "required");
close_form("print", "Print");

//membuat form_import
open_form("modal_import", "return import_data()");
	create_textbox("Pilih File.xls", "file", "file", 4, "", "required");
	$qgrup = mysqli_query($mysqli, "SELECT * FROM grup");
	$list = array();
	while($rg = mysqli_fetch_array($qgrup)){
		$list[] = array($rg['id_grup'], $rg['nama_grup']);
	}
	create_combobox("Group", "grup_import", $list, 4, "", "required");
close_form("import", "Import");

