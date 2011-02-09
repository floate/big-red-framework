<?php 
global $soup;
while ( have_posts() ) : the_post(); 
?>
<div id="contentHeadA" <?php post_class('article'); ?>><article>
	<div id="contentHead"><header>
		<h1 id="pageName" class="entry-title">
			<?php the_title()?>
		</h1>
	</header></div>			

	<div id="contentA">
		<div class="entry-content section"><section>
			<?php 
				the_content('Continue reading "'.the_title('', '', false).'" &raquo;');
				wp_link_pages('before=<div id="post-nav" class="page-nav post-nav nav">Pages:&after=</div>'); 
			?>
		</section></div>
		<?php edit_post_link('Edit', '<div class="footer"><footer><p class="entry-meta">', '</p></footer></div>'); ?>
	
		</div>
		<!-- //#contentA -->
	</section></div>
	<!-- //#contentHeadA -->
<?php endwhile; ?>
