<?php 
global $current_user;
$user_id = $current_user->ID;
$username = $current_user->user_login;	
$login_email = $current_user->user_email;
$client_personal_raw = get_user_meta($user_id, 'client_personal', true);	
$client_personal = unserialize($client_personal_raw);
$client_contact_raw = get_user_meta($user_id, 'client_contact', true);	
$client_contact = unserialize($client_contact_raw);	
$claim_pg = get_page_by_path( 'your-claim');
?>
<?php 
	$current_claims_args = array(
		'posts_per_page' => 1,
		'post_type'		=> 'post',
		'post_status'	=>	'private',
		'meta_key'	=> 'case_status',
		'meta_value'	=> 'open',
		'author'	=> $user_id,
		'orderby'	=> 'date'
	);
	$current_claims = get_posts( $current_claims_args );
	?>
	<?php if (!empty($current_claims)) { 
	$case_progress_raw = get_post_meta( $current_claims[0]->ID, 'case_progress', true );
	$case_progress = unserialize($case_progress_raw);
	$claim_details_raw = get_post_meta( $current_claims[0]->ID, 'claim_details', true );
	$claim_details = unserialize($claim_details_raw);
	$case_ref = get_post_meta( $current_claims[0]->ID, 'case_ref', true);
	?>
	
	<div class="alert alert-info text-center case-progress">
		<?php 
	 	$case_progress = array_reverse($case_progress); 
	 	$date = date('l jS F, Y', strtotime( str_replace('/','-',$case_progress[0]['date']) ) );
	 	$status = $case_progress[0]['status'];
	 	?>
	 	<div class="icon">
		 	<i class="fa fa-hourglass-half fa-3x"></i>
		 	<div class="icon-label">Progress report</div>
	 	</div>
 	
		<div class="status-date"><i class="fa fa-calendar"></i><?php echo $date; ?></div>
		<div class="case-details"><span>Case type: <?php echo $claim_details['claim-type']; ?></span> | <span>Case Ref: <?php echo $case_ref; ?></span></div>
		<div class="case-status"><i class="fa fa-check-circle txt-col-orange-dk fa-lg"></i> <?php echo $status; ?></div>
	</div>
	<a href="<?php echo get_permalink( $current_claims[0]->ID ); ?>" class="orange-btn btn btn-block btn-lg"><i class="fa fa-folder-open fa-lg"></i>Case details</a>
<?php } ?>

<?php
$claims_args = array(
	'posts_per_page' => -1,
	'post_type'		=> 'post',
	'post_status'	=>	'private',
	'author'	=> $user_id,
	'orderby'	=> 'date'
);
$claims = get_posts( $claims_args );
?>

<?php if (!empty($claims)) { ?>
<div class="rule"></div>
<div class="panel panel-default">
	<div class="panel-heading text-center">Your claims</div>	
	<table class="table table-bordered text-center">
		<thead>
			<tr>
				<td colspan="4">Status: <span class="label label-success">Open</span> <span class="label label-warning">Closed</span></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th width="20%" class="text-center">Reference</th>
				<th width="15%" class="text-center">Status</th>
				<th class="text-center">Type</th>
				<th width="60" class="text-center"><i class="fa fa-folder-open"></i></th>
			</tr>
			<?php foreach ($claims as $claim) { 
			$case_status = get_post_meta( $claim->ID, 'case_status', true );
			$case_ref = get_post_meta( $claim->ID, 'case_ref', true);
			$claim_details_raw = get_post_meta( $claim->ID, 'claim_details', true );
			$claim_details = unserialize($claim_details_raw);
			?> 
			<tr class="<?php echo ($case_status == 'open') ? 'success':'warning'; ?>">
				<td class="text-center"><?php echo $case_ref; ?></td>
				<td class="text-center"><span class="label label-<?php echo ($case_status == 'open') ? 'success':'warning'; ?> caps"><?php echo $case_status; ?></span></td>
			  	<td class="text-center"><?php echo $claim_details['claim-type']; ?></td>
			  	<td><a href="<?php echo get_permalink($claim->ID); ?>" class="btn btn-<?php echo ($case_status == 'open') ? 'success':'warning'; ?> btn-block"><span class="sr-only">View progress</span> <i class="fa fa-chevron-right"><i></a></td>
		  	</tr>	
			<?php } ?>
		</tbody>
	</table>
</div>
<?php } ?>
