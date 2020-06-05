<script type="text/javascript" src="script/script_profil.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password'])){
	header('location: ../login.php');
}

include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("user", "Profil User");

echo '<hr/><form id="form-profil" class="form-horizontal" onsubmit="return edit_data()">';
	
create_textbox("Nama Lengkap", "nama_lengkap", "text", 4, "", 'value="'.$_SESSION['namalengkap'].'" readonly');
create_textbox("Username", "username", "text", 4, "", 'value="'.$_SESSION['username'].'" readonly');
create_textbox("Level", "level", "text", 4, "", 'value="'.$_SESSION['leveluser'].'" readonly');
create_textbox("Password Lama", "lama", "password", 4, "", "required");
create_textbox("Password Baru", "baru", "password", 4, "", "required");
create_textbox("Ulang Password Baru", "ulang", "password", 4, "", "required");

echo '<div class="form-group">
<div class="col-md-2 col-md-offset-2"><button class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> Ubah Password </button></div>
</div></form>';
?>
