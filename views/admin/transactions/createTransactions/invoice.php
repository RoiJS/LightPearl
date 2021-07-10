<div class="row" >
	<div class="span12">
		<div >
			<div class="row">
				<div class="span12">
					<table class="transaction" >
						<!--Invoice header-->
						<tr>
							<td>
								<table cellspacing=0 class="transaction-header">
									<tr >
										<td style="padding-left:600px;">
											<b>Date:</b> <?php echo date('m-d-Y',strtotime($getLatestTransaction['row']['dateTime'])); ?>
										</td>
									</tr>
									<tr>
										<td style="padding-left:130px;"> <b><?php echo $getLatestTransaction['row']['customer']; ?></b></td>
									<tr>
									<tr>
										<td style="padding-left:350px;"><?php echo $getLatestTransaction['row']['purchaseOrderNo']; ?></td>
									<tr>
								</table>		
							</td>
						</tr>
						
						<!--Invoice body-->
						<tr >
							<td>
								<div class="row">
									<div class="span12" style="height:323px;">
										<table cellspacing=0 class="transaction-body" border=1>
											<tr >
												<th >Qty</th>
												<th >Unit</th>
												<th >Item Description</th>
												<th >Unit Price</th>
												<th >Amount</th>
											</tr>
											<?php foreach($getTransactionDetails as $transaction):?>
											<tr >
												<td style="text-align:center;width:70px"><?php echo $transaction['row']['noOfItem']; ?></td>
												<td style="text-align:center;width:90px"><?php echo $transaction['row']['unit']; ?></td>
												<td style="padding-left:5px;"><?php echo $transaction['row']['description']; ?></td>
												<td style="text-align:center;"><?php echo number_format($transaction['row']['itemPrice'],2,'.',','); ?></td>
												<td style="text-align:center;padding-right:10px;"><?php echo number_format($transaction['row']['amount'],2,'.',','); ?></td>
											</tr>
											<?php endforeach;?>
										</table>	
									</div>
								</div>
							</td>
						</tr>
						
						<!--Invoice footer-->
						<tr>
							<td>
								<table cellspacing=0  class="transaction-footer" >
									<tr >
										<td > <b>Vatable:</b> Php <?php echo number_format($getLatestTransaction['row']['totalVATable'],2,'.',','); ?></td>
									</tr>
									
									<tr >
										<td style="padding-top:18px;"><b>Vat:</b> Php <?php echo number_format($getLatestTransaction['row']['totalVAT'],2,'.',','); ?></td>
									</tr>
									<tr >
										<td><b>Total Amount Due:</b> Php <?php echo number_format($getLatestTransaction['row']['discountedAmount'],2,'.',','); ?></td>
									</tr>
									<tr>
										<td ><b>Change:</b> Php <?php echo number_format($getLatestTransaction['row']['amountChange'],2,'.',','); ?></td>
									</tr>
								</table>		
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12">
		<button class="btn btn-warning close-trasaction-form" style="float:left;" type="button">Close</button>
		<button class="btn btn-primary btn-print-as-invoice" style="float:right;margin-right:10px;" type="button">Print as Invoice</button>
		<button class="btn btn-success btn-print-as-delivery-report" style="float:right;margin-right:10px;" type="button">Print as Delivery Report</button>
	</div>
</div>
<style>
	.transaction{
		font-family:'Arial';
		width:21.5cm;
		margin-top:49.5px;
		margin-left:auto;
		margin-right:auto;
	}
	
	.transaction-header{
		width:100%;
		font-size:16px;
		margin-bottom:40px;
	}
	
	.transaction-body{
		width:100%;
		font-size:14px;
	}
	
	.transaction-footer{
		padding-left:660px;
		width:100%;
		font-size:12px;
		 
	}
	
</style>