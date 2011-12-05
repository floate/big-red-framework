<?php
/*
Note:
Function file load order:
	1) child
	2) parent
*/


function soup_setupParentThemeClass(){
	Class SoupThemeParent {
		
		public $options;
		public $parent;
		public $child;
		public $headTest;
		public $postAlt;
		public $inlineFooterJSarray;
		public $siteNameTag;
		public $pageNameTag;
		public $searchFormID;
		public $content_width;
		
		
		
		
		/**
	     * PHP 4 Compatible Constructor
	     */
		function SoupThemeParent(){$this->__construct();}
    
	    /**
	     * PHP 5 Constructor
	     */		
		function __construct(){
			$this->parent__construct();
			$this->child__construct();
		}
			
		function parent__construct() {
			$this->postAlt = 0;
			$this->searchFormID = 0;
			$this->definePaths();
			$this->defineChildVersions();
			$this->defineParentVersions();
			$this->defineMinimised();
			$this->defineOptions();
			$this->setupOptions();
			$this->setImageSizes();

			/* javascript and CSS */
			add_action('wp_print_styles', array(&$this,'registerCSS'), 50);
			add_action('wp_print_styles', array(&$this,'registerJS'),  75);
			add_action('wp_print_styles', array(&$this,'registerMoreCssJs'),  100);
			add_action('wp_print_styles', array(&$this,'enqueueCSS'),  125);
			add_action('wp_print_styles', array(&$this,'enqueueChildJs'),  150);
			add_action('wp_print_styles', array(&$this,'enqueueJS'),  175);
			add_filter('script_loader_src', array(&$this, 'removeVersionQstring'));
			add_filter('style_loader_src', array(&$this, 'removeVersionQstring'));
			
			add_action('wp_footer', array(&$this, 'inlineFooterJs'));
			
			/* class filters */
			add_filter('body_class', array(&$this, 'bodyClass'),1, 2);
			add_filter('post_class', array(&$this, 'postClass'),5, 3);

			/* misc filters */
			add_filter('wp_nav_menu', array(&$this, 'filterMenus'));
			add_filter('wp_title', array(&$this, 'filterHtmlTitle'), 10, 2);

			add_action('wp_head', array(&$this, 'setHeaderTags'));
			add_action('wp_footer', array(&$this, 'showQueriesTimer'));
			
			/* formidable filters */
			add_filter('frm_custom_html', array(&$this, 'formidableHtml'), 10, 2);
			add_filter('get_frm_stylesheet', '');
			
			add_filter('the_password_form', array(&$this, 'passwordProtectedForm') );
			
			$this->betterFormShortcodes();
			$this->httpHeaders();
		}
		
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
			$child['jsVer']  = '20111026.01';
			$child['childtheme']  = '20110927.01';
			$child['framework'] = '20110927.01'; // framework version child theme based on - don't change.
			
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
		
		function definePaths(){
			$child = &$this->child;
			$parent = &$this->parent;
			
			$child['url']	   = get_stylesheet_directory_uri();
			$child['assets']   = get_stylesheet_directory_uri() . '/assets/child';
			$child['css']	   = get_stylesheet_directory_uri() . '/assets/child/c';
			$child['js']	   = get_stylesheet_directory_uri() . '/assets/child/j';
			$child['img']	   = get_stylesheet_directory_uri() . '/assets/child/i';
			$child['php']	   = get_stylesheet_directory_uri() . '/assets/child/p';
			$child['phpPath']  = STYLESHEETPATH . '/assets/child/p';

			$parent['url']	   = get_template_directory_uri();
			$parent['assets']  = get_template_directory_uri() . '/assets/parent';
			$parent['css']	   = get_template_directory_uri() . '/assets/parent/c';
			$parent['js']	   = get_template_directory_uri() . '/assets/parent/j';
			$parent['img']	   = get_template_directory_uri() . '/assets/parent/i';
			$parent['php']	   = get_template_directory_uri() . '/assets/parent/p';
			$parent['phpPath'] = TEMPLATEPATH . '/assets/parent/p';

		}

		function defineParentVersions() {
			$parent = &$this->parent;
			$parent['cssVer'] = '20110617.01';
			$parent['jsVer']  = '20111020.01';
			$parent['framework']  = '20110927.01';
		}
				
		function versionCheck($versionNumber = null) {
			$parent = &$this->parent;
			$child = &$this->child;
			if ($versionNumber === null) {
				//doing work around for default so global function works.
				$versionNumber = $child['framework'];
			}
			
			if (isset($parent['framework']) AND isset($child['framework']) AND isset($child['childtheme']) AND ($versionNumber >= $child['framework'])) {
				return true;
			}
			else {
				return false;
			}
		}

		function setupOptions() {
			$options = &$this->options;

			// 1. setup defaults -- needed for bigRed_option()
			if (!isset($options['feed_links'])) {
				 $options['feed_links'] = true; 
			}
			if (!isset($options['feed_links_extra'])) {
				 $options['feed_links_extra'] = true;
			}
			if (!isset($options['rsd_link'])) {
				 $options['rsd_link'] = true; 
			}
			if (!isset($options['wlwmanifest_link'])) {
				 $options['wlwmanifest_link'] = true; 
			}
			if (!isset($options['index_rel_link'])) {
				 $options['index_rel_link'] = true; 
			}
			if (!isset($options['parent_post_rel_link'])) {
				 $options['parent_post_rel_link'] = true; 
			}
			if (!isset($options['start_post_rel_link'])) {
				 $options['start_post_rel_link'] = true; 
			}
			if (!isset($options['adjacent_posts_rel_link_wp_head'])) {
				 $options['adjacent_posts_rel_link_wp_head'] = true; 
			}
			if (!isset($options['locale_stylesheet'])) {
				 $options['locale_stylesheet'] = false; 
			}
			if (!isset($options['wp_generator'])) {
				 $options['wp_generator'] = true; 
			}
			if (!isset($options['wp_shortlink_wp_head'])) {
				 $options['wp_shortlink_wp_head'] = true; 
			}
						
			//general options
			if (!isset($options['admin_bar'])) {
				 $options['admin_bar'] = true; 
			}
			if (!isset($options['custom_admin_bar_css'])) {
				 $options['custom_admin_bar_css'] = false; 
			}
			if (!isset($options['remove_capital_P_dangit'])) {
				 $options['remove_capital_P_dangit'] = false; 
			}
			
			/* theme options*/
			if (!is_int($options['content_width']) OR ($options['content_width'] < 1)) {
				 $options['content_width'] = 800; 
			}
			if (!isset($options['thumbnails'])) {
				 $options['thumbnails'] = false; 
			}
			if (!is_int($options['attachment_page_img_width']) OR ($options['attachment_page_img_width'] < 1)) {
				if ($options['content_width'] >= 600) {
					$options['attachment_page_img_width'] = 600; 
				}
				else {
					$options['attachment_page_img_width'] = $options['content_width']; 
				}
			}
			if (!is_int($options['attachment_page_img_height']) OR ($options['attachment_page_img_height'] < 1)) {
				 $options['attachment_page_img_height'] = 600; 
			}
			if (!isset($options['post-formats'])) {
				 $options['post-formats'] = false;
			}
			if (!isset($options['favicon'])) {
				 $options['favicon'] = true; 
			}
			if (!isset($options['favicon-apple'])) {
				 $options['favicon-apple'] = true; 
			}
			if (trim($options['X-UA-Compatible']) == '') {
				$options['X-UA-Compatible'] = 'IE=edge'; 
			}
			if (trim($options['mobile-css-query']) == '') {
				$options['mobile-css-query'] = 'handheld, only screen and (min-device-width : 1px) and (max-device-width : 1024px)'; 
			}
			if (!isset($options['viewport-meta-tag'])) {
				$options['viewport-meta-tag'] = false;
			}
			if (!isset($options['page-comments-enabled'])) {
				 $options['page-comments-enabled'] = true; 
			}
			if (!isset($options['trackbacks-enabled'])) {
				 $options['trackbacks-enabled'] = true; 
			}
			if ( !is_int($options['max-comment-depth']) ) {
				$options['max-comment-depth'] = 10;
			}




			//2 implement options

			//meta tags in header
			
			if ( (function_exists('add_theme_support')) AND ($options['feed_links'] == true) ) {
				add_theme_support( 'automatic-feed-links' );
			}
			elseif (function_exists('remove_theme_support')) {
				remove_theme_support( 'automatic-feed-links' );
			}
			
			if ($options['feed_links_extra'] == false) {
				remove_action( 'wp_head', 'feed_links_extra', 3 );
			}
			
			if ($options['rsd_link'] == false) {
				remove_action( 'wp_head', 'rsd_link');
			}
			
			if ($options['wlwmanifest_link'] == false) {
				remove_action( 'wp_head', 'rsd_link');
			}
			
			if ($options['index_rel_link'] == false) {
				remove_action( 'wp_head', 'index_rel_link');
			}
			
			if ($options['parent_post_rel_link'] == false) {
				remove_action( 'wp_head', 'parent_post_rel_link', 10, 0);
			}
			
			if ($options['start_post_rel_link'] == false) {
				remove_action( 'wp_head', 'start_post_rel_link', 10, 0);
			}

			if ($options['adjacent_posts_rel_link_wp_head'] == false) {
				remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
			}
			
			if ($options['locale_stylesheet'] == false) {
				remove_action( 'wp_head', 'locale_stylesheet');
			}
			
			if ($options['wp_generator'] == false) {
				remove_action( 'wp_head', 'wp_generator');
				$feeds = array( 
					'rss2_head', 
					'commentsrss2_head', 
					'rss_head', 
					'rdf_header', 
					'atom_head', 
					'comments_atom_head', 
					'opml_head', 
					'app_head' );
				foreach ( $feeds as $action ) {
					remove_action( $action, 'the_generator' );
				}
			}
			
			if ($options['wp_shortlink_wp_head'] == false) {
				remove_action( 'wp_head', 'wp_shortlink_wp_head');
			}
			
			
			if ($options['admin_bar'] == false) {
				//source: http://yoast.com/disable-wp-admin-bar/
				add_filter( 'show_admin_bar', '__return_false' );
				remove_action( 'personal_options', '_admin_bar_preferences' );
			}
			
			//for customised admin bar CSS, see css registrations.

			if ($options['remove_capital_P_dangit'] == true) {
				foreach ( array( 'the_content', 'the_title' ) as $filter ) {
					remove_filter( $filter, 'capital_P_dangit', 11 );
				}
				remove_filter( 'comment_text', 'capital_P_dangit', 31 );
			}
						
			$this->content_width = $options['content_width'];

			if ($options['thumbnails'] == true)  {
				if ( function_exists( 'add_theme_support' ) ) {
					add_theme_support( 'post-thumbnails' );
				}	
			}
			
			if ( ($options['post-formats'] == true) OR (is_array($options['post-formats'])) ) {
				if ( function_exists( 'add_theme_support' ) ) {
					if (!is_array($options['post-formats'])) {
						$options['post-formats'] = array(
							'aside',	'gallery',
							'link',		'image',
							'quote',	'status',
							'video',	'audio',
							'chat');
					}
					add_theme_support( 'post-formats', $options['post-formats'] );
				}
			}

			if ($options['page-comments-enabled'] == false) {
				add_filter( 'comments_open', array(&$this, 'pageCommentsDisabled'), 10, 2 );
			}
			
			if ($options['trackbacks-enabled'] == false) {
				add_filter( 'pings_open', '__return_false' );
			}
			
			if ($options['max-comment-depth'] != 10) {
				add_filter( 'thread_comments_depth_max', array(&$this, 'maxCommentDepthAdmin') );
				add_filter( 'option_thread_comments_depth', array(&$this, 'maxCommentDepthFrontEnd') );
			}

			add_action('wp_head', array(&$this, 'meta_tags')); //sets options meta_tags

			//handheld media query in css registration
		 
			$this->registerSidebars(); //sets up sidebar options
			 
			$this->registerMenus(); //sets up menus
			
			add_action('wp_head', array(&$this, 'html5shiv'), 1); //sets options html5shiv

			add_action('wp_footer', array(&$this, 'selectivizr'), 9); //sets options selectivizr
			
			add_action('wp_footer', array(&$this, 'belatedpng'), 50); //sets up belated png js
			
			if (($options['editor-css'] == true) AND (function_exists('add_editor_style')) ) {
				add_editor_style("assets/child/c/all/editor-style.css");
			}
			
			if (is_array($this->options['editor-classes']) == true) {
				add_filter('mce_buttons_2', array(&$this, 'editorButtons'));
				add_filter('tiny_mce_before_init', array(&$this, 'editorEnglishClasses'));
			}

			if ($options['editor-fake-heading-levels'] == true) {
				add_filter('tiny_mce_before_init', array(&$this, 'editorHeadings'));
			}
						
			
		}

		function editorButtons($buttons){
			array_unshift($buttons, 'styleselect');
			return $buttons;
		}

		function editorEnglishClasses($settings) {
			$classes = $this->options['editor-classes'];

			if ( !empty($settings['theme_advanced_styles']) ) {
				$settings['theme_advanced_styles'] .= ';';
			}
			else {
				$settings['theme_advanced_styles'] = '';
			}
				
			$class_settings = '';
			foreach ( $classes as $name => $value ) {
				$class_settings .= "{$name}={$value};";
			}

			$settings['theme_advanced_styles'] .= trim($class_settings, '; ');
			
			return $settings;
		}
		
		function editorHeadings($settings) {

			if ( !empty($settings['theme_advanced_blockformats']) )
				$settings['theme_advanced_blockformats'] .= ';';
			else
				$settings['theme_advanced_blockformats'] = '';
			
			if (get_post_type() == 'page') {
				$formats = array(
					'Paragraph' => 'p',
					'Address' => 'address',
					'Preformatted' => 'pre',
					'Heading 1' => 'h2',
					'Heading 2' => 'h3',
					'Heading 3' => 'h4',
					'Heading 4' => 'h5',
					'Heading 5' => 'h6'
				);
				
				$settings['body_class'] .= 'page';
			}
			elseif ($this->versionCheck(20110927.01) == false) {			
				$formats = array(
					'Paragraph' => 'p',
					'Address' => 'address',
					'Preformatted' => 'pre',
					'Heading 1' => 'h4',
					'Heading 2' => 'h5',
					'Heading 3' => 'h6'
				);
				$settings['body_class'] .= 'single';
			}
			else {			
				$formats = array(
					'Paragraph' => 'p',
					'Address' => 'address',
					'Preformatted' => 'pre',
					'Heading 1' => 'h3',
					'Heading 2' => 'h4',
					'Heading 3' => 'h5',
					'Heading 4' => 'h6'
				);
				$settings['body_class'] .= 'single';
			}
				
			$format_settings = '';
			foreach ( $formats as $name => $value ) {
				$format_settings .= "{$name}={$value};";
			}

			$settings['theme_advanced_blockformats'] .= trim($format_settings, '; ');
			
			return $settings;
		}

		function registerCSS() {
			$options = &$this->options;
			$parent  = &$this->parent;
			$child   = &$this->child;
			$prot    = is_ssl() ? 'https' : 'http';
			global $wp_scripts,$wp_styles;
			$pce = $pje = $cce = $cje = '';
			if ($parent['cssMin']) {
				$pce = '-min';
			}
			
			if ($parent['jsMin']) {
				$pje = '-min';
			}
			
			if ($child['cssMin']) {
				$cce = '-min';
			}
			if ($child['jsMin']) {
				$cje = '-min';
			}
			
			if ($this->options['mobile-css-query'] == false) {
				$mobStyle = 'handheld, only screen and (min-device-width : 1px) and (max-device-width : 1024px)';
			}
			else {
				$mobStyle = $this->options['mobile-css-query'];
			}
			
			
			
			if ( (isset($options['custom_admin_bar_css'])) AND ($options['custom_admin_bar_css'] == true) ) {
				//default: do not customise
				wp_deregister_style('admin-bar');
				wp_register_style(
					'admin-bar',
					$child['css'] . "/all/admin-bar$cce.css",
					null,
					$child['cssVer']
					);
			}
			
			/* all media type */
			if (!function_exists('mfbfw_defaults')) :
				//defer to plugin
				wp_register_style(
					'fancybox',
					$parent['css'] . "/jq.fancybox$pce.css",
					null,
					'1.3.4'				
					);
			endif; //if (function_exists('mfbfw_defaults')) :
				
			/* combined media types */
			wp_register_style(
				'soup-all-media',
				$child['css'] . "/all-media/all-media$cce.css",
				null,
				$child['cssVer']
				);
		
			wp_register_style(
				'soup-all-media-ie6',
				$child['css'] . "/all-media/all-media-ie6$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie6']->extra['conditional'] = 'IE 6';
	
			wp_register_style(
				'soup-all-media-ie7',
				$child['css'] . "/all-media/all-media-ie7$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie7']->extra['conditional'] = 'IE 7';
	
			wp_register_style(
				'soup-all-media-ie8',
				$child['css'] . "/all-media/all-media-ie8$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie8']->extra['conditional'] = 'IE 8';
	
			wp_register_style(
				'soup-all-media-ie9',
				$child['css'] . "/all-media/all-media-ie9$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie9']->extra['conditional'] = 'IE 9';
			
		
			/* all media type */
			wp_register_style(
				'soup-all',
				$child['css'] . "/all/all$cce.css",
				null,
				$child['cssVer']
				);
		
			wp_register_style(
				'soup-all-ie6',
				$child['css'] . "/all/all-ie6$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie6']->extra['conditional'] = 'IE 6';
	
			wp_register_style(
				'soup-all-ie7',
				$child['css'] . "/all/all-ie7$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie7']->extra['conditional'] = 'IE 7';
	
			wp_register_style(
				'soup-all-ie8',
				$child['css'] . "/all/all-ie8$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie8']->extra['conditional'] = 'IE 8';
	
			wp_register_style(
				'soup-all-ie9',
				$child['css'] . "/all/all-ie9$cce.css",
				null,
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie9']->extra['conditional'] = 'IE 9';





			/* mobile media type */
			wp_register_style(
				'soup-mobile',
				$child['css'] . "/mobile/mobile$cce.css",
				null,
				$child['cssVer'],
				$mobStyle
				);
			


			/* print media type */
			wp_register_style(
				'soup-print',
				$child['css'] . "/print/print$cce.css",
				null,
				$child['cssVer'],
				'print'
				);

			wp_register_style(
				'soup-print-ie6',
				$child['css'] . "/print/print-ie6$cce.css",
				null,
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie6']->extra['conditional'] = 'IE 6';

			wp_register_style(
				'soup-print-ie7',
				$child['css'] . "/print/print-ie7$cce.css",
				null,
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie7']->extra['conditional'] = 'IE 7';

			wp_register_style(
				'soup-print-ie8',
				$child['css'] . "/print/print-ie8$cce.css",
				null,
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie8']->extra['conditional'] = 'IE 8';

			wp_register_style(
				'soup-print-ie9',
				$child['css'] . "/print/print-ie9$cce.css",
				null,
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie9']->extra['conditional'] = 'IE 9';



			//use own form styles for grunion plugin
			wp_deregister_style('grunion.css');
		}

		function registerJS() {
			$options = &$this->options;
			$parent  = &$this->parent;
			$child   = &$this->child;
			$prot    = is_ssl() ? 'https' : 'http';
			$pce = $pje = $cce = $cje = '';
			global $wp_scripts,$wp_styles;
			if ($parent['cssMin']) {
				$pce = '-min';
			}
			
			if ($parent['jsMin']) {
				$pje = '-min';
				$validatorURL = "$prot://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js";
			}
			else {
				$validatorURL = "$prot://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.js";
			}
			
			if ($child['cssMin']) {
				$cce = '-min';
			}
			if ($child['jsMin']) {
				$cje = '-min';
			}
			
			wp_register_script(
				'soup-base',
				$this->parent['js'] . "/base$pje.js",
				array('jquery'),
				$this->parent['jsVer'],
				true
			);
			
			$current_url = untrailingslashit( "$prot://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
			$current_url = esc_url($current_url);
			wp_localize_script('soup-base', 'SOUPGIANT_wpURLS', array(
				'register' => site_url('wp-login.php?action=register', 'login'),
				'regoEnabled' => get_option('users_can_register') ? "y" : "n",
				'lostpassword' => wp_lostpassword_url( $current_url ),
				'loginsubmit' => site_url( 'wp-login.php', 'login' ),
				'currentURL' => $current_url,
				// 'childAssets' => $child['assets'],
				'childCSS' => get_stylesheet_uri(),
				'parentCSS' => get_template_directory_uri() . '/style.css'
			));
			
			/* jQuery plugins */
			wp_register_script(
				'form-validation',
				$validatorURL,
				array('jquery'),
				'1.7',
				true
			);
		
		
			if (!function_exists('mfbfw_defaults')) :
				//defer to plugin
				wp_register_script(
					'fancybox',
					$parent['js'] . "/jq.fancybox$pce.js",
					array('jquery'),
					'1.3.4a',
					true				
					);
			endif; //if (function_exists('mfbfw_defaults')) :		
		
		
			wp_register_script(
				'hashchange',
				$this->parent['js'] . "/jq.ba-hashchange$pje.js",
				array('jquery'),
				'1.3',
				true
			);

			wp_register_script(
				'modernizr',
				$this->parent['js'] . "/modernizr$pje.js",
				null,
				'2.0.4',
				false
			);

			wp_register_script(
				'custom',
				$child['js'] . "/custom$cje.js",
				$child['jsDependencies'],
				$child['jsVer'],
				true
			);
			
			wp_register_script(
				'webfont-loader',
				"$prot://ajax.googleapis.com/ajax/libs/webfont/1.0.22/webfont.js",
				null,
				'1.0.22'
			);
			
		}

		function enqueueJS() {
			/* this just cleans up JS enqueing and applies any applicable combo packs */
			global $wp_scripts;
			
			
			if (wp_script_is('custom') == true) {
				foreach ($this->child['jsDependencies'] as $handle) {
					wp_enqueue_script($handle);
				}
			}
			
		
			if (wp_script_is('fancybox') == true) {
				wp_enqueue_style('fancybox');
			}
			
			if ( (wp_script_is('fancybox') == true) AND (wp_script_is('hashchange') == true) ) {
				//use single combo file
				$pje = '';
				if ($this->parent['jsMin']) {
					$pje = '-min';
				}
				
				$comboVer .= $wp_scripts->registered['fancybox']->ver;
				$comboVer .= '-';
				$comboVer .= $wp_scripts->registered['hashchange']->ver;
				
				$wp_scripts->registered['fancybox']->src = $this->parent['js'] . "/jq.fancybox.hashchange$pje.js";
				$wp_scripts->registered['fancybox']->ver = $comboVer;
				$wp_scripts->registered['hashchange']->src = '';
			}
			
			/* threaded comments */
			if ((!is_admin()) AND is_singular() AND comments_open() AND get_option('thread_comments') ) {
				wp_enqueue_script( 'comment-reply' );
			}
			
		}

		function httpHeaders(){
			$options = &$this->options;
			if (!is_admin()):

			if ($options['X-UA-Compatible']) {
				header('X-UA-Compatible: ' . $options['X-UA-Compatible']);
			}
			
			endif; //if (!is_admin()):			
		}

		function meta_tags(){
			$options = &$this->options;
			$result = "";
			
			if (!is_admin()):
				//double up IE header w/ meta tag to cover caching
				if ($options['X-UA-Compatible'] == true) {
					$result .= '<meta http-equiv="X-UA-Compatible" content="';
					$result .= $options['X-UA-Compatible'];
					$result .= '" />' . "\n";
				}
				
				if ($options['viewport-meta-tag'] == true) {
					$result .= '<meta name="viewport" content="';
					$result .= 'user-scalable=no,initial-scale=1.0,maximum-scale=1.0,width=device-width';
					$result .= '" />' . "\n";
				}				
			
				if ($options['favicon'] == true) { 
					$result .= '<link rel="shortcut icon" type="image/x-icon" href="';
					$result .= $this->child['img'];
					$result .= '/favicon.ico" />' . "\n";
					$result .= '<link rel="icon" type="image/x-icon" href="';
					$result .= $this->child['img'];
					$result .= '/favicon.ico" />' . "\n";		
				}
			
				if ($options['favicon-apple'] == true) {
					$result .= '<link rel="apple-touch-icon" href="';
					$result .= $this->child['img'];
					$result .= '/apple-touch-icon.png" />' . "\n";
				}
			endif; //if (!is_admin()):			
					
			echo $result;
			return;		
		}

		function html5shiv() {
			$options = &$this->options;
			$parent  = &$this->parent;
			
			
			$result = "";
			//not needed if modenizr included
			if ( ($options['js-html5-shiv'] == true) AND (!in_array('modernizr',  $this->child['jsDependencies'])) ):
				$result .= '<!--[if lt IE 9]>';
				$result .= '<script src="';
				$result .= $parent['js'];
				$result .= '/html5shiv.js"></script>';
				$result .= '<![endif]-->' . "\n";
			endif; // ($options['js-html5-shiv'] == true) ... :
			echo $result;
		}
		
		function selectivizr() {
			$options = &$this->options;
			$parent  = &$this->parent;
			$result = $pjs = "";
			if ($this->parent['jsMin'] == true) {
				$pjs = '-min';
			}
			
			if ($options['js-selectivizr'] == true) :
				$result .= '<!--[if lt IE 9]>';
				if (wp_script_is('jquery') == false) :
					
					$result .= '<script src="';
					$result .= "//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.4$pjs.js";
					$result .= '"></script>';
					
				endif;
				$result .= '<script src="';
				$result .= $parent['js'];
				$result .= "/selectivizr$pjs.js?ver=1.0.2\"></script>";
				$result .= '<![endif]-->' . "\n";
			endif; // $options['js-selectivizr'] == true :
			echo $result;
		}
		
		function registerSidebars() {
			$options = &$this->options;
			
			if ( function_exists('register_sidebar') ) {
			
				if ($options['widget-header']) {
					if (!is_string($options['widget-header'])) {
						$options['widget-header'] = 'Header';
					}
					register_sidebar(array(
						'name' => $options['widget-header'],
						'id' => 'bigredwidget_header',
						'before_widget' => '<div id="%1$s" class="head-widget widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>'
					));
				}

				if ($options['widget-sidebar-a']) {
					if (!is_string($options['widget-sidebar-a'])) {
						$options['widget-sidebar-a'] = 'Sidebar A';
					}
					register_sidebar(array(
						'name' => $options['widget-sidebar-a'],
						'id' => 'bigredwidget_sidebar-a',
						'before_widget' => '<div id="%1$s" class="widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>' 
					));
				}
			
				if ($options['widget-sidebar-b']) {
					if (!is_string($options['widget-sidebar-b'])) {
						$options['widget-sidebar-b'] = 'Sidebar B';
					}
					register_sidebar(array(
						'name' => $options['widget-sidebar-b'],
						'id' => 'bigredwidget_sidebar-b',
						'before_widget' => '<div id="%1$s" class="widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>' 
					));
				}

				if ($options['widget-footer']) {
					if (!is_string($options['widget-footer'])) {
						$options['widget-footer'] = 'Footer';
					}
					register_sidebar(array(
						'name' => $options['widget-footer'],
						'id' => 'bigredwidget_footer',
						'before_widget' => '<div id="%1$s" class="foot-widget widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>' 
					));
				}

			}
			return;
		}
		
		function registerMenus() {
			$options = &$this->options;
			if ( function_exists('register_nav_menus') ) {
				if ($options['header-menu']) {
					if (!is_string($options['header-menu'])) {
						$options['header-menu'] = 'Header Navigation';
					}
					$menus['header'] = $options['header-menu'];
				}

				if ($options['footer-menu']) {
					if (!is_string($options['footer-menu'])) {
						$options['footer-menu'] = 'Footer Navigation';
					}
					$menus['footer'] = $options['footer-menu'];
				}
				
				if ($options['not-found-map']) {
					if (!is_string($options['not-found-map'])) {
						$options['not-found-map'] = 'Not found sitemap';
					}
					$menus['not-found'] = $options['not-found-map'];
				}
				
				register_nav_menus( $menus );
			}
		}

		function filterMenus($menu) {
			$menu = str_replace('current_page_item', 'on active current_page_item', $menu);
			$menu = str_replace('current-page-ancestor', 'on active current-page-ancestor', $menu);
			$menu = str_replace('current_page_parent', 'on active current_page_parent', $menu);
			return $menu;
		}

		function setHeaderTags() {
			if (is_front_page()){
				$this->siteNameTag = 'h1';
				$this->pageNameTag = 'h2';
			}
			else {
				$this->siteNameTag = 'p';
				$this->pageNameTag = 'h1';
			}
		}

		function listPages($args = ''){
			/* similar to wp_list_pages with a number of changes
				- 'on active' classes added to current tree, eg class="on active current_page_ancestor etc"
				- able to show home page
			*/
			$defaults = array(
				'date_format' => get_option('date_format'),
				'image_replacement' => 0,
				'echo' => 1,
				'depth' => 2, 
				'show_date' => '',
				'child_of' => 0, 
				'exclude' => '',
				'title_li' => '', 
				'show_home' => 1,
				'authors' => '', 
				'sort_column' => 'menu_order, post_title',
				'link_before' => '', 
				'link_after' => '',
				'container' => 'div', 
				'container_class' => 'nav',
				'container_id' => '',
				'menu_class' => '',
				'menu_id' => ''
			);

			$r = wp_parse_args($args, $defaults);

			$menu = '';
			$menu .= '<' . $r['container'] . ' id="' . $r['container_id'] . '" class="' . $r['container_class'] . '">';
			
			if ($r['container'] != 'ul') {
				$menu .= '<ul id="' . $r['menu_id'] . '" class="' . $r['menu_class'] . '">';
			}

			// Show Home in the menu
			if ( isset($r['show_home']) && ! empty($r['show_home']) ) {
				if ( true === $r['show_home'] || '1' === $r['show_home'] || 1 === $r['show_home'] )
					$text = 'Home';
				else
					$text = $r['show_home'];
				$class = 'class="page_item page-item-home"';
				if ( is_front_page() && !is_paged() )
					$class = 'class="page_item page-item-home current_page_item"';
				$menu .= '<li ' . $class . '><a href="' . home_url() . '">' . $r['link_before'] . $text . $r['link_after'] . '</a></li>';
				// If the front page is a page, add it to the exclude list
				if (get_option('show_on_front') == 'page') {
					if ( !empty( $list_args['exclude'] ) ) {
						$list_args['exclude'] .= ',';
					} else {
						$list_args['exclude'] = '';
					}
					$list_args['exclude'] .= get_option('page_on_front');
				}
			}



			$list_args = $r;
			$list_args['echo'] = 0;
			$menu .= wp_list_pages($list_args);
			$menu = str_replace('current_page_item', 'on active current_page_item', $menu);
			$menu = str_replace('current_page_ancestor', 'on active current_page_ancestor', $menu);

			if ($r['container'] != 'ul') {
				$menu .= '</ul>';
			}
			$menu .= '</' . $r['container'] . '>';
			
			
			if ( $r['echo'] )
				echo $menu;
			else
				return $menu;	
		}

		function tagArchiveTitle() {
			//source: Thematic theme
			//if multiple tags are searched, display them correctly on the tag archive page
			static $nice_tag_query_result;

			if ($nice_tag_query_result) {
				echo $nice_tag_query_result;
				return;
			}
			else {
				$nice_tag_query = get_query_var('tag'); // tags in current query
				$nice_tag_query = str_replace(' ', '+', $nice_tag_query); // get_query_var returns ' ' for AND, replace by +
				$tag_slugs = preg_split('%[,+]%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of tag slugs
				$tag_ops = preg_split('%[^,+]*%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of operators

				$tag_ops_counter = 0;
				$nice_tag_query = '';

				if (count($tag_slugs) > 1) {
					foreach ($tag_slugs as $tag_slug) { 
						$tag = get_term_by('slug', $tag_slug ,'post_tag');
						// prettify tag operator, if any
						if ($tag_ops[$tag_ops_counter] == ',') {
							$tag_ops[$tag_ops_counter] = ', ';
						} elseif ($tag_ops[$tag_ops_counter] == '+') {
							$tag_ops[$tag_ops_counter] = ' + ';
						}
						// concatenate display name and prettified operators
						$nice_tag_query = $nice_tag_query.$tag->name.$tag_ops[$tag_ops_counter];
						$tag_ops_counter += 1;
					}
					$nice_tag_query_result = $nice_tag_query;
				}
				else {
					$nice_tag_query_result = single_tag_title('',false);
				}

				echo $nice_tag_query_result;
			}
		}

		function filterHtmlTitle($title, $separator){
			/* Don't do this if common SEO plugins are enabled */
			if ( class_exists('All_in_One_SEO_Pack') || class_exists('WPSEO_Frontend') ) {
				return $title;
			}
			
			//write out the html title, format similar to All In One SEO
			// SOURCE: twentyten theme
			if (is_feed()){
				return $title;
			}
			
			// The $paged global variable contains the page number of a listing of posts.
			// The $page global variable contains the page number of a single post that is paged.
			// We'll display whichever one applies, if we're not looking at the first page.
			global $paged, $page;

			if ( is_search() ) {
				// If we're a search, let's start over:
				$title = 'Search results for ' . get_search_query();
				// Add a page number if we're on page 2 or more:
				if ( $paged >= 2 )
					$title .= " $separator Page $paged";
				// Add the site name to the end:
				$title .= " $separator " . get_bloginfo( 'name', 'display' );
				// We're done. Let's send the new title back to wp_title():
				return $title;
			}
			
			if (is_404()) {
				//rewite request as words, as w/ all in one seo
				$request = htmlspecialchars($_SERVER['REQUEST_URI']);
				$request = str_replace('.html', ' ', $request);
				$request = str_replace('.htm', ' ', $request);
				$request = str_replace('.', ' ', $request);
				$request = str_replace('/', ' ', $request);
				$request_a = explode(' ', $request);
				$request_new = array();
				foreach ($request_a as $token) {
					$request_new[] = ucwords(trim($token));
				}
				$request = implode(' ', $request_new);
				
				$title = "Nothing found for $request $separator ";
			}
			
			if ( is_date() ) {
				if (is_day()) {
					$title = get_the_time(get_option('date_format')) . " $separator ";
				}
				elseif (is_month()) {
					$title = get_the_time('F Y') . " $separator ";
				}
				elseif (is_year()) {
					$title = get_the_time('Y') . " $separator ";
				}
				
			}

			// Otherwise, let's start by adding the site name to the end:
			$title .= get_bloginfo( 'name', 'display' );

			// If we have a site description and we're on the home/front page, add the description:
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) {
				$title .= " $separator " . $site_description;
			}

			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				$title .= " $separator Page " . max( $paged, $page ) ;

			// Return the new title to wp_title():
			return $title;
		}
		
		function removeVersionQstring($src){
			if ( preg_match( '/ajax\.googleapis\.com\/|ajax\.aspnetcdn\.com\/|ajax\.microsoft\.com\//', $src ) )
				$src = remove_query_arg('ver',$src);
			return $src;
		}

		function bodyClass($classes, $class = null) {
			global $wp_query, $current_user, $wpdb;

			if (is_home() OR is_archive()) {
				$classes[] = 'all_blog';
				$classes[] = 'list';
			}
			if (is_search()) {
				$classes[] = 'list';
			}
			if (is_singular()) {
				$classes[] = 'singular';
			}
			
			if (is_single()) {
				$post_id = $wp_query->get_queried_object_id();
				$post = $wp_query->get_queried_object();
				$postSlug = $wp_query->post->post_name;

				$classes[] = 'all_blog';
				
				$classes[] = 'postslug-' . sanitize_html_class($postSlug);
				
				if ( $cats = get_the_category() ) {
					foreach ( $cats as $cat ) {
						$classes[] = 'postcat-' . sanitize_html_class($cat->slug);
					}
				}
				
				if ( $tags = get_the_tags() ) {
					foreach ( $tags as $tag ) {
						$classes[] = 'posttag-' . sanitize_html_class($tag->slug);
					}
				}
				
				if (function_exists('get_terms')) {
					$post_taxonomies = get_taxonomies(array('_builtin' => false));
					$post_terms = wp_get_object_terms($post->ID, $post_taxonomies);
					foreach ($post_terms as $term) {
						$classes[] = 'postterm-' . sanitize_html_class($term->taxonomy . '-' . $term->slug);
					}
				}
			}
			elseif ( is_page() ) {
				$pageID = $wp_query->post->ID;
				$pageSlug = $wp_query->post->post_name;
				$post = get_page($pageID);
				
				$classes[] = 'pageslug-' . sanitize_html_class($pageSlug);
				$classes[] = 'pagetree-' . sanitize_html_class($pageSlug);
				$classes[] = 'pagetree-' . sanitize_html_class($pageID);
				
				if (!is_page_template()) {
					//add .page-template-default (bug in 3.2)
					
					//remove first for when bug has been fixed
					$classes = array_diff($classes, array('page-template-default'));
					//and add it back in
					$classes[] = 'page-template-default';	
				}
				
				$tree = get_post_ancestors($post);
				foreach ($tree as $tree_id) {
					$classes[] = 'pagetree-' . $tree_id;
					$classes[] = 'pagetree-' . sanitize_html_class(basename(get_permalink($tree_id)));
				}
			}
			
			return $classes;
		}
		
		function postClass($classes, $class = null, $post_id = null) {
			$postAlt = &$this->postAlt;
			$postAlt++;
			$classes[] = 'p' . $postAlt;
			$postAlt % 2 ? null : $classes[] = 'alt';
			$classes[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author()));
			
			$classes[] = get_the_tags() ? null : 'untagged';

			return $classes;
		}

		function searchFormID() {
			return $this->searchFormID++;
		}

		function belatedpng() {
			$options = &$this->options;
			$parent  = &$this->parent;
			if ($this->parent['jsMin'] == true) {
				$pjs = '-min';
			}
			else {
				$pjs = '';
			}
			
			if ($options['ddbelatedpng'] == true) :
				$result = "";
				$result .= '<!--[if IE 6]>';
				$result .= '<script src="';
				$result .= $parent['js'];
				$result .= "/ddbelatedpng$pjs.js\"></script>\n";
				
				$result .= "<script>\n";
				$result .= "/* <![CDATA[ */\n";
				$result .= 'if(typeof jQuery=="function")';
				$result .= "{jQuery(window).ready(function(){DD_belatedPNG.fix('img');});}";
				$result .= "else{DD_belatedPNG.fix('img');}\n";
				$result .= "/* ]]> */\n";
				$result .= '</script>';				
				$result .= '<![endif]-->' . "\n";
			endif; // $options['ddbelatedpng'] == true :
			echo $result;
		}

		function inlineFooterJs(){
			$showJs = false;
			$outputJs = '<script>var SOUPGIANT=SOUPGIANT||{};';
			if (is_array($this->inlineFooterJSarray)) {
				foreach ($this->inlineFooterJSarray as $js) {
					$showJs = true;
					$outputJs .= $js;
				}
			}
			$outputJs .= '</script>';
			if ($showJs) {
				echo $outputJs;
			}
		}

		function jsString($string){
			//takes a string and converts it for output to Javascript (escaped chars, etc)
		    return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/', ';'=>'\\;'));
		}

		function showQueriesTimer(){
			if (current_user_can('update_themes')) :
				?>
				<script type="text/javascript">
				/* <![CDATA[ */
					if (typeof console == "object") {
						console.log('queries: <?php echo get_num_queries(); ?>');
						console.log('<?php timer_stop(1); ?> seconds');
					}
				/* ]]> */
				</script>
				<?php
			endif;
		}

		function commentTemplate($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment;
			$GLOBALS['comment_depth'] = $depth;
			?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<div class="comment-head">
					<p class="comment-author vcard">
						<?php 
							if ($args['avatar_size'] != 0) {
								echo get_avatar($comment, $args['avatar_size']); 
							}
						?>
						<cite class="fn"><?php comment_author_link(); ?></cite> <span class="says">says:</span>
					</p>
					<p class="comment-meta">
						<a href="#comment-<?php comment_ID(); ?>" class="time"><time datetime="<?php comment_date('c') ?>" pubdate class="entry-date"><?php comment_date(); ?> at <?php comment_time(); ?></time></a>

						<?php edit_comment_link('(Edit)', ' <span class="comment-edit-link">', '</span>' ); ?>
					</p>
				</div>

				<div class="comment-body" id="c-body-<?php comment_ID(); ?>">
					<?php 

					if ($comment->comment_approved == '0') {
						echo '<p class="comment-moderation">Your comment is awaiting moderation.</p>';
					}
					comment_text(); 
					?>

				<?php // echo the comment reply link with help from Justin Tadlock http://justintadlock.com/ and Will Norris http://willnorris.com/
					if($args['type'] == 'all' || get_comment_type() == 'comment') :
						comment_reply_link(array_merge($args, array(
							'reply_text' => 'Reply to this comment', 
							'login_text' => 'Log in to reply.',
							'depth' => $depth,
							'before' => '<div class="reply">', 
							'after' => '</div>',
							'add_below' => 'c-body'
						)));
					endif;
				?>
				</div>
				<?php
		}
		
		function pingTemplate($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment;
			$GLOBALS['comment_depth'] = $depth;
			?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<div class="comment-head">
					<p class="comment-author">
						<?php comment_author_link(); ?>
					</p>
					<p class="comment-meta">
						<a href="#comment-<?php comment_ID(); ?>"><?php comment_date(); ?> at <?php comment_time(); ?></a>

						<?php edit_comment_link('(Edit)', ' <span class="comment-edit-link">', '</span>' ); ?>
					</p>
				</div>

				<?php
		}

		function pageCommentsDisabled($open,$post_id) {
			if (get_post_type($post_id) == 'page') {
				$open = false;
			}
			return $open;
		}
		
		function maxCommentDepthFrontEnd($depth) {
			$maxDepth = $this->options['max-comment-depth'];
			if ($depth > $maxDepth) {
				$depth = $maxDepth;
			}
			return $depth;
		}
		
		function maxCommentDepthAdmin($depth) {
			return (int) $this->options['max-comment-depth'];
		}
		
		/* === Grunion Contact Form === 
		   fix up front end code output by
		   this plugin by replacing shortcodes
		*/
		function betterFormShortcodes() {
			if (function_exists('contact_form_shortcode') 
				AND function_exists('contact_form_init') 
				AND function_exists('contact_form_field')) {
				
				remove_shortcode('contact-form');
				add_shortcode('contact-form', array(&$this, 'contact_form_shortcode') );
				
				remove_shortcode('contact-field');
				add_shortcode('contact-field', array(&$this, 'contact_form_field') );
				
			}
		}
		
		function contact_form_shortcode( $atts, $content ) {
			global $post;
			
			$content = str_replace("<br />\n", "\n", $content);

			$default_to = get_option( 'admin_email' );
			$default_subject = "[" . get_option( 'blogname' ) . "]";

			if ( !empty( $atts['widget'] ) && $atts['widget'] ) {
				$default_subject .=  " Sidebar";
			} elseif ( $post->ID ) {
				$default_subject .= " ". wp_kses( $post->post_title, array() );
				$post_author = get_userdata( $post->post_author );
				$default_to = $post_author->user_email;
			}

			extract( shortcode_atts( array(
				'to' => $default_to,
				'subject' => $default_subject,
				'show_subject' => 'no', // only used in back-compat mode
				'widget' => 0 //This is not exposed to the user. Works with contact_form_widget_atts
			), $atts ) );

			 $widget = esc_attr( $widget );

			if ( ( function_exists( 'faux_faux' ) && faux_faux() ) || is_feed() )
				return '[contact-form]';

			global $wp_query, $grunion_form, $contact_form_errors, $contact_form_values, $user_identity, $contact_form_last_id, $contact_form_message;

			// used to store attributes, configuration etc for access by contact-field shortcodes
			$grunion_form = new stdClass();
			$grunion_form->to = $to;
			$grunion_form->subject = $subject;
			$grunion_form->show_subject = $show_subject;

			if ( $widget )
				$id = 'widget-' . $widget;
			elseif ( is_singular() )
				$id = $wp_query->get_queried_object_id();
			else
				$id = $GLOBALS['post']->ID;
			if ( !$id ) // something terrible has happened
				return '[contact-form]';

			if ( $id == $contact_form_last_id )
				return;
			else
				$contact_form_last_id = $id;

			$body = contact_form_parse( $content );

			$r = "<div id='contact-form-$id'>\n";

			/*
			$errors = array();
			if ( is_wp_error( $contact_form_errors ) && $errors = (array) $contact_form_errors->get_error_codes() ) {
				$r .= "<div class='form-error'>\n<h3>" . __( 'Error!' ) . "</h3>\n<ul class='form-errors'>\n";
				foreach ( $contact_form_errors->get_error_messages() as $message )
					$r .= "\t<li class='form-error-message' style='color: red;'>$message</li>\n";
				$r .= "</ul>\n</div>\n\n";
			}
			*/

			$r .= "<form action='#contact-form-$id' method='post' class='grunion'>\n";
			$r .= $body;
			$r .= "\t<p class='submit'>\n";
			$r .= "\t\t<input type='submit' value='" . __( "Submit &#187;" ) . "' />\n";
			$r .= "\t\t" . wp_nonce_field( 'contact-form_' . $id , "_wpnonce", true, false) . "\n";
			$r .= "\t\t<input type='hidden' name='contact-form-id' value='$id' />\n";
			$r .= "\t</p>\n";
			$r .= "</form>\n</div>";

			// form wasn't submitted, just a GET
			if ( empty($_POST) )
				return $r;


			if ( is_wp_error($contact_form_errors) )
				return $r;


			$emails = str_replace( ' ', '', $to );
			$emails = explode( ',', $emails );
			foreach ( (array) $emails as $email ) {
				if ( is_email( $email ) && ( !function_exists( 'is_email_address_unsafe' ) || !is_email_address_unsafe( $email ) ) )
					$valid_emails[] = $email;
			}

			$to = ( $valid_emails ) ? $valid_emails : $default_to;

			$message_sent = contact_form_send_message( $to, $subject, $widget );

			if ( is_array( $contact_form_values ) )
				extract( $contact_form_values );

			if ( !isset( $comment_content ) )
				$comment_content = '';
			else
				$comment_content = wp_kses( $comment_content, array() );


			$r = "<div id='contact-form-$id'>\n";

			$errors = array();
			if ( is_wp_error( $contact_form_errors ) && $errors = (array) $contact_form_errors->get_error_codes() ) :
				$r .= "<div class='form-error'>\n<h3>" . __( 'Error!' ) . "</h3>\n<p>\n";
				foreach ( $contact_form_errors->get_error_messages() as $message )
					$r .= "\t$message<br />\n";
				$r .= "</p>\n</div>\n\n";
			else :
				$r .= "<h3>" . __( 'Message Sent' ) . "</h3>\n\n";
				$r .= wp_kses($contact_form_message, array('br' => array(), 'blockquote' => array())) . "</div>";

				// Reset for multiple contact forms. Hacky
				$contact_form_values['comment_content'] = '';

				return $r;
			endif;

			return $r;
		}
		
		function contact_form_field( $atts, $content, $tag ) {
			global $contact_form_fields, $contact_form_last_id, $grunion_form;

			$field = shortcode_atts( array(
				'label' => null,
				'type' => 'text',
				'required' => false,
				'options' => array(),
				'id' => null,
				'default' => null,
			), $atts);

			// special default for subject field
			if ( $field['type'] == 'subject' && is_null($field['default']) )
				$field['default'] = $grunion_form->subject;

			// allow required=1 or required=true
			if ( $field['required'] == '1' || strtolower($field['required']) == 'true' )
				$field['required'] = true;
			else
				$field['required'] = false;

			// parse out comma-separated options list
			if ( !empty($field['options']) && is_string($field['options']) )
				$field['options'] = array_map('trim', explode(',', $field['options']));

			// make a unique field ID based on the label, with an incrementing number if needed to avoid clashes
			$id = $field['id'];
			if ( empty($id) ) {
				$id = sanitize_title_with_dashes( $contact_form_last_id . '-' . $field['label'] );
				$i = 0;
				while ( isset( $contact_form_fields[ $id ] ) ) {
					$i++;
					$id = sanitize_title_with_dashes( $contact_form_last_id . '-' . $field['label'] . '-' . $i );
				}
				$field['id'] = $id;
			}

			$contact_form_fields[ $id ] = $field;

			if ( $_POST )
				contact_form_validate_field( $field );

			return $this->contact_form_render_field( $field );
		}
		
		function contact_form_render_field( $field ) {
			global $contact_form_last_id, $contact_form_errors, $contact_form_fields, $current_user, $user_identity;

			$r = '';

			$field_id = $field['id'];
			if ( isset($_POST[ $field_id ]) ) {
				$field_value = stripslashes( $_POST[ $field_id ] );
			} elseif ( is_user_logged_in() ) {
				// Special defaults for logged-in users
				if ( $field['type'] == 'email' )
					$field_value = $current_user->data->user_email;
				elseif ( $field['type'] == 'name' )
					$field_value = $user_identity;
				elseif ( $field['type'] == 'url' )
					$field_value = $current_user->data->user_url;
				else
					$field_value = $field['default'];
			} else {
				$field_value = $field['default'];
			}

			$field_value = wp_kses($field_value, array());

			$field['label'] = html_entity_decode( $field['label'] );
			$field['label'] = wp_kses( $field['label'], array() );
			
			//from here down, field type name can be treated as text
			if ($field['type'] == 'name') {
				$field['type'] = 'text';
			}
			
			/* types
			
			- select -- done
			- radio -- done
			- textarea -- done

			- checkbox

			- url
			- email
			- text
			
			*/
			$fieldClass = '';
			switch ($field['type']) {
				case 'textarea':
					//massive exception here
								
					$r .= "\n";
					$r .= '<div class="set">' . "\n";
					$r .= "\t" . '<label for="grunion-'.esc_attr($field_id).'">';
					$r .= htmlspecialchars( $field['label'] );
					if ($field['required']) {
						$r .= ' <span class="frm_required">*</span> ';
					}
					// $r .= "&nbsp;";
					if (contact_form_is_error($field_id)) {
						$r .= '<span htmlfor="grunion-'.esc_attr($field_id).'" generated="true" class="error">';
						$r .= 'This field is required.';
						$r .= '</span>';
						$fieldClass .= ' error';
					}				
					$r .= '</label>' . "\n";
					$r .= "\t" . '<textarea name="'.esc_attr($field_id).'" id="grunion-'.esc_attr($field_id).'" ';
					if ($field['required']) {
						$r .= 'required="required" ';
						$fieldClass .= ' required';
					}
					$r .= 'class="' . trim($fieldClass) . '">'.htmlspecialchars($field_value).'</textarea>' . "\n";
					$r .= '</div>' . "\n";
				break; //textarea
				
				case 'select':
					$r .= "\n";
					$r .= '<div class="set">' . "\n";
					$r .= "\t" . '<label for="grunion-'.esc_attr($field_id).'">';
					$r .= htmlspecialchars( $field['label'] );
					if ($field['required']) {
						$r .= ' <span class="frm_required">*</span> ';
					}
					// $r .= "&nbsp;";
					if (contact_form_is_error($field_id)) {
						$r .= '<span htmlfor="grunion-'.esc_attr($field_id).'" generated="true" class="error">';
						$r .= 'This field is required.';
						$r .= '</span>';
						$fieldClass .= ' error';
					}				
					$r .= '</label>' . "\n";
					$r .= "\t" . '<select name="'.esc_attr($field_id).'" id="grunion-'.esc_attr($field_id).'" ';
					if ($field['required']) {
						$r .= 'required="required" ';
						$fieldClass .= ' required';
					}
					$r .= 'class="' . trim($fieldClass) . '">' . "\n";
					foreach ( $field['options'] as $option ) {
						$option = html_entity_decode( $option );
						$option = wp_kses( $option, array() );
						$r .= "\t\t" . '<option'.( $option == $field_value ? ' selected="selected"' : '').'>';
						$r .= esc_html( $option ) .'</option>' . "\n";
					}
					$r .= "\t" . '</select>' . "\n";
					$r .= "</div>\n";
				break; //select
				
				case 'radio':
					$r .= "\n" . '<fieldset class="set">' . "\n";
					$r .= "\t" . '<legend>';
					$r .= htmlspecialchars( $field['label'] );
					if ($field['required']) {
						$r .= ' <span class="frm_required">*</span> ';
						$fieldClass .= ' required';
					}
					if (contact_form_is_error($field_id)) {
						$r .= '<span htmlfor="grunion-'.esc_attr($field_id).'" generated="true" class="error">';
						$r .= 'This field is required.';
						$r .= '</span>';
						$fieldClass .= ' error';
					}				
					$r .= '</legend>' . "\n";

					
					foreach ( $field['options'] as $oid => $option ) {
						$r .= "\t<div>\n";
						$r .= "\t\t";
						$r .= '<input type="radio" name="'.esc_attr($field_id).'" ';
						$r .= 'id="grunion-'.esc_attr($field_id).'-'.esc_attr($oid).'" ';
						$r .= 'value="'.esc_attr($option).'" ';
						$r .= 'class="'.esc_attr($field['type']).'" ';
						if ( $option == $field_value ) {
							$r .= 'checked="checked" ';
						}
						if ($field['required']) {
							$r .= 'required="required" ';
						}
						$r .= '/>' . "\n";
						
						$r .= "\t\t";
						$r .= '<label ';
						$r .= 'for="grunion-'.esc_attr($field_id).'-'.esc_attr($oid).'" ';
						$r .= '/>';
						$r .= htmlspecialchars( $option );
						$r .= '</label>';
						
						
						$r .= "\n";
						$r .= "\t</div>\n";
					}
					$r .= '</fieldset>' . "\n";
				break; //radio
				
				default: 
					/*
						-text
						-name
						-url
						-checkbox
						-email
					*/
					
					if ($field['type'] == 'checkbox') {
						$setType = ' set-check';
					}
					
					$r .= "\n";
					$r .= "<div class=\"set{$setType}\">\n";
					$r .= "\t" . '<label for="grunion-'.esc_attr($field_id).'">';
					$r .= htmlspecialchars( $field['label'] );
					if ($field['required']) {
						$r .= ' <span class="frm_required">*</span> ';
						$fieldClass .= ' required';
					}
					// $r .= "&nbsp;";
					if (contact_form_is_error($field_id)) {
						$r .= '<span htmlfor="grunion-'.esc_attr($field_id).'" generated="true" class="error">';
						if ($field['type'] == 'email') {
							$r .= 'Please enter a valid email address';
						}
						else {
							$r .= 'This field is required.';
						}
						$r .= '</span>';
						$fieldClass .= ' error';
					}				
					$r .= '</label>' . "\n";
					$r .= "\t" . '<input name="'.esc_attr($field_id).'" ';
					$r .= 'id="grunion-'.esc_attr($field_id).'" ';
					$r .= 'type="'.esc_attr($field['type']).'" ';
					$r .= 'class="'.esc_attr($field['type']) . $fieldClass . '" ';
					if ($field['type'] == 'checkbox') {
						$r .= 'value="'.__('Yes').'" ';
						if ($field_value) {
							$r .= 'checked="checked" ';
						}
					}
					else {
						$r .= 'value="'.esc_attr($field_value).'" ';
					}					
					if ($field['required']) {
						$r .= 'required="required" ';
					}
					$r .= '/>' . "\n";
					$r .= '</div>';
					$r .= "\n";
			}
			
			
			return $r;
		}
		/* === // Grunion Contact Form === */
	
		function formidableHtml($html, $type) {
			switch ($type) {
				case 'divider':
					$wrapper = 'div';
					$label = 'h3';
					$for = '';
					$set = 'set';
					$pair = '';
					break;
				case 'html':
					$wrapper = 'div';
					$label = 'h4';
					$for = '';
					$set = '';
					$pair = '';
					break;
				case 'checkbox':
				case 'radio':
				case 'scale':
					$wrapper = 'fieldset';
					$label = 'legend';
					$for = '';
					$set = 'set set-'. $type;
					$pair = '';
					break;
				default: 
					$wrapper = 'div';
					$label = 'label';
					$for = 'for="field_[key]" ';
					$set = 'set';
					$pair = '';
			}
			$html = <<<DEFAULT_HTML
				<{$wrapper} id="frm_field_[id]_container" class="{$set} form-field [required_class] [error_class]">
			    	<{$label} {$for}class="frm_pos_[label_position]">[field_name]
			        	<span class="frm_required">[required_label]</span>
						[if error]<span htmlfor="field_[key]" generated="true" class="error frm_error">[error]</span>[/if error]
			    	</{$label}>
			    	[input]
			    	[if description]<div class="frm_description">[description]</div>[/if description]
				</{$wrapper}>
DEFAULT_HTML;
			return $html;
		}

		function passwordProtectedForm($output) {
			global $post;
			$label = 'pwbox-'.(empty($post->ID) ? rand() : $post->ID);
			
			$output = '<form action="' . get_option('siteurl') . '/wp-pass.php" method="post" class="protected">
			<p>' . __("This post is password protected. To view it please enter your password below:") . '</p>
			<div class="set"><label for="' . $label . '">' . __("Password:") . '</label><input name="post_password" id="' . $label . '" type="password" class="password" /></div><div class="submit"><input type="submit" name="Submit" value="' . esc_attr__("Submit") . '" /></div></form>';
			
			return $output;
		}
	}


} // function soup_setupParentThemeClass()


$soup = null;
function soup_initialiseSoupObject(){
	global $soup,$content_width;
	// now need to initiate the soup object
	if (class_exists('SoupTheme')) {
		$soup = new SoupTheme();
		$content_width = $soup->content_width; //required to be global.
	}
	else if (class_exists('SoupThemeParent')){
		$soup = new SoupThemeParent();
		$content_width = $soup->content_width; //required to be global.
	}
	// else let it break

} //	function soup_initialiseSoupObject()


/*
 * The following function return data from/call functions in the $soup object for use
 * from theme files, removes the need to have <?php global $soup; ?> at the start
 * of every theme file. 
 * 
 * Not all functions in the soup object are listed below as most are filters/actions
 * not used within the theme's other .php files
 */

if ( !function_exists('bigRed_option') ) :
function bigRed_option($optionName = null, $default = true) {
	global $soup;
	
	if ( ($optionName != null) && (isset($soup->options[$optionName])) ) {
		$return = $soup->options[$optionName];
	}
	else {
		$return = $default;
	}
	
	return $return;
}
endif; //if ( !function_exists('bigRed_option') ) :

if ( !function_exists('bigRed_commentsTemplate') ) :
function bigRed_commentsTemplate($comment, $args, $depth) {
	global $soup;
	return $soup->commentTemplate($comment, $args, $depth);
}
endif; //if ( !function_exists('bigRed_commentsTemplate') ) :

if ( !function_exists('bigRed_pingTemplate') ) :
function bigRed_pingTemplate($comment, $args, $depth) {
	global $soup;
	return $soup->pingTemplate($comment, $args, $depth);
}
endif; //if ( !function_exists('bigRed_pingTemplate') ) :

if ( !function_exists('bigRed_listPages') ) :
function bigRed_listPages($args) {
	global $soup;
	return $soup->listPages($args);
}
endif; //if ( !function_exists('bigRed_listPages') ) :

if ( !function_exists('bigRed_fileData') ) :
function bigRed_fileData($dataName = null, $echo = 'true', $dataTheme = 'child') {
	global $soup;
	if ($dataTheme == 'parent') {
		$fileData = $soup->parent;		
	}
	else {
		$fileData = $soup->child;		
	}
	
	if ($echo == true) {
		echo $fileData[$dataName];
	}
	return $fileData[$dataName];
}
endif; //if ( !function_exists('bigRed_fileData') ) :

if ( !function_exists('bigRed_siteTag') ) :
function bigRed_siteTag($echo = true) {
	global $soup;
	$siteTag = $soup->siteNameTag;

	if ($echo == true) {
		echo $siteTag;
	}
	return $siteTag;
}
endif; //if ( !function_exists('bigRed_siteTag') ) :

if ( !function_exists('bigRed_uniqueInputID') ) :
function bigRed_uniqueInputID($echo = false){
	global $soup;
	
	$uniqueID = $soup->searchFormID();
	
	if ($echo == true) {
		echo $uniqueID;
	}
	return $uniqueID;
}
endif; //if ( !function_exists('bigRed_uniqueInputID') ) :

if ( !function_exists('bigRed_multiTagTitle') ) :
function bigRed_multiTagTitle($echo = true){
	global $soup;
	
	$multiTagTitle = $soup->tagArchiveTitle();
	
	if ($echo == true) {
		echo $multiTagTitle;
	}
	return $multiTagTitle;
}
endif; //if ( !function_exists('bigRed_multiTagTitle') ) :

if ( !function_exists('bigRed_versionCheck') ):
function bigRed_versionCheck($versionNumber = null) {
	global $soup;
	return $soup->versionCheck($versionNumber);
}
endif; //if ( !function_exists('bigRed_versionCheck') ) :

/* 
	need to reverse the order the function.php files usually run in
	parent's function.php needs to run before child's
*/
add_action('after_setup_theme', 'soup_setupParentThemeClass', 1);
// add_action('after_setup_theme', 'soup_setupChildThemeClass', 2); //reference: runs in child's function.php
add_action('after_setup_theme', 'soup_initialiseSoupObject', 3);


?>