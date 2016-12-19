<?php 
/*
Template Name: User Claims Page
*/
?>
<?php if ( is_user_logged_in() ) { ?>

<?php get_header(); ?>

<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="user-account-info" <?php post_class(); ?>>
				
				<div class="jumbotron wht-border-bottom">
					<div class="container">
					<?php the_content(); ?>	
					</div>
				</div>
				
				<?php
				$user_id = $current_user->ID;
				
				$claims_args = array(
					'posts_per_page' => 1,
					'post_type'		=> 'post',
					'post_status'	=>	'private',
					'author'	=> $user_id,
					'orderby'	=> 'date'
				);
				$claims = get_posts( $claims_args );
				//echo '<pre class="debug">';print_r($claims);echo '</pre>';
				?>
				<section class="claims-list">
					<?php
					$case_progress_raw = get_post_meta( $claims[0]->ID, 'case_progress', true );
					$case_progress = unserialize($case_progress_raw);
					$fee_earner_raw = get_post_meta( $claims[0]->ID, 'fee_earner', true );
					$fee_earner = unserialize($fee_earner_raw);
					$insurer_raw = get_post_meta( $claims[0]->ID, 'insurer', true );
					$insurer = unserialize($insurer_raw);
					$case_ref = get_post_meta( $claims[0]->ID, 'case_ref', true);
					$post_content = $claims[0]->post_content;
					$additinal_info = apply_filters( "the_content", $post_content );
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
						
						<div class="col-xs-12">
							
							<div class="alert alert-info text-center case-progress">
						 		<?php 
							 	$case_progress = array_reverse($case_progress); 
							 	$date = date('l jS F, Y', strtotime( str_replace('/','-',$case_progress[0]['date']) ) );
							 	$status = $case_progress[0]['status'];
							 	?>
							 	<div class="icon">
								 	<i class="fa fa-clock-o fa-3x"></i>
								 	<div class="icon-label">Case Status</div>
							 	</div>
							 	
								<div class="status-date"><?php echo $date; ?></div>
								<div class="case-status"><?php echo $status; ?></div>
								
							</div>
						
						</div>

					</div>
					<div class="row">
						
						<div class="col-xs-12">
							
							<div class="panel panel-default">
				
						 		<div class="panel-heading text-center">Case history</div>	
						
								<table class="table table-bordered">
									<tbody>
										<tr>
											<th width="5%" class="text-center"><i class="fa fa-info-circle"></i></th>
											<th width="45%" class="text-center">Date</th>
											<th width="50%" class="text-center">Details</th>
										</tr>
									  	<?php 
										array_shift($case_progress);
										foreach ($case_progress as $k => $progress) {
										$date = date('l jS F, Y', strtotime( str_replace('/','-',$progress['date']) ) );
										//echo '<pre class="debug">';print_r($date);echo '</pre>';
									  	?>
									  	<tr class="success">
										  	<td class="text-center"><i class="fa fa-check-circle text-success"></i></td>
										  	<td class="text-center"><strong><?php echo $date; ?></strong></td>
										  	<td class="text-center"><?php echo $progress['status']; ?></td>
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