The Big Red Framework is intended for web developers creating bespoke themes for their clients. It contains a ton of options for the developer to configure, without a messy options screen cluttering up the WordPress admin. This theme is intended for use with child themes.

The theme is filter and action heavy to allow use of the standard WordPress function names while custom data is output/returned. 


========= ACCESSING FUNCTIONS =========

To make overriding functions in the child themes slightly easier, functions in this theme are placed in classes which can be accessed through the object "$soup". 

A majority of the functions in the $soup objects are called as filters or actions. As such they have no global counterpart. In part this is to lower the risk of function name clashes. Functions with a global counterpart are defined towards the bottom of the parent's functions.php file in the name-space "bigRed_*".

The functions with a global counterpart are all pluggable to be easily overridden in the child theme's functions.php file.

========= THE FUTURE =========

One of the aims of the Big Red Framework is consistent html into the future. The aim is to keep bespoke client themes consistent, even as WordPress adds new features to the core. Whenever possible, new features affecting the html will be disabled by default in upgrades to the Big Red Framework. For example, had this framework been released prior to WordPress 3.1 the admin bar would be disabled by default.

NEW FEATURES ARE A GOOD THING!
The intention is to avoid breaking client sites, not to cripple WordPress. As a result, while a new feature will be turned off in the parent theme's functions.php file, it may be enabled in the _starter/functions.php file. 


========= NON-STANDARD THEME FUNCTIONS AND FILES =========

