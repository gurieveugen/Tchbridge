<?php
/*
 * @package WordPress
 * Template Name: Toolkit Page
*/
?>
<?php get_header(); ?>
<?php
$options        = $GLOBALS['gcoptions']->getAllOptions();
$count          = count($GLOBALS['post_type_tool']->getTools(array('posts_per_page' => -1)));
$tools_per_page = (intval($options['tools_per_page']) > 0) ? intval($options['tools_per_page']) : 1;
$pages_count    = ceil($count/$tools_per_page);
?>
<script>var pages_count = <?php echo $pages_count; ?></script>
<div class="main-green">
	<div class="toolkit-section cf">		
		<?php get_template_part('loop', 'tools'); ?>
		<?php 
		if($count > $tools_per_page)
		{
			?>
			<a href="#" onclick="getTools(); return false;" class="t-box view-box" id="view-more"><strong>+</strong>View More</a>
			<?php
		}
		if(!$options['hide_check_back_soon'])
		{
			?>
			<div class="t-box text-box" id="check-new-materials">
				<p>Check back <br>soon for new <br>materials!</p>
			</div>
			<?php
		}
		?>		
	</div>
	<p>Help us improve!</p>
	<button class="btn big dark" onclick="window.open('<?php echo $options['take_survey_url']; ?>', '', '');"><span>TAKE SURVEY</span><i class="survey"></i></button>
</div>
<?php get_footer(); ?>