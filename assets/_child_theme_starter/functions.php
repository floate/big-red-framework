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
		
		function defineOptions() {
			/* intended to be overridden in child theme */
			$options = &$this->options;
			
			//meta tags in header
			$options['feed_links'] = true; // sitewide and comments feed links. (default: true)
			$options['feed_links_extra'] = true; // archive, post/page comments, etc feed links. (default: true)
			$options['rsd_link'] = true; // desktop editors use this. (default: true)
			$options['wlwmanifest_link'] = true; //windows live writer uses this. (default: true)
			$options['index_rel_link'] = true; // rel tag linking to home_url(). (default: true)
			$options['parent_post_rel_link'] = true; //rel tag link to parent page. (default: true)
			$options['start_post_rel_link'] = true; //rel tag linking to first ever post. (default: true)
			$options['adjacent_posts_rel_link_wp_head'] = true; //next/prev posts. (default: true)
			$options['locale_stylesheet'] = false; //localised stylesheet tag - ltr, rtl. (default: false)
			$options['wp_generator'] = true; //generator meta tag, site & feeds. (default: true)
			$options['wp_shortlink_wp_head'] = true; //show shortlink tag. (default: true)
						
			//general options
			$options['admin_bar'] = true; //show admin_bar. (default: true)
			$options['custom_admin_bar_css'] = false; //use custom css for the admin bar. (default: false)
			$options['remove_capital_P_dangit'] = false; //remove capital_P_dangit filters (default: false)
			
			
			/* theme options*/
			$options['content_width'] = 800; //defaults to 800
			$options['thumbnails'] = false; //post thumbnails (default: false. true/false)
			$options['attachment_page_img_width'] = 600; //defaults to 600
			$options['attachment_page_img_height'] = 600; //defaults to 600
			$options['post-formats'] = false;// (default: false, true = all, array = selected types)
			$options['favicon'] = true; //show favicon meta tags in header (default:true)
			$options['favicon-apple'] = true; //show apple-icon meta tag in header (default: true)
			$options['X-UA-Compatible'] = 'IE=edge'; //ie header verson (default: IE=edge)
			$options['mobile-css-query'] = ''; // default: 'handheld, only screen and (min-device-width : 1px) and (max-device-width : 1024px)';
			$options['viewport-meta-tag'] = false; //adds <meta name = "viewport" to header (default: false)s
			$options['page-comments-enabled'] = true; //default: true 
			$options['trackbacks-enabled'] = true; //default: true;
			$options['max-comment-depth'] = 10; //default: 10
			



			//widget areas. true/false or string. If string that will be the areas english name
			$options['widget-header'] = true;
			$options['widget-footer'] = true;
			$options['widget-sidebar-a'] = true;
			$options['widget-sidebar-b'] = true;
			
			//navigation menus. true/false or string. If string that will be used for the english name
			$options['header-menu'] = true;
			$options['footer-menu'] = true;
			$options['not-found-map'] = true; //on 404 and no search results pages.
			
			// javascript options (these js files can't be queued with conditional comments)
			// currently setup in header.php, need to find a cleaner way.
			$options['js-html5-shiv'] = false; //remy sharp's html5 shiv
			$options['js-selectivizr'] = false; //selectivizr - prevents using CDN for CSS
			$options['ddbelatedpng'] = true; //alpha transparency support for IE6 (default: true)

			//visual editor options
			$options['editor-css'] = true; //custom css for editor (default: true, loads from all css folder if true)
			$options['editor-classes'] = false; //classes in editor style dropdown (default: false/array)
			$options['editor-fake-heading-levels'] = true; //fake editor header level to keep html accessible (default:true)

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
			$child['cssVer'] = '20110606.01';
			$child['jsVer']  = '20110606.01';
			$child['childtheme']  = '20110812.01';
			$child['framework'] = '20110812.01'; // framework version child theme based on - don't change.
			
			$child['jsDependencies'] = array(
				'jquery'
				,'soup-base'
				// ,'fancybox'
				// ,'hashchange'
				,'form-validation'
				// ,'modernizr'
				);
		}

		function setImageSizes() {
			/* intended to be overridden in child theme */
			if ( function_exists( 'set_post_thumbnail_size' ) ) {
				set_post_thumbnail_size( 150, 150, true ); // 150x150 size
			}
			if ( function_exists( 'add_image_size' ) ) {
				
				//set one for the attachment page
				add_image_size(
					$this->options['attachment_page_img_width']
					. 'x' .
					$this->options['attachment_page_img_height'],
					$this->options['attachment_page_img_width'],
					$this->options['attachment_page_img_height']
				);
				
				// add_image_size( '150x150', 150, 150, true); // 150x150 image size
				// add_image_size( '270x150', 270, 150, true ); // 270x150 image size
				// add_image_size( '310x150', 310, 150, true ); // 310x150 image size
				// add_image_size( '310x310', 310, 310, true ); // 310x310 image size
				// add_image_size( '590x400', 590, 400, true ); // 590x400 image size
				// add_image_size( '590', 590, 9999 ); // 590 image size
				// add_image_size( '950', 950, 9999 ); // 950 image size
			}
			
			// config image size to be displayed in attachment-loop
			
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
			
				// wp_enqueue_style('soup-mobile');

				// wp_enqueue_style('soup-print');
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