<div id="body-container">
	<div id="body-content">
		<section class="nav nav-page nav-page-fixed">
			<div class="container">
				<div class="row">
					<div class="span16">
						<center><div class="invoice-format">
							<div class="row">
								<div class="span7">
									<table class="invoice-header" >
										<tr>
											<td style="text-align: right;padding-right: 55px;">
												<?php echo date('F d, Y',strtotime($getLatestTransaction['row']['dateTime'])); ?>
											</td>
										</tr>
										<tr>
											<td style="text-align: center;"><b><?php echo $getLatestTransaction['row']['customer']; ?></b></td>
										<tr>
									</table>
								</div>
								<div class="span7 invoice-body" >
									<center>
									<table cellspacing=0 border=1>
										<tr>
											<th>Qty</th>
											<th>Unit</th>
											<th>Description</th>
											<th >Unit price</th>
											<th>Amount</th>
										</tr>
										<?php foreach($getTransactionDetails as $transaction):?>
										<tr >
											<td style="width:12.5%;text-align:center;"><?php echo $transaction['row']['noOfItem']; ?></td>
											<td style="width:4%;text-align:center;"><?php echo $transaction['row']['unit']; ?></td>
											<td style="width:47%;"><?php echo $transaction['row']['description']; ?></td>
											<td style="width:9%;text-align:center;padding-top:6px;"><?php echo number_format($transaction['row']['itemPrice'],2,'.',','); ?></td>
											<td style="text-align:center"><?php echo number_format($transaction['row']['amount'],2,'.',','); ?></td>
										</tr>
										<?php endforeach;?>
									</table></center>
								</div>
								<div class="span7" style="display:none;">
									<center>
									<table class="invoice-footer" cellspacing=0 >
										<tr >
											<td ><b>Vatable:</b> </td>
											<td style="width:100px;"><?php echo number_format($getLatestTransaction['row']['totalVATable'],2,'.',','); ?></td>
										</tr>
										
										<tr >
											<td><b>12% VAT:</b></td>
											<td style="padding-top:18px;"><?php echo number_format($getLatestTransaction['row']['totalVAT'],2,'.',','); ?></td>
										</tr>
										<tr >
											<td><b>Total Amount Due:</b></td>
											<td ><?php echo number_format($getLatestTransaction['row']['discountedAmount'],2,'.',','); ?></td>
										</tr>
										<tr >
											<td><b>Change:</b></td>
											<td style="padding-top:6.2px;"><?php echo number_format($getLatestTransaction['row']['amountChange'],2,'.',','); ?></td>
										</tr>
									</table></center>
								</div>
							</div>
						</div>
						</center>
					</div>
				</div>			
			</div>
		</section>
	</div>
</div>

<style>
	.invoice-format{
		height:19.8cm;
		width:16.7cm;
		border:1px solid black;
		font-family:'Arial';
	}
	
	.invoice-body{
		margin-top:2.2cm;
		width:100%;	
		height:370px;
	}
	
	.invoice-header{
		width:100%;
		margin-top:1.5cm;
	}
	
	.invoice-footer{
		margin-top: 10px;
		width:100%;
		text-align:right;
		padding-right:10px;
	}
</style>