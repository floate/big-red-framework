<?php
global $soup;
if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
	die ( 'Please do not load this page directly. Thanks.' );
?>
<div id="comments" class="section"><section>
	<?php
	if ( post_password_required() ) : ?>
		<div class="nopassword">This post is protected. Enter the password to view any comments.</div>
		</div>
		<!--//#comments -->
	<?php 
		endif; //if ( post_password_required() ) : 
	
	
	if ( have_comments() ) :
		$ping_count = $comment_count = 0;
		foreach ( $comments as $comment ) {
			if (get_comment_type() == "comment") {
				$comment_count++;
			}
			else {
				$ping_count++;
			}
		}
		
		if ( $comment_count > 0 ) :
			?>
			<h2>
				<?php
				if ($comment_count > 1) {
					echo "$comment_count Comments";
				}
				else {
					echo "One Comment";
				}
				?>
			</h2>
			
			<ol id="commentsList" class="commentsList">
				<?php wp_list_comments(array(
					'type'=> 'comment',
					'callback' => array($soup,'commentTemplate')
					)); ?>
			</ol>
			<!-- //#comments-list -->
			
			<div id="comment-nav" class="page-nav nav">
				<div class="page-nav-older"><?php previous_comments_link('Older comments') ?></div>
				<div class="page-nav-newer"><?php next_comments_link('Newer comments') ?></div>
			</div>
			<!-- //#comment-nav -->
			<?php 
		endif; // REFERENCE: if ( $comment_count > 0 ) 
		
		if ( $ping_count > 0 ) :
			?>
			<h2>Links to This Page</h2>

			<ol id="trackbacksList" class="commentsList">
		<?php wp_list_comments(array(
			'type'=> 'pings',
			'callback' => array($soup,'pingTemplate')
			)); ?>
			</ol>
			<!-- //#trackbacksList -->

			<?php 
		endif; // REFERENCE: if ( $ping_count > 0 ) 

	endif; // REFERENCE: if ( have_comments() ) :	
	?>
	
	
	
	<div class="section"><section>
		<?php comment_form(array(
			'fields' => apply_filters('comment_form_default_fields', array(
				'author' => '<div class="comment-form-author inputPair text">' . '<label for="author">' . __( 'Name' ) . '</label> ' 
							. ( $req ? '<span class="required">*</span>' : '' ) .
				            '<input id="author" name="author" type="text" value="' . 
							esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req .
							( $req ? ' required' : '' ) . ' /></div>',
				'email'  => '<div class="comment-form-email inputPair email"><label for="email">' . __( 'Email' ) . '</label> ' .
							( $req ? '<span class="required">*</span>' : '' ) .
				            '<input id="email" name="email" type="email" value="' . 
							esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . 
							( $req ? ' required' : '' ) . ' /></div>',
				'url'    => '<div class="comment-form-url inputPair url"><label for="url">' . __( 'Website' ) . '</label>' .
				            '<input id="url" name="url" type="url" value="' . 
							esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'
				)),
				'comment_notes_after'  => '<p class="form-allowed-tags">' . 
						sprintf( __( 'You may use these <abbr>HTML</abbr> tags and attributes: %s' ), ' <code>' .
						allowed_tags() . '</code>' ) . '</p>',
				'comment_field' => '<div class="comment-form-comment inputPair textarea"><label for="comment">' . 
							_x( 'Comment', 'noun' ) . '</label>' . 
							'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
		
			)); ?>
			
			
		<?php
		if ( get_option('comment_registration') && !$user_ID ) :
			$soup->loginForm();
		endif;
		?>
	</section></div>
	
	
</section></div>