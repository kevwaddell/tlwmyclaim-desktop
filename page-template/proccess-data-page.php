<?php 
/*
Template Name: Process data page
*/
?>

<?php
$headers = getallheaders();
echo '<pre class="debug">';print_r($headers);echo '</pre>';

if (isset($headers['Content-Type']) && $headers['Content-Type'] == "text/xml") {
$xmlBody = file_get_contents('php://input');
$caseDetailsXML = simplexml_load_string($xmlBody);
$caseDetails = json_decode(json_encode((array)$caseDetailsXML), TRUE);

//Check if user email exsists
$first_name =  $caseDetails['forename'];
$last_name = $caseDetails['surname'];
$tlw_ref = $caseDetails['solicitor-reference'];
$user_name = $first_name."_".$last_name."_".strtolower($tlw_ref);
$user_id = username_exists( $user_name );

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

//Case status
$case_progress = array();
$case_progress[] = array('date'=> date('d/m/Y'), 'status'	=> 'Case created' );	 

// Client Personal Details
$client_personal = array();
$client_personal['title'] = $caseDetails['title'];
$client_personal['forename'] = $first_name;
$client_personal['surname'] = $last_name;
$client_personal['date-of-birth'] = $caseDetails['date-of-birth'];

// Client Address
$client_address = array();
$client_address['address1'] = (is_array($caseDetails['address1'])) ? "" : $caseDetails['address1'];
$client_address['address2'] = (is_array($caseDetails['address2'])) ? "" : $caseDetails['address2'];
$client_address['address3'] = (is_array($caseDetails['address3'])) ? "" : $caseDetails['address3'];
$client_address['address4'] = (is_array($caseDetails['address4'])) ? "" : $caseDetails['address4'];
$client_address['postcode'] = $caseDetails['postcode'];

//Client contact details
$client_contact = array();
$client_contact['email'] = $caseDetails['email'];
$client_contact['tel'] = $caseDetails['telephone'];
$client_contact['mobile'] = $caseDetails['mobile'];			

if (!$user_id) {
	
	// User data for user account creation
	$random_password = wp_generate_password( 12, true, true );
	$user_email = $caseDetails['email'];
	
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
	 add_user_meta( $user_id, "_user_type", "field_581c5aad45023", true );
	 add_user_meta( $user_id, "user_type", "client", true );
	 wp_send_new_user_notifications( $user_id );
	 
	 	if ( !empty($caseDetails['solicitor-reference']) ) {

		 	$case_args['post_author']= $user_id;
		 	$case_args['post_type']= 'post';
		 	$case_args['post_status']= 'private';
		 	$case_args['post_name']	= sanitize_title($caseDetails['solicitor-reference']);
		 	$case_args['post_title'] = wp_strip_all_tags($caseDetails['solicitor-reference']);
		 	
		 	if (!empty($caseDetails['additional-info'])) {
			 $content = $caseDetails['additional-info'];
			 $case_args['post_content'] = $content;	
		 	}

		 	$case_id = wp_insert_post($case_args);
		 	
		 	if ($case_id) {
				echo "New case created\n";
				add_post_meta( $case_id, 'case_ref', $caseDetails['solicitor-reference'], true );
				echo "Case reference added\n";	
				add_post_meta( $case_id, 'case_status', "open", true );
				echo "Case status added\n";
				add_post_meta( $case_id, 'case_progress', serialize($case_progress), true );
				echo "Case progress added\n";	
				add_post_meta( $case_id, 'fee_earner', serialize($fee_earner), true );
				echo "Fee Earner data added\n";	
				add_post_meta( $case_id, 'insurer', serialize($insurer_data), true );
				echo "Insurer data added\n";	
			
				if ( !empty($caseDetails['source-company']) ) {
					$src_company = $caseDetails['source-company'];
					$src_ref = sanitize_title($caseDetails['source-reference']);
					if (empty($caseDetails['source-reference'])) {
					$src_ref =  sanitize_title($caseDetails['source-company']);
					}
					
					add_post_meta( $case_id, 'src_company', $src_company, true );
					add_post_meta( $case_id, 'src_ref', $src_ref, true );	
					
					$ref_id = username_exists( $src_ref );
					
					if ($ref_id) {
					add_post_meta( $case_id, 'src_ref_id', $ref_id, true );		
					}
					
					echo "Source company added\n";	
				}

		 	} // If case was created
		 		
	 	} // If has case reference
	 
	 echo "New user created\n";
	 }
	 
} else {
	echo "User already exists\n";
	$client_personal_raw = get_user_meta($user_id, 'client_personal', true);	
	$client_address_raw = get_user_meta($user_id, 'client_address', true);	
	$client_contact_raw = get_user_meta($user_id, 'client_contact', true);
	
			if (serialize($client_personal) != $client_personal_raw) {
			update_user_meta( $user_id, 'client_personal', serialize($client_personal), $client_personal_raw );
			echo "Client Personal details updated\n";	
			}
			
			if (serialize($client_address) != $client_address_raw) {
			update_user_meta( $user_id, 'client_address', serialize($client_address), $client_address_raw );
			echo "Client Address details updated\n";	
			}
			
			if (serialize($client_contact) != $client_contact_raw) {
			$client_contact_old = unserialize($client_contact_raw);
				if ($client_contact['email'] != $client_contact_old['email']) {
				$email_updated = wp_update_user( array( 'ID' => $user_id, 'user_email' => $client_contact['email'] ) );
					if ( is_wp_error( $email_updated ) ) {
						echo "Client email was not updated\n";
					} else {
						echo "Client email updated\n";
					}		
				}
			update_user_meta( $user_id, 'client_contact', serialize($client_contact), $client_contact_raw );
			echo "Client Contact details updated\n";	
			}
	
	$case_ref = $caseDetails['solicitor-reference'];
	$new_case = true;
				
	$claims_args = array(
		'posts_per_page' => -1,
		'post_type'		=> 'post',
		'post_status'	=> 'private',
		'author'	=> $user_id,
		'meta_key'	=> 'case_status',
		'meta_value' => 'open'
	);
	$claims = get_posts( $claims_args );
	
	foreach ($claims as $claim) {
		
		if ( $claim->post_name == sanitize_title($case_ref) ) {
			$new_case = false;		
			$case_progress_raw = get_post_meta( $claim->ID, 'case_progress', true );
			$case_progress = unserialize($case_progress_raw);
			$case_progress[] = array('date'=> date('d/m/Y'), 'status'	=> 'New case status - '.count($case_progress) );
			update_post_meta( $claim->ID, 'case_progress', serialize($case_progress), $case_progress_raw );	
			echo "Updated claim progress\n";
			
			$fee_earner_raw = get_post_meta( $claim->ID, 'fee_earner', true );
			
			if (serialize($fee_earner) != $fee_earner_raw) {
			update_post_meta( $claim->ID, 'fee_earner', serialize($fee_earner),$fee_earner_raw );
			echo "Updated Fee Earner\n";	
			}
			
			$insurer_raw = get_post_meta( $claim->ID, 'insurer', true );
			
			if (serialize($insurer_data) != $insurer_raw) {
			update_post_meta( $claim->ID, 'insurer', serialize($insurer_data), $insurer_raw );
			echo "Updated Insurer\n";	
			}
		
		}
	}
	
	if ($new_case) {
		$new_case_args['post_author']= $user_id;
	 	$new_case_args['post_type']= 'post';
	 	$new_case_args['post_status']= 'private';
	 	$new_case_args['post_name']	= sanitize_title($caseDetails['solicitor-reference']);
	 	$new_case_args['post_title'] = wp_strip_all_tags($caseDetails['solicitor-reference']);
	 	
	 	if (!empty($caseDetails['additional-info'])) {
		 $content = $caseDetails['additional-info'];
		 $new_case_args['post_content'] = $content;	
	 	}
	 	
	 	$new_case_id = wp_insert_post($new_case_args);
		 	
		 	if ($new_case_id) {
				echo "New case created\n";
				add_post_meta( $case_id, 'case_status', "open", true );
				echo "Case status added\n";
				add_post_meta( $new_case_id, 'case_progress', serialize($case_progress), true );
				echo "Case progress added\n";	
				add_post_meta( $new_case_id, 'fee_earner', serialize($fee_earner), true );
				echo "Fee Earner data added\n";	
				add_post_meta( $new_case_id, 'insurer', serialize($insurer_data), true );
				echo "Insurer data added\n";	
			
				if ( !empty($caseDetails['source-company']) ) {
					$src_company = $caseDetails['source-company'];
					$src_ref = sanitize_title($caseDetails['source-reference']);
					
					if (empty($caseDetails['source-reference'])) {
					$src_ref =  sanitize_title($caseDetails['source-company']);
					}
					
					add_post_meta( $new_case_id, 'src_company', $src_company, true );
					add_post_meta( $new_case_id, 'src_ref', $src_ref, true );	
					
					$ref_id = username_exists( $src_ref );
					
					if ($ref_id) {
					add_post_meta( $new_case_id, 'src_ref_id', $ref_id, true );		
					}
					
					echo "Source company added\n";	
				}

		 	} // If case was created
	}
}

} else {
$index_id = get_option( 'page_on_front' );
$url = get_permalink( $index_id  );
wp_redirect( $url );
exit;	
}
?>