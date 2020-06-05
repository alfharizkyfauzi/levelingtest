<script type="text/javascript" src="script/script_group.js"></script>
<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
	header('location:../login.php');
}

//include library yang dibutuhkan
include "../../library/function_view.php";
include "../../library/function_form.php";

//Membuat judul dan tombol tambah user
create_title("signal", "Manajemen Group");
create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");

//membuat header dan footer tabel
create_table(array("Nama Group", "Aksi"));

//membuat form tambah dan edit user
open_form("modal_group", "return save_data()");
	create_textbox("Nama Group", "grup", "text", 4, "", "required");
close_form();
?>