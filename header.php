<!DOCTYPE html>
<html class="no-js no-jswin" <?php language_attributes(); ?>>
<head>
	<meta charset=<?php bloginfo('charset'); ?>>
	<script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
	<title><?php wp_title("|", true, 'right'); ?></title>
	
	<?php wp_head(); ?>
	<meta name = "viewport" content = "user-scalable=no,initial-scale=1.0,maximum-scale=1.0,width=device-width">	
</head>
<body <?php body_class(); ?>>
<div id="skipLinks" class="nav">
	<a href="#content" tabindex="1">Skip to Content</a>
</div>

<div id="pageWrap">
<div id="header" role="banner" class="header">

	<a href="<?php echo home_url(); ?>" id="siteDetails">
	<<?php bigRed_siteTag(); ?> id="siteName"><span></span><?php bloginfo('name'); ?></<?php bigRed_siteTag(); ?>>
	<p id="siteDesc"><span></span><?php bloginfo('description'); ?></p>
	</a>
	
	<?php if (bigRed_option('widget-header')) :?>
	<div id="headerWidgets"><?php
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bigredwidget_header') ) {
			//insert static sidebar
			echo '<!' . '-- no header widgets --' . '>';
		}
	?></div>
	<!-- //#headerWidgets -->
	<?php endif; //bigRed_option('widget-header')
	?>
	

	<?php
	if (bigRed_option('header-menu')) :
		if (function_exists('wp_nav_menu')) {
			wp_nav_menu(array(
					'theme_location' => 'header',
					'container' => 'div',
					'container_id' => 'navWrap',
					'container_class' => 'nav',
					'menu_class' => '',
					'menu_id' => 'nav',
					'depth' => 2,
					'show_home' => 1,
					'fallback_cb' => 'bigRed_listPages'

				));
		}
		else {
			bigRed_listPages();
		}

	endif; //bigRed_option('header-menu')
	?>

	
</div>
<!--//#header -->