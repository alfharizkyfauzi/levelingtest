var save_method, table;
//menerapkan plugin datatables
$(function(){
	table = $('.table').DataTable({
		"processing" : true,
		"ajax" : {
			"url" : "ajax/ajax_group.php?action=table_data",
			"type" : "POST"
		}
	});
});

//ketika tombol tambah diklik
function form_add(){
	save_method = "add";
	$('#modal_group').modal('show');
	$('#modal_group form')[0].reset();
	$('.modal-title').text('Tambah Group');
}

//tombol edit
function form_edit(id){
	save_method = "edit";
	$('#modal_group form')[0].reset();
	$.ajax({
		url : "ajax/ajax_group.php?action=form_data&id="+id,
		type : "GET",
		dataType : "JSON",
		success : function(data){
			$('#modal_group').modal('show');
			$('.modal-title').text('Edit Group');

			$('#id').val(data.id_grup);
			$('#grup').val(data.nama_grup);
		},
		error : function(){
			alert("Tidak dapat menampilkan data!");
		}
	});
}

//Tombol Simpan
function save_data(){
	if(save_method == "add")
		url = "ajax/ajax_group.php?action=insert";
	else
		url = "ajax/ajax_group.php?action=update";

	$.ajax({
		url : url,
		type : "POST",
		data : $('#modal_group form').serialize(),
		success : function(data){
			$('#modal_group').modal('hide');
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
			url : "ajax/ajax_group.php?action=delete&id="+id,
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