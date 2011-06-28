<?php
get_header();
?>


	<div id="content">
		<div id="contentHeadA" class="section" role="main">
		
			<div id="contentHead" class="header">
				<h1 id="pageName">
				Results for <span><?php the_search_query() ?></span>
				</h1>
			</div>

			<div id="contentA" class="hfeed">
				<?php
				if ( have_posts() ) :
				
					get_template_part( 'template-parts/loop', 'search' ); 
					?>
			
					<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<div id="page-nav" class="page-nav nav">
						<div class="page-nav-older"><?php next_posts_link('Older posts') ?></div>
						<div class="page-nav-newer"><?php previous_posts_link('Newer posts') ?></div>
					</div>
					<!-- //#page-nav -->
					<?php 
					endif; 
				else: //have_posts
					get_template_part( 'template-parts/not-found', 'search' ); 
				endif; //have_posts
				?>		
			
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