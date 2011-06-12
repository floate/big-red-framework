<?php
/*
Template Name: Redirect Page (Permanent)
*/

the_post();
$bigRed_redirectTo = get_post_meta($post->ID, 'redirectTo', true);

$bigRed_parsed = parse_url($bigRed_redirectTo);

if (($bigRed_redirectTo) AND (($bigRed_parsed['scheme'] == 'http') OR ($bigRed_parsed['scheme'] == 'https'))) {
	//echo "<!-- 1 -->";
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: " . $bigRed_redirectTo ); 
}
elseif (($bigRed_redirectTo)) {
	//presume absolute url on this site
	if (substr($bigRed_redirectTo,0,1) != '/') {
		$bigRed_redirectTo = '/' . $bigRed_redirectTo;
	}
	
	$blogurl_parsed = parse_url(home_url());
	$bigRed_redirectToPrefix = $blogurl_parsed['scheme'] . '://' . $blogurl_parsed['host'];
	$bigRed_redirectTo = home_url() . $bigRed_redirectTo;
	//echo "<!-- 2 $bigRed_redirectTo -->";
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: " . $bigRed_redirectTo );
	/* ? >
		<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
		<html><head>
		<title>301 Moved Permanently</title>
		</head><body>
		<h1>Moved Permanently</h1>
		<p>The document has moved <a href="<?php echo $bigRed_redirectTo; ?>">here</a>.</p>
		
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