<?php
/*
 * @package WordPress
 * Template Name: Detail Toolkit Page
*/
?>
<?php get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
<nav class="toolkit-nav cf">
	<div class="jcarousel jquery-toolkit">		
		<ul>
			<?php
			$tools     = $GLOBALS['post_type_tool']->getTools(array('posts_per_page' => 500));
			$index     = 1;
			$meta      = $tools[get_the_ID()]->meta;			
			$meta_user = get_user_meta($current_user->ID, 'answers', true);
			$answer    = (isset($meta_user[$post->ID])) ? $meta_user[$post->ID] : '';
			foreach ($tools as $key => $value) 
			{
				?>
				<li data-index="<?php echo $index++; ?>" data-id="<?php echo $value->ID;?>" class="<?php echo active(($post->ID == $value->ID)); ?>">
					<a href="<?php echo get_permalink($value->ID); ?>">
						<?php echo get_the_post_thumbnail($value->ID, 'tool-small-img', array('alt' => get_the_title($value->ID))); ?>
						<span><?php echo strip_tags(get_the_title($value->ID)); ?></span>
					</a>
				</li>
				<?php		
			}
			?>			
		</ul>
	</div>
	<a href="#" onclick="next(); return false;" class="btn-next jcarousel-control-next">next</a>
</nav>
<div id="main">
	<div class="main-holder cf">
		<article id="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>			
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</article>		
		<?php get_sidebar(); ?>
	</div>
	<?php
	if($meta != "" AND isset($meta['question']))
	{
	?>
	<section class="question-block">
		<h3>QUESTIONS</h3>
		<p class="question-text">
			<?php 
			echo $meta['question']; 
			if(isset($meta['tool_tip']))
			{
				?>
				<span class="ico-info">
					<i></i>
					<span class="box"><?php echo $meta['tool_tip']; ?></span>
				</span>
				<?php
			}
			?> 
		</p>
		<?php
		if(!is_user_logged_in())
		{
			?>
			<p><a href="#" onclick="showHide(true, ['#sign-in', '.lightbox-mask'], this);" class="pink">Sign in</a> to save your response</p>
			<?php
		}
		else
		{
			?>
			<form action="#" method="post" onsubmit="setAnswer(<?php echo $post->ID; ?>); return false;">
				<textarea name="answer" id="answer"><?php echo $answer; ?></textarea>
				<button class="btn pink" ><span>SAVE</span></button>
			</form>
			<?php
		}
		?>
	</section>
	<?php
	}
	?>
	<section class="rate-block">
		<p>Rate how effective you find the Breaking the Ice tool.</p>
		<div class="cf">
			<ul class="star-rating">
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li></li>
			</ul>
			<button type="submit" class="btn"><span>Rate</span></button>
		</div>
	</section>
</div>
	<?php endwhile; ?>
<?php get_footer(); ?>