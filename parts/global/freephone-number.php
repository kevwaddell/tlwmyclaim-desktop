<?php 
$freephone_num = "0800 169 5925";	
?>
<div id="global-tel-num">
	<div class="container">
		<div class="row">
			<div class="col-xs-1">
				<i class="fa fa-phone fa-3x"></i>
			</div>
			<div class="col-xs-10">
				<div class="number font-slab-serif">
					Call us <span class="caps bold">free</span> on <a href="tel:<?php echo str_replace(' ', '', $freephone_num); ?>" title="Call us now"><?php echo $freephone_num; ?></a>
				</div>
			</div>
			<div class="col-xs-1">
				<i class="fa fa-mobile-phone fa-4x"></i>
			</div>
		</div>
	</div>
	<div class="overlay"></div>
</div>