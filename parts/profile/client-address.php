<div class="panel panel-default">
  <div class="panel-heading text-center">Address details</div>
  
  <table class="table table-bordered" style="min-height: 179px;">
	  <tbody>
		  <?php if (!empty($client_address)) { ?>
		  	 <tr>
			  <td>
				  <?php foreach ($client_address as $part) { ?>
				  <?php echo ( empty($part) ) ? "" : $part."<br/>"; ?>									  
				  <?php } ?>
			  </td>
		  </tr>		
		  <?php } ?>
	  </tbody>
  </table>

</div>	