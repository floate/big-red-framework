<?php 
global $soup;
while ( have_posts() ) : the_post(); ?>
<div id="contentHeadA" <?php post_class('article'); ?> role="main"><article>
	<div id="contentHead"><header>
		<h1 id="pageName" class="entry-title">
			<?php 
			$metadata = wp_get_attachment_metadata();
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


			<?php if ( wp_attachment_is_image() ) : ?>
			Full size image is <a href="<?php echo wp_get_attachment_url(); ?>"><?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a>.
			<?php endif; // ( wp_attachment_is_image() ) : 
			?>
		</p>
				
	</header></div>			

	<div id="contentA">
		<div class="entry-content section"><section>
			<?php 
				the_content('Continue reading "'.the_title('', '', false).'" &raquo;');
				wp_link_pages('before=<div id="post-nav" class="page-nav post-nav nav">Pages:&after=</div>'); 
			?>
		</section></div>
		<div class="footer"><footer>
			<p class="entry-meta">Posted in <span class="cat-links"><?php the_category(', '); ?></span> &bull; 
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
		</footer></div>
		<div id="page-nav" class="page-nav nav"><nav>
			<div class="page-nav-older"><?php previous_post_link('%link','<span class="direction">Previous post </span> <span class="title">%title</span>') ?></div>
			<div class="page-nav-newer"><?php next_post_link('%link', '<span class="direction">Next post </span> <span class="title">%title</span>') ?></div>
		</nav></div>
		<!-- //#page-nav -->
		
		
		<?php comments_template(); ?>
	
		</div>
		<!-- //#contentA -->
	</section></div>
	<!-- //#contentHeadA -->
<?php endwhile; ?>
