<?php
/*
 * @package WordPress
 * Template Name: Resources Page
*/
?>
<?php get_header(); ?>
<div class="main-blue">
	<!-- <nav class="nav-filter cf">
		<span>sort by</span>
		<ul>
			<li class="select"><a href="#">readings</a></li>
			<li class="deselect"><a href="#">activities</a></li>
			<li class="deselect"><a href="#">icebreakers</a></li>
			<li class="deselect"><a href="#">other</a></li>
		</ul>
	</nav> -->
	<?php echo getCategoriesHTML(); ?>
	<div class="holder">
		<h1>Recommended Readings for Role Models</h1>
		<?php 		
		GLOBAL $wp_query, $more;			
  		$more = 0;	
		$wp_query->query_vars['post_type'] = 'post';
		$wp_query->query_vars['pagename']  = '';
		$wp_query->query_vars['name']      = '';
		
		query_posts($wp_query->query_vars); 
		?>
		<?php get_template_part('loop', 'posts'); ?>
	</div>
</div>
<?php get_footer(); ?>