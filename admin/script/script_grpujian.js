var save_method, table;
//menerapkan plugin datatables
$(function(){
	table = $('.table').DataTable({
		"processing" : true,
		"ajax" : {
			"url" : "ajax/ajax_grpujian.php?action=table_data",
			"type" : "POST"
		}
	});
});

//Ketika tombol edit diklik
function form_edit(id){
   $.ajax({
      url : "ajax/ajax_grpujian.php?action=form_data&id="+id,
      type : "GET",
      dataType : "JSON",
      success : function(data){
         $('#modal_grpujian form')[0].reset();
         $('#modal_grpujian').modal('show');
         $('.modal-title').text('Edit Group Ujian');
			
         $('#id').val(id);
         var nama_grup = data.nama_grup.split(' ');
         for(i=0; i<nama_grup.length; i++){
            $('[value='+nama_grup[i]+']').attr('checked', true);

         }
      },
      error : function(){
         alert('Tidak dapat menampilkan data');
      }
   });
	
   $('#nama_grup input').attr('checked', false);		
}

//Tombol Simpan
function save_data(){
	url = "ajax/ajax_grpujian.php?action=update";

	$.ajax({
		url : url,
		type : "POST",
		data : $('#modal_grpujian form').serialize(),
		success : function(data){
			$('#modal_grpujian').modal('hide');
			table.ajax.reload();
		},
		error : function(){
			alert("Tidak dapat menyimpan data!");
		}
	});
	return false;
}