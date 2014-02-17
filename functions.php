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
// function scripts_method() {
// 	wp_deregister_script( 'jquery' );
// 	wp_register_script( 'jquery', TDU.'/js/jquery-1.9.1.min.js');
// 	wp_enqueue_script( 'jquery' );
// }
// add_action('wp_enqueue_scripts', 'scripts_method');

// register tag [template-url]
function template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'template_url');
add_filter('get_the_content', 'template_url');
add_filter('widget_text', 'template_url');

function theme_default_content( $content ) {
	$content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ultrices, magna non porttitor commodo, massa nibh malesuada augue, non viverra odio mi quis nisl. Nullam convallis tincidunt dignissim. Nam vitae purus eget quam adipiscing aliquam. Sed a congue libero. Quisque feugiat tincidunt tortor sed sodales. Etiam mattis, justo in euismod volutpat, ipsum quam aliquet lectus, eu blandit neque libero eu justo. Nunc nibh nulla, accumsan in imperdiet vel, pretium in metus. Aenean in lacus at lacus imperdiet euismod in non nulla. Mauris luctus sodales metus, ac porttitor est lacinia non. Proin diam urna, feugiat at adipiscing in, varius vel mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed tincidunt commodo massa interdum iaculis.</p><!--more--><p>Aliquam metus libero, elementum et malesuada fermentum, sagittis et libero. Nullam quis odio vel ipsum facilisis viverra id sit amet nibh. Vestibulum ullamcorper luctus lacinia. Etiam accumsan, orci eu blandit vestibulum, purus ante malesuada purus, non commodo odio ligula quis turpis. Vestibulum scelerisque feugiat diam, eu mollis elit cursus nec. Quisque commodo ultricies scelerisque. In hac habitasse platea dictumst. Nullam hendrerit rhoncus lacus, id lobortis leo condimentum sed. Nulla facilisi. Quisque ut velit a neque feugiat rutrum at sit amet neque. Sed at libero dictum est aliquam porttitor. Morbi tempor nulla ut tellus malesuada cursus condimentum metus luctus. Quisque dui neque, lobortis id vehicula et, tincidunt eget justo. Morbi vulputate velit eget leo fermentum convallis. Nam mauris risus, consectetur a posuere ultricies, elementum non orci.</p><p>Ut viverra elit vel mauris venenatis gravida ut quis mi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eleifend urna sit amet nisi scelerisque pretium. Nulla facilisi. Donec et odio vel sem gravida cursus vestibulum dapibus enim. Pellentesque eget aliquet nisl. In malesuada, quam ac interdum placerat, elit metus consequat lorem, non consequat felis ipsum et ligula. Sed varius interdum volutpat. Vestibulum et libero nisi. Maecenas sit amet risus et sapien lobortis ornare vel quis ipsum. Nam aliquet euismod aliquam. Donec velit purus, convallis ac convallis vel, malesuada vitae erat.</p>";
	return $content;
}
add_filter('default_content', 'theme_default_content');
// =========================================================
// REQUIRE
// =========================================================
require_once 'includes/page_theme_options.php';
require_once 'includes/meta_box_additional_options.php';
require_once 'includes/post_type_tool.php';
require_once 'includes/widget_singup.php';
// =========================================================
// HOOKS
// =========================================================
add_action('wp_ajax_gettools', 'getToolsAJAX');
add_action('wp_ajax_nopriv_gettools', 'getToolsAJAX');
add_action('wp_ajax_setanswer', 'setAnswerAJAX');
add_action('wp_ajax_nopriv_setanswer', 'setAnswerAJAX');
add_action('register_form','custom_register_form');
add_filter('registration_errors', 'custom_registration_errors', 10, 3);
add_action('user_register', 'custom_user_register');
add_filter('gettext', 'ts_edit_password_email_text');
// =========================================================
// JUST FOR THEME
// =========================================================
if(!is_admin())
{
	wp_enqueue_script('carousel', TDU.'/js/carousel.min.js', array('jquery'));
}
// =========================================================
// METHODS
// =========================================================
/**
 * Add custom fields to register form
 */
function custom_register_form()
{
	$full_name  = (isset($_POST['full_name'])) ? $_POST['full_name'] : '';
	$employment = (isset($_POST['employment'])) ? $_POST['employment'] : '';
	$password   = (isset($_POST['password'])) ? $_POST['password'] : '';
	
    ?>
    <p>
        <label for="full_name"><?php _e('Full name') ?><br />
            <input type="text" name="full_name" id="full_name" class="input" value="<?php echo esc_attr(stripslashes($full_name)); ?>" size="75" required />
        </label>
    </p>
    <p>
        <label for="employment"><?php _e('Employment') ?><br />
            <input type="text" name="employment" id="employment" class="input" value="<?php echo esc_attr(stripslashes($employment)); ?>" size="75" required />
        </label>
    </p>
    <p>
        <label for="password"><?php _e('Password') ?><br />
            <input type="password" name="password" id="password" class="input" value="<?php echo esc_attr(stripslashes($password)); ?>" size="75" />
        </label>
    </p>
    <?php
}

/**
 * Check errors
 * @param  object $errors               
 * @param  string $sanitized_user_login 
 * @param  string $user_email           
 * @return object
 */
function custom_registration_errors($errors, $sanitized_user_login, $user_email) 
{
    if(empty( $_POST['full_name'])) $errors->add('full_name_error', __('<strong>ERROR</strong>: You must include a full name.'));
    if(empty( $_POST['employment'])) $errors->add('employment_error', __('<strong>ERROR</strong>: You must include a employment.'));

    return $errors;
}

/**
 * Save user data
 * @param  integer $user_id
 */
function custom_user_register ($user_id) 
{
	$userdata       = array();	 
	$userdata['ID'] = $user_id;
	if($_POST['password'] !== '') $userdata['user_pass'] = $_POST['password'];
	$new_user_id = wp_update_user( $userdata );
	
    if(isset($_POST['full_name'])) update_user_meta($user_id, 'full_name', $_POST['full_name']);
    if(isset($_POST['employment'])) update_user_meta($user_id, 'employment', $_POST['employment']);
    if(isset($_POST['password'])) update_user_meta($user_id, 'password', $_POST['password']);
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
		$str.= '<li class="link-all active"><span>view all</span></li></ul></div>';
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
function getCategoriesHTML($cat = -1)
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
	$str = '';

	if($categories)
	{
		$str.= '<nav class="nav-filter cf"><span>sort by</span><ul>';
		foreach ($categories as $key => $value) 
		{
			$str.= '<li class="'.selectDeselect($value->term_id == $cat).'"><a href="'.get_category_link($value->term_id).'">'.$value->name.'</a></li>';
		}
		$str.= '</ul></nav>';
	}
	return $str;
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
