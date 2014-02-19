<?php 

GLOBAL $wp_query;

$cats_selected = '';
if(is_array($_SESSION['cats_selected']))
{
	$cats_selected = $_SESSION['cats_selected'];
	$cats_selected = array_keys($cats_selected);
	$cats_selected = implode(', ', $cats_selected);
}
$wp_query->query_vars['category_name'] = $cats_selected;

if($_GET['display'] == 'all')
{		
	$wp_query->query_vars['posts_per_page'] = 500;	
}
query_posts($wp_query->query_vars);

$pagination = getPagination(); 
echo $pagination;

?>
<div class="posts-holder">
	<?php
	if(have_posts())
	{
		while(have_posts())
		{
			the_post();
			$meta = get_post_meta(get_the_ID(), 'additional_options', true);
			if(isset($meta['external_url']) && $meta['external_url'] != '') $external_url = '<a href="'.esc_url($meta['external_url']).'" class="pink downl-link">Download report</a>';
			else $external_url = '';
			?>
			<article class="post cf <?php post_class(); ?>">
				<?php if (has_post_thumbnail() AND get_the_post_thumbnail() != "") echo '<a href="'.get_permalink().'" class="image-block">'.get_the_post_thumbnail().'</a>'; ?>				
				<div class="text">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p><?php the_content(' '); ?></p>
					<?php echo $external_url; ?>
				</div>
			</article>
			<?php
		}
	}	
	?>		
</div>
<?php echo $pagination;


		
	