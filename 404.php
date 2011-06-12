<?php
get_header();
?>


	<div id="content">
		<div id="contentHeadA" class="section" role="main">
		
			<div id="contentHead" class="header">
				<h1 id="pageName">
					File Not Found
				</h1>
			</div>

			<div id="contentA">

			<p>Apologies, but we were unable to find what you were looking for. Perhaps  searching will help.</p>
			
			<form method="get" action="<?php echo home_url(); ?>" class="search-form search-404">
				
				<div class="inputPair">
					<label for="s-404notfound" class="search-label">Search this Site</label>
					<input type="text" name="s" id="s-404notfound" class="search-input" />
				</div>
				<div class="inputPair">
					<input type="submit" value="Search" class="search-submit" />
				</div>
			</form>
			
			
			</div>
			<!-- //#contentA -->
		</div>
		<!-- //#contentHeadA -->
		<?php get_sidebar('a'); ?>
	</div><!-- //#content -->
<?php 
get_sidebar('b'); 
get_footer();
?>