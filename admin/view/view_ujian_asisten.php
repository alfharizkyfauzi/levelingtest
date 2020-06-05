<script type="text/javascript" src="script/script_ujian_asisten.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="asisten"){
   header('location: login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";

create_title("edit", "Manajemen Ujian");

echo '<hr/><div class="alert alert-info"><ul>
<li>Klik tombol edit pada kolom Bank Soal untuk mengatur soal!</li>
<li>Klik nama kelas pada kolom Kelas Ujian untuk melihat nilai pada kelas tersebut!</li>
</ul></div>';

create_table(array("Judul Ujian", "Nama Ujian", "Tanggal", "Jml. Soal", "Bank Soal", "Group Ujian"));
?>