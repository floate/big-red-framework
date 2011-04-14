<?php
global $soup;
get_header();
?>


	<div id="content">
		<div id="contentHeadA" class="section" role="main">
		
			<div id="contentHead" class="header">
				<h1 id="pageName">
				Author Archives: <span><?php 
				the_post();
				echo $authordata->display_name;
				?></span>
				</h1>
			</div>

			<div id="contentA" class="hfeed">
			
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
					<div id="entry-author-info">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 60 ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php echo get_the_author(); ?></h2>
							<?php the_author_meta( 'description' ); ?>
						</div><!-- #author-description	-->
					</div><!-- #entry-author-info -->
				<?php 
				
				endif; //if ( get_the_author_meta( 'description' ) ) :
				rewind_posts();
				
				
				get_template_part( 'template-parts/loop', 'archive' ); 
				?>
			
				<div id="page-nav" class="page-nav nav">
					<div class="page-nav-older"><?php next_posts_link('Older posts') ?></div>
					<div class="page-nav-newer"><?php previous_posts_link('Newer posts') ?></div>
				</div>
				<!-- //#page-nav -->
			
			
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