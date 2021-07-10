<form class="frm-edit-customer" id="<?php echo $customerInfo["row"]["customer_id"];?>">
	<div class="box"> 
		<div class="box-content">
			<div class="row">
				<div class="span4">		
						<div class="row">
							<div class="span1">
								<b>Name:</b>
							</div>
							<div class="span4">
								<input type="text" class="span4 txt-edit-customer-name required" name="txt-edit-customer-name" placeholder="Customer name&hellip;" value="<?php echo $customerInfo["row"]["name"];?>"/>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="span1">
								<b>Address:</b>
							</div>
							<div class="span4">
								<input type="text" class="span4 txt-edit-customer-address" name="txt-edit-customer-address" placeholder="Customer address&hellip;" value="<?php echo $customerInfo["row"]["address"];?>"/>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="span2">
								<b>Contact Info:</b>
							</div>
							<div class="span3">
								<input type="text" class="span4 txt-edit-customer-contact-info" name="txt-edit-customer-contact-info" placeholder="Customer contact info&hellip;" value="<?php echo $customerInfo["row"]["contactInfo"];?>"/>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<div class="span2">
								<b>TIN No:</b>
							</div>
							<div class="span3">
								<input type="text" class="span4 txt-edit-customer-tin-no" name="txt-edit-customer-tin-no" placeholder="Customer TIN No&hellip;" value="<?php echo $customerInfo["row"]["TinNo"];?>"/>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span1">
			<input type="submit" class="btn btn-primary" value="Save"/>
		</div>	
		<div class="span1" >
			<input type="button" class="btn btn-warning btn-close-edit-customer-form" value="Close"/>
		</div>
	</div>
</form>