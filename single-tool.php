<?php
/*
 * @package WordPress
 * Template Name: Detail Toolkit Page
*/
?>
<?php get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
<nav class="toolkit-nav cf">
	<div class="jquery-toolkit">		
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
						<span class="image">
							<?php echo get_the_post_thumbnail($value->ID, 'tool-small-img', array('alt' => get_the_title($value->ID))); ?>
						</span>
						<span><?php echo strip_tags(get_the_title($value->ID)); ?></span>
					</a>
				</li>
				<?php		
			}
			?>			
		</ul>
	</div>
	<a href="#" class="btn-next jquery-toolkit-next">next</a>
</nav>
<div id="main">
	<div class="main-holder cf">
		<article id="content" class="toolkit-content">
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
			<form action="#" id="answers" method="post" onsubmit="setAnswer(<?php echo $post->ID; ?>); return false;">
			<?php 			
			if(is_array($meta['question']))
			{
				foreach ($meta['question'] as $key => $value) 
				{
					echo '<p class="question-text">';
					echo $value;
					if($meta['tool_tip'][$key] != "")
					{
						?>
						<span class="ico-info">
							<i></i>
							<span class="box"><?php echo $meta['tool_tip'][$key]; ?></span>
						</span>
						<?php
					}
					echo '</p>';
					if(is_user_logged_in())
					{						
						?>
						<textarea name="answers[<?php echo $key; ?>]" data-id="<?php echo $key; ?>" class="answer"><?php echo $answer[$key]; ?></textarea>
						<?php
					}
				}	
			}
			if(is_user_logged_in())
			{
				?>			
				<button class="btn pink" ><span>SAVE</span></button>
				<?php 
			}	
			else
			{
				$count_meta = count($meta['question']);
				if($count_meta > 1)
				{
					?>
					<p><a href="#" onclick="showHide(true, ['#sign-in', '.lightbox-mask'], this);" class="pink">Sign in</a> to save your responses</p>
					<?php
				}
				else
				{					
					?>
					<p><a href="#" onclick="showHide(true, ['#sign-in', '.lightbox-mask'], this);" class="pink">Sign in</a> to save your response</p>
					<?php
				}
			}
			?>
		</form>
	</section>
	<?php
	}
	?>
	<?php echo $GLOBALS['gcrating']->getRateBlock(get_the_ID()); ?>		
</div>
	<?php endwhile; ?>
<?php get_footer(); ?>