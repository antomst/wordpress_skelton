<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
	<?php $mxs_options = get_option('mxs_theme_options');?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="header">
		<h1 class="siteName">
		<?php if ($mxs_options['logo_src']!='') { ?>
			<a class="logo_img" href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $mxs_options['logo_src']; ?>" /></a>
		<?php } else { ?>
			<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
		<?php } ?>
		</h1>
		<?php if ( !$mxs_options['desc']) {?>
		<p class="description"><?php bloginfo('description'); ?></p>
		<?php } ?>	
</div><div class="clear"></div>

<div id="globalNavi">
		<?php wp_nav_menu( array( 'show_home' => 'Home','container' => 'globalNavi', 'theme_location' => 'primary') ); ?>
	<?php get_search_form(); ?>
</div><div class="clear"></div>
<div id="content"><div id="outbox">
		<div class="clear"></div>



