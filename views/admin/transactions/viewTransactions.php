<?php require_once('views/header.php');?>

<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<?php unset($_SESSION["TransactionsSelected"]);?>
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
										<div class="box well well-small well-shadow mainform">
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
							
							<?php $c = query('SELECT customer_id FROM tbl_customerpaymentinfo','','','variable');?>
							<?php 
								foreach($c as $v){
									//echo $v['row']['customer']."<br>";
									$r = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer',[':customer' => $v['row']['customer_id']],'variable',1);

									if(empty($r)){
										query('DELETE FROM tbl_customerpaymentinfo','WHERE customer_id = :customer',[':customer' => $v['row']['customer_id']]);
									}
								}
							?>
							<div class="span4">
								<div class="row">
									<div class="span4">
										<?php $getCustomerList = query('SELECT * FROM tbl_customers','','','variable'); ?>
										<?php $verifyCustomerPaymentInfo = query("SELECT * FROM tbl_customerpaymentinfo","","","variable"); ?>
										<?php 
											$expectedCashReceived = 0.00;
											$actualCashReceived = 0.00;
											
											if(!empty($verifyCustomerPaymentInfo)){
												if(!empty($getCustomerList)){
													foreach($getCustomerList as $customer){
														$verifyCustomer = query("SELECT customer_id FROM tbl_customerpaymentinfo","WHERE customer_id = :id",[":id" => $customer["row"]["customer_id"]],"variable",1);
														
														if(!empty($verifyCustomer)){
															$expected = query('SELECT expectedCashReceived FROM tbl_customerpaymentinfo','WHERE customer_id = :customer',[':customer' => $customer['row']['customer_id']],'variable',1);
															
															$actual = query('SELECT actualCashReceived FROM tbl_customerpaymentinfo','WHERE customer_id = :customer',[':customer' => $customer['row']['customer_id']],'variable',1);
															
															$expectedCashReceived += $expected['row']['expectedCashReceived'];
															$actualCashReceived += $actual['row']['actualCashReceived'];	
														}
													}	
												}	
											}
											
											$getnoncustomerinfo = query("SELECT * FROM tbl_customerpaymentinfo","WHERE customer_id = :id",[":id" => 0],"variable",1);
											
											if(!empty($getnoncustomerinfo)){
												$expectedCashReceived += $getnoncustomerinfo['row']['expectedCashReceived'];
												
												$actualCashReceived += $getnoncustomerinfo['row']['actualCashReceived'];	
											}
										?>
										
										<h5>Expected cash received: </h5>Php <span class="expectedCash"><?php echo number_format($expectedCashReceived,2,".",","); ?></span>
										
										<h4>Total Amount Received: </h4> Php <span class="totalCash"><?php echo number_format($actualCashReceived,2,".",","); ?></span>
									</div>
								</div>	
							</div>
						</div>
					</div>
					
					<div class="span12">
						<div class="nav-tabs-custom" >
							<ul class="nav nav-pills">
								<li class="active"><a href="#existing-transaction" data-toggle="tab">Existing Transactions</a></li>
								<li ><a href="#walk-in-transaction" data-toggle="tab">Walk in Transactions</a></li>
							</ul>
						</div>
					</div>
					
					<div class="span12" style="overflow-x:hidden;">
						<div class="box box-solid">
							<div class="tab-content">
								<div class="tab-pane fade in " id="walk-in-transaction">
									<div class="row">
										<div class="span12" style="width:96%;">
											<div class="box mainform" style="padding:10px;">
												<legend>Walk in Transactions</legend>
												
												<div class="box-content">
													<div class="row"> 
															<div class="span7">
																<div class="row">
																	<div class="span3">
																		<h5 >Search by invoice no:</h5>
																	</div>
																	<div class="span7">
																		<form class="frm-search-walk-in-transaction">
																			<span >
																				<?php $transactionsId = query('SELECT transaction_id FROM tbl_transactions','WHERE customer_id = :id',[':id' => 0],'variable');?>
																				<select class="span5 invoice-no" placeholder="Enter invoice no&hellip;">
																					<option value=""></option>
																					<?php foreach($transactionsId as $transaction):?>
																						<option value="<?php echo $transaction['row']['transaction_id'];?>"><?php echo $transaction['row']['transaction_id'];?></option>
																					<?php endforeach;?>
																				</select>
																			</span>
																			<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
																			<button class="btn btn-warning btn-refresh-walk-in-transactions" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
																		</form>
																	</div>
																</div>
															</div>
															<div class="span2" >
																<div class="row">
																	<div class="span2">
																		<h6 style="float:right;">.</h6>
																	</div>
																	<div class="span2" > 
																		<div class="dropdown" style="float:right;">
																			<button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																			
																			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																				<li role="presentation" class="disabled option-select-single-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-select-single-walk-in-transaction">Select single</a>
																				</li>
																				<li role="presentation" class="option-select-several-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-select-several-walk-in-transaction">Select several</a>
																				</li>
																				<li role="presentation" class="option-select-all-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-select-all-walk-in-transaction">Select All Transactions</a>
																				</li>
																				<li role="presentation" class="disabled option-deselect-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-deselect-walk-in-transaction"> Deselect Transactions</a>
																				</li>
																				<li role="presentation" class="divider"></li>
																				<li role="presentation" class="option-sort-by-date-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-sort-by-date-walk-in-transaction">Sort by date</a>
																				</li>
																				<li role="presentation" class="option-sort-most-previous-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-sort-most-previous-walk-in-transaction"> Sort by most previous transactions</a>
																				</li>
																				<li role="presentation" class="disabled option-sort-most-recent-walk-in-transaction">
																					<a role="menuitem" tabindex="-1" class="menu-sort-most-recent-walk-in-transaction">Sort by most recent transactions</a>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													<hr>
													<div class="row">
														<div class="span9">
															<div class="nav-tabs-custom" >
																<ul class="nav nav-pills">
																	<li class="active"><a href="#walk-in-transaction-list" data-toggle="tab">Transaction List</a></li>
																	<li ><a href="#walk-in-transaction-sale-status" data-toggle="tab">Sales Status</a></li>
																</ul>
															</div>
														</div>
														<div class="span9">
															<div class="tab-content">
																<div class="tab-pane fade in active" id="walk-in-transaction-list">
																	<div class="row">
																		<div class="span9" >
																			<div class="table-responsive">
																				<table class="table table-hover table-striped table-walk-in-transactions">
																					<thead>
																						<tr>
																							<th style="width:150px;">Invoice no</th>
																							<th style="width:150px;">Date</th>
																							<th style="width:150px;">Amount Due (Php)</th>
																						</tr>
																					</thead>
																					<tbody class="displayAllWalkInTransactions">  
																						<!--Display All Transactions-->
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>
																
																<div class="tab-pane fade in" id="walk-in-transaction-sale-status">
																	<div class="row">
																		<div class="span9" style="width:96%;height:500px;">
																			<h3>This section is still under construction!</h3>
																			
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="span2" >
																<button class="btn btn-view-walk-in-transactions disabled" style="height:70px;"> View Transactions</button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="btn btn-remove-walk-in-transactions disabled" style="height:70px;">Remove transactions</button>
															</div>
														</div>
													</div>
												</div>
											
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade in active" id="existing-transaction">
									<div class="row">
										<div class="span12" style="width:96%;">
											<div class="box mainform" style="padding:10px;">
												<legend>Existing Transactions</legend>
												
												<div class="box-content">
													<div class="row"> 
														<div class="span12">
															<div class="row">
																<div class="span2">
																	<div class="row">
																		<div class="span2">
																			<h6 >Search by:</h6>
																		</div>
																		<div class="span2">
																			<select style="width:100%;margin-right:5px;" class="search-by">
																				<option value="customer_id">Customer</option>
																				<option value="id">Invoice no</option>
																			</select>	
																		</div>
																	</div>
																</div>
																<div class="span5">
																	<form class="frm-search-existing-transaction" style="margin-top:40px;">
																		<span class="search-by-customer">
																			<?php $customerList = query('SELECT DISTINCT(name), tbl_transactions.customer_id FROM tbl_customers INNER JOIN tbl_transactions ON tbl_customers.customer_id = tbl_transactions.customer_id ORDER BY name ASC','','','variable');?>
																			<select class="span3 customer-name" placeholder="Enter customer name&hellip;">
																				<option value=""></option>
																				<?php foreach($customerList as $customer):?>
																					<option value="<?php echo $customer['row']['customer_id'];?>"><?php echo $customer['row']['name'];?></option>
																				<?php endforeach;?>
																			</select>
																		</span>
																				
																		<span class="search-by-invoice-no" hidden>
																			<?php $transactionsId = query('SELECT * FROM tbl_transactions','WHERE customer_id != :id ORDER BY id ASC',[":id" => 0],'variable');?>
																			<select class="span3 invoice-no" placeholder="Enter invoice no&hellip;">
																				<option value=""></option>
																				<?php foreach($transactionsId as $transaction):?>
																					<option value="<?php echo $transaction['row']['id'];?>"><?php echo $transaction['row']['transaction_id'];?></option>
																				<?php endforeach;?>
																			</select>
																		</span>
																		<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
																		<button class="btn btn-warning btn-refresh-transactions-existing" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
																	</form>
																</div>
																<div class="span2" >
																	<div class="row">
																		<div class="span2">
																			<h6 style="float:right;">.</h6>
																		</div>
																		<div class="span2" > 
																			<div class="dropdown" style="float:right;">
																				<button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																						
																				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																					<li role="presentation" class="disabled option-select-single-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-select-single-existing-transaction">Select single</a>
																					</li>
																					<li role="presentation" class="option-several-all-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-select-several-existing-transaction">Select several</a>
																					</li>
																					<li role="presentation" class="option-select-all-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-select-all-existing-transaction">Select All Transactions</a>
																					</li>
																					<li role="presentation" class="disabled option-deselect-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-deselect-existing-transaction"> Deselect Transactions</a>
																					</li>
																					<li role="presentation" class="divider"></li>
																						<li role="presentation" class=" option-sort-by-date-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-sort-by-date-existing-transaction">Sort by date</a>
																					</li>
																					<li role="presentation" class="option-sort-most-previous-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-sort-most-previous-existing-transaction"> Sort by most previous transactions</a>
																					</li>
																					<li role="presentation" class="disabled option-sort-most-recent-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-sort-most-recent-existing-transaction">Sort by most recent transactions</a>
																					</li>
																				</ul>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<hr>
													
													<div class="row">
														<div class="span9">
															<div class="nav-tabs-custom" >
																<ul class="nav nav-pills">
																	<li class="active"><a href="#existing-transaction-list" data-toggle="tab">Transaction List</a></li>
																	<li ><a href="#existing-transaction-sale-status" data-toggle="tab">Sales Status</a></li>
																</ul>
															</div>
														</div>
														<div class="span9">
															<div class="tab-content">
																<div class="tab-pane fade in active" id="existing-transaction-list">
																	<div class="row">
																		<div class="span9" style="width:96%;">
																			<div class="table-responsive" style="overflow-x:auto;height:500px;">
																				<table class="table table-hover table-striped">
																					<thead>
																						<tr>
																							<th>Invoice no</th>
																							<th>Date</th>
																							<th>Customer</th>
																							<th>Amount Due (Php)</th>
																						</tr>
																					</thead>
																					<tbody class="displayAllExistingTransactions">
																						<!--Display All Transactions-->
																					</tbody>
																				</table>
																			</div>
																			
																		</div>
																	</div>
																</div>
																
																<div class="tab-pane fade in" id="existing-transaction-sale-status">
																	<div class="row">
																		<div class="span9" style="width:96%;height:500px;">
																			<h3>This section is still under construction!</h3>
																			
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="span2">
																<button class="btn btn btn-view-customer-account disabled" style="height:70px;"> View Customer Account</button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="btn btn btn-view-pending-transactions" style="height:70px;">View Pending transactions</button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="btn btn btn-view-existing-transactions disabled" style="height:70px;">View transactions</button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="btn btn btn-remove-existing-transactions disabled" style="height:70px;">Remove transactions</button>
															</div>
														</div>
													</div>
												
												</div>
											</div>
										</div>
									</div>
								
								</div>
							</div><!-- /.tab-pane -->  
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<?php require_once('views/footer.php');?>
