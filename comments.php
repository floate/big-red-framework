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
		<?php 
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		
		$commentFields = array(
			'author' => "<div class='inputPair inputSet set-text comment-form-author'>\n" .
						"<label for='comment-form-author'> " . __('Name') . 
						( $req ? " <span class='required'>*</span>" : "" ) . " </label>\n" .
						"<input type='text' id='comment-form-author' name='author' value='" .
						esc_attr( $commenter['comment_author'] ) . "' size='30' class='" .
						"text" . ($req ? " required' $aria_req required='required" : "") . 
						"' /> </div>",


			'email' => "<div class='inputPair inputSet set-email comment-form-email'>\n" .
						"<label for='comment-form-email'> " . __('Email') . 
						( $req ? " <span class='required'>*</span>" : "" ) . " </label>\n" .
						"<input type='email' id='comment-form-email' name='email' value='" .
						esc_attr( $commenter['comment_author_email'] ) . "' size='30' class='" .
						"email" . ($req ? " required' $aria_req required='required" : "") . 
						"' /> </div>",


			'url' => "<div class='inputPair inputSet set-url comment-form-url'>\n" .
						"<label for='comment-form-url'> " . __('Website') . " </label>\n" .
						"<input type='url' id='comment-form-url' name='url' value='" .
						esc_attr( $commenter['comment_author_url'] ) . "' size='30' " . 
						"class='url' /> </div>"

		);
		
		
		
		comment_form(array(
			'fields' => apply_filters('comment_form_default_fields', $commentFields),
				'comment_notes_after'  => '<p class="form-allowed-tags">' . 
						sprintf( __( 'You may use these <abbr>HTML</abbr> tags and attributes: %s' ), ' <code>' .
						allowed_tags() . '</code>' ) . '</p>',
				'comment_field' => "<div class='inputPair inputSet set-textarea comment-form-comment'>\n" .
							"<label for='comment-form-comment'> " . _x( 'Comment', 'noun' ) . 
							" <span class='required'>*</span> </label>\n" .
							"<textarea id='comment-form-comment' name='comment' " .
							"cols='45' rows='8' class='required' $aria_req required='required'>" . 
							"</textarea> </div>",
							
				'id_submit' => 'comment-form-submit'
		
			)); ?>
			
			
		<?php
		if ( get_option('comment_registration') && !$user_ID ) :
			$soup->loginForm();
		endif;
		?>
	</section></div>
	
	
</section></div>