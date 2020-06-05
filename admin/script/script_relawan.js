var save_method, table;
//menerapkan plugin datatables
$(function(){
	table = $('.table').DataTable({
		"processing" : true,
		"ajax" : {
			"url" : "ajax/ajax_relawan.php?action=table_data",
			"type" : "POST"
		}
	});
});

//ketika tombol tambah diklik
function form_add(){
	save_method = "add";
	$('#npm').removeAttr('readonly');
	$('#modal_relawan').modal('show');
	$('#modal_relawan form')[0].reset();
	$('.modal-title').text('Tambah Relawan');
}

//tombol edit
function form_edit(id){
	save_method = "edit";
	$('#modal_relawan form')[0].reset();
	$.ajax({
		url : "ajax/ajax_relawan.php?action=form_data&id="+id,
		type : "GET",
		dataType : "JSON",
		success : function(data){
			$('#modal_relawan').modal('show');
			$('.modal-title').text('Edit Relawan');

			$('#npm').val(data.relawan_npm).attr('readonly', true);
			$('#nama').val(data.relawan_nama);
			$('#kelas').val(data.relawan_kelas);
			$('#jurusan').val(data.relawan_jurusan);
			$('#fakultas').val(data.relawan_fakultas);
			$('#semester').val(data.relawan_semester);
			$('#email').val(data.relawan_email);
			$('#gender').val(data.relawan_gender);
			$('#domisili').val(data.relawan_domisili);
			$('#alamat').val(data.relawan_alamat);
			$('#ikut').val(data.relawan_ikut);
			$('#tlp').val(data.relawan_telpon);
			$('#grup').val(data.id_grup);
			$('#berkas').val(data.relawan_berkas);
		},
		error : function(){
			alert("Tidak dapat menampilkan data!");
		}
	});
}

//Tombol Simpan
function save_data(){
	// event.preventDefault();

	if(save_method == "add")
		url = "ajax/ajax_relawan.php?action=insert";
	else
		url = "ajax/ajax_relawan.php?action=update";

    var formdata = new FormData();
	var file = $('#berkas')[0].files[0];
	formdata.append('berkas', file);
	$.each($('#modal_relawan form').serializeArray(), function(a, b){
	formdata.append(b.name, b.value);
	});

	$.ajax({
		url : url,
		type : "POST",
		data : formdata,
		processData : false,
		contentType : false,
		success : function(data){
			if(data == "ok"){
			$('#modal_relawan').modal('hide');
			table.ajax.reload();
		} else {
			alert(data);
			$('#npm').focus();
		}
		},
		error : function(){
			alert("Tidak dapat menyimpan data!");
		}
	});
	return false;
}

//Tombol Hapus
function delete_data(id){
	if(confirm("Apakah Anda yakin menghapus data?")){
		$.ajax({
			url : "ajax/ajax_relawan.php?action=delete&id="+id,
			type : "GET",
			success : function(data){
				table.ajax.reload();
			},
			error : function(){
				alert("Tidak dapat menghapus data!");
			}
		});
	}
}

//tombol cetak kartu
function form_print(){
	$('#modal_print').modal('show');
	$('.modal-title').text('Cetak Kartu Ujian');
	$('#modal_print form')[0].reset();
}

//tombol cetak kartu pada modal
function print_data(){
	$('#modal_print').modal('hide');
	window.open("export/pdf_kartu.php?grup="+$('#grup_print').val(), "Cetak Kartu Ujian", "height=650, width=1024, left=150, scrollbars=yes");
	return false;
}

//tombol import
function form_import(){
	$('#modal_import').modal('show');
	$('.modal-title').text('Import Excel');
	$('#modal_import form')[0].reset();
}

//tombol import pada modal Import
function import_data(){
	var formdata = new FormData();
	var file = $('#file')[0].files[0];
	formdata.append('file', file);
	$.each($('#modal_import form').serializeArray(), function(a, b){
		formdata.append(b.name, b.value);
	});
	$.ajax({
		url : 'ajax/ajax_relawan.php?action=import',
		data : formdata,
		processData : false,
		contentType : false,
		type : 'POST',
		success : function(data){
			if(data == "ok"){
				$('#modal_import').modal('hide');
				table.ajax.reload();
			} else {
				alert(data);
			}
		},
		error : function(data){
			alert('Tidak dapat mengimport data!');
		}
	});
	return false;
}

