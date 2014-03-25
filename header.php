<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php 
$options = $GLOBALS['gcoptions']->getAllOptions();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php  echo (wp_title(' ', false, 'right') != '') ? wp_title(' ', false, 'right') : 'Home'; ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link media="all" rel="stylesheet" type="text/css" href="<?php echo TDU; ?>/css/jquery.formstyler.css" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
		wp_head(); ?>
	<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.formstyler.min.js" ></script>
	<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.main.js" ></script>
	<script>
		var SITE_FOLDER     = '<?PHP bloginfo('siteurl'); ?>';
		var SCROLL_POSITION = <?php echo getScrollPosition(); ?>;
	</script>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "ea3d8011-15bf-45e2-aaec-713ec3d1414e", onhover: false, doNotHash: true, doNotCopy: true, hashAddressBar: false });</script>
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo TDU; ?>/js/html5.js"></script>
		<script type="text/javascript" src="<?php echo TDU; ?>/js/pie.js"></script>
		<script type="text/javascript" src="<?php echo TDU; ?>/js/init-pie.js"></script>
	<![endif]-->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.placeholder.min.js"></script>
		<script type="text/javascript">
			jQuery(function(){
				jQuery('input, textarea').placeholder();
			});
		</script>
	<![endif]-->
</head>
<body <?php body_class(); ?> id="main-body">
	<div id="wrapper">
		<header id="header">
			<div class="top-bar cf">
				<?php 
				if(is_user_logged_in())
				{
					global $current_user;
      				get_currentuserinfo();

					?>
					<div class="current-user">
						<i></i>
						<span>Hi, <?php echo $current_user->display_name; ?></span>
						<ul>
							<li><a href="<?php echo home_url(); ?>/my-dashboard">My Dashboard</a></li>
							<li><a href="<?php echo home_url(); ?>/wp-login.php?action=logout">Logout</a></li>
						</ul>
					</div>
					<?php
				}
				else
				{
					?>
					<ul>
						<li><a href="#" onclick="showHide(true, ['#sign-up', '.lightbox-mask'], this);">sign up</a></li>
						<li class="pink"  onclick="showHide(true, ['#sign-in', '.lightbox-mask'], this);"><a href="#">sign in</a></li>
					</ul>
					<?php
				}
				?>
				
			</div>
			<div class="header-area cf">
				<?php if(is_front_page()): ?>
					<h1 class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php echo str_replace('\n', '<br>', $options['site_title']); ?><span><?php echo $options['site_slogan']; ?></span></a></h1>
				<?php else: ?>
					<strong class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php echo str_replace('\n', '<br>', $options['site_title']); ?><span><?php echo $options['site_slogan']; ?></span></a></strong>
				<?php endif; ?>
				<?php wp_nav_menu( array(
				'container' => 'nav',
				'menu_id' => 'nav',
				'theme_location' => 'primary_nav',
				)); ?>
			</div>
		</header>
		<div class="main-wrap">