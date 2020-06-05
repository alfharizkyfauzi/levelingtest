<script type="text/javascript" src="script/script_ujian_operator.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="operator"){
 header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";

create_title("edit", "Manajemen Ujian");

echo '<hr/><div class="alert alert-info"><p>Klik pada nama Group Relawan untuk mengaktifkan (Hijau) atau menon-aktifkan (Merah) ujian pada Group Relawan tersebut!</p></div>';

create_table(array("Judul Ujian", "Group"));
?>
