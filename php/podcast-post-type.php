<?php
/**
 * Register Podcast Post Type
 * 
 * Meta:	 	Media URL
 * Meta: 		Media Duration
 * Taxonomy: 	Artist
 * Taxonomy: 	Genre
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

// Register Main Post Type
add_action('init', 'create_podcast_post_type');

function create_podcast_post_type() {
	
	// Main post type
	register_post_type( 'podcast', 
		array(
			'labels' => array(
				'name' => __('Podcasts'),
				'add_new' => __('Add New Podcast'),
				'add_new_item' => __('Add New Podcast')
			),
			'public' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','author','comments', 'thumbnail')
		)
	);
		
	// Taxonomy: Artist
	register_taxonomy( 'artist', 'podcast',
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __('Artists'),
				'singular_name' => __('Artist'),
				'add_new_item' => __('Add New Artist'),
				'all_items' => __('All Artists')
			)
		)
	);
	
	// Taxonomy: Genre
	register_taxonomy( 'genre', 'podcast',
		array(
			'hierarchical' => false,
			'labels' => array(
				'name' => __('Genres'),
				'singular_name' => __('Genre'),
				'add_new_item' => __('Add New Genre'),
				'all_items' => __('All Genres')
			)
		)
	);
		
}

// Register Post Type Meta
add_action( 'add_meta_boxes', 'create_podcast_meta' );

function create_podcast_meta() {
	// Meta: Media URL
	add_meta_box( 'podcast_url', 'Media URL', 'print_podcast_url', 'podcast', 'normal', 'high' );
	// Meta: Media Duration
	add_meta_box( 'podcast_duration', 'Duration (HH:MM:SS)', 'print_podcast_duration', 'podcast', 'normal', 'high' );
}

// Callbacks to print meta boxes
function print_podcast_url($post, $metabox) {
	echo '<span id="media-update-status"></span>';
	printf('<p><label for="podcast_url">Podcast URL</label>
	<input type="text" name="podcast_url_field" value="%s" id="podcast_url_field" size="60"/>
	<a href="#" class="button" id="upload_media_button">Upload Audio</a></p>',
		get_post_meta($post->ID, 'podcast_url', true)
	);
}
function print_podcast_duration($post, $metabox) {
	printf('<p><label for="podcast_duration_field">Duration</label> <input type="text" name="podcast_duration_field" value="%s" id="podcast_duration_field" size="9"/> <label for="podcast_filesize_field">Filesize (bytes)</label> <input type="text" name="podcast_filesize_field" value="%s" id="podcast_filesize_field" size="14"/> <a href="#" class="button" id="get_media_info">Get Media Information</a> <img src="/wp-admin/images/wpspin_light.gif" id="podcast-ajax-loading" alt="" style="display:none;" /></p>',
		get_post_meta($post->ID, 'podcast_duration', true),
		get_post_meta($post->ID, 'podcast_filesize', true)
	);
}

// Save Meta Box Values
add_action('save_post', 'save_podcast_meta');

function save_podcast_meta($post_id) {
	global $post;
	if(isset($_POST["podcast_url_field"])) 		update_post_meta( $post->ID, "podcast_url", $_POST["podcast_url_field"] );
	if(isset($_POST["podcast_duration_field"])) 	update_post_meta( $post->ID, "podcast_duration", $_POST["podcast_duration_field"] );
	if(isset($_POST["podcast_filesize_field"])) 	update_post_meta( $post->ID, "podcast_filesize", $_POST["podcast_filesize_field"] );
}

/////////////////////////////////////////////////////////////////////
// ADMIN : Add functionality for media file box upload button
//////////////////////////////////////////////////////////////////////
function media_file_upload_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_bloginfo('template_directory') . '/js/admin-audio-upload.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}

function media_file_upload_admin_styles() {
	wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'media_file_upload_admin_scripts');
add_action('admin_print_styles', 'media_file_upload_admin_styles'); // do we even need this?
?>