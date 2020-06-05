var save_method, table;
//menerapkan plugin datatables
$(function(){
	table = $('.table').DataTable({
		"processing" : true,
		"ajax" : {
			"url" : "ajax/ajax_ujian.php?action=table_data",
			"type" : "POST"
		}
	});
	//konfigurasi datepicker
	$('.datepicker').datepicker({
		format : 'yyyy-mm-dd',
		autoclose : true
	});
});

//ketika tombol tambah diklik
function form_add(){
	save_method = "add";
	$('#modal_ujian').modal('show');
	$('#modal_ujian form')[0].reset();
	$('.modal-title').text('Tambah Ujian');
}

//tombol edit
function form_edit(id){
	save_method = "edit";
	$('#modal_ujian form')[0].reset();
	$.ajax({
		url : "ajax/ajax_ujian.php?action=form_data&id="+id,
		type : "GET",
		dataType : "JSON",
		success : function(data){
			$('#modal_ujian').modal('show');
			$('.modal-title').text('Edit Ujian');

			$('#id').val(data.id_ujian);
			$('#judul').val(data.judul_ujian);
			$('#ujian').val(data.nama_ujian);
			$('#tanggal').val(data.tanggal_ujian);
			$('#waktu').val(data.waktu_ujian);
			$('#jml_soal').val(data.jml_soal_ujian);
			$('#pengampu').val(data.id_user);
		},
		error : function(){
			alert("Tidak dapat menampilkan data!");
		}
	});
}

//Tombol Simpan
function save_data(){
	if(save_method == "add")
		url = "ajax/ajax_ujian.php?action=insert";
	else
		url = "ajax/ajax_ujian.php?action=update";

	$.ajax({
		url : url,
		type : "POST",
		data : $('#modal_ujian form').serialize(),
		success : function(data){
			$('#modal_ujian').modal('hide');
			table.ajax.reload();
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
			url : "ajax/ajax_ujian.php?action=delete&id="+id,
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