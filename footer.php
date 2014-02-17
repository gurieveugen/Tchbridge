<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_template_part('lightbox'); ?>
<?php $theme_options = $GLOBALS['gcoptions']->getAllOptions(); ?>
	</div>
	<footer id="footer">
		<section class="footer cf">
			<a class="f-logo" href="<?php echo $theme_options['techbridge_url']; ?>" target="_blank"><img src="<?php echo TDU; ?>/images/logo-techbridge.jpg" alt="image description"></a>
			<a class="f-logo" href="<?php echo $theme_options['nsf_url']; ?>" target="_blank"><img src="<?php echo TDU; ?>/images/logo-NSF.jpg" alt="image description"></a>
			<div class="description">
				<p>This website is a project of Techbridge, a 501(c)(3) nonprofit inspiring girls and underrepresented youth to discover a passion for technology, science, and engineering through hands-on learning and career exploration.</p>
				<div class="row cf">
					<a href="<?php echo $theme_options['techbridge_url']; ?>" target="_blank" class="link">techbridge.org</a>
					<ul class="f-socials">
						<li class="twitter"><a href="<?php echo $theme_options['twitter_url']; ?>" target="_blank">twitter</a></li>
						<li class="facebook"><a href="<?php echo $theme_options['facebook_url']; ?>" target="_blank">facebook</a></li>
					</ul>
				</div>
			</div>
		</section>
		<div class="f-bottom cf">
			<div class="right">
				<span>Designed by <a href="<?php echo $theme_options['designed_by_url']; ?>" class="by-logo"><img src="<?php echo TDU; ?>/images/text-elefit-designs.png" alt="elefit designs"></a></span>
			</div>
			<ul class="cf">
				<li>&copy; 2014 Techbridge</li>
				<li>
					<a href="#">Privacy Policy</a>
				</li>
				<li>
					<a href="#">Terms of Use</a>
				</li>
			</ul>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
