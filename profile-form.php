<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/

$GLOBALS['current_user'] = $current_user = wp_get_current_user();
$GLOBALS['profileuser'] = $profileuser = get_user_to_edit( $current_user->ID );
?>

<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ) ?>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />

		<?php if ( has_filter( 'personal_options' ) || has_filter( 'profile_personal_options' ) ) : ?>
		<fieldset>
			<legend><?php _e( 'Personal Options', $theme_my_login->textdomain ); ?></legend>		

			<table class="form-table">
			<?php do_action( 'personal_options', $profileuser ); ?>
			</table>
			<?php do_action( 'profile_personal_options', $profileuser ); ?>
		<?php endif; ?>
		
		
		<fieldset>
			<legend><?php _e( 'Name', $theme_my_login->textdomain ) ?></legend>

			<div class="set">
				<label for="user_login"><?php _e( 'Username', $theme_my_login->textdomain ); ?> (<?php _e( 'Your username cannot be changed.', $theme_my_login->textdomain ); ?>)</label>
				<input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="text" /> <span class="description"></span>
			</div>


			<div class="set">
				<label for="first_name"><?php _e( 'First name', $theme_my_login->textdomain ) ?></label>
				<input type="text" name="first_name" id="first_name" 
					value="<?php echo esc_attr( $profileuser->first_name ) ?>" class="text" />
			</div>


			<div class="set">
				<label for="last_name"><?php _e( 'Last name', $theme_my_login->textdomain ) ?></label>
				<input type="text" name="last_name" id="last_name" 
					value="<?php echo esc_attr( $profileuser->last_name ) ?>" class="text" />
			</div>

			<div class="set">
				<label for="nickname"><?php _e( 'Nickname', $theme_my_login->textdomain ); ?> <?php _e( '(required)', $theme_my_login->textdomain ); ?></label>
				<input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ) ?>" class="text required" required="required" />
			</div>
			
			<div class="set">
				<label for="display_name"><?php _e( 'Display name publicly as', $theme_my_login->textdomain ) ?></label>
				<select name="display_name" id="display_name">
				<?php
					$public_display = array();
					$public_display['display_nickname']  = $profileuser->nickname;
					$public_display['display_username']  = $profileuser->user_login;
					if ( !empty( $profileuser->first_name ) )
						$public_display['display_firstname'] = $profileuser->first_name;
					if ( !empty( $profileuser->last_name ) )
						$public_display['display_lastname'] = $profileuser->last_name;
					if ( !empty( $profileuser->first_name ) && !empty( $profileuser->last_name ) ) {
						$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
						$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
					}
					if ( !in_array( $profileuser->display_name, $public_display ) )
						// Only add this if it isn't duplicated elsewhere
						$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;
					$public_display = array_map( 'trim', $public_display );
					foreach ( $public_display as $id => $item ) {
						$selected = ( $profileuser->display_name == $item ) ? ' selected="selected"' : '';
				?>
						<option id="<?php echo $id; ?>" value="<?php echo esc_attr( $item ); ?>"<?php echo $selected; ?>><?php echo $item; ?></option>
				<?php } ?>
				</select>				
			</div>

		</fieldset>
		
		
		
		<fieldset>

			<legend><?php _e( 'Contact Info', $theme_my_login->textdomain ) ?></legend>

			<div class="set">
				<label for="email"><?php _e( 'E-mail', $theme_my_login->textdomain ); ?> <?php _e( '(required)', $theme_my_login->textdomain ); ?></label>
				<input type="email" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ) ?>" class="email required" required="required" />
			</div>

			<div class="set">
				<label for="url"><?php _e( 'Website', $theme_my_login->textdomain ) ?></label>
				<input type="url" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ) ?>" class="url" />
			</div>

			<?php if ( function_exists( '_wp_get_user_contactmethods' ) ) :
				foreach ( _wp_get_user_contactmethods() as $name => $desc ) {
			?>
			<div class="set">
				<label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label>
				<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ) ?>" class="text" />
			</div>
			<?php
				}
				endif;
			?>
			</table>
		</fieldset>
		
		<fieldset>
			<legend><?php _e( 'About Yourself', $theme_my_login->textdomain ); ?></legend>

			<div class="set">
				<label for="description"><?php _e( 'Biographical Info', $theme_my_login->textdomain ); ?></label>
				<textarea name="description" id="description" rows="5" cols="30"><?php echo esc_html( $profileuser->description ); ?></textarea>
			</div>
		</fieldset>

			<?php
			$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
			if ( $show_password_fields ) :
			?>
			<fieldset>
				<legend>Change Password</legend>
				<p>If you would like to change the password type a new one. Otherwise leave this blank.</p>

				<p class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', $theme_my_login->textdomain ); ?></p>

			
			<div class="set">
				<label for="pass1"><?php _e( 'New Password', $theme_my_login->textdomain ); ?></label>
				<input type="password" name="pass1" id="pass1" class="text" size="16" value="" autocomplete="off" />
			</div>
			
			<div class="set">
				<label for="pass2">Confirm Password</label>
				<input type="password" name="pass2" id="pass2" class="text" size="16" value="" autocomplete="off" />
			</div>
			
			<div id="pass-strength-result"><?php _e( 'Strength indicator', $theme_my_login->textdomain ); ?></div>

			<?php endif; ?>
		</fieldset>

		<?php
			do_action( 'show_user_profile', $profileuser );
		?>

		<?php if ( count( $profileuser->caps ) > count( $profileuser->roles ) && apply_filters( 'additional_capabilities_display', true, $profileuser ) ) { ?>
		<br class="clear" />
			<table width="99%" style="border: none;" cellspacing="2" cellpadding="3" class="editform">
				<tr>
					<th scope="row"><?php _e( 'Additional Capabilities', $theme_my_login->textdomain ) ?></th>
					<td><?php
					$output = '';
					global $wp_roles;
					foreach ( $profileuser->caps as $cap => $value ) {
						if ( !$wp_roles->is_role( $cap ) ) {
							if ( $output != '' )
								$output .= ', ';
							$output .= $value ? $cap : "Denied: {$cap}";
						}
					}
					echo $output;
					?></td>
				</tr>
			</table>
		<?php } ?>

		<div class="submit">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="submit" value="<?php esc_attr_e( 'Update Profile', $theme_my_login->textdomain ); ?>" name="submit" />
		</div>
	</form>
</div>