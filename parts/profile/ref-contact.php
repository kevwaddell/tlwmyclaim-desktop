<?php 
global $current_user;
get_currentuserinfo();	
$primary_contact = $current_user->display_name;	
$company = get_user_meta($current_user->ID, 'company_name', true);	
$username = $current_user->user_login;	
$login_email = $current_user->user_email;
?>

<table class="table table-bordered text-center">
  <tbody>
	  <tr>
		  <th width="50%" class="text-center">Company:</th>
		  <th width="50%" class="text-center">Contact name:</th>
	  </tr>
	   <tr>
		  <td><?php echo $company; ?></td>
		  <td><?php echo $primary_contact; ?></td>
	  </tr>
	  <tr>
		  <th class="text-center">Account email:</th>
		  <th class="text-center">Account Username:</th>
	  </tr>
	  <tr>
		<td><?php echo $login_email; ?></td>
		<td><?php echo $username; ?></td>
	  </tr>
	  
</tbody>
</table>