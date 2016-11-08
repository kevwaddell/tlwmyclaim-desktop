 <table class="table table-bordered">
  <tbody>
	  <tr>
		  <th width="30%">Primary Contact:</th>
		  <td><?php echo $client_personal['title']; ?> <?php echo $client_personal['forename']; ?> <?php echo $client_personal['surname']; ?></td>
	  </tr>
	  <tr>
		  <th>Contact email:</th>
		  <td><?php echo $client_contact['email']; ?></td>
	  </tr>
	  <?php if (!empty($client_contact['tel'])) { ?>
	  <tr>
		  <th>Telephone:</th>
		  <td><?php echo $client_contact['tel']; ?></td>
	  </tr>
	   <?php } ?>
	   <?php if (!empty($client_contact['mobile'])) { ?>
	  <tr>
		  <th>Mobile:</th>
		  <td><?php echo $client_contact['mobile']; ?></td>
	  </tr>
	   <?php } ?>
  </tbody>
</table>