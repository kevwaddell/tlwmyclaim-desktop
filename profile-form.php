<?php //echo '<pre class="debug">';print_r($template);echo '</pre>'; ?>

<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
		<?php $template->the_action_template_message( 'profile' ); ?>
		<?php $template->the_errors(); ?>
		
		<?php do_action( 'profile_personal_options', $profileuser ); ?>
		
		<div class="panel panel-default">
			  <div class="panel-heading text-center">Account details</div>
			  <div class="panel-body">
				  <div class="row">
					<div class="col-xs-6 text-center">
						<p>Email/username:</p>
						<p><?php echo esc_attr( $profileuser->user_email ); ?></p>
					</div>
					<div class="col-xs-6 text-center">
						<p>Full Name:</p>
						<p><?php echo esc_attr( $profileuser->first_name ); ?> <?php echo esc_attr( $profileuser->last_name ); ?></p>
					</div>
				  </div>
			  </div>
		</div>
		<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		
		<input type="hidden" name="from" value="profile" />
		<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		<input type="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" />
		<input type="hidden" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" />
		
		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		
		<div class="panel panel-default">
			  <div class="panel-heading text-center">Account Password</div>
			  <div class="panel-body">
				  <div class="row">
					<div class="col-xs-6 text-center">
						
					</div>
					<div class="col-xs-6 text-center">
						
					</div>
				  </div>
			  </div>
		</div>
		
		<h3>Account Password</h3>
		<table class="tml-form-table">
		<tr id="password" class="user-pass1-wrap">
			<th><label for="pass1">New Password</label></th>
			<td>
				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<button type="button" class="btn btn-default wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
				<div class="wp-pwd hide-if-js">
					<span class="password-input-wrapper">
						<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
					</span>
					<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
					<button type="button" class="btn btn-defaulty wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Hide password">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text">Hide</span>
					</button>
					<button type="button" class="btn btn-default wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="Cancel password change">
						<span class="text">Cancel</span>
					</button>
				</div>
			</td>
		</tr>
		<tr class="user-pass2-wrap hide-if-js">
			<th scope="row"><label for="pass2">Repeat New Password</label></th>
			<td>
			<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
			<p class="description">Type your new password again.</p>
			</td>
		</tr>
		<tr class="pw-weak">
			<th>Confirm Password</th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					Confirm use of weak password
				</label>
			</td>
		</tr>
		<?php endif; ?>

		</table>

		<?php do_action( 'show_user_profile', $profileuser ); ?>
		
			<p class="tml-submit-wrap">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="btn btn-success btn-lg btn-block button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit" />
			</p>
	</form>
</div>
