<?php global $soup; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class(); ?>>
<head>
	<meta charset=<?php bloginfo('charset'); ?>>
	<title><?php wp_title("|", true, 'right'); ?></title>
	<!--[if IE]><![endif]-->
	
	<?php wp_head(); ?>
		
</head>
<body>
<div id="skipLinks" class="nav">
	<a href="#content">Skip to Content</a>
</div>

<div id="pageWrap">
<div id="header" role="banner" class="header">

	<a href="<?php echo home_url(); ?>" id="siteDetails">
	<<?php echo $soup->siteNameTag; ?> id="siteName"><span></span><?php bloginfo('name'); ?></<?php echo $soup->siteNameTag; ?>>
	<p id="siteDesc"><span></span><?php bloginfo('description'); ?></p>
	</a>
	
	<div id="headerWidgets"><?php
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header') ) {
			//insert static sidebar
			echo '<!' . '-- no header widgets --' . '>';
		}
	?></div>
	<!-- //#headerWidgets -->
	

	<div id="navWrap" class="nav" role="navigation">
		<ul id="nav">
			<?php
				if (function_exists('wp_nav_menu')) {
					wp_nav_menu(array(
							'menu' => 'header',
							'container' => 'ul',
							'container_id' => 'navWrap',
							'menu_class' => '',
							'menu_id' => 'nav',
							'depth' => 2,
							'show_home' => 1,
							'fallback_cb' => array(&$soup,'listPages')

						));
				}
				else {
					$soup->listPages();
				}

			?>
		</ul>		
	</div>

	
</div>
<!--//#header -->