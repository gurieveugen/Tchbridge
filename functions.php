<?php
/*
 * @package WordPress
 * @subpackage Base_Theme
 */
define('TDU', get_bloginfo('template_url'));
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
add_filter( 'use_default_gallery_style', '__return_false' );
register_sidebar(array(
	'id' => 'right-sidebar',
	'name' => 'Right Sidebar',
	'before_widget' => '<div class="widget %2$s" id="%1$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
	));
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 604, 270, true );
add_image_size( 'single-post-thumbnail', 400, 9999, false );
add_image_size( 'category_post_thumb', 240, 170, true );
register_nav_menus( array(
	'primary_nav' => __( 'Primary Navigation', 'theme' ),
	'top_nav' => __( 'Top Navigation', 'theme' ),
	'bottom_nav' => __( 'Bottom Navigation', 'theme' )
	) );
function change_menu_classes($css_classes){
	$css_classes = str_replace("current-menu-item", "current-menu-item active", $css_classes);
	$css_classes = str_replace("current-menu-parent", "current-menu-parent active", $css_classes);
	return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');
function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');
function theme_paging_nav() {
	global $wp_query;
	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="nav-links cf">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'theme' ) ); ?></div>
			<?php endif; ?>
			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'theme' ) ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
function theme_post_nav() {
	global $post;
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'theme' ); ?></h1>
		<div class="nav-links">
			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'theme' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'theme' ) ); ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
function theme_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'theme' );
	else
		$format_prefix = '%2$s';
	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'theme' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);
	if ( $echo )
		echo $date;
	return $date;
}
function theme_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'theme' ) . '</span>';
	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		theme_entry_date();
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'theme' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}
	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'theme' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}
	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'theme' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
function template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'template_url');
add_filter('get_the_content', 'template_url');
add_filter('widget_text', 'template_url');
function theme_default_content( $content ) {
	$content = "<p>Enter your content here. If you are adding a new resource post, text above the \"More\" page break will appear on the list of resources.</p><!--more--><p>Text below the \"More\" page break will only be visible if the user clicks the resource title to view the full post.</p>";
	return $content;
}
add_filter('default_content', 'theme_default_content');
// =========================================================
// LAUNCH
// =========================================================
launch_session();
// =========================================================
// REQUIRE
// =========================================================
require_once 'includes/page_theme_options.php';
require_once 'includes/meta_box_additional_options.php';
require_once 'includes/meta_box_tool_options.php';
require_once 'includes/post_type_tool.php';
require_once 'includes/widget_singup.php';
// =========================================================
// HOOKS
// =========================================================
add_action('wp_ajax_gettools', 'getToolsAJAX');
add_action('wp_ajax_nopriv_gettools', 'getToolsAJAX');
add_action('wp_ajax_setanswer', 'setAnswerAJAX');
add_action('wp_ajax_nopriv_setanswer', 'setAnswerAJAX');
add_action('wp_ajax_selectdeselectcat', 'selectDeselectCatAJAX');
add_action('wp_ajax_nopriv_selectdeselectcat', 'selectDeselectCatAJAX');
add_action('wp_ajax_set_scroll_position', 'setScrollPositionAJAX');
add_action('wp_ajax_nopriv_set_scroll_position', 'setScrollPositionAJAX');
add_filter( 'wp_mail_content_type', 'setContentType' );
add_action('init', 'loginInitAJAX');
add_filter('gettext', 'ts_edit_password_email_text');
add_filter('wp_list_categories', 'replaceCategoryCSSClass');
add_filter( 'show_admin_bar' , 'adminBarJustForAdmins');
// =========================================================
// JUST FOR ADMIN
// =========================================================
if(is_admin())
{
	wp_enqueue_style('admin-styles-theme', TDU.'/css/admin-styles.min.css');
	wp_enqueue_style('font-awesome-theme', TDU.'/css/font-awesome.min.css');
}
// =========================================================
// JUST FOR THEME
// =========================================================
else
{
	wp_enqueue_script('carousel', TDU.'/js/carousel.min.js', array('jquery'));
}
// =========================================================
// METHODS
// =========================================================
/**
 * Admin bar just for admin
 * @return boolean
 */
function adminBarJustForAdmins()
{
	if(is_admin() || is_super_admin()) return true;
	return false;
}

/**
 * Set default content type 
 * for wp_mail
 */
function setContentType( $content_type )
{
	return 'text/html';
}

/**
 * Redirect after succes registration
 * @return string
 */
