<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title(' ', true, 'right'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link media="all" rel="stylesheet" type="text/css" href="<?php echo TDU; ?>/css/jquery.formstyler.css" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
		wp_head(); ?>
	<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.formstyler.min.js" ></script>
	<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.main.js" ></script>
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
							<li><a href="/my-dashboard">My Dashboard</a></li>
							<li><a href="/wp-login.php?action=logout">Logout</a></li>
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
					<h1 class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
				<?php else: ?>
					<strong class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></strong>
				<?php endif; ?>
				<?php wp_nav_menu( array(
				'container' => 'nav',
				'menu_id' => 'nav',
				'theme_location' => 'primary_nav',
				)); ?>
			</div>
		</header>
		<div class="main-wrap">
