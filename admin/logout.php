<?php
  session_start();
  session_destroy();
  echo "<script>
      alert('Anda telah logout dari halaman Administrator'); 
      window.location = 'login.php';
      </script>";
?>
