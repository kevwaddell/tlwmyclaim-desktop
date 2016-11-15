<tbody>
	<tr>
		<th width="25%" class="text-center">Client name:</th>
		<th width="50%" class="text-center" colspan="2">Progress status:</th>
		<th width="20%" class="text-center">Case handler:</th>
		<th width="5%" class="text-center"><i class="fa fa-info-circle fa-lg"></i></th>
  	</tr>
  	<?php while ( have_posts() ) : the_post(); ?>
  	<?php
	$case_progress_raw = get_post_meta( $post->ID, 'case_progress', true );
	$case_progress = unserialize($case_progress_raw);
	$client_personal_raw = get_user_meta($post->post_author, 'client_personal', true);
	$client_personal = unserialize($client_personal_raw); 
	$fee_earner_raw = get_post_meta($post->ID, 'fee_earner', true);	
	$fee_earner = unserialize($fee_earner_raw);
	$case_status = get_post_meta( $post->ID, 'case_status', true);
	//echo '<pre class="debug">';print_r($case_status);echo '</pre>';
  	?>
  	<tr class="<?php echo ($case_status == "open") ? 'success':'danger'; ?>">
	  	<td><?php echo $client_personal[title]; ?> <?php echo $client_personal[forename]; ?> <?php echo $client_personal[surname]; ?></td>
	  	<td width="15%"><i class="fa fa-calendar"></i> <?php echo $case_progress[count($case_progress) - 1][date]; ?></td>
	  	<td width="35%"><?php echo $case_progress[count($case_progress) - 1][status]; ?></td>
	  	<td><a href="mailto:<?php echo $fee_earner[email]; ?>" class="btn btn-block btn-primary"><?php echo $fee_earner[name]; ?> <i class="fa fa-envelope pull-right"></i><span class="sr-only">Email <?php echo $fee_earner[name]; ?></span></a> </td>
	  	<td><i class="fa fa-<?php echo ($case_status == "open") ? 'folder-open text-success':'folder text-danger'; ?> fa-lg"></i></td>
  	</tr>
  	<?php endwhile; ?>
</tbody>