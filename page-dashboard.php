<?php
/*
 * @package WordPress
 * Template Name: Dashboard Page
*/
?>
<?php 
get_header(); 
$items               = getDashboardItems($current_user->ID);
$items_count         = count($items);
$all_responses       = $current_user->user_email.'?subject='.rawurlencode('All responses').'&body=';
$theme_options       = $GLOBALS['gcoptions']->getAllOptions();
$tools_per_page_dash = intval($theme_options['tools_per_page_dash']);
$paged               = max(1, intval(get_query_var('paged')))-1;
$offset 			 = $tools_per_page_dash*$paged;
$pagination          = getDashPagination($items_count, $tools_per_page_dash);

if($_GET['display'] != 'all') $items = array_slice($items, $offset, $tools_per_page_dash);
?>

		<div class="main-transparent">
			<div class="holder">
				<h1>My Dashboard</h1>
				<h2>Responses</h2>
				<div class="dashboard-accordion">
					<?php foreach ($items as $key => $value) 
					{
						$mailto = $current_user->user_email.'?subject='.rawurlencode($value->post_title).'&body=';						
						?>
						<div class="item">
							<div class="head cf">
								<span class="ico ico-role"></span>
								<h3><?php echo strip_tags($value->post_title); ?></h3>
								<a href="#" onclick="openClose(this); return false;" class="btn-arrow">open/close</a>
							</div>
							<div class="item-content cf">
								<div class="content">

									<?php 
									$all_responses .= strip_tags($value->post_title).rawurlencode("\n");
									foreach ($value->meta['question'] as $key2 => $value2) 
									{
										echo '<h4>'.$value2.'</h4>';
										echo '<p>'.$value->answer[$key2].'</p>';
										$mailto        .= rawurlencode($value2.' '.$value->answer[$key2]."\n");
										$all_responses .= rawurlencode($value2.' '.$value->answer[$key2]."\n");
									}	
									$all_responses .= rawurlencode("\n\n");								
									?>									
								</div>
								<div class="aside buttons">
									<button class="btn pink mini" onclick="window.open('<?php echo get_permalink($value->ID); ?>', '_self', '');"><span>edit</span><i class="pensil"></i></button>
									<button class="btn mini" onclick="window.open('mailto:<?php echo $mailto;?>', '_self', '');"><span>email</span><i class="mail"></i></button>
									
								</div>
							</div>
						</div>
						<?php	
					}
					?>					
				</div>
				<?php echo $pagination; ?>
				<!-- <div class="cf">
					<ul class="page-nav">
						<li class="active">1</li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li class="link-all"><a href="#">View All</a></li>
					</ul>
				</div> -->
				<div class="button-columns cf">
					<div class="column">
						<h2>Send my responses!</h2>
						<button class="btn big" onclick="window.open('mailto:<?php echo $all_responses;?>', '_self', '');"><span>email</span><i class="mail"></i></button>
					</div>
					<div class="column">
						<h2>Help us improve!</h2>
						<button class="btn big dark"><span>TAKE SURVEY</span><i class="survey"></i></button>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); 

