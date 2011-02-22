<?php
//make sure id isn't specified twice on the same page
//no need to seed since php 4.2.0
global $soup;
$soup_safeIds = $soup->searchFormID();
//  required="required" // doesn't work with jQuery.Validate
?>
	<form method="get" action="<?php echo home_url(); ?>" class="search-form">
	
		<div class="inputPair inputSet set-text">
			<label for="s-<?php echo $soup_safeIds; ?>" class="search-label">
				Search this Site
			</label>
			<input type="text" name="s" id="s-<?php echo $soup_safeIds; ?>" class="text required" aria-required="true" />
		</div>
		<div class="inputPair inputSet set-submit">
			<input type="submit" value="Search" class="search-submit" />
		</div>
	</form>
