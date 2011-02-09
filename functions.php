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
		
		
		
		/**
	     * PHP 4 Compatible Constructor
	     */
		function SoupThemeParent(){$this->__construct();}
    
	    /**
	     * PHP 5 Constructor
	     */		
		function __construct(){
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
			
			/* class filters */
			add_filter('body_class', array(&$this, 'bodyClass'),1, 2);
			add_filter('post_class', array(&$this, 'postClass'),5, 3);

			/* misc filters */
			add_filter('wp_nav_menu', array(&$this, 'filterMenus'));
			add_filter('wp_title', array(&$this, 'filterHtmlTitle'), 10, 2);

			add_action('wp_head', array(&$this, 'setHeaderTags'));
			
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
			$child['cssVer'] = '20110129';
			$child['jsVer']  = '20110129';
			
			$child['jsDependencies'] = array(
				'jquery'
				,'soup-base'
				// ,'prettyPhoto'
				// ,'hashchange'
				// ,'form-validation'
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

		function enqueueChildJs(){
			/* intended to be overridden in child theme */
			wp_enqueue_script('custom');
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
			$parent['cssVer'] = '20110129';
			$parent['jsVer']  = '20110129';
		}
				
		function setupOptions() {
			$options = &$this->options;

			//meta tags in header
			if ( (function_exists('add_theme_support')) AND ($options['feed_links'] == true) ) {
				add_theme_support( 'automatic-feed-links' );
			}
			elseif (function_exists('remove_theme_support')) {
				remove_theme_support( 'automatic-feed-links' );
			}
			
			if ($options['feed_links_extra'] != true) {
				remove_action( 'wp_head', 'feed_links_extra', 3 );
			}
			
			if ($options['rsd_link'] != true) {
				remove_action( 'wp_head', 'rsd_link');
			}
			
			if ($options['wlwmanifest_link'] != true) {
				remove_action( 'wp_head', 'rsd_link');
			}
			
			if ($options['index_rel_link'] === false) {
				remove_action( 'wp_head', 'index_rel_link');
			}
			
			if ($options['parent_post_rel_link'] != true) {
				remove_action( 'wp_head', 'parent_post_rel_link', 10, 0);
			}
			
			if ($options['start_post_rel_link'] != true) {
				remove_action( 'wp_head', 'start_post_rel_link', 10, 0);
			}

			if ($options['start_post_rel_link'] != true) {
				remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
			}
			
			if ($options['locale_stylesheet'] != true) {
				remove_action( 'wp_head', 'locale_stylesheet');
			}
			
			if ($options['wp_generator'] != true) {
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
			
			if ($options['wp_shortlink_wp_head'] === false) {
				remove_action( 'wp_head', 'wp_shortlink_wp_head');
			}
			
			if ($options['admin_bar'] != true) {
				//source: http://yoast.com/disable-wp-admin-bar/
				
				/* Disable the Admin Bar. */
				add_filter( 'show_admin_bar', '__return_false' );

				/* Remove the Admin Bar preference in user profile */
				remove_action( 'personal_options', '_admin_bar_preferences' );
			}

			if ($options['remove_capital_P_dangit'] !== false) {
				foreach ( array( 'the_content', 'the_title' ) as $filter )
					remove_filter( $filter, 'capital_P_dangit', 11 );
				remove_filter( 'comment_text', 'capital_P_dangit', 31 );
			}

			if ( ($options['thumbnails'] === true) OR (is_array($options['thumbnails'])) ) {
				if ( function_exists( 'add_theme_support' ) ) {
					add_theme_support( 'post-thumbnails' );
				}	
			}
			
			if ( ($options['post-formats'] != false) OR (is_array($options['thumbnails'])) ) {
				if ( function_exists( 'add_theme_support' ) ) {
					if (!is_array($options['thumbnails'])) {
						$options['thumbnails'] = array(
							'aside',	'gallery',
							'link',		'image',
							'quote',	'status',
							'video',	'audio',
							'chat');
					}
					add_theme_support( 'post-formats', $options['thumbnails'] );
				}
			}

			add_action('wp_head', array(&$this, 'meta_tags')); //sets options meta_tags
			 
			$this->registerSidebars(); //sets up sidebar options
			 
			$this->registerMenus(); //sets up menus
			
			add_action('wp_head', array(&$this, 'html5shiv'), 1); //sets options html5shiv

			add_action('wp_head', array(&$this, 'selectivizr'), 9); //sets options selectivizr
			
			add_action('wp_footer', array(&$this, 'belatedpng'), 50); //sets up belated png js
			
			if (($options['editor-css'] !== false) AND (function_exists('add_editor_style')) ) {
				add_editor_style("assets/child/c/all/editor-style.css");
			}
			
			if (is_array($this->options['editor-classes']) !== false) {
				add_filter('mce_buttons_2', array(&$this, 'editorButtons'));
				add_filter('tiny_mce_before_init', array(&$this, 'editorEnglishClasses'));
			}

			if ($this->options['editor-fake-heading-levels'] === false) {
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
			else {			
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
			
			
			
			if ($options['custom_admin_bar_css'] == true) {
				wp_deregister_style('admin-bar');
				wp_register_style(
					'admin-bar',
					$child['css'] . "/all/admin-bar$cce.css",
					null,
					$child['cssVer']
					);
			}
			
			/* all media type */
			wp_register_style(
				'prettyPhoto',
				$parent['css'] . "/prettyPhoto$pce.css",
				null,
				'3.0.1'
				);
		
			wp_register_style(
				'soup-all',
				$child['css'] . "/all/all$cce.css",
				null,
				$child['cssVer']
				);
		
			wp_register_style(
				'soup-all-ie6',
				$child['css'] . "/all/all-ie6$cce.css",
				array('soup-all'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie6']->extra['conditional'] = 'IE 6';
	
			wp_register_style(
				'soup-all-ie7',
				$child['css'] . "/all/all-ie7$cce.css",
				array('soup-all'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie7']->extra['conditional'] = 'IE 7';
	
			wp_register_style(
				'soup-all-ie8',
				$child['css'] . "/all/all-ie8$cce.css",
				array('soup-all'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-ie8']->extra['conditional'] = 'IE 8';
	
			wp_register_style(
				'soup-all-ie9',
				$child['css'] . "/all/all-ie9$cce.css",
				array('soup-all'),
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
				array('soup-print'),
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie6']->extra['conditional'] = 'IE 6';

			wp_register_style(
				'soup-print-ie7',
				$child['css'] . "/print/print-ie7$cce.css",
				array('soup-print'),
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie7']->extra['conditional'] = 'IE 7';

			wp_register_style(
				'soup-print-ie8',
				$child['css'] . "/print/print-ie8$cce.css",
				array('soup-print'),
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie8']->extra['conditional'] = 'IE 8';

			wp_register_style(
				'soup-print-ie9',
				$child['css'] . "/print/print-ie9$cce.css",
				array('soup-print'),
				$child['cssVer'],
				'print'
				);
			$wp_styles->registered['soup-print-ie9']->extra['conditional'] = 'IE 9';


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
				array('soup-all-media'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie6']->extra['conditional'] = 'IE 6';
	
			wp_register_style(
				'soup-all-media-ie7',
				$child['css'] . "/all-media/all-media-ie7$cce.css",
				array('soup-all-media'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie7']->extra['conditional'] = 'IE 7';
	
			wp_register_style(
				'soup-all-media-ie8',
				$child['css'] . "/all-media/all-media-ie8$cce.css",
				array('soup-all-media'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie8']->extra['conditional'] = 'IE 8';
	
			wp_register_style(
				'soup-all-media-ie9',
				$child['css'] . "/all-media/all-media-ie9$cce.css",
				array('soup-all-media'),
				$child['cssVer']
				);
			$wp_styles->registered['soup-all-media-ie9']->extra['conditional'] = 'IE 9';


		
		}

		function registerJS() {
			$options = &$this->options;
			$parent  = &$this->parent;
			$child   = &$this->child;
			$prot    = is_ssl() ? 'https' : 'http';
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
			wp_localize_script('soup-base', 'SOUPGIANT_wpURLS', array(
				'register' => site_url('wp-login.php?action=register', 'login'),
				'regoEnabled' => get_option('users_can_register') ? "y" : "n",
				'lostpassword' => wp_lostpassword_url( site_url( $_SERVER['REQUEST_URI'] ) ),
				'loginsubmit' => site_url( 'wp-login.php', 'login' ),
				'currentURL' => site_url( $_SERVER['REQUEST_URI'] )
			));
			
			/* jQuery plugins */
			wp_register_script(
				'form-validation',
				$validatorURL,
				array('jquery'),
				'1.7',
				true
			);
		
			wp_register_script(
				'prettyPhoto',
				$this->parent['js'] . "/jq.prettyphoto$pje.js",
				array('jquery'),
				'3.0.1',
				true
			);
	
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
				'1.6',
				true
			);

			wp_register_script(
				'custom',
				$child['js'] . "/custom$cje.js",
				$child['jsDependencies'],
				$child['jsVer'],
				true
			);
			
		}

		function enqueueJS() {
			/* this just cleans up JS enqueing and applies any applicable combo packs */
			
			
			if (wp_script_is('custom') == true) {
				foreach ($this->child['jsDependencies'] as $handle) {
					wp_enqueue_script($handle);
				}
			}
			
		
			if (wp_script_is('prettyPhoto') == true) {
				wp_enqueue_style('prettyPhoto-css');
			}
			
			/* threaded comments */
			if ((!is_admin()) AND is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
				wp_enqueue_script( 'comment-reply' );
			}
			
		}

		function meta_tags(){
			$options = &$this->options;
			
			$result = "";
			
			if ($options['favicon'] !== false) {
				$result .= '<link rel="shortcut icon" type="image/x-icon" href="';
				$result .= $this->child['img'];
				$result .= '/favicon.ico" />' . "\n";
				$result .= '<link rel="icon" type="image/x-icon" href="';
				$result .= $this->child['img'];
				$result .= '/favicon.ico" />' . "\n";		
			}
			
			if ($options['favicon-apple'] !== false) {
				$result .= '<link rel="apple-touch-icon" href="';
				$result .= $this->child['img'];
				$result .= '/apple-touch-icon.png" />' . "\n";
			}
		
			if ($options['X-UA-Compatible'] !== false) {
				if (!is_string($options['X-UA-Compatible'])) {
					$options['X-UA-Compatible'] = 'IE=edge';
				}
				$result .= '<meta http-equiv="X-UA-Compatible" content="';
				$result .= $options['X-UA-Compatible'];
				$result .= '" />' . "\n";
			}
			
			
			echo $result;
			return;		
		}

		function html5shiv() {
			$options = &$this->options;
			$parent  = &$this->parent;
			
			if ($options['js-html5-shiv'] !== false) :
				$result = "";
				$result .= '<!--[if lt IE 9]>';
				$result .= '<script src="';
				$result .= $parent['js'];
				$result .= '/html5shiv.js"></script>';
				$result .= '<![endif]-->' . "\n";
			endif; // ($options['js-html5-shiv'] !== false) :
			echo $result;
		}
		
		function selectivizr() {
			$options = &$this->options;
			$parent  = &$this->parent;
			if ($this->parent['jsMin'] == true) {
				$pjs = '-min';
			}
			else {
				$pjs = '';
			}
			
			if ($options['js-selectivizr'] !== false) :
				$result = "";
				$result .= '<!--[if lt IE 9]>';
				$result .= '<script src="';
				$result .= $parent['js'];
				$result .= "/selectivizr$pjs.js\"></script>";
				$result .= '<![endif]-->' . "\n";
			endif; // ($options['js-html5-shiv'] !== false) :
			echo $result;
		}
		
		function registerSidebars() {
			$options = &$this->options;
			if ( function_exists('register_sidebar') ) {
			
				if ($options['widget-header'] !== false) {
					if (!is_string($options['widget-header'])) {
						$options['widget-header'] = 'Header';
					}
					register_sidebar(array(
						'name' => $options['widget-header'],
						'id' => 'header',
						'before_widget' => '<div id="%1$s" class="head-widget widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>', 
					));
				}

				if ($options['widget-sidebar-a'] !== false) {
					if (!is_string($options['widget-sidebar-a'])) {
						$options['widget-sidebar-a'] = 'Sidebar A';
					}
					register_sidebar(array(
						'name' => $options['widget-sidebar-a'],
						'id' => 'sidebar-a',
						'before_widget' => '<div id="%1$s" class="widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>', 
					));
				}
			
				if ($options['widget-sidebar-b'] !== false) {
					if (!is_string($options['widget-sidebar-b'])) {
						$options['widget-sidebar-b'] = 'Sidebar B';
					}
					register_sidebar(array(
						'name' => $options['widget-sidebar-b'],
						'id' => 'sidebar-b',
						'before_widget' => '<div id="%1$s" class="widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>', 
					));
				}

				if ($options['widget-footer'] !== false) {
					if (!is_string($options['widget-footer'])) {
						$options['widget-footer'] = 'Footer';
					}
					register_sidebar(array(
						'name' => $options['widget-footer'],
						'id' => 'footer',
						'before_widget' => '<div id="%1$s" class="foot-widget widget %2$s">', 
						'after_widget' => '</div>', 
						'before_title' => '<h5 class="widget-title">', 
						'after_title' => '</h5>', 
					));
				}

			}
			return;
		}
		
		function registerMenus() {
			$options = &$this->options;
			if ( function_exists('register_nav_menus') ) {
				if ($options['header-menu'] !== false) {
					if (!is_string($options['header-menu'])) {
						$options['header-menu'] = 'Header Navigation';
					}
					$menus['header'] = $options['header-menu'];
				}

				if ($options['footer-menu'] !== false) {
					if (!is_string($options['footer-menu'])) {
						$options['footer-menu'] = 'Footer Navigation';
					}
					$menus['footer'] = $options['footer-menu'];
				}
				
				
				register_nav_menus( $menus );
			}
		}

		function filterMenus($menu) {
			$menu = str_replace('current_page_item', 'on active current_page_item', $menu);
			$menu = str_replace('current-page-ancestor', 'on active current-page-ancestor', $menu);
			$menu = str_replace('current_page_parent', 'on active current_page_parent', $menu);
			$menu = str_replace('</ul>', '', $menu);
			$menu = preg_replace('(\<ul(/?[^\>]+)\>)', '',$menu);
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
				'link_after' => ''
			);

			$r = wp_parse_args($args, $defaults);

			$menu = '';

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

			$classes[] = 'nojs';
			$classes[] = 'nojswin'; 
			
			if (is_home() OR is_archive()) {
				$classes[] = 'all_blog';
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
			}
			elseif ( is_page() ) {
				$pageID = $wp_query->post->ID;
				$pageSlug = $wp_query->post->post_name;
				$page_children = wp_list_pages("child_of=$pageID&echo=0");
				$post = get_page($pageID);
				
				$classes[] = 'pageslug-' . sanitize_html_class($pageSlug);
				$classes[] = 'pagetree-' . sanitize_html_class($pageID);
				
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
			$classes[] = $postAlt % 2 ? null : 'alt';
			$classes[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
			
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
			
			if ($options['ddbelatedpng'] !== false) :
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
			endif; // ($options['js-html5-shiv'] !== false) :
			echo $result;
		}

		function inlineFooterJs(){
			$showJs = false;
			$outputJs = '<script>var SOUPGIANT=SOUPGIANT||{};';
			foreach ($this->inlineFooterJSarray as $js) {
				$showJs = true;
				$outputJs .= $js;
			}
			$outputJs .= '</script>';
			if ($showJs) {
				echo $outputJs;
			}
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


	}


} // function soup_setupParentThemeClass()


$soup = null;
function soup_initialiseSoupObject(){
	global $soup;
	// now need to initiate the soup object
	if (class_exists('SoupTheme')) {
		$soup = new SoupTheme();
	}
	else if (class_exists('SoupThemeParent')){
		$soup = new SoupThemeParent();
	}
	// else let it break

} //	function soup_initialiseSoupObject()


/* 
	need to reverse the order the function.php files usually run in
	parent's function.php needs to run before child's
*/
add_action('after_setup_theme', 'soup_setupParentThemeClass', 1);
// add_action('after_setup_theme', 'soup_setupChildThemeClass', 2); //reference: runs in child's function.php
add_action('after_setup_theme', 'soup_initialiseSoupObject', 3);


?>