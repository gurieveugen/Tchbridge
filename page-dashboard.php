<?php
/*
 * @package WordPress
 * Template Name: Dashboard Page
*/
?>
<?php 
get_header(); 
$items = getDashboardItems($current_user->ID);
?>

		<div class="main-transparent">
			<div class="holder">
				<h1>My Dashboard</h1>
				<h2>Responses</h2>
				<div class="dashboard-accordion">
					<?php foreach ($items as $key => $value) 
					{
						$mailto = $current_user->user_email.'?subject='.rawurlencode($value->post_title).'&body='.rawurlencode($value->meta['question'].' '.$value->answer);						
						?>
						<div class="item">
							<div class="head cf">
								<span class="ico ico-role"></span>
								<h3><?php echo strip_tags($value->post_title); ?></h3>
								<a href="#" onclick="openClose(this); return false;" class="btn-arrow">open/close</a>
							</div>
							<div class="item-content cf">
								<div class="content">
									<h4><?php echo $value->meta['question']; ?></h4>
									<p><?php echo $value->answer; ?></p>
								</div>
								<div class="aside buttons">
									<button class="btn pink mini"><span>edit</span><i class="pensil"></i></button>
									<a class="btn mini" href="mailto:<?php echo $mailto;?>"><span>email</span><i class="mail"></i></a>
								</div>
							</div>
						</div>
						<?php	
					}
					?>
					<div class="item">
						<div class="head cf">
							<span class="ico ico-role"></span>
							<h3>The Role Model Impact</h3>
							<a href="#" class="btn-arrow">open/close</a>
						</div>
						<div class="item-content cf">
							<div class="content">
								<h4>What icebreaker will you lead when you next do STEM outreach with girls?</h4>
								<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. </p>
							</div>
							<div class="aside buttons">
								<button class="btn pink mini"><span>edit</span><i class="pensil"></i></button>
								<button class="btn mini"><span>email</span><i class="mail"></i></button>
							</div>
						</div>
					</div>
					<div class="item open">
						<div class="head cf">
							<span class="ico ico-ice"></span>
							<h3>Breaking the Ice</h3>
							<a href="#" class="btn-arrow">open/close</a>
						</div>
						<div class="item-content cf">
							<div class="content">
								<h4>What icebreaker will you lead when you next do STEM outreach with girls?</h4>
								<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. </p>
							</div>
							<div class="aside buttons">
								<button class="btn pink mini"><span>edit</span><i class="pensil"></i></button>
								<button class="btn mini"><span>email</span><i class="mail"></i></button>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="head cf">
							<span class="ico ico-messaging"></span>
							<h3>STEM Messaging</h3>
							<a href="#" class="btn-arrow">open/close</a>
						</div>
						<div class="item-content cf">
							<div class="content">
								<h4>What icebreaker will you lead when you next do STEM outreach with girls?</h4>
								<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. </p>
							</div>
							<div class="aside buttons">
								<button class="btn pink mini"><span>edit</span><i class="pensil"></i></button>
								<button class="btn mini"><span>email</span><i class="mail"></i></button>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="head cf">
							<span class="ico ico-art"></span>
							<h3>The Art of Questioning</h3>
							<a href="#" class="btn-arrow">open/close</a>
						</div>
						<div class="item-content">
							<div class="content cf">
								<h4>What icebreaker will you lead when you next do STEM outreach with girls?</h4>
								<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. </p>
							</div>
							<div class="aside buttons">
								<button class="btn pink mini"><span>edit</span><i class="pensil"></i></button>
								<button class="btn mini"><span>email</span><i class="mail"></i></button>
							</div>
						</div>
					</div>
					<div class="item open">
						<div class="head cf">
							<span class="ico ico-girls"></span>
							<h3>Giving Girls Feedback</h3>
							<a href="#" class="btn-arrow">open/close</a>
						</div>
						<div class="item-content cf">
							<div class="content">
								<h4>What kind of feedback would you give to a girl who is struggling with a hands-on STEM activity?</h4>
								<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. </p>
								<h4>What kind of feedback would you give to a girl who is finding a hands-on STEM activity easy?</h4>
								<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Proin gravida nibh.</p>
							</div>
							<div class="aside buttons">
								<button class="btn pink mini"><span>edit</span><i class="pensil"></i></button>
								<button class="btn mini"><span>email</span><i class="mail"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="cf">
					<ul class="page-nav">
						<li class="active">1</li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li class="link-all"><a href="#">View All</a></li>
					</ul>
				</div>
				<div class="button-columns cf">
					<div class="column">
						<h2>Send my responses!</h2>
						<button class="btn big"><span>email</span><i class="mail"></i></button>
					</div>
					<div class="column">
						<h2>Help us improve!</h2>
						<button class="btn big dark"><span>TAKE SURVEY</span><i class="survey"></i></button>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); ?>