function getRegistrationRedirectURL()
{
	$url = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	if(strpos($url, get_bloginfo('url')) < 0) $url = get_bloginfo('url');
    return $url;
}

/**
 * Replace Categories css class
 * @param  string $list
 * @return string      
 */
function replaceCategoryCSSClass($list)
{
	$list = str_replace('cat-item', 'deselect', $list);
	$list = str_replace('current-cat', 'active', $list);
	return $list;
}

/**
 * Replace register text
 * @param  string $text 
 * @return string       
 */
function ts_edit_password_email_text($text) 
{
	if($text == 'A password will be e-mailed to you.') 
	{
		$text = 'If you leave password fields empty one will be generated for you. Password must be at least eight characters long.';
	}
	return $text;
}

/**
 * Get pagination HTML Code
 */
function getPagination($total = -1)
{
	global $wp_query;
	if($total == -1) $total = $wp_query->max_num_pages;
	$big   = 999999999; 	
	$base  = esc_url(get_pagenum_link($big));
	$base  = preg_replace('/\?.*/', '', $base);
	$links = paginate_links( array(
		'base'      => str_replace($big, '%#%', $base),
		'prev_next' => False,
		'format'    => '?paged=%#%',
		'show_all'  => True,
		'current'   => max(1, get_query_var('paged')),
		'total'     => $total,
		'type'		=> 'array'));

	if(isset($_GET) && $_GET['display'] == 'all')
	{
		$str = '<div class="cf"><ul class="page-nav">';	
		if($links)
		{
			$links[0] = '<a href="'.preg_replace('/\?.*/', '', get_pagenum_link('1')).'">1</a>';			
			foreach ($links as $key => $value) 
			{				
				$str   .= '<li>'.$value.'</li>';
			}	
		}
		$str.= '</ul></div>';
	}
	else
	{
		$str = '<div class="cf"><ul class="page-nav">';	
		if($links)
		{
			foreach ($links as $key => $value) 
			{
				$active = (preg_match('/current/', $value)) ? ' class="active" ': '';			
				$str   .= '<li'.$active.'>'.$value.'</li>';
			}	
		}
		$str.= '<li class="link-all"><a href="'.preg_replace('/\?.*/', '', get_pagenum_link('1')).'?display=all">view all</a></li></ul></div>';
	}

	return $str;
}
/**
 * Custom pagination for dashboard
 * @param  integer $total    
 * @param  integer $per_page 
 * @return string
 */
function getDashPagination($total, $per_page)
{
	$big         = 999999999; 	
	$base        = esc_url(get_pagenum_link($big));
	$base        = preg_replace('/\?.*/', '', $base);
	$base        = str_replace($big, '%s', $base); 
	$pages       = ceil($total/$per_page);
	$start_block = '<div class="cf"><ul class="page-nav">';
	$end_block   = '';
	$middle      = '';
	$current     = max(1, intval(get_query_var('paged')));

	if($pages <= 1) return '';
	
	if(isset($_GET) && $_GET['display'] == 'all')
	{
		$current    = 9999999999;
		$end_block .= '<li class="link-all active">view all</li></ul></div>';
	}
	else
	{
		$end_block .= '<li class="link-all"><a href="'.preg_replace('/\?.*/', '', get_pagenum_link('1')).'?display=all">view all</a></li></ul></div>';
	}
	
	for ($i=1; $i <= $pages; $i++) 
	{ 
		$url    = sprintf($base, $i);
		$middle.= ($i == $current) ? '<li class="active">'.$i.'</li>'  : '<li><a href="'.$url.'">'.$i.'</a></li>';
	}

	return $start_block.$middle.$end_block;
}
/**
 * Get all categories to navigation block
 * @return string
 */
function getCategoriesHTML()
{
	$args = array(
		'type'         => 'post',
		'child_of'     => 0,
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 1,
		'hierarchical' => 1,
		'exclude'      => '1',
		'taxonomy'     => 'category',
		'pad_counts'   => false); 
	$categories    = get_categories($args);	
	$str           = '';
	$cats_selected = $_SESSION['cats_selected'];
	if($categories)
	{
		$str.= '<nav class="nav-filter cf"><span>sort by</span><ul>';
		foreach ($categories as $key => $value) 
		{
			$str.= '<li class="'.selectDeselect(isset($cats_selected[$value->name])).'"><a href="'.get_category_link($value->term_id).'" onclick="selectDeselectCat('.intval(!isset($cats_selected[$value->name])).', \''.$value->name.'\', '.$value->term_id.'); return false;">'.$value->name.'</a></li>';
		}
		$str.= '</ul></nav>';
	}
	return $str;
}

