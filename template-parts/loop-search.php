<?php 
global $soup;
while ( have_posts() ) : the_post();
?>


<div id="post-<?php the_ID() ?>" <?php post_class('article'); ?>>

	<div class="header">
		<?php 
		$the_title = the_title('','',false);
		if (!$the_title) {
			$the_title = 'Untitled post #' . $post->ID;
		}
		if (is_home()) : 
		?>
		<h2 class="entry-title"><a href="<?php the_permalink();?>"><?php echo $the_title; ?></a></h2>
		<?php else : ?>
		<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php echo $the_title; ?></a></h3>
		<?php endif; ?>
		
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

	<div class="entry-summary section">
		<?php
		the_excerpt();
		 // the_content('Continue reading "'.the_title('', '', false).'" &raquo;'); 
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
				if (('open' == $post->comment_status) || (get_comments_number() > 0)) {
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
</div>
<!-- //#post-<?php the_ID() ?> -->

<?php
endwhile;
?>