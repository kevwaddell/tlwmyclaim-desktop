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

$cases_pg =  get_option('page_for_posts');
$referrers_pg = get_page_by_path( 'referrers' );	
//$users = false;
//echo '<pre class="debug">';print_r($users);echo '</pre>';
?>

<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article <?php post_class(); ?>>
				
				<div class="jumbotron wht-border-bottom">
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
									<th width="30%" class="text-center">Case ref</th>
									<th width="35%" class="text-center">Client name</th>
									<th width="35%" class="text-center">Email</th>
							  	</tr>
							  	
							  	<?php foreach ($users as $user) { 
								//echo '<pre class="debug">';print_r($user->ID);echo '</pre>';
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
								  	<td class="text-center">
										<?php if (count($claims) == 1) { 
										$case_ref = get_post_meta( $claims[0]->ID, 'case_ref', true);	
										?>
										<a href="<?php echo get_permalink( $claims[0]->ID ); ?>"><?php echo $case_ref; ?></a>
										<?php } else { ?>
										<div class="btn-group">
										  <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Select a case <i class="fa fa-angle-down"></i>
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

									<td class="text-center"><a href="<?php echo get_author_posts_url($user->ID); ?>"><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></a></td>
									<td class="text-center"><a href="mailto:<?php echo $client_contact['email']; ?>"><?php echo $client_contact['email']; ?></a></td>
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
							<div class="well well-lg well-message text-center">
								<i class="fa fa-group"></i>
								<h2>Sorry</h2>
								<p>There are no clients at the moment.</p>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<div class="container">
					<div class="rule"></div>
					<div class="btns-group">
						<a href="<?php echo get_permalink($cases_pg); ?>" class="red-btn btn btn-block btn-lg">
							<?php echo get_the_title($cases_pg); ?> archive <i class="fa fa-folder-open"></i>
						</a>
						<a href="<?php echo get_permalink($referrers_pg->ID ); ?>" class="red-btn btn btn-block btn-lg">
							<?php echo get_the_title($referrers_pg->ID); ?> archive <i class="fa fa-building"></i>
						</a>
						<a href="<?php echo wp_logout_url( $redirect ); ?>" class="red-btn btn btn-block btn-lg">
							Log Out <i class="fa fa-power-off"></i>
						</a>
					</div>
				</div>

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