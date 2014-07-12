<?php
/**
 * iTunes RSS Feed
 * Look at wp-includes/feed-rss2.php for inspiration
 * Get to it at: /?feed=itunes&post_type=podcast
 * Setup in php/system-setup.php
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1; // wtf is this for? 

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
<channel>
	<title><?php bloginfo_rss('name'); ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<language><?php echo get_option('rss_language'); ?></language>
	<copyright>2011 NomadRadio.fm</copyright>
	<itunes:subtitle><?php bloginfo_rss("description") ?></itunes:subtitle>
	<itunes:author>Nomad Radio</itunes:author>
	<itunes:summary>A podcast dedicated to independent music. From Dubstep, Juke and UK Bass to Folk, Doom and Sound Art.</itunes:summary>
	<description>A podcast dedicated to independent music. From Dubstep, Juke and UK Bass to Folk, Doom and Sound Art.</description>

	<itunes:owner>
		<itunes:name>Nomad Radio</itunes:name>
		<itunes:email>us@nomadradio.fm</itunes:email>
	</itunes:owner>

	<itunes:image href="<?php echo get_template_directory_uri(); ?>/images/logo-400.png" />
	<itunes:category text="Music" />
	<itunes:explicit>No</itunes:explicit>

	<?php while( have_posts()) : the_post(); 
	
	// get correct url
	$url = get_post_meta($post->ID, 'podcast_url', true);
	$urlparsed=parse_url($url);
	if(!isset($urlparsed['scheme'])) { $url = 'http://' . $_SERVER['SERVER_NAME'] . $url; }

	?>
	<item>
		<title><?php the_title_rss() ?></title>
		<itunes:author><?php the_author() ?></itunes:author>
		<itunes:subtitle></itunes:subtitle>
		<itunes:summary><![CDATA[<?php the_excerpt_rss() ?>]]></itunes:summary>
		<?php 
		// Get featured image src from post
		$thumb_id = get_post_thumbnail_id($post->ID);
		if($thumb_id) {
			$thumb_url = wp_get_attachment_image_src($thumb_id, 'medium', false);
			echo '<itunes:image href="'.$thumb_url[0].'" />';
		}
		?>
		<enclosure url="<?php echo $url; ?>" length="<?php echo get_post_meta($post->ID, 'podcast_filesize', true); ?>" type="audio/mpeg" />
		<guid><?php echo $url; ?></guid>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<itunes:duration><?php echo get_post_meta($post->ID, 'podcast_duration', true); ?></itunes:duration>
		<itunes:explicit>No</itunes:explicit>
		<itunes:keywords><?php 
			$terms = get_the_terms( $post->ID, array('artist', 'genre'));
			foreach($terms as $term) {
				echo $term->name . ', ';
			};
			?></itunes:keywords>
	</item>
	<?php endwhile; ?>
</channel>
</rss>