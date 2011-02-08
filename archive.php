<?php
global $soup;
get_header();
?>


	<div id="content">
		<div id="contentHeadA" class="section" role="main"><section>
		
			<div id="contentHead" class="header"><header>
				<h1>
				<?php if ( is_day() ) : ?>
					Daily Archives: <span><?php the_time(get_option('date_format')); ?></span>
				<?php elseif ( is_month() ) : ?>
					Monthly Archives: <span><?php the_time('F Y'); ?></span>
				<?php elseif ( is_year() ) : ?>
					Annual Archives: <span><?php the_time('Y'); ?></span>
				<?php elseif ( is_category() ) : ?>
					Category Archives: <span><?php single_cat_title(); ?></span>
				<?php elseif ( is_tag() ) : ?>
					Tag Archives: <span><?php echo $soup->tagQuery(); ?></span>
				<?php elseif ( is_author() ) : ?>
					Author Archives: <span><?php 
					the_post();
					echo $authordata->display_name;
					rewind_posts();
					?></span>
				<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
					Blog Archives
				<?php endif; ?>				
				</h1>
			</header></div>

			<div id="contentA" class="hfeed">

				<?php get_template_part( 'template-parts/loop', 'archive' ); ?>
			
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