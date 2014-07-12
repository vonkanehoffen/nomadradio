<?php
/**
 * Setup scripts (put in footer and switch to google apis / recent versions)
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

if(!is_admin()) {
	
	// Switch jQuery to Google API (there's a fallback in the footer)
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js', '', '1.6.2', true );
	wp_deregister_script( 'jquery-ui' );
	wp_enqueue_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', '', '1.8.16', true );
	
	// Upgrade to latest jQuery form and switch loading to footer (for comments plugin)
	wp_deregister_script( 'jquery-form' );
	wp_register_script( 'jquery-form', get_template_directory_uri() . '/js/jquery.form.js', '', '2.84', true );
	
	// SoundManager (for player)
	define(	'SOUNDMANAGER_URI', get_template_directory_uri() . '/js/soundmanager' );
	wp_enqueue_script( 'soundmanager', SOUNDMANAGER_URI . '/script/soundmanager2-nodebug-jsmin.js', '', '2.97a', true);
	
	// Nomad Code
	//wp_enqueue_script( 'nomad-player', get_template_directory_uri() . '/js/player.js', '', '1.0', true);
	wp_enqueue_script( 'nomad-frontend', get_template_directory_uri() . '/js/frontend.js', '', '1.0', true);

}

?>