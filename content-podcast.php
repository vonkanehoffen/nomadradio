<?php
/**
 * The default template for displaying content
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 */

// Stop AddThis plugin printing in content
remove_filter('the_content', 'addthis_display_social_widget', 15);
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="featured-image">
			<?php the_post_thumbnail('medium'); ?>
		</div>
		<?php } else { ?>
			<div class="featured-image empty"></div>
		<?php } ?> 
		<div class="entry-content">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="podcast-links"> // 
					<a href="<?php echo get_post_meta($post->ID, 'podcast_url', true); ?>" class="music-action download">Download</a>
					<!-- <a href="<?php echo get_post_meta($post->ID, 'podcast_url', true); ?>" class="music-action listen">Listen</a> -->
				</div>
			</header>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:' ) . '</span>', 'after' => '</div>' ) ); ?>
			<footer class="entry-meta">
				<p>Posted on <?php the_date(); 
				$artist = get_the_term_list( $post->ID, 'artist', 'Artist: ', ', ', '');
				$genre = get_the_term_list( $post->ID, 'genre', 'Genre: ', ', ', '');
				$duration = get_post_meta( $post->ID, "podcast_duration", true);
				if($artist) echo ' // ' . $artist;
				if($genre) echo ' // ' . $genre;
				if($duration) echo ' // Duration: <strong>' . $duration . '</strong>';
				?><br/>
					<?php if ( comments_open() && !is_single() ) : ?>
					<span class="comments-link"><?php comments_popup_link( '<span class="leave-comment">' . __( 'Leave a comment' ) . '</span>', __( '<b>1</b> Comment' ), __( '<b>%</b> Comments' ) ); ?></span>
					<?php endif; // End if comments_open() ?>

					<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>	
				</p>
				<?php if(function_exists('addthis_display_social_widget')) echo addthis_display_social_widget(""); ?>
				<?php nomad_tweet_button(); ?>
				<div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="200" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
			</footer><!-- #entry-meta -->
		</div><!-- .entry-content -->
		<?php endif; ?>

	</article><!-- #post-<?php the_ID(); ?> -->
	
	
