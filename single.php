<?php
/**
 * The Template for displaying all single posts.
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

// Doubt this is getting used! Fuckes up social bookmarking
if(is_ajax()) {
	while ( have_posts() ) : the_post();
	get_template_part( 'content', get_post_type() );
	comments_template( '', true );
	//echo '<div style="background:#f00; width:200px; height:200px;">here</div>';
	endwhile;
} else {
?>
	
<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_type() ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

<?php } // endif is_ajax ?>