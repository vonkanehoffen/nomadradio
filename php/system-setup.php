<?php
/**
 * Setup Wordpress System
 *	
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

add_action( 'after_setup_theme', 'nomad_setup');

function nomad_setup() {
	// Show only Podcast post type on front page
	add_filter( 'pre_get_posts', 'my_get_posts' );

	function my_get_posts( $query ) {

		if ( (is_author() || is_home() ) && !isset($query->query_vars['suppress_filters']) ) {
			$query->set( 'post_type', array( 'podcast', 'post' ) );
		}
		if ( is_feed('itunes') ) {
			$query->set( 'post_type', array( 'podcast' ) );;
		}

		return $query;

	}

	// Add Thumbnail Support
	add_theme_support( 'post-thumbnails' );
	
	// Disable admin bar on front end
	// show_admin_bar(false);
		
}

// Stop #name appearing in more links
add_filter('the_content_more_link', 'nomad_more_link');

function nomad_more_link($link) {
	global $post;
	$new_link = '<a href="' . get_permalink() . '#post-' . $post->ID . '" class="more-link">Continue reading <span class="meta-nav">&rarr;</span></a>';
	return $new_link;
}

// Add iTunes feed
function create_itunes_feed() {
	add_filter('request', 'podcast_request');
	load_template( TEMPLATEPATH . '/feed-itunes.php'); 
}
add_action('do_feed_itunes', 'create_itunes_feed', 10, 1); 

function podcast_request($query) {
	echo "POD REQUEST";
	$query->set( 'post_type', array('podcast'));
	return $query;
}

function podcast_feed_rewrite($wp_rewrite) {
	$feed_rules = array(
		'itunes.xml' => 'index.php?feed=itunes'
	);
	$wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'podcast_feed_rewrite');

?>
