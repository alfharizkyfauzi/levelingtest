<?php 
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.box{
			border: 1px solid #000;
		}
		.header td{
			border-bottom: 1px solid #000;
		}
		.box td{
			padding: 5px 10px;
		}
	</style>
</head>
<body>
<?php
include "../../library/config.php";

$query = mysqli_query($mysqli, "SELECT * FROM relawan WHERE id_grup = '$_GET[grup]'");
$no = 1;
echo "<table width='100%' cellspacing='20'><tr>";
while ($r = mysqli_fetch_array($query)){
	$password = substr(md5($r['relawan_npm']), 0,5);
	$grup = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM grup WHERE id_grup = '$r[id_grup]'"));
	echo "<td class='box' width='335'>
	<table width='100%' style='width: 330px;' cellspacing='0'>
	<tr class='header'>
		<td width='50' align='center'>
			<img src='../../images/logotc.png' width='82'>
		</td>
		<td width='130' align='center' valign='middle' style='padding: 3px 30px;'>
		<b>KARTU PESERTA LEVELING</b>
		<b>Relawan Pajak Tax Center Gunadarma </b>
		</td>
	</tr>
	<tr><td>Nama</td><td> : $r[relawan_nama]</td></tr>
	<tr><td>Group</td><td> : $grup[nama_grup]</td></tr>
	<tr><td>Username</td><td> : <b>$r[relawan_npm]</b></td></tr>
	<tr><td>Password</td><td> : <b>$password</b></td></tr>
	<td>*Selamat mengerjakan jangan lupa berdo'a*</td>
	</table>
	</td>";
		if($no&2 == 0) 
			echo "</tr><tr>";
		$no++;
}
echo "</tr></table>";
?>
</body>
</html>

<?php
require_once('../../assets/html2pdf/html2pdf.class.php');
$content = ob_get_clean();
$html2pdf = new HTML2PDF('P', 'A4', 'en');
$html2pdf -> WriteHTML($content);
$html2pdf -> Output('Kartu_Peserta.pdf');
?>