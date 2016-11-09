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
					$insurer_raw = get_post_meta( $post->ID, 'insurer', true );
					$insurer = unserialize($insurer_raw);
					?>
					<div class="container">
					
					<?php if ( current_user_can( 'administrator' ) ) { ?>
					<?php 
					$client_personal_raw = get_user_meta($post->post_author, 'client_personal', true);
					$client_personal = unserialize($client_personal_raw);
					$client_contact_raw = get_user_meta($post->post_author, 'client_contact', true);
					$client_contact = unserialize($client_contact_raw);
					$case_status = get_post_meta( $post->ID, 'case_status', true);
					$case_ref = get_post_meta( $post->ID, 'case_ref', true);
					//echo '<pre class="debug">';print_r($client_contact);echo '</pre>';
					?>
					<div class="row" style="margin-bottom: 20px;">
						<div class="col-xs-4">
						<a href="/cases/" class="btn btn-info btn-block btn-lg"><i class="fa fa-chevron-left fa-lg pull-left" style="line-height: 25px;"></i> Back to cases</a>
						</div>
						<div class="col-xs-4">
							<div class="label label-<?php echo ($case_status == open) ? 'success':'danger'; ?> block" style="line-height: 38px;">
								<i class="fa fa-briefcase fa-lg pull-left" style="line-height: 38px;"></i>Case status: <?php echo $case_status; ?>
							</div>
						</div>
						<div class="col-xs-4">
							<a href="<?php echo get_author_posts_url($post->post_author); ?>" class="btn btn-info btn-block btn-lg">View client details<i class="fa fa-info-circle fa-lg pull-right" style="line-height: 25px;"></i></a>
						</div>

					</div>
						
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
					<div class="row">
					<div class="col-xs-6">
						
						<div class="panel panel-default">
				
					 		<div class="panel-heading text-center">Claim details</div>	
					
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th width="40%">Claim Reference:</th>
										<td><?php echo $case_ref; ?></td>
								  	</tr>
								  	<tr>
										<th>Date created:</th>
										<td><?php echo $case_progress[0]['date']; ?></td>
								  	</tr>	
								</tbody>
							</table>
								
						</div>	
						
					</div>	
					<div class="col-xs-6">
						
						<div class="panel panel-default">
				
					 		<div class="panel-heading text-center">Case handler</div>	
					
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th width="40%">Name:</th>
										<td><?php echo $fee_earner['name']; ?></td>
								  	</tr>
								  	<tr>
										<th>Email:</th>
										<td><a href="mailto:<?php echo $fee_earner['email']; ?>"><?php echo $fee_earner['email']; ?></a></td>
								  	</tr>	
								</tbody>
							</table>
								
						</div>	

					</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="panel panel-default">
			
								<div class="panel-heading text-center">Additional information</div>
								
								<div class="panel-body add-info-txt">
									<?php the_content(); ?>
								</div>

							</div>		
						</div>
						<div class="col-xs-6">
							<div class="panel panel-default">
			
								<div class="panel-heading text-center">Insurer details</div>
								<table class="table table-bordered">
									<tbody>
										<tr>
											<th width="40%">Company:</th>
											<td width="60%"><?php echo ($insurer['company']) ? $insurer['company'] : " - "; ?></td>
									  	</tr>
									  	<tr>
											<th>Reference number:</th>
											<td><?php echo ($insurer['ref']) ? $insurer['ref'] : " - "; ?></td>
									  	</tr>	
									  	<tr>
											<th>Policy number:</th>
											<td><?php echo ($insurer['policy-number']) ? $insurer['policy-number'] : " - "; ?></td>
									  	</tr>	
									</tbody>
								</table>

							</div>			
						</div>
					</div>
					<div class="row">
						
						<div class="col-xs-12">
																					
							<div class="panel panel-default">
				
					 		<div class="panel-heading text-center">Case progress</div>	
					
							<table class="table table-bordered">
								<tbody>
								  	<tr>
									  	<th width="45%" class="text-center">Date</th>
									  	<th width="50%" class="text-center">Status</th>
									  	<th width="5%" class="text-center"><i class="fa fa-info-circle"></i></th>
								  	</tr>
								  	<?php 
									$case_progress = array_reverse($case_progress); 	
									foreach ($case_progress as $k => $status) {
									$date = date('l jS F, Y', strtotime( str_replace('/','-',$status['date']) ) ) ;
									//echo '<pre class="debug">';print_r($date);echo '</pre>';
								  	?>
								  	<tr<?php echo ($k == 0) ? ' class="success"':''; ?>>
									  	<td class="text-center"><strong><?php echo $date; ?></strong></td>
									  	<td class="text-center"><?php echo $status['status']; ?></td>
									  	<td class="text-center">
										  	<?php if ($k == 0) { ?>
										  	<i class="fa fa-clock-o text-info"></i>		
										  	<?php } else { ?>
										  	<i class="fa fa-check-circle text-success"></i>		
										  	<?php } ?>
										</td>
								  	</tr>	
								  	<?php } ?>
								  	
								</tbody>
							</table>
								
							</div>
													
						</div>

					</div>
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