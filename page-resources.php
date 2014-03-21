<?php
/*
 * @package WordPress
 * Template Name: Resources Page
*/
?>
<?php get_header(); ?>
<div class="main-blue">	
	<div class="categories">
		<?php echo getCategoriesHTML(); ?>
	</div>
	<div class="holder">
		<h1>Recommended Resources for Role Models</h1>
		<?php 		
		GLOBAL $wp_query, $more;			
  		$more = 0;	
		$wp_query->query_vars['post_type'] = 'post';
		$wp_query->query_vars['pagename']  = '';
		$wp_query->query_vars['name']      = '';
		
		query_posts($wp_query->query_vars); 
		?>
		<div class="posts">
			<?php get_template_part('loop', 'posts'); ?>	
		</div>
	</div>
</div>
<?php get_footer(); ?>