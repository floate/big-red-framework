<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'login' ); ?>
	<?php $template->the_errors(); ?>
	<form name="loginform" id="tmloginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
		<div class="tm-login-form-user inputPair inputSet set-text">
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username', 'theme-my-login' ) ?></label>
			<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" required="required" class="text required" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
		</div>
		<div class="tm-login-form-pass inputPair inputSet set-password">
			<label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Password', 'theme-my-login' ) ?></label>
			<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" required="required" class="password required" value="" size="20" />
		</div>
<?php
do_action( 'login_form' ); // Wordpress hook
do_action_ref_array( 'tml_login_form', array( &$template ) ); // TML hook
?>
		<div class="forgetmenot inputPair inputSet set-checkbox">
			<input class="checkbox" name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
			<label for="rememberme<?php $template->the_instance(); ?>"><?php _e( 'Remember Me', 'theme-my-login' ); ?></label>
		</div>
		<div class="inputPair inputSet set-submit">
			<input type="submit" class="submit" name="wp-submit" id="tm-wp-submit<?php $template->the_instance(); ?>" value="<?php _e( 'Log In', 'theme-my-login' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="testcookie" value="1" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
		</div>
	</form>
	<?php $template->the_action_links( array( 'login' => false ) ); ?>
</div>