<?php
/*
 * @package WordPress
 * Template Name: Resources Page
*/
?>
<?php get_header(); ?>
<div class="main-blue">	
	<div class="categories">
		<?php // echo getCategoriesHTML(); ?>
		<nav class="nav-filter cf">
			<span>sort by</span>
			<ul>
			<?php 
				$args = array(
					'show_option_all'    => '',
					'orderby'            => 'name',
					'order'              => 'ASC',
					'style'              => 'list',
					'show_count'         => 0,
					'hide_empty'         => 1,
					'use_desc_for_title' => 1,
					'child_of'           => 0,
					'feed'               => '',
					'feed_type'          => '',
					'feed_image'         => '',
					'exclude'            => '',
					'exclude_tree'       => '',
					'include'            => '',
					'hierarchical'       => 1,
					'title_li'           => '',
					'show_option_none'   => __('No categories'),
					'number'             => null,
					'echo'               => 1,
					'depth'              => 0,
					'current_category'   => 0,
					'pad_counts'         => 0,
					'taxonomy'           => 'category',
					'walker'             => null
				);
				wp_list_categories( $args ); 
			?>
			</ul>
		</nav>
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