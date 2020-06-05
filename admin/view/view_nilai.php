<script type="text/javascript" src="script/script_nilai.js"> </script>

<?php
// var_dump(1);
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="asisten"){
   header('location: ../login.php');
}

include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("check", "Hasil Ujian");
create_button("primary", "export", "Export", "btn-add", "export_nilai()");

echo '<input type="hidden" id="id_ujian" value="'.$_GET['ujian'].'">';
echo '<input type="hidden" id="id_grup" value="'.$_GET['group'].'">';

create_table(array("NPM", "Nama Relawan", "Jml. Benar", "Nilai"));
?>
