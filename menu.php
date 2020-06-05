<?php
if( empty($_SESSION['username']) or empty($_SESSION['password']) ){
   header('location: login.php');
}
?>

<div class="navbar-header">
   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
   </button>
</div>

<div id="navbar" class="navbar-collapse collapse">
   <ul class="nav navbar-nav">
      <li><a><i class="glyphicon glyphicon-user"></i> <?= $_SESSION['npm'] ?> : <?= $_SESSION['namalengkap'] ?></a></li>
   </ul>
   <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><i class="glyphicon glyphicon-off"></i> Keluar </a></li>
   </ul>
</div>
