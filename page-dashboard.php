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
								<div class="image">
									<?php
									if(has_post_thumbnail($value->ID))
									{
										echo get_the_post_thumbnail($value->ID, 'tool-small-img', array('alt' => get_the_title($value->ID)));
									}
									?>									
								</div>
								<h3><?php echo strip_tags($value->post_title); ?></h3>
								<a href="#" onclick="openClose(this); return false;" class="btn-arrow">open/close</a>
							</div>
							<div class="item-content cf">
								<div class="content">

									<?php 									
									$answers[$value->ID]['title'] = $value->post_title;									
									foreach ($value->meta['question'] as $key2 => $value2) 
									{
										echo '<h4>'.$value2.'</h4>';
										echo '<p>'.$value->answer[$key2].'</p>';										
										
										$answers[$value->ID]['items'][] = array('question' => $value2, 'answer' => $value->answer[$key2]);
										$mailto        .= rawurlencode($value2.' '.$value->answer[$key2]."\n");										
									}	
																							
									?>									
								</div>
								<div class="aside buttons">
									<script type='text/javascript'>/* <![CDATA[ */ var item_<?php echo $value->ID; ?> = <?php echo json_encode($answers[$value->ID]); ?>; /* ]]> */</script>
									<button class="btn pink mini" onclick="window.open('<?php echo get_permalink($value->ID); ?>', '_self', '');"><span>edit</span><i class="pensil"></i></button>
									<button class="btn mini response-button" data-id="<?php echo $value->ID; ?>"><span>email</span><i class="mail"></i></button>									
								</div>
							</div>
						</div>
						<?php	
					}
					?>					
				</div>
				<?php echo $pagination; ?>				
				<div class="button-columns cf">
					<div class="column">
						<h2>Send my responses!</h2>
						<script type='text/javascript'>/* <![CDATA[ */ var item_all = <?php echo json_encode($answers); ?>; /* ]]> */</script>
						<a class="btn big response-button" href="#" data-id="-1"><span>email</span><i class="mail"></i></a>
						<!-- <a class="btn big st_email_custom" st_title="All responses"><span>email</span><i class="mail"></i></a> -->
					</div>
					<div class="column">
						<h2>Help us improve!</h2>
						<button class="btn big dark" onclick="window.open('<?php echo $theme_options['take_survey_url']; ?>', '', '');"><span>TAKE SURVEY</span><i class="survey"></i></button>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); 