The framework contains several non-standard features and files. These include functionality to enable consistent form output from a number of plugins. The form plugins filtered in this manner are for Grunion Contact Form and Formidable/Formidable Pro (I don't own Gravity forms so have been unable to filter this for consistency). 

I frequently use the plugin Theme My Login for bespoke client sites. Template files for theme my login are included in addition to the standard WordPress template files. Theme My Login's files are:
	* login-form.php
	* register-form.php
	* resetpass-form.php
	* lostpassword-form.php
	* profile-form.php
	* user-panel.php


========= CREATING A CHILD THEME =========

1. Copy the files from the starter directory, "assets/_starter", into the base folder of your child theme.
2. Create the sub-directory "assets" in your child theme.
3. Copy the framework’s "assets/child/" directory into the assets directory of your child theme.
4. Update the theme information in your child theme's "style.css" file.

You can override files in the framework by copying the file into your child theme and editing it there. It is recommended you start by copying "header.php" and "footer.php" into your child theme to allow you to customise the logo/footer credits as required.

========= SETTING YOUR THEME’S OPTIONS =========

All of your theme’s options are set within the child theme’s functions.php file. At the start of the project, you should ask your client what they want from their website and set the options appropriately. 

Options are set in the class’s "defineOptions()" function in the form "$options[‘option_name’]".

== META TAGS ==
These add and remove the meta tags WordPress adds to the "<head>" of your html, including feed links, parent pages, adjacent pages, etc. All of these are true by default except for the localised style sheet (rtl languages).

•	feed_links (true) – the site’s rss feed (example.com/feed/) & rss comments feed (example.com/comments/feed/).
•	feed_links_extra (true) – adds category rss feed (example.com/category/general/feed/), tags rss feed (example.com/tag/my-tag/feed/), per article comments feed (example.com/my-article/feed/) 
•	rsd_link (true) – used by offline editors
•	wlwmanifest_link (true) – used by Window’s Live Writer for offline editing
•	index_rel_link – link to site’s home page (example.com)
•	parent_post_rel_link – link to parent page (example.com/page/sub-page will link to example.com/page)
•	start_post_rel_link – all posts link to the first ever post
•	adjacent_posts_rel_link_wp_head – link with in posts & pages to the next & previous posts/pages
•	locale_stylesheet – stylesheet for right to left languages
•	wp_generator – displays the version of WordPress used by the blog. Here’s not the place for the security through obscurity argument, I just point you to Dion’s version detection tool -- http://bit.ly/wpVersion .
•	wp_shortlink_wp_head – removes the shortlink reference (example.com/?p=432)


== GENERAL OPTIONS ==
These add or remove WordPress features commonly disabled on client sites. All the features default to the WordPress standard:
•	admin_bar – the much loved & much despised admin bar
•	custom_admin_bar_css – allows you to customise the CSS for the admin bar to suit your client’s theme
•	remove_capital_P_dangit – remove the filter to replace occurrences of "Wordpress" with the correct form "WordPress". At Soupgiant we usually remove the filter as we’ve found it interferes with images named WordPress.jpg (capital W) or similar. <img src=”/files/WordPress.jpg”>

== THEME OPTIONS ==

A few generic options for use with your theme. Includes custom theme meta tags, enabling built in WordPress features such as post formats and thumbnails:

•	content_width – width of content throughout the site
•	thumbnails – enable/disable post thumbnails
•	attachment_page_img_width – maximum width of images to displayed on the attachments pages
•	attachment_page_img_height - maximum height of images to displayed on the attachments pages
•	post-formats – enable post formats
	o	false: disabled
	o	true: all formats enabled
	o	array of post types – enable types in the array
•	favicon – add a favicon meta tag, the favicon should be placed named /assets/child/i/favicon.ico
•	favicon-apple – add an idevice icon meta tag, file should be named /assets/child/i/apple-touch-icon.png
•	X-UA-Compatible – IE version meta tag to be added, defaults to IE=edge
•	mobile-css-query – css media query used for loading the mobile stylesheet.
•	viewport-meta-tag – adds the viewport meta tag
•	page-comments-enabled – enables/disables comments on pages
•	trackbacks-enabled – enables/disables trackbacks and pingbacks throughout the site

== WIDGETS & NAVIGATION AREAS ==

The framework includes 4 widget areas and 2 navigation areas. You can enable them by setting the options below to true, disable them by setting the option to false.
If you wish to customise the human readable name from the default, you can enable the areas by setting them as a string & your string will be used as the readable name.
•	widget-header – default readable name: Header
•	widget-footer – default readable name: Footer
•	widget-sidebar-a – default readable name: Sidebar A
•	widget-sidebar-b – default readable name: Sidebar B
•	header-menu – default readable name: Header
•	footer-menu – default readable name: Footer

== JAVASCRIPT OPTIONS ==

Add conditional JavaScript files for various versions of IE. At the time of development, WordPress doesn’t support conditional tags for IE so these are added to "wp_head()" as <script> html rather than using the wp_enqueue_script functions
•	js-html5-shiv – add Remy Sharp’s html5 shiv for IE versions 8 and below
•	js-selectivizr – add Selectivizr for IE versions 8 and below
•	ddbelatedpng – add ddbelatedpng for IE6 to enable alpha transparency in png images

== VISUAL EDITOR OPTIONS ==

•	editor-css – use custom css for the visual editor, this is loaded from assets/child/c/all/editor-styles.css
•	editor-classes – adds a class dropdown to the visual editor (in kitchen sink mode). Set this as an key => value array, with the key being the readable class, eg:
array (
	‘Readable Name Class One’ => ‘class1’,
	‘Readable Name Class Two’ => ‘class2’
);
•	editor-fake-heading-levels – this fakes the heading levels in the editor so the client can select ‘Heading 1’ as the first level heading in both pages and posts & the appropriate <h#> tag will be added to the html. This keeps the heading levels accessible while, from the client’s perspective, the visual editor just works.


========= GLOBAL FUNCTIONS =========

# bigRed_option()
Returns an option defined in the array $soup->options[]. These options are all set in $soup->defineOptions [see below], the function operates in a similar manner to the native WordPress function get_option()

# bigRed_commentsTemplate()
Callback used for the comments template, it passes the arguments to $soup->commentTemplate()

# bigRed_pingTemplate()
Callback used for the pings/trackbacks template, it passes the arguments to $soup->pingTemplate()

# bigRed_listPages()
Fallback function for displaying menus, it passes the arguments to $soup->listPages()

# bigRed_fileData()
Retrieves file and path data stored in the arrays $soup->child[] and $soup->parent, this includes path data, file editions and minimisation settings. To get the child themes image path, the call is bigRed_fileData('img'), to get the equivalent path for the parent theme is bigRed_fileData('img', 'parent').

# bigRed_siteTag()
Returns/echos the tag used for the site name, either a h1 (home page) or p (sub pages)

# bigRed_uniqueInputID()
Returns or echos the unique id needed for multiple search form instances on a single page. Passes calls to $soup->searchFormID()

# bigRed_multiTagTitle()
Returns or echos a title for tag pages displaying multiple tags using either the + or , operator in the URL. Passes calls to $soup->tagArchiveTitle()
	
========= $soup... FUNCTIONS =========


# $soup->parent__construct()
Constructor used by the parent theme, it calls all functions required for basic setup of the theme


# $soup->child__construct()
-- intended to be overridden in the child theme
Constructor used by the child theme, it calls functions required for setup of the child theme.
This function is intentionally blank in the framework & the starter functions.php file. It is intended to be used by web developers adding advanced functionality to their child themes.


# $soup->defineMinimised()
-- intended to be overridden in the child theme
To reduce the download time, I suggest you run your CSS and JavaScript through YUI compressor and give the minimised files the name format filename-min.ext. This function allows you to switch to minimised versions with a series of true/false statements. You can minimise CSS and JS from the parent and child themes separately.


# $soup->defineChildVersions()
-- intended to be overridden in the child theme
For setting the version numbers of CSS and JavaScript files in the child theme. If you cache your static files for a long time (as recommended), you should update these numbers each time you publish changes to the files. I use the format YYYYMMDD.## for versioning.
Also used for defining the javascript dependancies for the child's theme custom.js file in /assets/child/j/


# $soup->defineOptions()
-- intended to be overridden in the child theme
A number of common customisations of a WordPress theme have been distilled down to a series of true/false statements. These include:
	* adding/removing removing various meta tags from the header
	* removing the admin bar
	* removing the capital P dangit filter
	* setting up theme options such as thumbnails, post formats
	* adding removing meta tags for favicons, mobile stylesheet media types, etc
	* disabling comments on posts
	* disabling trackbacks site wide
	* setup of menus and widgetised areas
	* use of regular IE targeted javascript for HTML5, CSS attribute selectors & PNG fixes 
	* addition of classes to the visual editor


# $soup->setImageSizes()
-- intended to be overridden in the child theme
Use this function to set various image sizes to be used in your theme. Image sizes defined here will be created in addition to sizes defined on the Settings>Media pages. This gives the designer the option to define fixed image sizes within the theme will allowing the user to use their preferred images sizes when inserting images into posts.

# function $soup->registerMoreCssJs()
-- intended to be overridden in the child theme
This is where child themes can register custom CSS and JS files using wp_register_style and wp_register_script

#function $soup->enqueueCSS()
-- intended to be overridden in the child theme
This is where the child theme queues all css files, including those registered by the parent theme using the function wp_enqueue_style. 


#function $soup->enqueueChildJs()
-- intended to be overridden in the child theme
This is where the child theme queues JavaScript files registered by the child theme. JavaScript files registered by the parent theme will be queued automatically if the child JavaScript depends on them.

#function $soup->definePaths()
This automatically defines the URLs containing the assets of both the parent and the child theme. They are stored in the array's $soup->parent[] and $soup->child[] respectively. Both arrays contains the keys:
	* url => root directory of theme, eg /wp-content/themes/<theme>/
	* assets => root directory of themes assets directory, /wp-content/themes/<theme>/assets/<parent or child>/
	* css => <assets dir>/c/
	* js => <assets dir>/j/
	* img => <assets dir>/i/
	* php => <assets dir>/p/
	* phpPath => server file path to <assets dir>/p/
	
# function $soup->defineParentVersions()
Used to define the version numbers for css files and javascript files registered within the parent theme's assets, eg /wp-content/themes/big-red-framework/assets/parent/*

#function $soup->setupOptions()
This sets up the options defined in $soup->defineOptions. The default is used if no option has been sent.

#function $soup->editorButtons()
Filter to add the styles dropdown to the visual editor

#function $soup->editorEnglishClasses()
Filter used to add the custom classes to the styles dropdown in the visual editor

#function $soup->editorHeadings()
If $options['editor-fake-heading-levels'] is set to true, this rewrites the Format dropdown in the visual editor for posts to add an <h3> when the user selects 'Heading One'. This keeps heading rating levels in tact for SEO purposes without the need for Authors to understand the subtleties of HTML headings and SEO requirements.

#function $soup->registerCSS()
This registers default CSS files in the child theme, it does not queue them for output in the html. The defaults are:
* <child theme css folder>/all/all.css
* <child theme css folder>/all/all-ie6.css (w/ conditional comments for IE6)
* <child theme css folder>/all/all-ie7.css (w/ conditional comments for IE7)
* <child theme css folder>/all/all-ie8.css (w/ conditional comments for IE8)
* <child theme css folder>/all/all-ie9.css (w/ conditional comments for IE9)

* <child theme css folder>/mobile/mobile.css (w/ mobile media type defined in options)

* <child theme css folder>/print/print.css (w/ print media type)
* <child theme css folder>/print/print-ie6.css (w/ print media type and conditional comments for IE6)
* <child theme css folder>/print/print-ie7.css (w/ print media type and conditional comments for IE7)
* <child theme css folder>/print/print-ie8.css (w/ print media type and conditional comments for IE8)
* <child theme css folder>/print/print-ie9.css (w/ print media type and conditional comments for IE9)

* CSS file required by prettyPhoto - this does not need to be queued manually

#function $soup->enqueueJS()
This tidies up after CSS and JavaScript files have been queued
	* if prettyPhoto JS queued, queues associated CSS
	* queues comments-reply.js if required
	
#function $soup->httpHeaders()
Outputs any HTTP Headers required, such as the X-UA-Compatible header using the option defined.

#functions $soup->meta_tags()
Outputs meta tags required according to defined options, at this stage this is only the favicons

#functions $soup->html5shiv()
Outputs Remy Sharp's HTML5 enabling script in the header wrapped by IE<=8 conditional tags.

#functions $soup->selectivizr()
Outputs Keith Clark's selectivizr script in the footer wrapped by IE<=8 conditional tags. An upcoming update will parse CSS on load at which point this script will be moved to the HTML header.

#function $soup->registerSidebars()
Registers up to four sidebars with using the human readable names as defined in the options, the theme references are 
	* header (default human readable name: Header)
	* sidebar-a (default human readable name: Sidebar A)
	* sidebar-b (default human readable name: Sidebar B)
	* footer (default human readable name: Footer)
	
#function $soup->registerMenus()
Registers up to two menus with the human readable names as defined in the options, the theme references are
	* header (default human readable name: Header Navigation)
	* footer (default human readable name: Footer Navigation)
	
#function $soup->filterMenus()
Filters WordPress menus to add the classes .on and .active to the current tree, ie in addition to the default WordPress classes
	* .current_page_item
	* .current-page-ancestor
	* .current_page_parent
	
#function $soup->setHeaderTags()
Sets the html tags used for the #pageName and #siteName html. On the home page, #siteName is a h1 & #pageName is a h2. On inner pages, #siteName is a p & #pageName is a h1. This is for SEO purposes

#function $soup->listPages()
Function used as menu fall backs, it wraps the output with the appropriate tags/classes combination and uses in the .on & .active classes used by $soup->filterMenus()

#function $soup->tagArchiveTitle()
Used in place of the WordPress function single_tag_title() on tag archives. This function takes into account multiple tag archives using the + and , operators in the URL

#function $soup->filterHtmlTitle()
Filter run against the wp_title() function to format the html title in an SEO friendly manner. For the most part, this function was ripped out of twentyten.

#function $soup->removeVersionQstring()
Used to remove the ver=X.X querystring when referencing javascript and css files on either the Microsoft public CDN or the Google public CDN.

#function $soup->bodyClass()
Filter run against the body_class function. It adds numerous custom body tags, including
	* all_blog (all posts, archives and blog home page)
	* list (pages including a list of posts [blog home, archives, search])
	* singular (pages where is_singular() returns true)
	* adds postslug-<slug> class to posts/single
	* adds posttag-<tag> for each tag assigned to a post/single
	* adds postterm-<taxonomy>-<term> for each term from custom taxonomies assigned to a post/single
	* adds pageslug-<slug> to pages
	* adds pagetree-<slug> to pages
	* for each parent & ancestor page to pages, adds pagetree-<ancestor-slug> and pagetree-<ancestor-ID>
	
#function $soup->postClass()
Filter run agains the post_class function. It adds numerous custom post tags, including
	* p#, where # is the position of the post on the page
	* alt to every second post
	* author-<author-slug> for the post's author
	* tag slug for each tag assigned to a post

#function $soup->searchFormID()
Appended to the search form input field (and associated label for=) to keep IDs unique when multiple search forms/widgets are included on one page.

#function $soup->belatedpng()
Outputs belated png script in the footer wrapped by IE=6 conditional tags.

#function $soup->inlineFooterJs()
Outputs any inline JavaScript into the footer of the page, inline JavaScript is used for slideshows and other JavaScript requiring information stored in the Database on a per post basis.

#function $soup->jsString()
Takes a PHP string and converts it to a string for output in JavaScript

#function $soup->commentTemplate()
-In many instances, this function will be overwritten by the child theme.
Callback function used by wp_list_comments(array('type'=>'comment')) to format comment output

#function $soup->pingTemplate()
-In many instances, this function will be overwritten by the child theme.
Callback function used by wp_list_comments(array('type'=>'pings')) to format ping/trackback output

#function $soup->pageCommentsDisabled()
If options are set to disable comments on all pages, this function filters comments_open to always return false if a page is been displayed.

#function $soup->betterFormShortcodes()
If the plugin Grunion Contact Form is active, this replaces the shortcodes used by the plugin to standardise the form output for styling by the theme.

#function $soup->contact_form_shortcode()
Output for [contact-form] shortcode used by Grunion Contact Form plugin

#function $soup->contact_form_field()
Output for [contact-field] shortcode used by Grunion Contact Form plugin

#function $soup->contact_form_render_field()
Renders fields for [contact-field] shortcode used by Grunion Contact Form plugin

#function $soup->formidableHtml()
Filter used on formidable plugin to standardise form output for styling by the theme