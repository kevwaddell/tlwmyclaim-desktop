<?php
global $user_id;
$current_user = wp_get_current_user();
$user_data = get_userdata($user_id);
//echo '<pre class="debug">';print_r($user_data);echo '</pre>';	

$claims_args = array(
'posts_per_page' => -1,
'post_type'		=> 'post',
'post_status'	=>	'private',
'meta_key'	=> 'src_ref',
'meta_value'	=> $current_user->user_login
);
$claims = get_posts( $claims_args );

$open = 0;
$closed = 0;

	foreach ($claims as $claim) {
	
	$case_status = get_post_meta( $claim->ID, 'case_status', true);
	//echo '<pre class="debug">';print_r($case_status);echo '</pre>';
	
		if ($case_status == 'open') {
			$open++;
		}
									   		
		if ($case_status == 'closed') {
			$closed++;	
		}
	}	
	
//echo '<pre class="debug">';print_r($open_cases);echo '</pre>';
//echo '<pre class="debug">';print_r($closed_cases);echo '</pre>';
?>
<div class="row">
	<div class="col-xs-6">
		<div class="alert alert-success text-center dashboard-alert">
			<div class="alert-heading text-center">Open Cases <i class="fa fa-folder-open"></i></div>
			<div class="alert-number text-center"><?php echo $open; ?></div>
		</div>
	</div>
	
	<div class="col-xs-6">
		<div class="alert alert-warning text-center dashboard-alert">
			<div class="alert-heading text-center">Closed Cases <i class="fa fa-folder"></i></div>
			<div class="alert-number"><?php echo $closed; ?></div>
		</div>
	</div>
</div>