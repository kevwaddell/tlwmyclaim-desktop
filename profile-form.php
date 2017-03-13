<?php 
$user_id = $current_user->ID;
$user_type = get_user_meta( $user_id, 'user_type', true); 
$contact_pg = get_page_by_path( 'contact-us');
$dashboard_pg = get_page_by_path( 'dashboard' );
$cases_pg =  get_option('page_for_posts');
?>

<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
		<?php $template->the_action_template_message( 'profile' ); ?>
		<?php $template->the_errors(); ?>
		
		<?php do_action( 'profile_personal_options', $profileuser ); ?>
		
		<div class="panel panel-default">
		  <div class="panel-heading text-center">Account details</div>
		  	<?php if ($user_type == 'client') { ?>
		  	 <?php get_template_part( 'parts/profile/client', 'contact' ); ?>
		  	<?php } else { ?>
		  	 <?php get_template_part( 'parts/profile/ref', 'contact' ); ?>
		  	<?php } ?>
		</div>
		
		<?php if ($user_type == 'client') { ?>
	  	 <?php get_template_part( 'parts/profile/client', 'address' ); ?>
	  	<?php } ?>
		
		
		<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		
		<input type="hidden" name="from" value="profile" />
		<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		<input type="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" />
		<input type="hidden" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" />
		
			<div class="panel panel-default">
				  <div class="panel-heading text-center">Account Password</div>
				  <div class="panel-body">
					  			
					<?php
					$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
					if ( $show_password_fields ) :
					?>
					
						<table class="tml-form-table" width="100%">
						<tr id="password" class="user-pass1-wrap">
							<td>
								<input class="hidden form-control input-lg" value=" " /><!-- #24364 workaround -->
								<button type="button" class="btn btn-block btn-default btn-lg wp-generate-pw hide-if-no-js red-btn">Generate New Password<i class="fa fa-refresh pull-right"></i></button>
								<div class="wp-pwd hide-if-js">
									<span class="password-input-wrapper">
										<input type="password" name="pass1" id="pass1" class="regular-text form-control input-lg" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
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
				
						</table>
						<?php endif; ?>
						
						<p class="tml-submit-wrap">
						<input type="hidden" name="action" value="profile" />
						<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
						<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
<!-- 						<input type="submit" class="btn btn-default btn-lg btn-block button-primary" value="<?php esc_attr_e( 'Change password', 'theme-my-login' ); ?>" name="submit" id="submit" /> -->
						<button type="submit" class="btn btn-success btn-lg btn-block">Change password<i class="fa fa-check"></i></button>
						</p>
				  </div>
			</div>

			<?php do_action( 'show_user_profile', $profileuser ); ?>
	
		</form>
		
		<a href="<?php echo get_permalink( $contact_pg->ID ); ?>" class="red-btn btn btn-block btn-lg">
			<i class="fa fa-envelope fa-lg"></i>
			<?php echo get_the_title($contact_pg->ID); ?>
		</a>
		<a href="<?php echo get_permalink($dashboard_pg->ID ); ?>" class="red-btn btn btn-block btn-lg">
			<i class="fa fa-dashboard"></i>
			<?php echo get_the_title($dashboard_pg->ID); ?>
		</a>
		<a href="<?php echo wp_logout_url( $redirect ); ?>" class="red-btn btn btn-block btn-lg">
			<i class="fa fa-power-off fa-lg"></i>
			Log Out
		</a>
	
</div>