/**
 * Init login AJAX
 */
function loginInitAJAX()
{	
    wp_localize_script('carousel', 'ajax_login_object', array( 
		'ajaxurl'        => get_bloginfo('template_url').'/includes/ajax.php',
		'redirecturl'    => getRegistrationRedirectURL(),
		'loadingmessage' => __('Sending user info, please wait...')
    ));
}

/**
 * Set answet to Tool question
 */
function setAnswerAJAX()
{
	global $current_user, $post;
    get_currentuserinfo();
    $json['msg'] = 'ERROR';
    if(isset($_POST['post_id']) AND isset($_POST['answer']))
    {    	
		$user_id                       = $current_user->ID;
		$post_id                       = intval($_POST['post_id']);
		$answer                        = $_POST['answer'];
		$answers                       = get_user_meta($user_id, 'answers', true);
		$answers[$post_id] 			   = $answer;
		update_user_meta($user_id, 'answers', $answers);	    
		$json['msg']     = 'OK';	
    }

	echo json_encode($json);
	die();
}
/**
 * Set answet to Tool question
 */
function selectDeselectCatAJAX()
{
	$cat           = $_POST['cat'];
	$term_id       = intval($_POST['term_id']);
	$cats_selected = $_SESSION['cats_selected'];
	if(intval($_POST['select']))
	{
		$cats_selected[$cat] = $term_id;
		$json['status']      = 'SELECTED CATEGORIES:'.implode(', ', $cats_selected);
		$json['msg']		 = 'SELECTED';
	}
	else
	{
		unset($cats_selected[$cat]);
		$json['status']      = 'SELECTED CATEGORIES:'.implode(', ', $cats_selected);
		$json['msg']		 = 'DESELECTED';
	}
	$_SESSION['cats_selected'] = $cats_selected;
	
	echo json_encode($json);
	die();
}

/**
 * Set Scrool Position
 */
function setScrollPositionAJAX()
{
	$_SESSION['scroll_position'] = intval($_POST['position']);		
	die();
}

/**
 * Get scroll position
 * @return integer
 */
function getScrollPosition()
{	
	if(isset($_SESSION['scroll_position'])) return max(1, intval($_SESSION['scroll_position']));
	return 1;
}

/**
 * Get all dashboard items
 * @param  integer $user_id 
 * @return array          
 */
function getDashboardItems($user_id)
{
	$arr       = array();
	$meta_user = get_user_meta($user_id, 'answers', true);
	if($meta_user)
	{
		foreach ($meta_user as $key => $value) 
		{
			$obj         = get_post($key);
			$obj->meta   = get_post_meta($key, 'tools_options', true);
			$obj->answer = $value;
			$arr[]       = $obj;
		}
	}
	return $arr;
}
/**
 * Get AJAX loop tools
 */
function getToolsAJAX()
{
	GLOBAL $wp_query;
	if(isset($_POST['paged']))
	{
		$wp_query->query_vars['paged'] = intval($_POST['paged']);	
		get_template_part('loop', 'tools');
	}
	die();
}
/**
 * Helper for li css class
 * @param  boolean $x 
 * @return string     
 */
function selectDeselect($x = false)
{
	if($x) return 'select';
	return 'deselect';
}
/**
 * Helper for li css class
 * @param  boolean $x 
 * @return string     
 */
function active($x = false)
{
	if($x) return 'active';
	return '';
}
/**
 * Launch session
 */
function launch_session()
{
	if(session_id() == '')
	{
		session_start();
		if(!is_array($_SESSION['cats_selected']))
		{
			$_SESSION['cats_selected'] = getDefaultSelectedCats();
		}
	}
}
/**
 * Get default selected categories
 * @return  array
 */
function getDefaultSelectedCats()
{
	$args = array(
		'type'         => 'post',
		'child_of'     => 0,
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 1,
		'hierarchical' => 1,
		'exclude'      => '1',
		'taxonomy'     => 'category',
		'pad_counts'   => false); 
	$categories = get_categories($args);
	foreach ($categories as $key => $value) 
	{
		$selected_cats[$value->name] = $value->term_id;
	}
	return $selected_cats; 	
}
/**
 * Get tamplate part to variable
 * @param  string $template_name
 * @param  string $part_name    
 * @return string               
 */
function load_template_part($template_name, $part_name=null) 
{
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}