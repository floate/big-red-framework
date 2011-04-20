<?php
global $soup;
get_header();
?>


	<div id="content">
		<div id="contentHeadA" class="section" role="main">
		
		<?php if ( have_posts() ) : ?>

			<div id="contentHead" class="header">
				<h1 id="pageName">
				Results for <span><?php the_search_query() ?></span>
				</h1>
			</div>

			<div id="contentA" class="hfeed">


			<?php get_template_part( 'template-parts/loop', 'search' ); ?>
			
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
			<div id="page-nav" class="page-nav nav">
				<div class="page-nav-older"><?php next_posts_link('Older posts') ?></div>
				<div class="page-nav-newer"><?php previous_posts_link('Newer posts') ?></div>
			</div>
			<!-- //#page-nav -->
			<?php endif; ?>
			
			</div>
			<!-- //#contentA -->
		<?php else : //if ( have_posts() ) : ?>

			<div id="contentHead" class="header">
				<h1>
				No result for <span><?php the_search_query() ?></span>
				</h1>
			</div>

			<div id="contentA">

			<p>Apologies, but we were unable to find what you were looking for. Perhaps another search will help.</p>
			
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
		<?php endif; //if ( have_posts() ) : ?>
		<?php get_sidebar('a'); ?>
	</div><!-- //#content -->
<?php 
get_sidebar('b'); 
get_footer();
?>