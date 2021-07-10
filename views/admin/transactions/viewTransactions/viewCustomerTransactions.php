<div class="row">
	<div class="span10">
		<div class="nav-tabs-custom" >
			<ul class="nav nav-pills">
				<li class="active"><a href="#transaction-list" data-toggle="tab">Transaction List</a></li>
				<li ><a href="#payment-breakdown" data-toggle="tab">Payment Breakdown</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="span10">
		<div class="tab-content" style="overflow-x:hidden;">
			<div class="tab-pane fade in active" id="transaction-list">
				<div class="well well-small well-shadow" style="width:150px;margin-bottom:-20px;margin-left:20px;">
					<center>Transaction Details</center>
				</div>

				<?php session_start(); ?>
				<div class="box">
					<div class="box-content"> 
						
						<br>
						<div class="row">
							<div class="span10">
								<div class="table-responsive" style="height:220px;overflow-y:auto;">
									<table class="table table-hover table-striped" style="width:100%;">
										<thead>
											<tr >
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
												<tr class="transaction-info" id="transaction-info<?php echo $transaction['row']['transaction_id'];?>" idti="<?php echo $transaction['row']['transaction_id'];?>" align="center">
													<?php //if(parseSession($_SESSION['account_id'],1) == 'admin'){?>
														<td>
															<button class="btn btn-danger btn-remove-transaction" id="btn-remove-transaction<?php echo $transaction['row']['id'];?>" idrt="<?php echo $transaction['row']['id']; ?>" style="float:right; "><i class="fa fa-remove"></i></button>
															
														</td>
													<?php //}?>
													<td><button class="btn btn-primary btn-view-transaction-breakdown" idvtb="<?php echo $transaction['row']['id'];?>"><i class="fa fa-search"></i></button></td>
													<td hidden>
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
				<div class="row">
					<div class="span10">
						<div class="row">
							<div class="span1"  style="margin-right:20px;">
								<h5>Transactions:</h5>
							</div>
							<div class="span1">
								<?php $transactionsCount = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id',[':customer_id' => $transaction['row']['customer_id']],'rows');?>
								<h5><span class="totalTransactionsCustomer" style="color:red;"><?php echo $transactionsCount;?></span></h5>
							</div>
						
							<div class="span1">
								<h5>Pending:</h5>
							</div>
							<div class="span1">
								<?php $transactionsPendingCount = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id AND remarks = :remarks',[':customer_id' => $transaction['row']['customer_id'], ':remarks' => 0],'rows');?>
								<h5><span class="totalPendingTransactionsCustomer" style="color:red;"><?php echo $transactionsPendingCount;?></span></h5>
							</div>
						</div>
					</div>
				</div>				
			</div>
			<?php if(parseSession($_SESSION['account_id'],1) == 'admin'){?>
				<?php 
					$expectedCashGiven = number_format(getExpectedAmountGivenPerCustomer($customer_id),2,".",",");
					$actualCashGiven = number_format(getActualAmountGivenPerCustomer($customer_id),2,".",",");
				?>
				
				<div class="row">
					<div class="span10">
						<button style="display:none;" class="btn btn-default btn-generate-statement" style="float:right;" <?php echo $expectedCashGiven == $actualCashGiven ? 'disabled' : '';?> ><i class="fa fa-files-o"></i> Generate statement of accounts</button>
					</div>
				</div>
			<?php }?>
			<div class="tab-pane fade in" id="payment-breakdown">
				<div class="box">
					<div class="box-content">
						<div class="row">	
							<div class="span5">
								<div class="well well-small well-shadow" style="width:230px;margin-bottom:-20px;margin-left:20px;">
									Payment modification breakdown
								</div>
								<div class="box">
									<div class="box-content">
										<br>
										<?php $paymentModificationBreakdownInfo = query('SELECT * FROM tbl_paymentmodificationbreakdown','WHERE customer_id = :id ORDER BY dateTimePaid DESC',[':id' => $customer_id],'variable');?>
										
										<?php if(!empty($paymentModificationBreakdownInfo)){?>
											<div class="table-responsive" style="height:150px;overflow-y:auto;">
												<table class="table table-hover" style="width:100%;">
													<thead>
														<tr>	
															<th>Date paid</th>
															<th>Amount</th>
															<th></th>
														</tr>
														</thead>
														<tbody>
															<?php $totalPayment = 0; ?>
															<?php foreach($paymentModificationBreakdownInfo as $transactionModification){?>
															<tr id="payment-details<?php echo $transactionModification["row"]["paymentmodificationbreakdown_id"]; ?>" style="<?php if($transactionModification['row']['amountGiven'] < 0){echo "background-color:#FF7C7C";}?>">
																<td><?php echo date('M d, Y',strtotime($transactionModification['row']['dateTimePaid']));?></td>
																<td><?php echo number_format($transactionModification['row']['amountGiven'],2,'.',',');?></td>
																<td><button class="btn btn-danger btn-remove-payment" id="btn-remove-payment<?php echo $transactionModification["row"]["paymentmodificationbreakdown_id"];?>" idrp="<?php echo $transactionModification["row"]["paymentmodificationbreakdown_id"]; ?>"><i class="fa fa-remove"></i></button></td>
															</tr>
															<?php $totalPayment += $transactionModification['row']['amountGiven']; } ?>
														</tbody>
												</table>
											</div>	
											<h5>Total Amount: <span style="color:red;">Php <?php echo number_format($totalPayment, 2, ".", ","); ?></span></h5>
										<?php }else{?>
											<h5>No Payment modification has been made yet.</h5>
										<?php }?>
										
									</div>
								</div>
							</div>
							<div class="span4">
								<h5>Expected cash received: </h5>Php <span class="expectedCashCustomer" style="color:red;"><?php echo $expectedCashGiven; ?></span>
														
								<h4>Total Amount Received: </h4> Php <span class="totalCashCustomer" style="color:red;"><?php echo $actualCashGiven; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="span4">
		<button class="btn btn-warning btn-close-customer-transaction-form" autofocus="autofocus">Close</button>
	</div>
	
	<div class="span3" >
		<button class="btn btn-success btn-pay-all-transaction" <?php echo $expectedCashGiven == $actualCashGiven ? 'disabled' : '';?> style="float:right;margin-right:-80px;"> Pay all transactions</button>
	</div>
	<div class="span3" style="float:right;">
		<button class="btn btn-primary btn-modify-payment-form" <?php echo $expectedCashGiven == $actualCashGiven ? 'disabled' : '';?> autofocus="autofocus" style="float:right;" >Modify payment</button>
	</div>
</div>
