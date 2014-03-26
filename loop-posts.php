<?php 

GLOBAL $wp_query;

// $cats_selected = '';
// if(is_array($_SESSION['cats_selected']))
// {
// 	$cats_selected = $_SESSION['cats_selected'];
// 	$cats_selected = array_keys($cats_selected);
// 	$cats_selected = implode(', ', $cats_selected);
// }
// $wp_query->query_vars['category_name'] = $cats_selected;

$target = array('_blank', '_self');

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
			$meta         = get_post_meta(get_the_ID(), 'additional_options', true);
			$link_title   = (isset($meta['link_title']) && $meta['link_title'] != '') ? $meta['link_title'] : 'Download resource';
			$external_url = (isset($meta['external_url']) && $meta['external_url'] != '') ? '<a href="'.esc_url($meta['external_url']).'" target="'.$target[intval($meta['open_in'])].'" class="pink downl-link">'.$link_title.'</a>' : '';
			?>
			<article class="post cf <?php post_class(); ?>">
				<?php if (has_post_thumbnail() AND get_the_post_thumbnail() != "") echo '<div class="image-block">'.get_the_post_thumbnail().'</div>'; ?>				
				<div class="text">
					<h2><?php the_title(); ?></h2>
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


		
	