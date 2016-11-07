<?php 
/*
Template Name: Clients List page
*/
?>

<?php if ( is_user_logged_in() && current_user_can( 'administrator' )  ) { ?>

<?php get_header(); ?>

<?php $users_args = array(
	'role'         => 'subscriber',
	'meta_key'     => 'user_type',
	'meta_value'   => 'client',
	'orderby'      => 'display_name'
 ); 
$users = get_users( $users_args ); 
//$users = false;
//echo '<pre class="debug">';print_r($users);echo '</pre>';
?>

<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article <?php post_class(); ?>>
				
				<div class="welcome-banner jumbotron wht-border-bottom">
					<div class="container">
					<?php the_content(); ?>	
					</div>
				</div>
				
				<?php if (!empty($users)) { ?>
				<section id="users-list">
				<div class="container">	
					<div class="panel panel-default">	
			
						<div class="panel-heading text-center">Clients</div>	
			
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th width="40%" class="text-center">Client name</th>
									<th width="40%" class="text-center">Email</th>
									<th width="15%" class="text-center">Cases</th>
									<th width="5%"></th>
							  	</tr>
							  	
							  	<?php foreach ($users as $user) { 
								$client_personal_raw = get_user_meta($user->ID, 'client_personal', true); 	
								$client_personal = unserialize($client_personal_raw); 	
								$client_contact_raw = get_user_meta($user->ID, 'client_contact', true);
								$client_contact = unserialize($client_contact_raw);
								$claims_args = array(
								'posts_per_page' => -1,
								'post_type'		=> 'post',
								'post_status'	=>	'private',
								'author'	=> $user->ID,
								'orderby'	=> 'date'
								);
								$claims = get_posts( $claims_args );
								//echo '<pre class="debug">';print_r($claims);echo '</pre>';
							  	?>
							  	<tr>
									<td class="text-center" style="vertical-align: middle;"><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></td>
									<td class="text-center" style="vertical-align: middle;"><a href="mailto:<?php echo $client_contact['email']; ?>"><?php echo $client_contact['email']; ?></a></td>
									<td class="text-center" style="vertical-align: middle;">
										<?php if (empty($claims)) { ?>
										[0]
										<?php } else { ?>
										<div class="btn-group">
										  <button type="button" class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Select a case <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
											  <?php foreach ($claims as $claim) { 
											   $case_ref = get_post_meta( $claim->ID, 'case_ref', true);
											  ?>
											  <li><a href="<?php echo get_permalink( $claim->ID ); ?>"><?php echo $case_ref; ?></a></li>
											  <?php } ?>
										   
										  </ul>
										</div>
										<?php } ?>
									</td>
									<td width="5%"><a href="<?php echo get_author_posts_url($user->ID); ?>" class="btn btn-success btn-block"><span class="sr-only">View client details</span><i class="fa fa-chevron-right fa-lg" style="line-height: 20px;"></i></a></th>
							  	</tr>
							  	<?php } ?>
							  	
							</tbody>
						</table>
						
					</div>
				</div>
				</section>
				<?php } else { ?>
				<div class="container">
					<div class="row">
						<div class="col-xs-8 col-xs-offset-2">
							<div class="well well-lg text-center">
								<h2>Sorry</h2>
								<p>There are no clients at the moment</p>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>

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