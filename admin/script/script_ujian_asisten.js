var table;

$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
        "url" : "ajax/ajax_ujian_asisten.php",
        "type" : "POST"
     }
   });
});
