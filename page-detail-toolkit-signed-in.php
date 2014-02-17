<?php
/*
 * @package WordPress
 * Template Name: Detail Toolkit Signed Page
*/
?>
<?php get_header('sign-in'); ?>
	<?php while (have_posts()) : the_post(); ?>
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
				<h1>Breaking the Ice</h1>
				<p class="text-big-pink">Research shows there is a need for role models, and they do make a difference.</h2>
				<ul>
					<li>Less than 50% of high school girls know a woman in a STEM career.</li>
					<li>87% of Techbridge program participants say that field trips and role models made them more interested in working in technology, science, or engineering.</li>
					<li>Exposing girls to female role models helps to counteract negative stereotypes about women and STEM.</li>
				</ul>
				<h3>ACTIONS</h3>
				<p>Listen to these girls talk about how meeting a STEM role model in their Techbridge program made an impact on them. Then, answer the questions below. </p>
				<div class="video-holder">
					<img src="<?php echo TDU; ?>/images/img-1.jpg" alt="image description">
					<a href="#" class="btn big pink"><span>play video</span> <i class="video"></i></a>
				</div>
			</article>
			<div id="sidebar">
				<aside class="widget widget-socials">
					<p>Share This Page! </p>
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
			<p class="question-text">How did you end up on your career path? Were any role models influential in helping you choose your career?
				<span class="ico-info">
					<i></i>
					<span class="box">Girls want to hear how you ended up where you are. Be sure to share your responses with them.</span>
				</span>
			</p>
			<form action="#">
				<textarea></textarea>
				<button class="btn pink"><span>SAVE</span></button>
			</form>
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