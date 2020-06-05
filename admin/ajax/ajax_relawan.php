<?php 
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

//menampilkan data ke tabel
if($_GET['action'] == "table_data"){
	$query = mysqli_query($mysqli, "SELECT * FROM relawan ORDER BY id_relawan DESC");
	$data = array();
	$no = 1;
	while($r = mysqli_fetch_array($query)){
		$grup = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM grup WHERE id_grup='$r[id_grup]'"));
		$jurusan = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM jurusan WHERE id_jurusan='$r[relawan_jurusan]'"));
		$fakultas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM fakultas WHERE id_fakultas='$r[relawan_fakultas]'"));
		$gender = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM gender WHERE id_gender='$r[relawan_gender]'"));
		$domisili = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM domisili WHERE id_domisili='$r[relawan_domisili]'"));
		$ikut = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM ikut_tidak WHERE id_ikut='$r[relawan_ikut]'"));
		$row = array();
		$row[] = $no;
		$row[] = $r['relawan_npm'];
		$row[] = $r['relawan_nama'];
		$row[] = substr(md5($r['relawan_npm']),0,5);
		$row[] = $r['relawan_kelas'];
		$row[] = $jurusan['jurusan'];
		$row[] = $fakultas['fakultas'];
		$row[] = $r['relawan_semester'];
		$row[] = $r['relawan_email'];
		$row[] = $gender['gender'];
		$row[] = $domisili['domisili'];
		$row[] = $r['relawan_alamat'];
		$row[] = $ikut['tidak_ikut'];
		$row[] = $r['relawan_telpon'];
		$row[] = $grup['nama_grup'];
		$row[] = $r['relawan_berkas'];
		$row[] = create_action($r['id_relawan']);
		$data[] = $row;
		$no++;
	}
	$output = array("data" => $data);
	echo json_encode($output);
}

//menampilkan data ke form
elseif ($_GET['action'] == "form_data") {
	$query = mysqli_query($mysqli, "SELECT * FROM relawan WHERE id_relawan='$_GET[id]'");
	$data = mysqli_fetch_array($query);
	echo json_encode($data);
}

