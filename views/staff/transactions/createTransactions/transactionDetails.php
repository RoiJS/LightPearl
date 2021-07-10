<div class="well well-small well-shadow" style="width:200px;margin-bottom:-20px;margin-left:20px;">
	<center>Transaction Details</center>
</div>
<form class="frm-transaction-details">
	<div class="box" style="padding-right:15px;padding-left:15px;">
		<div class="box-content">
			<br>
			<div class="row">
				<div class="span7">
					<div class="row" style="margin-bottom:-15px;">
						<div class="span7" >
							<div class="row" >
								<div class="span4">
									<h3>Amount Due:</h3>
								</div>
								<div class="span3">
									<input type="hidden" value="<?php  echo $transactionDetails['row']['totalAmountDue']; ?>" class="txt-total-due"/>
									<h3 style="color:red;">Php <span class="txt-discounted-due"><?php echo $transactionDetails['row']['totalAmountDue'];?></span></h3>
								</div>	
							</div>
						</div>
						<div class="span7" style="margin-top:-20px;">
							<div class="row">
								<div class="span4">
									<h4>Vatable:</h4>
							`	</div>
								<div class="span3">
									<h4 style="color:red;">Php <span class="txt-total-vatable"><?php echo $transactionDetails['row']['totalVatable'];?></span></h4>
								</div>		
							</div>
						</div>
						<div class="span7" style="margin-top:-30px;">
							<div class="row">	
								<div class="span4">
								<?php $setting = query('SELECT vat FROM tbl_settings','','','variable',1);?>
									<h4><?php echo $setting['row']['vat'];?>% Vat:</h4>
							`	</div>
								<div class="span3">
									<h4 style="color:red;">Php <span class="txt-total-vat"><?php echo $transactionDetails['row']['totalVat'];?></span></h4>
								</div>
							</div>		
						</div>
						<div class="span7" style="margin-top:-30px;">
							<div class="row">	
								<div class="span4">
									<h4>Discount:</h4>
							`	</div>
								<div class="span3">
									<input type="text" class="txt-discount span2" style="float:left;margin-right:10px;margin-top:16px;" autofocus=autofocus /><h4 style="float:left;">%</h4>
								</div>
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span7">
			<div class="row">
				<div class="span7">
					<input type="radio" checked value="pay-now" class="pay-now" style="float:left;margin-top:14px; margin-right: 10px;" >&nbsp;<h5 style="float:left;margin-right:20px;">Pay Now</h5>
					<input type="radio" value="pending" class="pending" style="float:left;margin-top:14px; margin-right: 10px;"/>&nbsp;<h5 style="float:left;">Pending</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="box box-transaction-details" style="padding-right:15px;padding-left:15px;" >
		<div class="box-content">
			<div class="row">
				<div class="span7">
					<div class="row" style="margin-bottom:-15px;">
						<div class="span7" >
							<div class="row" >
								<div class="span4">
									<h3>Cash Received:</h3>
								</div>
								<div class="row">	
									<div class="span3">
										<h4 style="float:left;margin-right:10px;">Php</h4>
										<input type="text" class="span2 txt-cash-received required" style="float:left;margin-top:16px;"/>
								`	</div>
								</div>		
							</div>
						</div>
						<div class="span7" style="margin-top:-20px;">
							<div class="row">
								<div class="span4">
									<h4>Change:</h4>
							`	</div>
								<div class="span3">
									<h4 style="color:red;">Php <span class="txt-change">0.00</span></h4>
								</div>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<button class="btn btn-warning close-trasaction-form" style="float:right;" type="button">Close</button>
		<button class="btn btn-primary" style="float:right;margin-right:10px;" type="submit">Save</button>
	<div>
</form>
