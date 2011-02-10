<?php
/*
Template Name: Redirect Page (Permanent)
*/

the_post();
$soup_redirectTo = get_post_meta($post->ID, 'redirectTo', true);

$soup_parsed = parse_url($soup_redirectTo);

if (($soup_redirectTo) AND (($soup_parsed['scheme'] == 'http') OR ($soup_parsed['scheme'] == 'https'))) {
	//echo "<!-- 1 -->";
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: " . $soup_redirectTo ); 
}
elseif (($soup_redirectTo)) {
	//presume absolute url on this site
	if (substr($soup_redirectTo,0,1) != '/') {
		$soup_redirectTo = '/' . $soup_redirectTo;
	}
	
	$blogurl_parsed = parse_url(home_url());
	$soup_redirectToPrefix = $blogurl_parsed['scheme'] . '://' . $blogurl_parsed['host'];
	$soup_redirectTo = home_url() . $soup_redirectTo;
	//echo "<!-- 2 $soup_redirectTo -->";
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: " . $soup_redirectTo );
	/* ? >
		<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
		<html><head>
		<title>301 Moved Permanently</title>
		</head><body>
		<h1>Moved Permanently</h1>
		<p>The document has moved <a href="<?php echo $soup_redirectTo; ?>">here</a>.</p>
		
		</body></html>
	< ? php */
}
else {
	//just show the user the page content
	$templates[] = "page.php";

	if ('' == locate_template($templates, true)) {
		load_template( get_theme_root() . '/default/page.php');
	}
}

?>