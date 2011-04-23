<?php
/*
Note:
Function file load order:
	1) child
	2) parent
*/


function soup_setupChildThemeClass() {

	Class SoupTheme Extends SoupThemeParent {

		function child__construct() {
			/* intended to be overridden in child theme */
		}

		function defineMinimised() {
			/* intended to be overridden in child theme */
			$this->parent['cssMin'] = false;
			$this->child ['cssMin'] = false;

			$this->parent['jsMin'] = false;
			$this->child ['jsMin'] = false;
		}
		
		function defineChildVersions() {
			/* intended to be overridden in child theme */
			$child = &$this->child;
			$child['cssVer'] = '20110222';
			$child['jsVer']  = '20110222';
			
			$child['jsDependencies'] = array(
				'jquery'
				,'soup-base'
				// ,'prettyPhoto'
				// ,'hashchange'
				,'form-validation'
				// ,'modernizr'
				);
		}

		function defineOptions() {
			/* intended to be overridden in child theme */
			$options = &$this->options;
			
			//meta tags in header
			$options['feed_links'] = false; // sitewide and comments feed links. (default: false)
			$options['feed_links_extra'] = false; // archive, post/page comments, etc feed links. (default: false)
			$options['rsd_link'] = false; // desktop editors use this. (default: false)
			$options['wlwmanifest_link'] = false; //windows live writer uses this. (default: false)
			$options['index_rel_link'] = true; // rel tag linking to home_url(). (default: true)
			$options['parent_post_rel_link'] = false; //rel tag link to parent page. (default: false)
			$options['start_post_rel_link'] = false; //rel tag linking to first ever post. (default: false)
			$options['adjacent_posts_rel_link_wp_head'] = false; //next/prev posts. (default: false)
			$options['locale_stylesheet'] = false; //localised stylesheet tag - ltr, rtl. (default: false)
			$options['wp_generator'] = false; //generator meta tag, site & feeds. (default: false)
			$options['wp_shortlink_wp_head'] = true; //show shortlink tag. (default: true)
						
			//general options
			$options['admin_bar'] = false; //show admin_bar. (default: false)
			$options['custom_admin_bar_css'] = false; //use custom css for the admin bar. (default: false)
			$options['remove_capital_P_dangit'] = true; //remove capital_P_dangit filters (default: true)
			
			
			/* theme options*/
			$options['thumbnails'] = false; //post thumbnails (default: false. true/false)
			$options['post-formats'] = false;// (default: false, true = all, array = selected types)
			$options['favicon'] = true; //show favicon meta tags in header (default:true)
			$options['favicon-apple'] = true; //show apple-icon meta tag in header (default: true)
			$options['X-UA-Compatible'] = 'IE=edge'; //ie header verson (default: IE=edge)
			$this->options['mobile-css-query'] = ''; // default: 'handheld, only screen and (min-device-width : 1px) and (max-device-width : 1024px)';

			//widget areas. true/false or string. If string that will be the areas english name
			$options['widget-header'] = true;
			$options['widget-footer'] = true;
			$options['widget-sidebar-a'] = true;
			$options['widget-sidebar-b'] = true;
			
			//navigation menus. true/false or string. If string that will be used for the english name
			$options['header-menu'] = true;
			$options['footer-menu'] = true;
			
			// javascript options (these js files can't be queued with conditional comments)
			// currently setup in header.php, need to find a cleaner way.
			$options['js-html5-shiv'] = true; //remy sharp's html5 shiv
			$options['js-selectivizr'] = false; //selectivizr - prevents using CDN for CSS
			$options['ddbelatedpng'] = true; //alpha transparency support for IE6 (default: true)

			$options['editor-css'] = true; //custom css for editor (default: true, loads from all css folder if true)
			$options['editor-classes'] = false; //classes in editor style dropdown (default: false/multi dimentional array)
			$options['editor-fake-heading-levels'] = true; //fake editor header level to keep html accessible (default:true)

		}

		function setImageSizes() {
			/* intended to be overridden in child theme */
			if ( function_exists( 'set_post_thumbnail_size' ) ) {
				set_post_thumbnail_size( 150, 150, true ); // 150x150 size
			}
			if ( function_exists( 'add_image_size' ) ) {
				// add_image_size( '150x150', 150, 150, true); // 150x150 image size
				// add_image_size( '270x150', 270, 150, true ); // 270x150 image size
				// add_image_size( '310x150', 310, 150, true ); // 310x150 image size
				// add_image_size( '310x310', 310, 310, true ); // 310x310 image size
				// add_image_size( '590x400', 590, 400, true ); // 590x400 image size
				// add_image_size( '590', 590, 9999 ); // 590 image size
				// add_image_size( '950', 950, 9999 ); // 950 image size
			}
		}

		function registerMoreCssJs() {
			/* intended to be overridden in child theme */
		}
		
		function enqueueCSS() {
			/* intended to be overridden in child theme */
			/* *******************
			 * Don't queue both seperate and combined sheets!
			 * ****************** */
			if (!is_admin()) {
			
			
				wp_enqueue_style('soup-all');
				// wp_enqueue_style('soup-all-ie6');
				// wp_enqueue_style('soup-all-ie7');
				// wp_enqueue_style('soup-all-ie8');
				// wp_enqueue_style('soup-all-ie9');
			
				wp_enqueue_style('soup-mobile');

				wp_enqueue_style('soup-print');
				// wp_enqueue_style('soup-print-ie6');
				// wp_enqueue_style('soup-print-ie7');
				// wp_enqueue_style('soup-print-ie8');
				// wp_enqueue_style('soup-print-ie9');
			
				// wp_enqueue_style('soup-all-media');
				// wp_enqueue_style('soup-all-media-ie6');
				// wp_enqueue_style('soup-all-media-ie7');
				// wp_enqueue_style('soup-all-media-ie8');
				// wp_enqueue_style('soup-all-media-ie9');
			}
			
		}

		function enqueueChildJs(){
			/* intended to be overridden in child theme */
			if (!is_admin()) {
				wp_enqueue_script('custom');
			}
		}
	}

} // function soup_setupChildThemeClass() 


/* 
	need to reverse the order the function.php files usually run in
	parent's function.php needs to run before child's
*/
//add_action('after_setup_theme', 'soup_setupParentThemeClass', 1); //reference: runs in parents's function.php
add_action('after_setup_theme', 'soup_setupChildThemeClass', 2); 
//add_action('after_setup_theme', 'soup_initialiseSoupObject', 3); //reference: runs in parents's function.php


?>