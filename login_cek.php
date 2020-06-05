<?php
session_start();
include "library/config.php";
include "library/function_antiinjection.php";

$username = antiinjeksi($_POST['username']);
$password = antiinjeksi(md5($_POST['password']));

$cekuser = mysqli_query($mysqli, "SELECT * FROM relawan WHERE relawan_npm='$username' AND relawan_password='$password'");
$jmluser = mysqli_num_rows($cekuser);
$data = mysqli_fetch_array($cekuser);
if($jmluser > 0){
   if($data['relawan_status'] == "off"){
     $_SESSION['username']     = $data['relawan_npm'];
     $_SESSION['namalengkap']  = $data['relawan_nama'];
     $_SESSION['password']     = $data['relawan_password'];
     $_SESSION['npm']          = $data['relawan_npm'];
     $_SESSION['grup']        = $data['id_grup'];

     mysqli_query($mysqli, "UPDATE relawan SET relawan_status='login' WHERE relawan_npm='$data[relawan_npm]'");
     echo "ok";
   }else{
      echo "Relawan sedang <b>Login</b>. Hubungi operator untuk mereset login!";
   }
}else{
   echo "<b>Username</b> atau <b>password</b> tidak terdaftar!";
}
?>