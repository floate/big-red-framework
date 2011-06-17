<?php
//make sure id isn't specified twice on the same page
//no need to seed since php 4.2.0
$bigRed_safeIds = bigRed_uniqueInputID();
//  required="required" // doesn't work with jQuery.Validate
?>
	<form method="get" action="<?php echo home_url(); ?>" class="search-form">
	
		<div class="set">
			<label for="s-<?php echo $bigRed_safeIds; ?>" class="search-label">
				Search this Site
			</label>
			<input type="text" name="s" id="s-<?php echo $bigRed_safeIds; ?>" class="text required" aria-required="true" />
		</div>
		<div class="submit">
			<input type="submit" value="Search" class="submit" />
		</div>
	</form>
