<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<?php query('UPDATE tbl_transactions SET checkStatus = 0');?>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>View Transactions<br/>
                            <small>Eiblin Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container">
		<legend>Transactions Summary</legend>
		<div class="row">
			<div class="blockoff-right">
				<div class="row">
					<div class="span4">
						<div class="row">
							<div class="span4">
								<div class="box well well-small well-shadow mainform">
									<div class="row">
										<div style="text-align:center;float:left;width:50%;padding-left:40px;">
											<i class="fa fa-edit fa-5x"></i>
											<p>Total Transactions</p>
										</div>
										<div>
											<h3 style="font-size:50px;margin-top:50px;float:left;">
												<?php $totalTransactions = query('SELECT * FROM tbl_transactions','','','rows');?>
												<span class="totalTransactions"><?php echo $totalTransactions;?></span>
											</h3>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<div class="box well well-small well-shadow mainform" >
											<div class="row">
												<div  style="float:left;width:50%;padding-left:40px;">
													<p style="margin-top:-10px;">Paid</p>
													<h3 style="font-size:30px;margin-top:-15px;">
														<?php $totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE remarks = :remarks',[':remarks' => 1],'rows');?>
														<span class="totalPaidTransactions"><?php echo $totalPaidTransactions;?></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="span2">
										<div class="box well well-small well-shadow mainform btn-view-pending-transactions" style="cursor:pointer;">
											<div class="row">
												<div style=";float:left;width:50%;padding-left:40px;">
													<p style="margin-top:-10px;">Pending</p>
													<h3 style="font-size:30px;margin-top:-15px;">
														<?php $totalPendingTransactions = query('SELECT * FROM tbl_transactions','WHERE remarks = :remarks',[':remarks' => 0],'rows');?>
														<span class="totalPendingTransactions"><?php echo $totalPendingTransactions;?></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
								</div>		
							</div>
						
							<div class="span4">
								<div class="row">
									<div class="span4">
										<?php $getAmountDetails = query('SELECT FORMAT(SUM(actualCashReceived),2) as actualCashReceived,  FORMAT(SUM(expectedCashReceived),2) as expectedCashReceived FROM tbl_transactionspercustomer','','','variable',1);?>
										
										<h5>Expected cash received: </h5>Php <span class="expectedCash"><?php if(!empty($getAmountDetails['row']['expectedCashReceived'])){echo $getAmountDetails['row']['expectedCashReceived'];}else{echo '0.00';}?></span>
										
										<h4>Total Amount Received: </h4> Php <span class="totalCash"><?php if(!empty($getAmountDetails['row']['actualCashReceived'])){echo $getAmountDetails['row']['actualCashReceived'];}else{ echo '0.00';}?></span>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="span12">
						<div class="box mainform" style="padding:10px;">
							<legend>All Transactions</legend>
							<div class="well well-small well-shadow mainform" style="width:150px;margin-bottom:-20px;margin-left:20px;">
								Search Transactions
							</div>
							<div class="box">
								<div class="box-content">
									<br>
									<div class="row"> 
										<div class="span2">
											<div class="row">
												<div class="span2">
													<h6 >Search by:</h6>
												</div>
												<div class="span2">
													<select style="width:100%;margin-right:5px;" class="search-by">
														<option value="customer">Customer</option>
														<option value="transaction_id">Invoice no</option>
													</select>	
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="row">
												<div class="span7">
													<form class="frm-search-transaction-putek" style="margin-top:40px;">
													
														<span class="search-by-customer">
															<?php $customerList = query('SELECT DISTINCT(customer) FROM tbl_transactions ORDER BY customer ASC','','','variable');?>
															<select class="customer-name" style="width:50%;" placeholder="Enter customer name&hellip;">
																<option value=""></option>
																<?php foreach($customerList as $customer):?>
																	<option value="<?php echo $customer['row']['customer'];?>"><?php echo $customer['row']['customer'];?></option>
																<?php endforeach;?>
															</select>
														</span>
														
														<span class="search-by-invoice-no " hidden>
															<?php $transactionsId = query('SELECT transaction_id FROM tbl_transactions ORDER BY transaction_id ASC','','','variable');?>
															<select class="invoice-no" placeholder="Enter invoice no&hellip;" style="width:50%;">
																<option value=""></option>
																<?php foreach($transactionsId as $transaction):?>
																	<option value="<?php echo $transaction['row']['transaction_id'];?>"><?php echo $transaction['row']['transaction_id'];?></option>
																<?php endforeach;?>
															</select>
														</span>
														<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
														<button class="btn btn-warning btn-refresh-transactions" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
													</form>
												</div>
											</div>
										</div>
										<div class="span2" style="margin-left:60px;">
											<div class="row">
												<div class="span2">
													<h6 >Sort item:</h6>
												</div>
												<div class="span3">
													<select style="width:70%;margin-right:5px;" class="transaction-sort-order">
														<option value="DESC">Descending</option>
														<option value="ASC">Ascending</option>
													</select>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="box-content">
								<div class="row">
									<div class="span2" style="margin-right:-30px;">
										<a class="btn-check-all-transactions">
											<h5><i class="fa fa-check"></i> Check all</h5>
										</a>	
									</div>
									<div class="span8">
										<a class="btn-uncheck-all-transactions">
											<h5><i class="fa fa-remove"></i> Uncheck all</h5>
										</a>	
									</div>
									<div class="span11">
										<button class="btn btn-primary btn-view-transaction-cutomer" style="float:right;margin-bottom:20px;width: 235px;"><i class="fa fa-eye"></i> View Transactions</button>
									</div>
									<div class="span11">
										<button class="btn btn-danger btn-remove-selected-transactions disabled" style="float:right;margin-bottom:20px;"><i class="fa fa-remove"></i> Remove selected transactions</button>
									</div>
									
									<div class="span11" style="width:96%;">
										<div class="table-responsive" style="overflow-x:auto;height:500px;">
											<table class="table table-striped ">
												<thead>
													<tr>
														<th></th>
														<th></th>
														<th></th>
														<th>Date</th>
														<th>Invoice no</th>
														<th>PO no</th>
														<th>Customer</th>
														<th>Amount Due (Php)</th>
														<th>Remarks</th>
													</tr>
												</thead>
												<tbody class="displayAllTransactions">
													<!--Display All Transactions-->
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script src="public/js/admin/transactions/viewTransactions.js" type="text/javascript"></script>

<?php require_once('views/footer.php');?>
