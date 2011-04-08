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



			<div class="entry-attachment">
			<?php 
			//pretty much line for line from twentyten
			if ( wp_attachment_is_image() ) :
				$attachments = array_values( get_children( array( 
					'post_parent' => $post->post_parent, 
					'post_status' => 'inherit', 
					'post_type' => 'attachment', 
					'post_mime_type' => 'image', 
					'order' => 'ASC', 
					'orderby' => 'menu_order ID' 
				) ) );
				foreach ( $attachments as $k => $attachment ) {
					if ( $attachment->ID == $post->ID )
						break;
				}
				$k++;
				
				// If there is more than 1 image attachment in a gallery
				if ( count( $attachments ) > 1 ) {
					if ( isset( $attachments[ $k ] ) )
						// get the URL of the next image attachment
						$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
					else
						// or get the URL of the first image attachment
						$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
				} 
				else {
				// or, if there's only 1 image attachment, get the URL of the image
				$next_attachment_url = wp_get_attachment_url();
				}
			?>
			<p class="attachment">
				<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
					$attachment_width = apply_filters('soup_attachment_width', $soup->options['attachment_page_img_width']);
					$attachment_height = apply_filters('soup_attachment_width', $soup->options['attachment_page_img_height']);
					
					echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); 
					// filterable image width with, essentially, no limit for image height.
				?></a></p>
				
				<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>
				
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>


				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_image_link( false ); ?></div>
					<div class="nav-next"><?php next_image_link( false ); ?></div>
				</div><!-- #nav-below -->
			<?php else : ?>
				<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
			<?php endif; ?>
		</div><!-- .entry-attachment -->


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
