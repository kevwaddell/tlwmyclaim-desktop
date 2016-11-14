<?php 
global $current_user;
$user_id = $current_user->ID;
$username = $current_user->user_login;	
$login_email = $current_user->user_email;
$client_personal_raw = get_user_meta($user_id, 'client_personal', true);	
$client_personal = unserialize($client_personal_raw);
$client_contact_raw = get_user_meta($user_id, 'client_contact', true);	
$client_contact = unserialize($client_contact_raw);	
$account_pg = get_page_by_path( 'account-details' );
?>

<div class="panel panel-default">
		<div class="panel-heading text-center">Primary contact</div>
		<div class="panel-body text-center">
			<h2 class="txt-col-red font-slab-serif caps"><?php echo $client_personal['title']; ?> <?php echo $client_personal['forename']; ?> <?php echo $client_personal['surname']; ?></h2>
			<h3 class="txt-col-gray font-slab-serif"><?php echo $client_contact['email']; ?></h3>
		</div>
</div>

<div class="panel panel-default">
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
	<div class="panel-heading text-center">Current claim</div>
	<?php if (!empty($current_claims)) { ?>
	<?php
	$case_progress_raw = get_post_meta( $current_claims[0]->ID, 'case_progress', true );
	$case_progress = unserialize($case_progress_raw);
	$fee_earner_raw = get_post_meta( $current_claims[0]->ID, 'fee_earner', true );
	$fee_earner = unserialize($fee_earner_raw);
	$case_ref = get_post_meta( $current_claims[0]->ID, 'case_ref', true);
	$case_status = get_post_meta( $current_claims[0]->ID, 'case_status', true);
	$post_content = $current_claims[0]->post_content;
	$additinal_info = apply_filters( "the_content", $post_content );
	?>
	<table class="table table-bordered text-center">
		<tbody>
			<tr>
				<td width="50%"><strong>Claim Reference:</strong> <?php echo $case_ref; ?></td>
				<td width="50%"><strong>Date created:</strong> <?php echo $case_progress[0]['date']; ?></td>
		  	</tr>
		  	<tr>
				<td><strong>Case handler:</strong> <?php echo $fee_earner['name']; ?></td>
				<td><strong>Case handler Email:</strong> <a href="mailto:<?php echo $fee_earner['email']; ?>"><?php echo $fee_earner['email']; ?></a></td>
		  	</tr>
		  	<tr>
				<td><strong>Case Status:</strong> <?php echo ucfirst( $case_status ); ?></td>
				<td><strong>Case Progress:</strong> <?php echo $case_progress[count($case_progress) - 1]['status']; ?></td>
		  	</tr>
		  	<tr>
				<th colspan="2" class="text-center">Additional information:</th>
		  	</tr>	
		  	<tr>
				<td colspan="2"><?php echo $additinal_info; ?></td>
		  	</tr>	
		</tbody>
	</table>
</div>

<a href="<?php echo get_permalink( $current_claims[0]->ID ); ?>" class="red-btn btn btn-default btn-block btn-lg">View progress report<i class="fa fa-chevron-right fa-lg pull-right"></i></a>
<?php } ?>

<a href="<?php echo get_permalink( $account_pg->ID ); ?>" class="red-btn btn btn-default btn-block btn-lg">View Account details<i class="fa fa-chevron-right fa-lg pull-right"></i></a>

<?php
$claims_args = array(
	'posts_per_page' => -1,
	'post_type'		=> 'post',
	'post_status'	=>	'private',
	'author'	=> $user_id,
	'exclude'	=>  $current_claims[0]->ID,
	'orderby'	=> 'date'
);
$claims = get_posts( $claims_args );
?>

<?php if (!empty($claims)) { ?>
<div class="rule"></div>
<div class="panel">
	<div class="panel-heading text-center">Other claims</div>	
	<table class="table table-bordered">
	<tbody>
		<tr>
		<th width="30%" class="text-center">Case reference</th>
		<th width="35%" class="text-center">Case progress</th>
		<th width="30%" class="text-center">Case handler</th>
		<th width="5%" class="text-center"><i class="fa fa-info-circle"></i></th>
		</tr>
		<?php foreach ($claims as $claim) { 
		$case_progress_raw = get_post_meta( $claim->ID, 'case_progress', true );
		$case_progress = unserialize($case_progress_raw);
		$fee_earner_raw = get_post_meta( $claim->ID, 'fee_earner', true );
		$fee_earner = unserialize($fee_earner_raw);
		$case_status = get_post_meta( $claim->ID, 'case_status', true );
		$case_ref = get_post_meta( $claim->ID, 'case_ref', true);
		?>
		<tr>
		  	<td class="text-center"><?php echo $case_ref; ?></td>
		  	<td class="text-center">
			  	<?php if ($case_status == 'closed') { ?>
			  	<span class="label label-danger">Case <?php echo $case_status; ?></span>
			  	<?php } else { ?>
			  	<?php echo $case_progress[count($case_progress) - 1]['status']; ?>
			  	<?php } ?>
			</td>
			<td class="text-center"><?php echo $fee_earner['name']; ?></td>
		  	<td><a href="<?php echo get_permalink($claim->ID); ?>" class="btn btn-success btn-block"><span class="sr-only">View claim details</span> <i class="fa fa-chevron-right"><i></a></td>

	  	</tr>	
		<?php } ?>
	</tbody>
</table>

</div>
<?php } ?>
