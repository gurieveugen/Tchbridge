<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>

<?php if ( have_posts() ) : ?>

<div class="posts-holder">
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php
				if(strpos($post->post_content, '<!--more-->'))
					the_content( __( 'Read more', 'theme' ) );
				else {
					the_excerpt();
				}
				
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
			?>
		</div><!-- .entry-content -->
	
	</article><!-- #post -->

<?php endwhile; ?>
</div> <!-- .post-holder -->
	
<?php theme_paging_nav(); ?>

<?php else: ?>
	
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'theme' ); ?></h1>
	</header>
	
	<div class="page-content">

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'theme' ); ?></p>
		<?php get_search_form(); ?>

	</div><!-- .page-content -->
	
<?php endif; ?>