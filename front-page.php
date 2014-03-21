<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>

<?php 
get_header(); 
the_post();
echo do_shortcode('[slider][/slider]');
$youtube    = get_post_meta(get_the_ID(), 'youtube', true);
?>
<section class="media-section cf">
	<?php 
	$theme_options = $GLOBALS['gcoptions']->getAllOptions();
	$youtube_video = (isset($theme_options['youtube_video'])) ? $theme_options['youtube_video'] : '';
	echo do_shortcode('[hivista_youtube thumbnail="http://site10.miydim.com/wp-content/themes/techbridge/images/img-video.jpg"]'.$youtube_video.'[/hivista_youtube]'); 
	?>
	
	<article>
		<h1><?php the_title(); ?></h1>		
		<?php the_content(); ?>
		<a href="<?php echo home_url(); ?>/toolkit" class="btn big"><span>view toolkit</span><i class="tool"></i></a>
	</article>
</section>
<section class="info-section">
	<h2>Getting started is easy!</h2>
	<div class="cf">
		<div class="column">
			<img src="<?php echo TDU; ?>/images/ico-pencil.png" alt="image description" class="icon">
			<div class="holder">
				<h4><a href="#" onclick="showHide(true, ['#sign-up', '.lightbox-mask'], this);" class="pink">SIGN UP</a></h4>
				<p>Set up a free account to save and share your work.</p>
			</div>
		</div>
		<div class="column wide">
			<img src="<?php echo TDU; ?>/images/ico-tools.png" alt="image description" class="icon">
			<div class="holder">
				<h4><a href="<?php echo home_url(); ?>/toolkit">Check out the Toolkit</a></h4>
				<p>Through readings, videos, questions and more, this toolkit will help prepare you to be a STEM role model.</p>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>