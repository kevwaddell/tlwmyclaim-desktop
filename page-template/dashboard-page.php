<?php 
/*
Template Name: Dashboard page
*/
?>
<?php if ( is_user_logged_in() ) { ?>
<?php
$user_id = $current_user->ID;
$user_type = get_user_meta( $user_id, 'user_type', true);
$contact_pg = get_page_by_path( 'contact-us');	
$account_pg = get_page_by_path( 'account-details' );
$cases_pg =  get_option('page_for_posts');
$claim_pg = get_page_by_path( 'your-claim');
//echo '<pre class="debug">';print_r($user_id);echo '</pre>';?>
<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<div class="jumbotron wht-border-bottom">
					<div class="container text-center">
						<?php if ($user_type == 'client') { 
						$client_personal_raw = get_user_meta($user_id, 'client_personal', true); 	
						$client_personal = unserialize($client_personal_raw); 
						//echo '<pre class="debug">';print_r($client_personal);echo '</pre>';
						?>
						<h1>Welcome <?php echo $client_personal['forename']; ?></h1>
						<p><strong>To the TLW Solicitors account portal.</strong></p>
						<?php } ?>
						<?php if ($user_type == 'ref') { 
						$company = get_user_meta( $user_id, 'company_name', true);	
						?>
						<h1>Referrer account dashboard</h1>
						<p><strong>A brief overview of referred cases from<br><span class="caps"><?php echo $company; ?></span></strong></p>
						<?php } ?>
					</div>
				</div>

				<div class="container">
										
					<section id="dashboard-panels">
						<?php if ($user_type == 'client') { ?>
						<?php get_template_part( 'parts/dashboard/client', 'panels' ); ?>
						<?php } ?>
							<?php if ($user_type == 'ref') { ?>
						<?php get_template_part( 'parts/dashboard/ref', 'panels' ); ?>
						<?php } ?>
					</section>
					<div class="rule"></div>
					<div class="btns-group">
						<?php if ($user_type == 'ref') { ?>
						<a href="<?php echo get_permalink( $cases_pg ); ?>" class="red-btn btn btn-block btn-lg">
							<?php echo get_the_title($cases_pg); ?> archive<i class="fa fa-folder-open fa-lg"></i>
						</a>
						<?php } ?>
						<?php if ($user_type == 'client') { ?>
						<a href="<?php echo get_permalink($claim_pg->ID); ?>" class="red-btn btn btn-block btn-lg">
							<i class="fa fa-folder-open"></i>
							<?php echo get_the_title($claim_pg->ID); ?>
						</a>
						<?php } ?>
						<a href="<?php echo get_permalink( $account_pg->ID ); ?>" class="red-btn btn btn-block btn-lg">
							<?php echo get_the_title($account_pg->ID); ?><i class="fa fa-vcard fa-lg"></i>
						</a>
						<a href="<?php echo get_permalink( $contact_pg->ID ); ?>" class="red-btn btn btn-block btn-lg">
							<?php echo get_the_title($contact_pg->ID); ?><i class="fa fa-envelope fa-lg"></i>
						</a>
						<a href="<?php echo wp_logout_url( $redirect ); ?>" class="red-btn btn btn-block btn-lg">
							Log Out<i class="fa fa-power-off fa-lg"></i>
						</a>
					</div>
								
				</div><!-- #post-## -->
			
			<?php endwhile; ?>

		<?php endif; ?>
	</main><!-- .site-main -->

<?php get_footer(); ?>
<?php } else { ?>
<?php 
$index_id = get_option( 'page_on_front' );
$url = get_permalink( $index_id  );
wp_safe_redirect( $url );
exit;
?>
<?php }	?>