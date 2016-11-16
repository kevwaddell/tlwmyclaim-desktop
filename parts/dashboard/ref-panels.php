<?php
global $user_id;
$current_user = wp_get_current_user();
$user_data = get_userdata($user_id);
$account_pg = get_page_by_path( 'account-details' );
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
$open_cases = array();
$closed_cases = array();

	foreach ($claims as $claim) {
	
	$case_status = get_post_meta( $claim->ID, 'case_status', true);
	
		if ($case_status == 'open') {
			$open_cases[] = $claim;	
		}
									   		
		if ($case_status == 'closed') {
			$closed_cases[] = $claim;	
		}
	}	
	
//echo '<pre class="debug">';print_r($current_user);echo '</pre>';
//echo '<pre class="debug">';print_r($closed_cases);echo '</pre>';
?>

<div class="panel panel-default">
	<div class="panel-heading text-center">Primary contact</div>
	<div class="panel-body text-center">
		<h2 class="txt-col-red font-slab-serif caps"><?php echo $current_user->display_name; ?></h2>
		<h3 class="txt-col-gray font-slab-serif"><?php echo $current_user->user_email; ?></h3>
	</div>
</div>

<div class="row">
	<div class="col-xs-6">
		<div class="panel panel-success text-center">
			<div class="panel-heading text-center">Open Cases</div>
			<div class="panel-body">
				<div class="number">3</div>
			</div>
		</div>
	</div>
	
	<div class="col-xs-6">
		<div class="panel panel-danger text-center">
			<div class="panel-heading text-center">Closed Cases</div>
			<div class="panel-body">
				<div class="number">3</div>
			</div>
		</div>
	</div>
</div>

<a href="<?php echo get_permalink( $account_pg->ID ); ?>" class="red-btn btn btn-default btn-block btn-lg">View Account details<i class="fa fa-chevron-right fa-lg pull-right"></i></a>