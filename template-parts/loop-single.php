<?php 
global $soup;
while ( have_posts() ) : the_post(); ?>
<div id="contentHeadA" <?php post_class('article'); ?> role="main">
	<div id="contentHead" class="header">
		<h1 id="pageName" class="entry-title">
			<?php 
			$the_title = the_title('','',false);
			if (!$the_title) {
				$the_title = 'Untitled post #' . $post->ID;
			}
			echo $the_title;
			?>
		</h1>
		<p class="entry-meta">
			Posted on 
			<span class="time pubdate"><time datetime="<?php the_time('c') ?>" pubdate class="entry-date">
				<?php the_time(get_option('date_format')); ?>
			</time></span> 

			by <span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="View all posts by <?php the_author(); ?>"><?php the_author(); ?></a></span>.

		</p>
		
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
		<div class="footer">
			<p class="entry-meta">Category: <span class="cat-links"><?php the_category(', '); ?></span> &bull; 
			<?php 
				edit_post_link('Edit', '', ' &bull; ');  
				the_tags('<span class="tag-links">Tagged: ', ', ', '</span> &bull; '); 
			?>
			<span class="comments-link">
				<?php
					if (comments_open() || (get_comments_number() > 0)) {
						echo '<a href="';
						comments_link();
						echo '">';
						comments_number('Leave a comment','One comment','% comments');
						echo '</a>';
					}
					else {
						echo 'Comments are closed';
					}
				?>
			</span>
			</p>
		</div>
		
		<?php
		if ((get_adjacent_post(false, '', true) != '') || (get_adjacent_post(false, '', false) != '')) :
		?>
			<div id="page-nav" class="page-nav nav">
				<div class="page-nav-older"><?php previous_post_link('%link','<span class="direction">Previous post </span> <span class="title">%title</span>') ?></div>
				<div class="page-nav-newer"><?php next_post_link('%link', '<span class="direction">Next post </span> <span class="title">%title</span>') ?></div>
			</div>
			<!-- //#page-nav -->
		<?php
		endif;
		?>
		
		
		<?php comments_template(); ?>
	
		</div>
		<!-- //#contentA -->
	</div>
	<!-- //#contentHeadA -->
<?php endwhile; ?>
