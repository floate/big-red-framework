<?php
global $soup;
get_header();
?>


	<div id="content">
		<div id="contentHeadA" class="section" role="main"><section>

			<div id="contentA" class="hfeed">

				<?php get_template_part( 'loop', 'index' ); ?>
			
				<div id="page-nav" class="page-nav nav">
					<div class="page-nav-older"><?php next_posts_link('Older posts') ?></div>
					<div class="page-nav-newer"><?php previous_posts_link('Newer posts') ?></div>
				</div>
				<!-- //#page-nav -->
			
			
			</div>
			<!-- //#contentA -->
		</section></div>
		<!-- //#contentHeadA -->
		<?php get_sidebar('a'); ?>
	</div><!-- //#content -->
<?php 
get_sidebar('b'); 
get_footer();
?>