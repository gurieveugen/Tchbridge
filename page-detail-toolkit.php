<?php
/*
 * @package WordPress
 * Template Name: Detail Toolkit Page
*/
?>
<?php get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
<nav class="toolkit-nav cf">
	<ul>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-1.png" alt="image description">
				<span>Role Model Impact</span>
			</a>
		</li>
		<li class="active">
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-2.png" alt="image description">
				<span>Breaking the Ice</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-3.png" alt="image description">
				<span>Sharing About You</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-4.png" alt="image description">
				<span>STEM Messaging</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-5.png" alt="image description">
				<span>Technobabble</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-6.png" alt="image description">
				<span>The Art of Questioning</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-7.png" alt="image description">
				<span>Giving Girls Feedback</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-8.png" alt="image description">
				<span>Career Exploration</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-9.png" alt="image description">
				<span>Crowd Control</span>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="<?php echo TDU; ?>/images/ico-nav-10.png" alt="image description">
				<span>Strategies</span>
			</a>
		</li>
	</ul>
	<a href="#" class="btn-next">next</a>
</nav>
<div id="main">
	<div class="main-holder cf">
		<article id="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<div class="video-holder">
				<img src="<?php echo TDU; ?>/images/img-1.jpg" alt="image description">
				<a href="#" class="btn big pink"><span>play video</span> <i class="video"></i></a>
			</div>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</article>
		<div id="sidebar">
			<aside class="widget widget-sign-up">
				<a href="#" class="btn big pink wide"><span>SIGN UP</span> <i class="pensil"></i></a>
				<p>To track progress, save<br> and share responses.</p>
			</aside>
			<aside class="widget widget-socials">
				<ul class="socials">
					<li class="twitter"><a href="https://twitter.com/techbridgegirls">twitter</a></li>
					<li class="facebook"><a href="https://www.facebook.com/techbridge">facebook</a></li>
					<li class="rss"><a href="#">rss</a></li>
				</ul>
			</aside>
		</div>
	</div>
	<section class="question-block">
		<h3>QUESTIONS</h3>
		<p class="question-text">How did you end up on your career path? Were any role models influential in helping you choose your career?</p>
		<p><a href="#" class="pink">Sign in</a> to save your response</p>
	</section>
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