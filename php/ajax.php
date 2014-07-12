<?php
/**
 * Ajax Enabling Functions
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

/**
 * Check if the current request is an Ajax one
 *
 * @return true | false
 * @author Cormorant
 **/
function is_ajax() {
	if(isset($_POST['ajax'])) { return true; } else { return false; }
}

?>