<?php
/**
 * Footer
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/


?>

	</div><!-- #main -->

	<footer role="contentinfo">

			<?php dynamic_sidebar( 'footer-1' ); ?>
			<?php dynamic_sidebar( 'footer-2' ); ?>
			<?php dynamic_sidebar( 'footer-3' ); ?>
			<?php dynamic_sidebar( 'footer-4' ); ?>

	</footer>
</div><!-- #page -->

<script>var themedir = "<?php echo get_template_directory_uri(); ?>"; </script>

<!-- BEGIN: wp_footer -->
<?php wp_footer(); ?>
<!-- END: wp_footer -->

<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
<!--[if lt IE 7 ]>
  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->

</body>
</html>