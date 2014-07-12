/**
 * Handle Media Upload for Podcast Post Type
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

jQuery(document).ready(function(){
	
	var post_ID = jQuery('#post_ID').val();
	var url_box = jQuery('#podcast_url_field');
	var upload_button = jQuery('#upload_media_button');
	
	// display an upload box on button click
	upload_button.click(function(){
		thickBoxURL = 'media-upload.php?post_id='+post_ID+'&amp;TB_iframe=true&amp;send=true';
		tb_show( '', thickBoxURL );
		//console.log('tb_show called with url:'+thickBoxURL);
		return false;
	});
	
	// modify upload box handler to populate our URL field
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function( file_link ) {
		if ( upload_button.html() ) {
			// if there's the appropriate form field to populate set, 
			// get output from upload box and convert to jquery object
			// then print it to the form URL field
			var filePath = jQuery( file_link ).attr( 'href' );
			if ( filePath.length ) {
				url_box.val( filePath );
			}
			// close the upload box
			tb_remove();
		} else {
			// if there isn't the appropriate field to act on, stop interfering
			window.original_send_to_editor(html);
		}
	}
	
	// Get media information (duration & filesize)
	jQuery('#get_media_info').click(function(){
		
		var info_script = '/wp-content/themes/nomad2011/php/getid3/get-id3-info.php';
		var media_file = jQuery('input#podcast_url_field').val();
		var loader = jQuery('#podcast-ajax-loading');
		
		loader.show();
		jQuery.ajax({
			url: info_script,
		  	dataType: 'json',
		  	data: 'file='+media_file ,
		  	success: function(data){
				jQuery('#podcast_duration_field').val(data.duration);
				jQuery('#podcast_filesize_field').val(data.filesize);
				loader.hide();
			}
		});
		
		return false;
		
	});
	
});