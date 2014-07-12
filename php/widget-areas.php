<?php
/**
 * Register Widget areas (footer)
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/


register_sidebar( array(
	'name' => 'Footer One',
	'id' => 'footer-1',
	'description' => "Footer Sidebar",
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => "</aside>",
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>'
 ) );

register_sidebar( array(
	'name' => 'Footer Two',
	'id' => 'footer-2',
	'description' => "Footer Sidebar",
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => "</aside>",
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>'
 ) );

register_sidebar( array(
	'name' => 'Footer Three',
	'id' => 'footer-3',
	'description' => "Footer Sidebar",
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => "</aside>",
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>'
 ) );

register_sidebar( array(
	'name' => 'Footer Four',
	'id' => 'footer-4',
	'description' => "Footer Sidebar",
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => "</aside>",
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>'
 ) );


?>