//menambah data
elseif ($_GET['action'] == "insert") {
	$filename		= basename($_FILES['berkas']['name']);
	$destination	= 'upload/' . $filename;
	$extensi 		= pathinfo($filename, PATHINFO_EXTENSION);
	$berkas = "none";

	if(!in_array($extensi, ['zip', 'rar'])){
		echo "File yang di-upload tidak berformat .rar / .zip!";
	} elseif ($_FILES['berkas']['size'] > 1000000) {
		echo "File to large!";
	} else {
		$path	= "../upload";
		move_uploaded_file($_FILES['berkas']['tmp_name'], "$path/$filename");
		$berkas 	= "../upload/$filename";
		// $data 		= new berkas();
		// $data 		-> read($berkas);
		// $jdata		= $jdata 	= $data->rowcount();

		// for($i=2; $i<=$jdata; $i++){
		// 	$idrelawan 	= addslashes(str_replace(" ", "", $data->val(1,2)));
		// 	$berkas 	= addslashes($data->val($i,3));
		// 	$cek 		= mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM relawan WHERE id_relawan='$idrelawan'"));

		// 	if($cek > 0){
		// 		mysqli_query($mysqli, "UPDATE relawan SET relawan_berkas = '$berkas' WHERE id_relawan = '$idrelawan'");
		// 	} else {
		// 		mysqli_query($mysqli, "INSERT INTO relawan SET relawan_berkas = '$berkas'");
		// 	}
		// }
		// unlink($berkas);
	}

	$password = md5(substr(md5($_POST['npm']),0,5));
	$jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM relawan WHERE relawan_npm='$_POST[npm]'"));
	if($jml > 0){
		echo "NPM Relawan sudah digunakan!";
	} else {
		mysqli_query($mysqli, "INSERT INTO relawan SET
					relawan_npm 		= '$_POST[npm]',
					relawan_nama 		= '$_POST[nama]',
					relawan_password 	= '$password',
					relawan_kelas 		= '$_POST[kelas]',
					relawan_jurusan 	= '$_POST[jurusan]',
					relawan_fakultas 	= '$_POST[fakultas]',
					relawan_semester 	= '$_POST[semester]',
					relawan_email	 	= '$_POST[email]',
					relawan_gender		= '$_POST[gender]',
					relawan_domisili	= '$_POST[domisili]',
					relawan_alamat		= '$_POST[alamat]',
					relawan_ikut 		= '$_POST[ikut]',
					relawan_telpon 		= '$_POST[tlp]',
					id_grup 			= '$_POST[grup]',
					relawan_berkas 		= '$berkas',
					relawan_status 		= 'off'");
		echo "ok";
	}

}

//mengedit data
elseif ($_GET['action'] == "update") {
	$filename		= basename($_FILES['berkas']['name']);
	$destination	= 'upload/' . $filename;
	$extensi 		= pathinfo($filename, PATHINFO_EXTENSION);
	$berkas 		= "none";

	if(!in_array($extensi, ['zip', 'rar'])){
		echo "File yang di-upload tidak berformat .rar / .zip!";
	} elseif ($_FILES['berkas']['size'] > 1000000) {
		echo "File to large!";
	} else {
		$path	= "../upload";
		move_uploaded_file($_FILES['berkas']['tmp_name'], "$path/$filename");
		$berkas 	= "../upload/$filename";
	}

	$password = md5(substr(md5($_POST['npm']),0,5));
		mysqli_query($mysqli, "UPDATE relawan SET
					relawan_npm 		= '$_POST[npm]',
					relawan_nama 		= '$_POST[nama]',
					relawan_kelas 		= '$_POST[kelas]',
					relawan_jurusan 	= '$_POST[jurusan]',
					relawan_fakultas 	= '$_POST[fakultas]',
					relawan_semester 	= '$_POST[semester]',
					relawan_email	 	= '$_POST[email]',
					relawan_gender		= '$_POST[gender]',
					relawan_domisili	= '$_POST[domisili]',
					relawan_alamat		= '$_POST[alamat]',
					relawan_ikut 		= '$_POST[ikut]',
					relawan_telpon 		= '$_POST[tlp]',
					id_grup 			= '$_POST[grup]',
					relawan_berkas 		= '$berkas'
					WHERE relawan_npm	= '$_POST[npm]'");
		echo "ok";
   
}

//menghapus data
elseif ($_GET['action'] == "delete") {
	mysqli_query($mysqli, "DELETE FROM relawan WHERE id_relawan='$_GET[id]'");
}

//Import data dari file Excel
elseif ($_GET['action'] == "import") {
	include "../../assets/excel_reader/excel_reader.php";
	$filename	= strtolower($_FILES['file']['name']);
	$extensi	= substr($filename, -4);
	if($extensi != ".xls"){
		echo "File yang di-upload tidak berformat .xls!";
	} else {
		$path	= "../upload";
		move_uploaded_file($_FILES['file']['tmp_name'], "$path/$filename");
		$file 	= "../upload/$filename";
		$data 	= new Spreadsheet_Excel_Reader();
		$data 	-> read($file);
		$jdata 	= $data->rowcount($sheet_index=0);

		for($i=2; $i<=$jdata; $i++){
			$idrelawan 	= addslashes(str_replace(" ", "", $data->val(1,2)));
			$npm 		= addslashes($data->val($i,3));
			$nama 		= addslashes($data->val($i,3));
			$kelas 		= addslashes($data->val($i,3));
			$jurusan 	= addslashes($data->val($i,3));
			$fakultas 	= addslashes($data->val($i,3));
			$semester 	= addslashes($data->val($i,3));
			$email 		= addslashes($data->val($i,3));
			$gender 	= addslashes($data->val($i,3));
			$domisili 	= addslashes($data->val($i,3));
			$alamat 	= addslashes($data->val($i,3));
			$ikut 		= addslashes($data->val($i,3));
			$tlp 		= addslashes($data->val($i,3));
			$berkas 	= addslashes($data->val($i,3));
			$cek 		= mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM relawan WHERE id_relawan='$idrelawan'"));

			if($cek > 0){
				mysqli_query($mysqli, "UPDATE relawan SET 
							relawan_npm			= '$npm', 
							relawan_nama		= '$nama', 
							relawan_kelas		= '$kelas', 
							relawan_jurusan		= '$jurusan', 
							relawan_fakultas	= '$fakultas', 
							relawan_semester	= '$semester', 
							relawan_email		= '$email', 
							relawan_gender		= '$gender', 
							relawan_domisili	= '$domisili', 
							relawan_alamat		= '$alamat', 
							relawan_ikut		= '$ikut', 
							relawan_telpon		= '$tlp', 
							id_grup				= '$_POST[grup_import]', 
							relawan_berkas		= '$berkas'
							WHERE id_relawan	= '$idrelawan'");
			} else {
				$pass = md5(substr(md5($npm),0,5));
				mysqli_query($mysqli, "INSERT INTO relawan SET
							id_relawan			= '$idrelawan', 
							relawan_npm			= '$npm', 
							relawan_nama		= '$nama', 
							relawan_password	= '$pass', 
							relawan_kelas		= '$kelas', 
							relawan_jurusan		= '$jurusan', 
							relawan_fakultas	= '$fakultas', 
							relawan_semester	= '$semester', 
							relawan_email		= '$email', 
							relawan_gender		= '$gender', 
							relawan_domisili	= '$domisili', 
							relawan_alamat		= '$alamat', 
							relawan_ikut		= '$ikut', 
							relawan_telpon		= '$tlp', 
							id_grup				= '$_POST[grup_import]', 
							relawan_berkas		= '$berkas',
							relawan_status		= 'off'
							");
			}
		}
		unlink($file);
		echo "ok";
	}
}
?>