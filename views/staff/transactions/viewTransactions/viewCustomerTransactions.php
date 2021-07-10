<div class="well well-small well-shadow" style="width:150pxs;margin-bottom:-20px;margin-left:20px;">
	<center>Transaction Details</center>
</div>
<?php query('UPDATE tbl_transactions','SET checkStatus = :status WHERE customer = :customer',[':status' => 0, ':customer' => $customerName]);?>
<?php session_start(); ?>
<div class="box">
	<div class="box-content">
		</div>
		<br>
		<div class="row">
			<div class="span10">
				<div class="table-responsive" style="height:220px;overflow-y:auto;">
					<table class="table table-hover table-striped" style="width:100%;">
						<thead>
							<tr >
								<th></th>
								<th></th>
								<th></th>
								<th>Invoice no.</th>
								<th>PO no.</th>
								<th>Date</th>	
								<th>AmountDue (Php)</th>
								<th>Remarks</th>
								<th></th>
							</tr>
							</thead>
							<tbody class="customer-transactions">
								<?php foreach($viewTransaction as $transaction):?>
								<tr class="transaction-info" id="transaction-info<?php echo $transaction['row']['transaction_id'];?>" idti="<?php echo $transaction['row']['transaction_id'];?>">
									<?php //if(parseSession($_SESSION['account_id'],1) == 'admin'){?>
										<td>
											<button class="btn btn-danger btn-remove-transaction" id="btn-remove-transaction<?php echo $transaction['row']['id'];?>" idrt="<?php echo $transaction['row']['id']; ?>" style="float:right; "><i class="fa fa-remove"></i></button>
											
										</td>
									<?php //}?>
									<td><button class="btn btn-primary btn-view-transaction-breakdown" idvtb="<?php echo $transaction['row']['id'];?>"><i class="fa fa-search"></i></button></td>
									<td>
										<button class="btn btn-success generate-purchase-order" id="generate-purchase-order<?php echo $transaction['row']['transaction_id'];?>" idgpo="<?php echo $transaction['row']['transaction_id'];?>" style="float:right;" ><i class="fa fa-file-o"></i></button>
									</td>
									<td><?php echo $transaction['row']['transaction_id'];?></td>
									<td><?php echo $transaction['row']['purchaseOrderNo'];?></td>
									<td><?php echo date('M d, Y',strtotime($transaction['row']['dateTime']));?></td>
									<td><?php echo number_format($transaction['row']['discountedAmount'],2,'.',',');?></td>
									<td><?php if($transaction['row']['remarks'] == 1){echo 'Paid';}else{echo 'Pending';}?></td>
								</tr>
								<?php endforeach;?>
							</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>
</div>
<?php if(parseSession($_SESSION['account_id'],1) == 'admin'){?>
	<div class="row">
		<div class="span10">
			<button class="btn btn-default btn-generate-statement" style="float:right;"><i class="fa fa-files-o"></i> Generate statement of accounts</button>
		</div>
	</div>
<?php }?>
<br>
<div class="box">
	<div class="box-content">
		<div class="row">
			<div class="span5">
				<?php $getAmountDetails = query('SELECT FORMAT(SUM(actualCashReceived),2) as actualCashReceived,  FORMAT(SUM(expectedCashReceived),2) as expectedCashReceived FROM tbl_transactionspercustomer','WHERE customer = :customer',[':customer' => $transaction['row']['customer']],'variable',1);?>
				
				<h5>Expected cash received: </h5>Php <span class="expectedCashCustomer"><?php if(!empty($getAmountDetails['row']['expectedCashReceived'])){echo $getAmountDetails['row']['expectedCashReceived'];}else{echo '0.00';}?></span>
										
				<h4>Total Amount Received: </h4> Php <span class="totalCashCustomer"><?php if(!empty($getAmountDetails['row']['actualCashReceived'])){echo $getAmountDetails['row']['actualCashReceived'];}else{ echo '0.00';}?></span>
			</div>
			<div class="span2">
				<div class="row">
					<div class="span2">
						<h5>Transactions:</h5>
					</div>
					<div class="span1">
						<?php $transactionsCount = query('SELECT * FROM tbl_transactions','WHERE customer = :customer',[':customer' => $transaction['row']['customer']],'rows');?>
						<span class="totalTransactionsCustomer"><?php echo $transactionsCount;?></span>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="span2">
						<h5>Pending:</h5>
					</div>
					<div class="span1">
						<?php $transactionsPendingCount = query('SELECT * FROM tbl_transactions','WHERE customer = :customer AND remarks = :remarks',[':customer' => $transaction['row']['customer'], ':remarks' => 0],'rows');?>
						<span class="totalPendingTransactionsCustomer"><?php echo $transactionsPendingCount;?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="span3">
		<button class="btn btn-warning btn-close-customer-transaction-form" autofocus="autofocus">Close</button>
	</div>
	<div class="span4" style="float:right;">
		<button class="btn btn-success btn-modify-payment-form" <?php echo $getAmountDetails['row']['expectedCashReceived'] == $getAmountDetails['row']['actualCashReceived'] ? 'disabled' : '';?> autofocus="autofocus" style="float:right;" customerName="<?php echo $transaction['row']['customer'];?>" >Modify payment</button>
	</div>
</div>
