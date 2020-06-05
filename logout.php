<?php
  session_start();
  include "library/config.php";
  mysqli_query($mysqli, "UPDATE relawan SET relawan_status='off' WHERE relawan_npm='$_SESSION[npm]'");
  
  session_destroy();
  echo "<script>
   alert('Anda keluar dari ujian!'); 
   window.location = 'login.php';
   </script>";
?>
