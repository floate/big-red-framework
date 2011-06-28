<?php

if (is_search()) {
	echo "<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>";
}
else {
	echo "<p>Apologies, but we were unable to find what you were looking for. Perhaps  searching will help.</p>";
}

?>
<form method="get" action="<?php echo home_url(); ?>" class="search-form">

	<div class="set">
		<label for="s-404notfound" class="search-label">
			Search this Site
		</label>
		<input type="text" name="s" id="s-404notfound" class="text required" aria-required="true" />
	</div>
	<div class="submit">
		<input type="submit" value="Search" class="submit" />
	</div>
</form>

<?php
if (bigRed_option('not-found-map')) {
	echo '<h2>Site Map</h2>';
	if (function_exists('wp_nav_menu')) {
		wp_nav_menu(array(
				'theme_location' => 'not-found',
				'container' => 'div',
				'container_id' => 'footNavWrap',
				'container_class' => 'nav',
				'menu_class' => '',
				'menu_id' => 'footNav',
				'depth' => 4,
				'show_home' => 1,
				'fallback_cb' => 'bigRed_listPages'

			));
	}
	else {
		bigRed_listPages();
	}				
}
