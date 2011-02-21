<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'register' ); ?>
	<?php $template->the_errors(); ?>
    <form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
        <div class="inputPair inputSet set-text">
            <label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username', 'theme-my-login' ) ?></label>
            <input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input input-text" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
        </div>
        <div class="inputPair inputSet set-email">
            <label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail', 'theme-my-login' ) ?></label>
            <input type="email" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input input-text" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
        </div>
<?php
do_action( 'register_form' ); // Wordpress hook
do_action_ref_array( 'tml_register_form', array( &$template ) ); //TML hook
?>
		<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.', $theme_my_login->textdomain ) ); ?></p>
        <div class="set-submit inputSet inputPair">
            <input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php _e( 'Register', 'theme-my-login' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
        </div>
    </form>
	<?php $template->the_action_links( array( 'register' => false ) ); ?>
</div>