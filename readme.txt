The Big Red Framework is intended for web developers creating bespoke themes for their clients. It contains a ton of options for the developer to configure, without a messy options screen cluttering up the WordPress admin. This theme is intended for use with child themes.

The theme is filter and action heavy to allow use of the standard WordPress function names while custom data is output/returned. 


========= ACCESSING FUNCTIONS =========

To make over riding functions in the child themes slightly easier, functions in this theme are placed in classes which can be accessed through the object $soup. All PHP files except functions.php used by the theme & child themes must start with the line:

<?php global $soup; ?>

========= FUNCTIONS =========


# $soup->parent__construct()
Constructor used by the parent theme, it calls all functions required for basic setup of the theme


# $soup->child__construct()
-- intended to be overridden in the child theme
Constructor used by the child theme, it call functions required for setup of the child theme.
This function is intentionally blank in the framework's & the starter's functions.php. It is intended to be used by web developers adding advanced functionality to their child themes.


# $soup->defineMinimised()
-- intended to be overridden in the child theme
To reduce the download time, I suggest you run your CSS and JavaScript through YUI compressor and give the minimised files the name format filename-min.ext. This function allows you to switch to minimised versions with a series of true/false statements. You can minimise CSS and JS from the parent and child themes separately.


# $soup->defineChildVersions()
-- intended to be overridden in the child theme
For setting the version numbers of CSS and JavaScript files in the child theme. If you cache your static files for a long time (as recommended), you should update these numbers each time you publish changes to the files. I use the format YYYYMMDD.## for versioning.


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
	* assets => root directory of themes assets directory, /wp-content/themes/<theme>/<parent or child>/
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