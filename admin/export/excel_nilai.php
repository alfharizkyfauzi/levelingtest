<?php
include "../../library/config.php";

$rujian = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM ujian WHERE id_ujian = '$_GET[ujian]' "));
$rgrup = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM grup WHERE id_grup = '$_GET[grup]' "));

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Nilai_$rujian[nama_ujian]_$rgrup[nama_grup].xls");

session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="asisten"){
	header('location: ../login.php');
}
echo '<table>
	<tr>
	<td>No</td>	
	<td>NPM</td>	
	<td>Nama Relawan</td>	
	<td>Jml. Benar</td>	
	<td>NIlai</td>	
	</tr>';
$query = mysqli_query($mysqli, "SELECT * FROM relawan WHERE id_grup='$_GET[grup]'");
$no = 1;

while ($r = mysqli_fetch_array($query)){
	$n = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM nilai WHERE relawan_npm='$r[relawan_npm]' AND id_ujian='$_GET[ujian]'")) ;
	echo '<tr>
	<td>'.$no.'</td>		
	<td>'.$r['relawan_npm'].'</td>		
	<td>'.$r['relawan_nama'].'</td>		
	<td>'.$n['jml_benar'].'</td>		
	<td>'.$n['nilai'].'</td>		
	</tr>';
	$no++;
	}
	echo '</table>';