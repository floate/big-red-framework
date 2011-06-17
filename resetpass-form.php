<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'resetpass' ); ?>
	<?php $template->the_errors(); ?>
	<form name="resetpasswordform" id="resetpasswordform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'resetpass' ); ?>" method="post">
		<div class="set">
			<label for="pass1<?php $template->the_instance(); ?>"><?php _e( 'New Password:', $theme_my_login->textdomain );?></label>
			<input autocomplete="off" name="pass1" id="pass1<?php $template->the_instance(); ?>" class="password" size="20" value="" type="password" />
		</div>
		<div class="set">
			<label for="pass2<?php $template->the_instance(); ?>"><?php _e( 'Confirm Password:', $theme_my_login->textdomain );?></label>
			<input autocomplete="off" name="pass2" id="pass2<?php $template->the_instance(); ?>" class="password" size="20" value="" type="password" />
		</div>
<?php
do_action( 'resetpassword_form' ); // Wordpress hook
do_action_ref_array( 'tml_resetpassword_form', array( $template ) ); // TML hook
?>
		<div class="submit">
			<input type="submit" class="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php _e( 'Change Password', $theme_my_login->textdomain ); ?>" />
			<input type="hidden" name="key" value="<?php $template->the_posted_value( 'key' ); ?>" />
			<input type="hidden" name="login" value="<?php $template->the_posted_value( 'login' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
		</div>
	</form>
	<?php $template->the_action_links( array( 'lost_password' => false ) ); ?>
</div>