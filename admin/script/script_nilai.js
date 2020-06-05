var table;

$(function(){
   var ujian = $('#id_ujian').val();
   var grup = $('#id_grup').val();
   table = $('.table').DataTable({
      "processing" : true,
      "pageLength" : 50,
      "paging" : false,
      "ajax" : {
         "url" : "ajax/ajax_nilai.php?action=table_data&ujian=" + ujian + "&grup=" + grup,
         "type" : "POST"
      }
   });
});

function export_nilai(){
   ujian = $('#id_ujian').val();
   grup = $('#id_grup').val();
   window.open("export/excel_nilai.php?ujian=" + ujian + "&grup=" + grup, "Export Nilai");
}
