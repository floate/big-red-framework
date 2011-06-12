<?php 
while ( have_posts() ) : the_post(); 
?>
<div id="contentHeadA" <?php post_class('article'); ?>>
	<div id="contentHead" class="header">
		<h1 id="pageName" class="entry-title">
			<?php 
			$the_title = the_title('','',false);
			if (!$the_title) {
				$the_title = 'Untitled page #' . $post->ID;
			}
			echo $the_title;
			?>
		</h1>
		
		<?php if (current_theme_supports( 'post-thumbnails' )) : ?>
			<p class="entry-thumbnail">
				<?php echo get_the_post_thumbnail( $post->ID,  'post-thumbnail', array(
					'alt' => '',
					'title' => ''
				) ); ?>
			</p>
		<?php endif; //(current_theme_supports( 'post-thumbnails' )) : 
		?>
		
	</div>			

	<div id="contentA">
		<div class="entry-content section">
			<?php 
				the_content('Continue reading "'.the_title('', '', false).'" &raquo;');
				wp_link_pages('before=<div id="post-nav" class="page-nav post-nav nav">Pages:&after=</div>&link_before=<span>&link_after=</span>'); 
			?>
		</div>
		<?php edit_post_link('Edit', '<div class="footer"><p class="entry-meta">', '</p></div>'); ?>
	
	<?php 
	if (bigRed_option('page-comments-enabled',true)) {
		comments_template(); 
	}
	?>

	
	
		</div>
		<!-- //#contentA -->
	</div>
	<!-- //#contentHeadA -->
<?php endwhile; ?>
