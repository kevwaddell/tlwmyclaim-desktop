 <?php 
global $current_user;
get_currentuserinfo();
$user_id = $current_user->ID;
$username = $current_user->user_login;	
$login_email = $current_user->user_email;
$client_personal_raw = get_user_meta($user_id, 'client_personal', true);	
$client_personal = unserialize($client_personal_raw);
$client_contact_raw = get_user_meta($user_id, 'client_contact', true);	
$client_contact = unserialize($client_contact_raw);	
?>
 <table class="table table-bordered">
  <tbody>
	  <tr>
		  <th>Username:</th>
		  <td colspan="2"><?php echo $username; ?></td>
	  </tr>
	  <?php if ($client_contact['email'] != $login_email) { ?>
	   <tr>
		  <th width="30%">Account email:</th>
		  <td colspan="2"><?php echo $client_personal['title']; ?> <?php echo $client_personal['forename']; ?> <?php echo $client_personal['surname']; ?></td>
	  </tr>
	  <?php } ?>
	  <tr>
		  <th width="30%">Primary Contact:</th>
		  <td colspan="2"><?php echo $client_personal['title']; ?> <?php echo $client_personal['forename']; ?> <?php echo $client_personal['surname']; ?></td>
	  </tr>
	  <tr>
		  <th>Contact email:</th>
		  <td colspan="2"><?php echo $client_contact['email']; ?></td>
	  </tr>
	  <tr>
		  <th>Contact numbers:</th>
		  <td>
			<?php echo (!empty($client_contact['tel'])) ? "Tel: ".$client_contact['tel'] : " - "; ?> 
		  </td>
		  <td>
			<?php echo (!empty($client_contact['mobile'])) ? "Mobile: ".$client_contact['mobile'] : " - "; ?>  
		  </td>
	  </tr>
  </tbody>
</table>