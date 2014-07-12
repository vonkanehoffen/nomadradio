<?php
/**
 * Custom Tag Cloud Widget
 * Displays Taxonomies for Podcast post type
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

class nomad_tagcloud_widget extends WP_Widget {
	function nomad_tagcloud_widget() {
		// settings
		$widget_ops = array( 'classname' => 'nomad-tagcloud', 'description' => 'Displays Taxonomies from Podcast Post Type.' );
		$control_ops = array();
		$this->WP_Widget( 'nomad-tagcloud-widget', 'Nomad Tag Cloud', $widget_ops, $control_ops );
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		
		echo $before_title . "Tag Cloud" . $after_title;
		
		wp_tag_cloud( array(
			'taxonomy' => array( 'artist', 'genre')
		));
		
		echo $after_widget;
	}
}
add_action( 'widgets_init', 'load_nomad_tagcloud_widget' );
function load_nomad_tagcloud_widget() {
	register_widget('nomad_tagcloud_widget');
}

?>