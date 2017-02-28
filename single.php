<?php 
$user_id = get_current_user_id();	
?>
<?php if ($post->post_author == $user_id || current_user_can( 'administrator' ) ) { ?>
<?php get_header(); ?>
<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
			<article id="user-account-info" <?php post_class(); ?>>
				<section class="claims-list">
					<?php
					$case_progress_raw = get_post_meta( $post->ID, 'case_progress', true );
					$case_progress = unserialize($case_progress_raw);
					$fee_earner_raw = get_post_meta( $post->ID, 'fee_earner', true );
					$fee_earner = unserialize($fee_earner_raw);
					$claim_details_raw = get_post_meta( $post->ID, 'claim_details', true );
					$claim_details = unserialize($claim_details_raw);
					//echo '<pre class="debug">';print_r($claim_details);echo '</pre>';
					$case_ref = get_post_meta( $post->ID, 'case_ref', true);
					
					$client_personal_raw = get_user_meta($post->post_author, 'client_personal', true);
					$client_personal = unserialize($client_personal_raw);
					$client_contact_raw = get_user_meta($post->post_author, 'client_contact', true);
					$client_contact = unserialize($client_contact_raw);
					$case_status = get_post_meta( $post->ID, 'case_status', true);
					?>
					<div class="container">
						<div class="row">
							<div class="col-xs-9">
							<?php if ( current_user_can( 'administrator' ) ) { ?>
								<div class="panel panel-default">
						
							 		<div class="panel-heading text-center">Client details</div>	
							
									<table class="table table-bordered">
										<tbody>
											<tr>
												<th width="20%">Name:</th>
												<td width="30%"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></a></td>
												<th width="20%">Tel:</th>
												<td width="30%"><?php echo (!empty($client_contact[tel])) ? $client_contact[tel]:" - "; ?></td>
										  	</tr>
										  	<tr>
												<th>Email:</th>
												<td><a href="mailto:<?php echo $client_contact['email']; ?>"><?php echo $client_contact['email']; ?></a></td>
												<th>Mobile:</th>
												<td><?php echo (!empty($client_contact[mobile])) ? $client_contact[mobile]:" - "; ?></td>
										  	</tr>	
										</tbody>
									</table>
										
								</div>	
								<?php } ?>
								
								<div class="panel panel-default">
						
							 		<div class="panel-heading text-center">Claim details</div>	
							
									<table class="table table-bordered">
										<tbody>
											<tr>
												<th class="header_lg caps text-center" colspan="4">Claim Ref: <?php echo $case_ref; ?></th>
										  	</tr>
											<tr>
												<th width="20%">Claim type:</th>
												<td width="30%"><?php echo $claim_details['claim-type']; ?></td>
												<th width="20%">Case handler:</th>
												<td width="30%"><?php echo $fee_earner['name']; ?></td>
										  	</tr>
										  	<tr>
											  	<th>Date of accident:</th>
												<td><?php echo $claim_details['accident-date']; ?></td>
												<th>Email:</th>
												<td><a href="mailto:<?php echo $fee_earner['email']; ?>"><?php echo $fee_earner['email']; ?></a></td>
										  	</tr>	
										</tbody>
									</table>
										
								</div>	
								
								<?php if (count($case_progress) > 0) { ?>
								<div class="panel panel-default">
								
									<div class="panel-heading text-center">Case progress</div>	
					
									<table class="table table-bordered">
										<tbody>
										  	<tr>
											  	<th width="5%" class="text-center"><i class="fa fa-info-circle"></i></th>
											  	<th width="35%" class="text-center">Date</th>
											  	<th width="60%" class="text-center">Status</th>
										  	</tr>
										  	<?php 
											//array_shift($case_progress);	
											foreach ($case_progress as $k => $status) {
											$date = date('l jS F, Y', strtotime( str_replace('/','-',$status['date']) ) ) ;
											//echo '<pre class="debug">';print_r($date);echo '</pre>';
										  	?>
										  	<tr class="<?php echo ($k == 0) ? 'warning' : 'success'; ?>">
											  	<td class="text-center"><i class="fa <?php echo ($k == 0) ? 'fa-hourglass-half text-warning' : 'fa-check-circle text-success'; ?>"></i></td>
											  	<td class="text-center"><strong><?php echo $date; ?></strong></td>
											  	<td class="text-center"><?php echo $status['status']; ?></td>	
										  	</tr>	
										  	<?php } ?>
										  	
										</tbody>
									</table>
								
								</div>
								<?php } ?>
												
							</div><!-- end of 9 col -->
							<div class="col-xs-3 sidebar">
								<?php if ( current_user_can( 'administrator' ) ) { ?>
								<a href="<?php echo get_author_posts_url($post->post_author); ?>" class="btn btn-info btn-block btn-lg">
									<i class="fa fa-info-circle fa-lg pull-left"></i>
									Client profile
								</a>

								<div class="alert alert-info text-center case-progress <?php echo ($case_status == 'open') ? 'case-open':'case-closed'; ?>">
									<div class="icon bg-lines">
									 	<i class="fa fa-briefcase"></i>
									 	<div class="icon-label">Case status</div>
								 	</div>
									<div class="label caps label-<?php echo ($case_status == open) ? 'success':'danger'; ?> block"><?php echo $case_status; ?></div>
								</div>
								<?php } ?>
								
								<div class="alert alert-warning text-center case-progress">
							 		<?php 
								 	//$case_progress = array_reverse($case_progress); 
								 	$date = date('l jS F, Y', strtotime( str_replace('/','-',$case_progress[0]['date']) ) );
								 	$status = $case_progress[0]['status'];
								 	?>
								 	<div class="icon bg-lines">
									 	<i class="fa fa-hourglass-half"></i>
									 	<div class="icon-label">Recent Progress</div>
								 	</div>
								 	
									<div class="status-date"><?php echo $date; ?></div>
									<div class="case-status"><?php echo $status; ?></div>
									
								</div>

							</div><!-- end of 3 col -->
							
						</div><!-- end of row -->
					
					</div><!-- end of container -->
					
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