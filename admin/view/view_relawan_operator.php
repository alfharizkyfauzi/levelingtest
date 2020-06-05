<script type="text/javascript" src="script/script_relawan_operator.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="operator"){
	header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("list-alt", "Manajemen Relawan");
create_button("success", "refresh", "Refresh", "btn-refresh", "refresh_data()");

create_table(array("NPM", "Nama Relawan", "Password", "Kelas", "Jurusan", "Semester", "No.Tlp", "Email", "Domisili", "Group", "Status", "Aksi"));
?>