<?php 
/*
Template Name: Process data page
*/
?>

<?php
$headers = getallheaders();
//echo '<pre class="debug">';print_r($headers);echo '</pre>';

if (isset($headers['Content-Type']) && $headers['Content-Type'] == "text/xml") {
$xmlBody = file_get_contents('php://input');
$caseDetailsXML = simplexml_load_string($xmlBody);
$caseDetails = json_decode(json_encode((array)$caseDetailsXML), TRUE);

//Check if user email exsists
$user_email = $caseDetails['email'];
$user_id = email_exists( $user_email );

if (!$user_id) {
	
	// User data for user account creation
	$random_password = wp_generate_password( 12, true, true );
	$first_name =  $caseDetails['forename'];
	$last_name = $caseDetails['surname'];
	$user_name = $first_name."_".$last_name;	
	
	//Case Reference number
	$client_cases = array();
	$client_cases[] = $caseDetails['solicitor-reference'];
	
	// Client Personal Details
	$client_personal = array();
	$client_personal['title'] = $caseDetails['title'];
	$client_personal['forename'] = $first_name;
	$client_personal['surname'] = $last_name;
	$client_personal['date-of-birth'] = $caseDetails['date-of-birth'];
	
	// Client Address
	$client_address = array();
	$client_address['address1'] = $caseDetails['address1'];
	$client_address['address2'] = $caseDetails['address2'];
	$client_address['address3'] = $caseDetails['address3'];
	$client_address['address4'] = $caseDetails['address4'];
	$client_address['postcode'] = $caseDetails['postcode'];
	
	//Client contact details
	$client_contact = array();
	$client_contact['email'] = $caseDetails['email'];
	$client_contact['tel'] = $caseDetails['telephone'];
	$client_contact['mobile'] = $caseDetails['mobile'];
		
	//Case status
 	$case_status = array();
 	$case_status[] = array('date'=> date('d/m/Y'), 'status'	=> 'Case created' );
 	
 	//Fee Earsner Details
 	$fee_earner = array();
 	$fee_earner['name'] = $caseDetails['fee-earner'];
 	$fee_earner['email'] = $caseDetails['fee-earner-email'];
 	
 	//Insurer Details
 	$insurer_data = array();
 	$insurer_data['company'] = $caseDetails['insurer-company'];
 	if(!empty($caseDetails['insurer-reference'])) {
	$insurer_data['ref'] = $caseDetails['insurer-reference'];	
 	}
 	$insurer_data['policy-number'] = $caseDetails['insurer-policy'];			 	

 	$case_args['post_type']= 'post';
 	$case_args['post_status']= 'publish';
 	$case_args['post_name']	= sanitize_title($caseDetails['solicitor-reference']);
 	$case_args['post_title'] = wp_strip_all_tags($caseDetails['solicitor-reference']);

	$userdata = array(
	 'user_login'  =>  $user_name,
	 'user_pass'	=> $random_password,
	 'user_email'	=> $user_email,
	 'first_name'	=> $first_name,
	 'last_name'	=> $last_name,
	 'nickname'		=> $first_name,
	 'display_name'	=> $first_name. " " .$last_name
	 );	
	 
	 $user_id = wp_insert_user( $userdata );
	 
	 if ( ! is_wp_error( $user_id ) ) {
	 add_user_meta( $user_id, "client_personal", serialize($client_personal), true );
	 add_user_meta( $user_id, "client_address", serialize($client_address), true );
	 add_user_meta( $user_id, "client_contact", serialize($client_contact), true );
	 wp_send_new_user_notifications( $user_id );
	 
	 	if ( !empty($caseDetails['solicitor-reference']) ) {

		 	$case_args['post_author']= $user_id;
		 	$case_args['post_type']= 'post';
		 	$case_args['post_status']= 'publish';
		 	$case_args['post_name']	= sanitize_title($caseDetails['solicitor-reference']);
		 	$case_args['post_title'] = wp_strip_all_tags($caseDetails['solicitor-reference']);
		 	
		 	if (!empty($caseDetails['additional-info'])) {
			 $content = $caseDetails['additional-info'];
			 $case_args['post_content'] = $content;	
		 	}

		 	$case_id = wp_insert_post($case_args);
		 	
		 	if ($case_id) {
				echo "New case created\n";
				add_post_meta( $case_id, 'case_status', serialize($case_status), true );
				echo "Case status added\n";	
				add_post_meta( $case_id, 'fee_earner', serialize($fee_earner), true );
				echo "Fee Earner data added\n";	
				add_post_meta( $case_id, 'insurer', serialize($insurer_data), true );
				echo "Insurer data added\n";	
			
				if ( !empty($caseDetails['source-company']) ) {
					$src_company = $caseDetails['source-company'];
					add_post_meta( $case_id, 'src_company', $src_company, true );
					echo "Source company added\n";	
				}

		 	} // If case was created
		 		
	 	} // If has case reference
	 
	 echo "New user created\n";
	 }
	 
} else {
	echo "User already exists";
}

} else {
$index_id = get_option( 'page_on_front' );
$url = get_permalink( $index_id  );
wp_redirect( $url );
exit;	
}
?>