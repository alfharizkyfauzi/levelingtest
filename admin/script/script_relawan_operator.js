var table;

//Menampilkan data dengan plugin dataTable
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "ajax/ajax_relawan_operator.php?action=table_data",
       "type" : "POST"
     }
   });
});

//Ketika tombol Refresh diklik
function refresh_data(){
   table.ajax.reload();
}

//Ketika tombol Reset Login diklik
function reset_login(id){
   if(confirm("Apakah yakin akan mereset login Relawan dengan NPM "+id+" ?")){
      $.ajax({
         url : "ajax/ajax_relawan_operator.php?action=reset_login&relawan_npm="+id,
         type : "GET",
         success : function(data){
            table.ajax.reload();
         },
         error : function(){
            alert("Tidak dapat mereset login!");
         }
      });
   }
}
