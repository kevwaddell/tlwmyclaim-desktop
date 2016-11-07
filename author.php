<?php if ( is_user_logged_in() && current_user_can( 'administrator' ) ) { ?>

<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
	
	<section class="account-info-panels">
		<div class="container">
		
		<?php if ( have_posts() ) : the_post(); ?>
		<?php 
		$client_personal_raw = get_user_meta($post->post_author, 'client_personal', true);
		$client_personal = unserialize($client_personal_raw);
		$client_contact_raw = get_user_meta($post->post_author, 'client_contact', true);
		$client_contact = unserialize($client_contact_raw);
		$client_address_raw = get_user_meta($post->post_author, 'client_address', true);	
		$client_address = unserialize($client_address_raw);
		//echo '<pre class="debug">';print_r($client_contact);echo '</pre>';
		?>
		<div class="row">
		<div class="col-xs-8">
				<div class="panel panel-default">
					
			 		<div class="panel-heading text-center">Client details</div>	
			
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th width="20%">Primary Contact:</th>
								<td width="30%"><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></td>
							</tr>
							<tr>
								<th>Contact email:</th>
								<td><a href="mailto:<?php echo $client_contact['email']; ?>"><?php echo $client_contact['email']; ?></td></td>
							</tr>
							<tr>
								<th>Tel:</th>
								<td><?php echo (!empty($client_contact[tel])) ? $client_contact[tel]:" - "; ?></td>
							</tr>
							<tr>
								<th>Mobile:</th>
								<td><?php echo (!empty($client_contact[mobile])) ? $client_contact[mobile]:" - "; ?></td>
						  	</tr>
						</tbody>
					</table>
						
				</div>	
		</div>
		<div class="col-xs-4">

			<div class="panel panel-default">
				  <div class="panel-heading text-center">Address details</div>
					  <table class="table table-bordered" style="min-height: 179px;">
						  <tbody>
							  <?php if (!empty($client_address)) { ?>
							  	 <tr>
								  <td>
									  <?php foreach ($client_address as $part ) { ?>
									 <?php echo ( empty($part) ) ? "" : $part."<br/>"; ?>
									  <?php } ?>
								  </td>
							  </tr>		
							  <?php } ?>
						  </tbody>
					  </table>

			</div>	
		</div>
		</div>
	<?php endif; ?>
			<?php rewind_posts(); ?>
			<?php if ( have_posts() ) : ?>

			<div class="panel panel-default">
				
			<div class="panel-heading text-center">Current Cases</div>	
			
			<table class="table table-bordered">
			<tbody>
				<tr>
				<th width="5%"></th>
				<th width="30%" class="text-center">Case reference</th>
				<th width="30%" class="text-center">Case Status</th>
				<th width="30%" class="text-center">Referer</th>
				<th width="5%"></th>
				</tr>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php 
				$case_progress_raw = get_post_meta( $post->ID, 'case_progress', true );
				$case_progress = unserialize($case_progress_raw);	
				$case_ref = get_post_meta( $post->ID, 'case_ref', true);
				$referer = get_post_meta( $post->ID, 'src_company', true);
				?>
				<tr>
					<td class="text-center"><i class="fa fa-info-circle text-primary"></i></td>
				  	<td class="text-center"><?php echo $case_ref; ?></td>
				  	<td class="text-center"><?php echo $case_progress[count($case_progress) - 1]['status']; ?></td>
				  	<td class="text-center"><?php echo $referer; ?></td>
				  	<td><a href="<?php echo get_permalink($claim->ID); ?>" class="btn btn-success btn-block"><span class="sr-only">View claim details</span> <i class="fa fa-chevron-right"><i></a></td>
				</tr><!-- #post-## -->

			
			<?php endwhile; ?>
			</tbody>
			</table>

		</div>	
		
		<?php endif; ?>
		
		</div>
		
		</section>
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