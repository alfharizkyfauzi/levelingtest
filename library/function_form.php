<?php
//Fungsi untuk membuka modal dan form
function open_form($modal_id, $action){
   echo '<div class="modal fade" id="'.$modal_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
				  
<form class="form-horizontal" enctype="multipart/form-data"  onsubmit="'.$action.'">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>
				
   <div class="modal-body">
      <input type="hidden" name="id" id="id">';
}

//Fungsi untuk membuat kotak input
function create_textbox($label, $name, $type="text", $width='5', $class="", $attr=""){
   echo'<div class="form-group">
   <label for="'.$name.'" class="col-sm-2 control-label"> '.$label.'</label>
   <div class="col-sm-'.$width.'">
      <input type="'.$type.'" class="form-control '.$class.'" id="'.$name.'" name="'.$name.'" '.$attr.'>
   </div> </div>';
}

//Fungsi untuk membuat textarea
function create_textarea($label, $name, $class='', $attr=''){
   echo'<div class="form-group">
   <label for="'.$name.'" class="col-sm-2 control-label"> '.$label.'</label>
   <div class="col-sm-10">
     <textarea class="form-control '.$class.'" id="'.$name.'" rows="8" name="'.$name.'" '.$attr.'></textarea>
   </div> </div>';
}


//Fungsi untuk membuat combobox / select box
function create_combobox($label, $name, $list, $width='5', $class="", $attr=""){
   echo'<div class="form-group">
   <label for="'.$name.'" class="col-sm-2 control-label"> '.$label.'</label>
   <div class="col-sm-'.$width.'">
      <select class="form-control '.$class.'" name="'.$name.'" id="'.$name.'" '.$attr.'>
         <option value="">- Silahkan Pilih -</option>';

foreach($list as $ls){
   echo '<option value='.$ls[0].'>'.$ls[1].'</option>';
}
	
   echo '</select>
   </div> </div>';
}


//Fungsi untuk membuat checkbox
function create_checkbox($label, $name, $list){
   echo '<div class="form-group" id="'.$name.'">
   <label class="col-sm-2 control-label">'.$label.'</label>
   <div class="col-sm-10">';

foreach($list as $ls){
   echo' <input type="checkbox" name="'.$name.'[]" value="'.$ls[0].'" style="margin-left: 30px"> '.$ls[1];
}
	
   echo '</div></div>';
}

//Fungsi untuk menutup form dan modal
function close_form($icon="floppy-disk", $button="Simpan"){
   echo'</div>
   <div class="modal-footer">
   <button type="submit" class="btn btn-primary btn-save">
   <i class="glyphicon glyphicon-'.$icon.'"></i> '.$button.' 
   </button>
   <button type="button" class="btn btn-danger" data-dismiss="modal">
   <i class="glyphicon glyphicon-remove-sign"></i> Close
   </button>
   </div>
		
   </form></div></div></div>';
}
?>
