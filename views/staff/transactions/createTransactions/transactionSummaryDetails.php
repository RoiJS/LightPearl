<div class="well well-small well-shadow" style="width:200px;margin-bottom:-20px;margin-left:20px;">
	<center>Transaction Details</center>
</div>
<form class="frm-print-transaction-details" id="<?php echo $transaction['row']['transaction_id'];?>">
	<div class="box" style="padding-right:15px;padding-left:15px;">
		<div class="box-content">
			<br>
			<div class="row">
				<div class="span7">
					<div class="row" style="margin-bottom:-15px;">
						<div class="span7" >
							<div class="row" >
								<div class="span4">
									<h3>Total amount due:</h3>
								</div>
								<div class="span3">
									<input type="hidden" value="<?php echo number_format($transaction['row']['totalAmountDue'],2,'.',','); ?>" class="txt-total-due"/>
									<h3 style="color:red;">Php <span class="txt-discounted-due"><?php echo number_format($transaction['row']['totalAmountDue'],2,'.',',');?></span></h3>
								</div>	
							</div>
						</div>
						<div class="span7" style="margin-top:-30px;">
							<div class="row">
								<div class="span4">
									<h4>Vatable:</h4>
								</div>
								<div class="span3">
									<h4 style="color:red;">Php <span class="txt-total-vatable"><?php echo number_format($transaction['row']['totalVATable'],2,'.',',');?></span></h4>
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
									<h4 style="color:red;">Php <span class="txt-total-vat"><?php echo number_format($transaction['row']['totalVAT'],2,'.',','); ?></span></h4>
								</div>
							</div>		
						</div>
						<div class="span7" style="margin-top:-30px;">
							<div class="row">	
								<div class="span4">
									<h4>Discount:</h4>
							`	</div>
								<div class="span3">
									<h4 style="float:left;"><?php echo $transaction['row']['discount'] != '' ?  number_format($transaction['row']['discount'],2,'.',',') : '0' ;?> %</h4>
								</div>
							</div>		
						</div>
					</div>
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
										<h4 style="float:left;margin-right:10px;">Php <?php echo $transaction['row']['amountReceived'] != '' ? number_format($transaction['row']['amountReceived'],2,".",",") : '0.00';?></h4>
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
									<h4 style="color:red;">Php <?php echo number_format($transaction['row']['amountChange'],2,'.',',');?></h4>
								</div>		
							</div>
						</div>
					</div>
				</div>
			
			</div>
		</div>
	</div>
	<div>
		<button class="btn btn-warning close-trasaction-details-form" style="float:right;" type="button">Close</button>
		<button class="btn btn-primary" style="float:right;margin-right:10px;" type="submit" autofocus="autofocus" ><i class="fa fa-print"></i> Print</button>
	<div>
</form>
