<script type="text/javascript" src="script/script_grpujian.js"></script>
<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser'] != "admin"){
	header('location: ../login.php');
}

//include library yang dibutuhkan
include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

//Membuat judul dan tombol 
create_title("sort-by-attributes", "Manajemen Group per Ujian");

//membuat header dan footer tabel
create_table(array("Judul Ujian", "Group", "Aksi"));

//membuat form edit data
open_form("modal_grpujian", "return save_data()");
	$qgrup 	= mysqli_query($mysqli, "SELECT * FROM grup");
	$list	= array();
	while($rg = mysqli_fetch_array($qgrup)){
		$list[] = array($rg['id_grup'], $rg['nama_grup']);
	}
	create_checkbox("Group", "grup", $list);
close_form();


?>
