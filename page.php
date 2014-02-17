<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>
<div class="main-wide">
	<div id="content" role="main">
	
		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
					<h1 class="entry-title"><?php the_title(); ?></h1>
	
				<div class="entry-content cf">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
				</div><!-- .entry-content -->
	
			</article><!-- #post -->
	
		<?php endwhile; ?>
	
	</div><!-- #content -->
	
</div>
<?php get_footer(); ?>
