<?php get_header(); ?>

<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="user-account-info" <?php post_class(); ?>>
				<section class="claims-list">
					<?php
					$case_status_raw = get_post_meta( $post->ID, 'case_status', true );
					$case_status = unserialize($case_status_raw);
					$fee_earner_raw = get_post_meta( $post->ID, 'fee_earner', true );
					$fee_earner = unserialize($fee_earner_raw);
					$insurer_raw = get_post_meta( $post->ID, 'insurer', true );
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
										<td><?php the_title(); ?></td>
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
									  	<td width="5%" class="text-center">
										  	<?php if ($k == 0) { ?>
										  	<i class="fa fa-check-circle text-success"></i>	
										  	<?php } else { ?>
										  	<i class="fa fa-clock-o text-info"></i>		
										  	<?php } ?>
										</td>
									  	<td width="45%" class="text-center"><strong><?php echo $date; ?></strong></td>
									  	<td width="50%" class="text-center"><?php echo $status['status']; ?></td>
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