<tbody>
	<tr>
		<th width="60" class="text-center"><i class="fa fa-info-circle fa-lg"></i></th>
		<th width="44%" class="text-center">Case referrence:</th>
		<th class="text-center">Client name:</th>
		<th width="60" class="text-center"><i class="fa fa-eye fa-lg"></i></th>
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
  	<tr class="<?php echo ($case_status == "open") ? 'success':'warning'; ?>">
	  	<td><i class="fa fa-<?php echo ($case_status == "open") ? 'folder-open text-success':'folder text-warning'; ?> fa-lg"></i></td>
	  	<td><?php echo $case_ref; ?></td>
	  	<td><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></td>
	  	<td><a href="<?php the_permalink(); ?>" class="btn btn-<?php echo ($case_status == "open") ? 'success':'warning'; ?> btn-block"><span class="sr-only">View case details</span><i class="fa fa-chevron-right"></i></a></td>
  	</tr>
  	<?php endwhile; ?>
</tbody>