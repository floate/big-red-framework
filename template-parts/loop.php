<?php 
global $soup;
while ( have_posts() ) : the_post();
?>


<div id="post-<?php the_ID() ?>" <?php post_class('article'); ?>><article>

	<div class="header"><header>
		<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title()?></a></h3>
		
		<p class="entry-meta">
			Posted on 
			<span class="time pubdate"><time datetime="<?php the_time('c') ?>" pubdate class="entry-date">
				<?php the_time(get_option('date_format')); ?>
			</time></span> 
			
			by <span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( $authordata->ID, $authordata->user_nicename ); ?>" title="View all posts by <?php the_author(); ?>"><?php the_author(); ?></a></span>
			
		</p>
	</header></div>

	<div class="entry-content section"><section>
		<?php the_content('Continue reading "'.the_title('', '', false).'" &raquo;'); ?>
	</section></div>

	<div class="footer"><footer>
		<p class="entry-meta">Posted in <span class="cat-links"><?php the_category(', '); ?></span> &bull; 
		<?php edit_post_link('Edit', '', ' &bull; '); ?> 
		<?php the_tags('<span class="tag-links">Tagged: ', ', ', '</span> &bull; '); ?>
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
	</footer></div>
</article></div>
<!-- //#post-<?php the_ID() ?> -->

<?php
endwhile;
?>