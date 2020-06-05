<?php
function antiinjeksi($text){
	global $mysqli;
	$safetext = $mysqli->real_escape_string(stripslashes(strip_tags(htmlspecialchars($text,ENT_QUOTES))));
	return $safetext;
}
?>
