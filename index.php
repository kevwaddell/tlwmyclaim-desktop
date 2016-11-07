<?php if ( is_user_logged_in() && current_user_can( 'administrator' ) ) { ?>

<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		
		<div class="welcome-banner jumbotron wht-border-bottom">
			<div class="container text-center">
				<h1>Client cases archive</h1>
				<p><strong>TLW's recent open and completed case files</strong></p>
			</div>
		</div>
		
		<div class="container">
		
		<section id="client-cases">
			
		<?php if ( have_posts() ) : ?>
		<div class="panel panel-default">	
			
			<div class="panel-heading text-center">Recent cases</div>	
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<td colspan="6">Status: <span class="label label-success">Open</span> <span class="label label-danger">Closed</span></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th width="20%">Ref:</th>
						<th width="20%">Client name:</th>
						<th width="25%">Progress status:</th>
						<th width="15%">Date created:</th>
						<th width="15%">Referer:</th>
						<th width="5%"></th>
				  	</tr>
				  	<?php while ( have_posts() ) : the_post(); ?>
				  	<?php
					$case_progress_raw = get_post_meta( $post->ID, 'case_progress', true );
					$case_progress = unserialize($case_progress_raw);
					$client_personal_raw = get_user_meta($post->post_author, 'client_personal', true);
					$client_personal = unserialize($client_personal_raw); 	
					$case_status = get_post_meta( $post->ID, 'case_status', true);
					$case_ref = get_post_meta( $post->ID, 'case_ref', true);
					$referer = get_post_meta( $post->ID, 'src_company', true);
					//echo '<pre class="debug">';print_r($case_status);echo '</pre>';
				  	?>
				  	<tr class="<?php echo ($case_status == "open") ? 'success':'danger'; ?>">
					  	<td><?php echo $case_ref; ?></td>
					  	<td><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></td>
					  	<td><?php echo $case_progress[count($case_progress) - 1][status]; ?></td>
					  	<td><?php echo $case_progress[0][date]; ?></td>
					  	<td><?php echo (empty($referer)) ? "": $referer; ?></td>
					  	<td><a href="<?php the_permalink(); ?>" class="btn btn-<?php echo ($case_status == "open") ? 'success':'danger'; ?> btn-block"><span class="sr-only">View case details</span><i class="fa fa-chevron-right"></i></a></td>
				  	</tr>
				  	<?php endwhile; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6"><?php wp_pagenavi(); ?></td>
					</tr>
				</tfoot>
			</table>
			
		</div>
		<?php else: ?>
		<div class="row">
			<div class="col-xs-8 col-xs-offset-2">
				<div class="well well-lg text-center">
					There are no open cases at the moment.
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		</section>	
		
		</div>
	</main><!-- .site-main -->

<?php get_footer(); ?>

<?php } else { ?>
<?php 
$index_id = get_option( 'page_on_front' );
$url = get_permalink( $index_id  );
wp_redirect( $url );
exit;
?>
<?php }	?>