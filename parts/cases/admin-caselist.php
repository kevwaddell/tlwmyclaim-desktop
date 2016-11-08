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