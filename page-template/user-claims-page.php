<?php 
/*
Template Name: User Claims Page
*/
?>

<?php get_header(); ?>

<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="user-account-info" <?php post_class(); ?>>
				
				<div class="welcome-banner jumbotron wht-border-bottom">
					<div class="container">
					<?php the_content(); ?>	
					</div>
				</div>
				
				<?php
				$user_id = $current_user->ID;
				
				$claims_args = array(
					'posts_per_page' => -1,
					'post_type'		=> 'post',
					'author'	=> $user_id,
					'orderby'	=> 'date'
				);
				$claims = get_posts( $claims_args );
				//echo '<pre class="debug">';print_r($claims);echo '</pre>';
				?>
				<section class="claims-list">
					<?php
					$case_status_raw = get_post_meta( $claims[0]->ID, 'case_status', true );
					$case_status = unserialize($case_status_raw);
					$fee_earner_raw = get_post_meta( $claims[0]->ID, 'fee_earner', true );
					$fee_earner = unserialize($fee_earner_raw);
					$insurer_raw = get_post_meta( $claims[0]->ID, 'insurer', true );
					$insurer = unserialize($insurer_raw);
					?>
					<div class="container">
					<div class="row">
					<div class="col-xs-6">
						
						<div class="panel panel-default">
				
					 		<div class="panel-heading text-center">Claim details</div>	
					
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th width="40%">Claim Reference:</th>
										<td><?php echo get_the_title( $claims[0]->ID ); ?></td>
								  	</tr>
								  	<tr>
										<th>Date created:</th>
										<td><?php echo $case_status[0]['date']; ?></td>
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
						
						<div class="col-xs-12">
							
							<?php if (!empty($insurer)) { ?>
								<div class="panel panel-default">
				
									<div class="panel-heading text-center">Insurer details</div>
									<table class="table table-bordered">
										<tbody>
											<tr>
												<th width="40%">Company:</th>
												<td><?php echo $insurer['company']; ?></td>
										  	</tr>
										  	<?php if ($insurer['ref']) { ?>
										  	<tr>
												<th>Reference number:</th>
												<td><?php echo $insurer['ref']; ?></td>
										  	</tr>	
										  	<?php } ?>
										  	<tr>
												<th>Policy number:</th>
												<td><?php echo $insurer['policy-number']; ?></td>
										  	</tr>	
										</tbody>
									</table>

								</div>		
							<?php } ?>
							
							<div class="panel panel-default">
				
					 		<div class="panel-heading text-center">Case status history</div>	
					
							<table class="table table-bordered">
								<tbody>
								  	<?php 
									$case_status = array_reverse($case_status); 	
									foreach ($case_status as $k => $status) {
									$date = date('l jS F, Y', strtotime( str_replace('/','-',$status['date']) ) ) ;
									//echo '<pre class="debug">';print_r($date);echo '</pre>';
								  	?>
								  	<tr<?php echo ($k == 0) ? ' class="success"':''; ?>>
									  	<td width="5%" class="text-center"><i class="fa fa-check-circle text-success"></i></td>
									  	<td width="45%" class="text-center"><strong><?php echo $date; ?></strong></td>
									  	<td width="50%" class="text-center"><?php echo $status['status']; ?></td>
								  	</tr>	
								  	<?php } ?>
								  	
								</tbody>
							</table>
								
							</div>
							
							<?php if (count($claims) > 1) { 
							unset($claims[0]);	
							?>
							<div class="rule"></div>
							
							<div class="panel panel-default">
				
					 		<div class="panel-heading text-center">Past claims archive</div>	
					
							<table class="table table-bordered">
								<tbody>
									<tr>
									<th width="5%"></th>
									<th width="45%" class="text-center">Case completion date</th>
									<th width="45%" class="text-center">Case reference</th>
									<th width="5%"></th>
									</tr>
									<?php foreach ($claims as $claim) { 
									$case_status_raw = get_post_meta( $claim->ID, 'case_status', true );
									$case_status = unserialize($case_status_raw);
									?>
									<tr>
									  	<td class="text-center"><i class="fa fa-info-circle text-primary"></i></td>
									  	<td class="text-center"><?php echo $case_status[count($case_status) - 1]['date']; ?></td>
									  	<td class="text-center"><?php echo get_the_title($claim->ID); ?></td>
									  	<td><a href="<?php echo get_permalink($claim->ID); ?>" class="btn btn-success btn-block"><span class="sr-only">View claim details</span> <i class="fa fa-chevron-right"><i></a></td>

								  	</tr>	
									<?php } ?>
								</tbody>
							</table>
								
							</div>
	
							<?php } ?>
						
						</div>

					</div>
					</div>

				</section>
				
			</article><!-- #post-## -->

			<?php endwhile; ?>

	<?php endif; ?>
</main><!-- .site-main -->

<?php get_footer(); ?>