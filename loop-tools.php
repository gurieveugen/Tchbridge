<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$tools = $GLOBALS['post_type_tool']->getTools(array('paged' => $paged));
foreach ($tools as $key => $value) 
{
	echo '<a href="'.get_permalink($value->ID).'" class="t-box">';
	if(has_post_thumbnail($value->ID))
	{
		echo '<span class="image">'.get_the_post_thumbnail($value->ID, 'tool-img', array('alt' => get_the_title($value->ID))).'</span>';
	}
	echo '<strong>'.get_the_title($value->ID).'</strong>';
	echo '</a>';
}
?>