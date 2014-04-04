<?php
/*
 * @package WordPress
 * Template Name: Logout page
*/
?>
<?php get_header(); ?>
<?php the_post(); ?>
<?php	
	$user_id = get_current_user_id();
	$url     = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : get_bloginfo('url');
	
	if($user_id)
	{
		update_user_meta($user_id, 'default_url', $url);
	}
?>
<div class="main-wide">
	<div id="content" role="main">
		<p><?php the_content(); ?></p>
	</div><!-- #content -->
</div>
<script>
	setTimeout(function() { var url = '<?php echo wp_logout_url($url); ?>'; window.location = url.replace(/&amp;/g, '&'); }, 3000);
</script>
<?php get_footer(); ?>