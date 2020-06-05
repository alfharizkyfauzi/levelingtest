$(function(){
   $('#content').load('home.php');	
});

function show_detail(ujian){
   $('#content').load('detail.php?ujian='+ujian);	
}

function show_petunjuk(ujian){
   $('#content').load('petunjuk.php?ujian='+ujian);		
}

function show_ujian(ujian){
   $('#content').load('ujian.php?ujian='+ujian);	
   return false;
}

function selesai_ujian(ujian){
   $.ajax({
      url: "ajax_ujian.php?action=selesai_ujian",
      type: "POST",
      data: "ujian="+ujian,
      success: function(data){
         if(data=="ok"){
            $('#modal-selesai').modal('hide');
            $('#modal-selesai').on('hidden.bs.modal', function(){
               $('#content').load('home.php');
            });	
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat memproses nilai!');
      }
   });
   return false;
}