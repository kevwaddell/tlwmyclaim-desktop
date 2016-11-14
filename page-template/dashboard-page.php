<?php 
/*
Template Name: Dashboard page
*/
?>
<?php if ( is_user_logged_in() ) { ?>
<?php
$user_id = $current_user->ID;
$user_type = get_user_meta( $user_id, 'user_type', true);
//echo '<pre class="debug">';print_r($user_id);echo '</pre>';?>
<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class(); ?>>
					<div class="jumbotron wht-border-bottom">
						<div class="container text-center">
							<?php if ($user_type == 'client') { 
							$client_personal_raw = get_user_meta($user_id, 'client_personal', true); 	
							$client_personal = unserialize($client_personal_raw); 
							//echo '<pre class="debug">';print_r($client_personal);echo '</pre>';
							?>
							<h1>Welcome <?php echo $client_personal['forename']; ?></h1>
							<p><strong>To your TLW Solicitors client account.</strong></p>
							<?php } ?>
							<?php if ($user_type == 'ref') { 
							$company = get_user_meta( $user_id, 'company_name', true);	
							?>
							<h1><?php echo $company; ?></h1>
							<p><strong>TLW Solicitors referrer account.</strong></p>
							<?php } ?>
						</div>
					</div>
					
					<section id="dashboard-panels">
						<div class="container">
							<div class="panel panel-default">
								<?php if ($user_type == 'client') { ?>
								<?php get_template_part( 'parts/dashboard/client', 'panels' ); ?>
								<?php } ?>
							</div>
					</section>
								
				</article><!-- #post-## -->
			
			
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