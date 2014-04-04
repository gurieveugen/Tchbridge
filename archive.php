<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>
<div class="main-blue">
	<?php // echo getCategoriesHTML(get_query_var('cat')); ?>
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
	<div class="holder">
		<h1 class="archive-title">
		<?php global $post;
			if (is_category()):
				
			elseif( is_tag() ):
				printf( __( 'Tag Archives: %s', 'theme' ), single_tag_title( '', false ) );
			elseif ( is_day() ) :
				printf( __( 'Daily Archives: %s', 'theme' ), get_the_date() );
			elseif ( is_month() ) :
				printf( __( 'Monthly Archives: %s', 'theme' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'theme' ) ) );
			elseif ( is_year() ) :
				printf( __( 'Yearly Archives: %s', 'theme' ), get_the_date( _x( 'Y', 'yearly archives date format', 'theme' ) ) );
			elseif (is_author()):
				printf( __( 'All posts by %s', 'theme' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
			else :
				_e( 'Archives', 'theme' );
			endif;
			?>
		</h1>
		<?php get_template_part('loop', 'posts'); ?>
	</div>
</div>
<?php get_footer(); ?>
