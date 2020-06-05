<script type="text/javascript" src="script/script_user.js"></script>
<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
	header('location:../login.php');
}

//include library yang dibutuhkan
include "../../library/function_view.php";
include "../../library/function_form.php";

//Membuat judul dan tombol tambah user
create_title("user", "Manajemen User");
create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");

//membuat header dan footer tabel
create_table(array("Nama", "Username", "Lavel", "Aksi"));

//membuat form tambah dan edit user
open_form("modal_user", "return save_data()");
	create_textbox("Nama", "nama", "text", 4, "", "required");
	create_textbox("Username", "username", "text", 4, "", "required");
	create_textbox("Password", "password", "password", 4);

	$list = array();
	$list[] = array("admin", "Admin");
	$list[] = array("asisten", "Asisten");
	$list[] = array("operator", "Operator");
	create_combobox("Level", "level", $list, 4, "", "required");
close_form();
?>