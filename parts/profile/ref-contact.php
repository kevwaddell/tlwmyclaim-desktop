<?php 
global $current_user;
get_currentuserinfo();	
$primary_contact = $current_user->display_name;	
$company = get_user_meta($current_user->ID, 'company_name', true);	
?>

<table class="table table-bordered">
  <tbody>
	  <tr>
		  <th width="40%">Company:</th>
		  <td><?php echo $company; ?></td>
	  </tr>
	  <tr>
		  <th>Contact name:</th>
		  <td><?php echo $primary_contact; ?></td>
	  </tr>
</tbody>
</table>