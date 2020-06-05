<?php
session_start();
include "../library/config.php";
include "../library/function_antiinjection.php";

$username = antiinjeksi($_POST['username']);
$password = antiinjeksi(md5($_POST['password']));

$cekuser = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$username' AND password='$password'");
$jmluser = mysqli_num_rows($cekuser);
$data = mysqli_fetch_array($cekuser);
if($jmluser > 0){
   $_SESSION['username']     = $data['username'];
   $_SESSION['namalengkap']  = $data['nama'];
   $_SESSION['password']     = $data['password'];
   $_SESSION['iduser']       = $data['id_user'];
   $_SESSION['leveluser']    = $data['level'];

   $_SESSION['timeout'] = time()+1000;
   $_SESSION['login'] = 1;
   echo "ok";
}else{
   echo "<b>Username</b> atau <b>password</b> tidak terdaftar!";
}
?>