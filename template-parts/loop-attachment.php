<?php 
while ( have_posts() ) : the_post(); ?>
<div id="contentHeadA" <?php post_class('article'); ?> role="main">
	<div id="contentHead" class="header">
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
				
	</div>			

	<div id="contentA">
		<div class="entry-content section">



			<div class="entry-attachment">
			<?php 
			//adapted from 20ten
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
				
				// If there is more than 1 image attachment in a gallery
				if ( count( $attachments ) > 1 ) {
					if ( isset( $attachments[ $k+1 ] ) ) {
						// get the URL of the next image attachment
						$next_attachment_link = '<a href="';
						$next_attachment_link .= get_attachment_link( $attachments[ $k+1 ]->ID );
						$next_attachment_link .= '" title="';
						$next_attachment_link .= esc_attr( get_the_title($attachments[ $k+1 ]->ID) );
						$next_attachment_link .= '"><span class="direction">Next image </span> ';
						$next_attachment_link .= '<span class="title">';
						$next_attachment_link .= esc_attr( get_the_title($attachments[ $k+1 ]->ID) );
						$next_attachment_link .= '</span></a>';
					}
					if ( isset( $attachments[ $k-1 ] ) ) {
						// get the URL of the prev image attachment
						$prev_attachment_link = '<a href="';
						$prev_attachment_link .= get_attachment_link( $attachments[ $k-1 ]->ID );
						$prev_attachment_link .= '" title="';
						$prev_attachment_link .= esc_attr( get_the_title($attachments[ $k-1 ]->ID) );
						$prev_attachment_link .= '"><span class="direction">Previous image </span> ';
						$prev_attachment_link .= '<span class="title">';
						$prev_attachment_link .= esc_attr( get_the_title($attachments[ $k-1 ]->ID) );
						$prev_attachment_link .= '</span></a>';
					}
				}
				
				
				$attachment_width = apply_filters('soup_attachment_width', bigRed_option('attachment_page_img_width',600));
				$attachment_height = apply_filters('soup_attachment_width', bigRed_option('attachment_page_img_width',600));
				
				if ( ($metadata['width'] > $attachment_width) OR ($metadata['height'] > $attachment_height) ) {
					$zoom_attachment_link = '<a href="' . wp_get_attachment_url() . '" title="';
					$zoom_attachment_link .= esc_attr( get_the_title() ) . '" rel="attachment">';
					
					$zoom_attachment_link_close = '</a>';
				}
			?>
			<p class="attachment">
				<?php
					echo $zoom_attachment_link;
					echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); 
					echo $zoom_attachment_link_close;
					// filterable image width with, essentially, no limit for image height.
				?>
				</p>
				
				<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>
				
				<?php wp_link_pages('before=<div id="post-nav" class="page-nav post-nav nav">Pages:&after=</div>&link_before=<span>&link_after=</span>');  ?>


				
			<?php else : ?>
				<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
			<?php endif; ?>
		</div><!-- .entry-attachment -->


		</div>
		<div class="footer">
			<p class="entry-meta">
			<?php 
			if ( ! empty( $post->post_parent ) ) : 
				?>
				Part of <span class="entry-parent"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( get_the_title( $post->post_parent ) ); ?>" rel="parent"><?php
					/* translators: %s - title of parent post */
					echo esc_attr( get_the_title( $post->post_parent ) );
				?></a></span> &bull;
				<?php
			endif; 
			
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
		<div id="page-nav" class="page-nav nav">
			<div class="page-nav-older"><?php echo $prev_attachment_link; ?></div>
			<div class="page-nav-newer"><?php echo $next_attachment_link; ?></div>
		</div>
		<!-- //#page-nav -->
		
		
		<?php comments_template(); ?>
	
		</div>
		<!-- //#contentA -->
	</div>
	<!-- //#contentHeadA -->
<?php endwhile; ?>
