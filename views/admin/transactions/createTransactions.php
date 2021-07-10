<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<input type="hidden" value="tbl_items" class="tblname"/>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php'); ?>
	
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Transactions Information<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	
	<section class="page container">
		<div class="row">
			<div class="span16">
				<div class="nav-tabs-custom">
					<ul class="nav nav-pills">
						<li class="<?php if($_GET["mainsub"] == "create_transactions"){echo "active";}?>"><a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1('transactions');?>&mainsub=create_transactions&sub=walk_in">Create Transactions</a></li>
						<li class="<?php if($_GET["mainsub"] == "view_transactions"){echo "active";}?>"><a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1('transactions');?>&mainsub=view_transactions&sub=existing_transactions" >View Transactions</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span16">
				<div class="tab-content" style="overflow-x:hidden;">
					<?php if($_GET["mainsub"] == "create_transactions"){?>
						<div class="tab-pane fade in active well well-small mainform" id="walk-in-transaction">
							<div class="row ">
								<div class="span10">
									<div class="nav-tabs-custom" >
										<ul class="nav nav-pills">
											<li class="<?php if($_GET["sub"] == "walk_in"){echo "active";}?>"><a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1("transactions");?>&mainsub=create_transactions&sub=walk_in" >Walk in orders</a></li>
											<li class="<?php if($_GET["sub"] == "existing"){echo "active";}?>"><a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1("transactions");?>&mainsub=create_transactions&sub=existing" >Existing orders</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="span16">
									<div class="tab-content" style="overflow-x:hidden;">
										<?php if($_GET["sub"] == "walk_in"){?>
											<div class="tab-pane fade in active" id="walk-in-transaction">
												<div class="row">
													<div class="span10">
														<div class="well well-small well-shadow mainform"> 
															<legend>Create Transaction</legend>
															<div class="row" style="margin-left:auto;margin-right:auto;">
																<div class="span6" style="margin-right:-12px;">
																	<form class="item-select">
																		<select class="select-items refresh-item-list span6" id="select-items" placeholder="Enter item description&hellip;">
																			<option></option>
																			<?php $itemList = query('SELECT * FROM tbl_items ORDER BY itemId DESC','','','variable');?>
																			<?php foreach($itemList as $item):?>
																				<option value="<?php echo $item['row']['itemId'];?>"><?php echo $item['row']['description']." - ";?> <?php echo $item['row']['unit']; ?></option>
																			<?php endforeach;?>
																		</select>
																	</form>
																</div>
																<div class="span3">
																	<button class="btn btn-primary span3 btn-see-items" style="margin-left:-1px;"><i class="fa fa-search" style="font-size:20px;"></i>&nbsp;See Items</button>
																</div>
															</div>
															<br>
															<div class="">
															
															</div>
															<div class="well well-small well-shadow" style="width:150px;margin-bottom:-20px;margin-left:20px;">
																Transaction Breakdown
															</div>
															
															<div class="box">
																<div class="box-content">
																<br>
																	<div class="row">
																		<div class="span9" style="width:96%;">
																			<div class="table-responsive" style="overflow-x:auto;">
																				<table class="table table-hover table-striped">
																					<thead>
																						<tr>
																							<th>Qty</th>
																							<th>Unit</th>
																							<th>Description</th>
																							<th>Unit Price (Php)</th>
																							<th>Amount (Php)</th>
																						</tr>
																					</thead>
																					<tbody class="displayItemBreakdown">
																						<!--Display Item Breakdown-->
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="span6" style="width:33%;">
														<form class="frm-submit-transaction">
															<div class="well well-small well-shadow mainform">	
																<legend>Transaction Details</legend>
																<div class="box">
																	<div class="box-content">
																		<div class="row">
																			<div class="span6">
																				<div class="row">
																					<div class="span3">
																						<div class="row">
																							<div class="span3" style="margin-bottom:18px;">
																								<b>Charge Invoice No.</b>
																							</div>
																							<div class="span3">
																								<h5 hidden> 
																									<?php do{?>
																									<?php $rand = rand(0,1000); $zeros = '';  ?>
																									<?php if(strlen($rand) < 4):?>
																										<?php $zeroLength = 4 - strlen($rand); ?>
																										<?php for($i = 0;$i < $zeroLength; $i++):?>
																											<?php $zeros .= "0";?>
																										<?php endfor;?>
																									<?php endif;?>
																									<?php $invoiceNo =  "No-".$zeros.$rand;?>
																									<?php $verifyInvoiceNo = query('SELECT transaction_id FROM tbl_transactions','WHERE transaction_id = :id',[':id' => $invoiceNo],'variable',1);?>
																									<?php }while(!empty($verifyInvoiceNo));?>
																									<?php echo $invoiceNo;?>
																								</h5>
																								<input type="text" class="invoice-no span2 required"  id="invoice-no" placeholder="Enter invoice no&hellip;"/>
																							</div>
																						</div>
																					</div>
																					<div class="span3" style="margin-left:-2px;">
																						<div class="row">
																							<div class="span3" style="margin-bottom:18px;">
																								<b>Date</b>
																							</div>
																							<div class="span3">
																								<div id="datepicker" class="input-prepend date" >
																									<span class="add-on"><i class="icon-th"></i></span>
																									<input style="width:90px;" type="text" value="<?php echo date('m/d/Y');?>" class="transaction-date required" readonly="true" />
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																
																<div class="box">
																	<div class="box-content">
																		<div class="row">
																			<div class="span2" >
																				<div style="margin-left:10px;">
																					<?php $vatValue = query('SELECT * FROM tbl_settings','','','variable',1);?>
																					<h6>VATable: </h6><h5 style="margin-top:-10px;color:red;">Php <span class="vatable">0.00</span></h5>
																					<h6><?php echo $vatValue['row']['vat'];?>% VAT: </h6>
																					<h5 style="margin-top:-10px;color:red;">Php <span class="vat">0.00</span></h5>
																				</div>
																			</div>
																			<div class="span3">
																				<div style="float:right;">
																					<h3>Amount Due:</h3> <h2 style="font-size: 27px;">Php <span class="amountDue">0.00</span></h2>
																				</div>
																			</div>	
																		</div>
																	</div>
																</div>
																<div><button class="btn btn-primary">Save transaction</button></div>
															</div>
														</form>
													</div>
												</div>	
											</div>
											<script src="public/js/admin/transactions/createTransaction.js" type="text/javascript" ></script>
										<?php }elseif($_GET["sub"] == "existing"){?>
											<div class="tab-pane fade in active" id="existing-transaction">
												<div class="row">
													<div class="span10">
														<div class="row">
															<div class="span10">
																<div class="well well-small well-shadow mainform">
																	<legend>Select customer</legend>
																	<div class="row">
																		<div class="span9 " style="width:96%;">
																			<div class="row select-existing-customer" >
																				<div class="span3" style="margin-top:5px;">
																					<b >Customer name:</b>			
																				</div>
																				<div class="span6">
																				<?php $customers = query('SELECT * FROM tbl_customers','','','variable');?>
																					<div class="row">
																						<div class="span6">
																							<form class="select-customer">
																								<div class="row">
																									<div class="span4">
																										<select class="customer-name required" id="customer-name" style="margin-left: -90px;width:400px;" placeholder="Enter customer name&hellip;">
																											<option value=""></option>
																											<?php foreach($customers as $customer):?>
																												<option value="<?php echo $customer['row']['customer_id'];?>" ><?php echo $customer['row']['name'];?></option>
																											<?php endforeach; ?>
																										</select>		
																									</div>
																									<div class="span2" >
																										<button class="btn btn-primary" type="submit" style="margin-left:50px;">Select</button>
																									</div>
																								</div>
																							</form>	
																						</div>
																					</div>
																				</div>
																				
																			</div>
																		
																			<div hidden class="display-selected-customer">
																				<div class="box" > 
																					<div class="box-content">
																						<div class="row">
																							<div class="span4">
																								<div class="row">
																									<div class="span3" style="margin-bottom:10px;"> 
																										<b>Customer name:</b>
																									</div>
																									<div class="span5" style="font-size:20px;"> 
																										<span class="selected-customer-name"></span>
																									</div>
																									<input type="hidden" class="customer-name-selected" >
																									<input type="hidden" class="customer-id-selected" >
																								</div>
																							</div>
																							<div class="span3">
																								<div class="row"> 
																									<div class="span3" style="margin-bottom:10px;">
																										<b>Date Last Transaction: </b>
																									</div>
																									<div class="span3" style="font-size:20px;">
																										<span class="date-last-transaction"></span>
																									</div>
																								</div>
																							</div>
																							
																							<div class="span2">
																								<div class="row">
																									<div class="span3" style="margin-bottom:10px;">
																										<b>Total transactions: </b>
																									</div>
																									<div class="span3" style="font-size:20px;">
																										<span class="total-transaction"></span>
																									</div>
																								</div>
																							</div>
																						</div>		
																					</div>
																				</div>
																				<button style="display:none;" class="btn btn-warning btn-select-other-customer">Select other customer</button>
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
															
															<div class="span10">
																<div class="well well-small well-shadow mainform"> 
																		<legend>Create Transaction</legend>
																		<div class="row" style="margin-left:auto;margin-right:auto;">
																			<div class="span6 frm-select-items" style="margin-right:-12px;">
																				<form class="item-select">
																					<select class="select-items refresh-item-list span6" id="select-items" placeholder="Enter item description&hellip;">
																						<option></option>
																						<?php $itemList = query('SELECT * FROM tbl_items ORDER BY itemId DESC','','','variable');?>
																						<?php foreach($itemList as $item):?>
																							<option value="<?php echo $item['row']['itemId'];?>"><?php echo $item['row']['description']." - ";?> <?php echo $item['row']['unit']; ?></option>
																						<?php endforeach;?>
																					</select>
																				</form>
																			</div>
																			<div class="span3">
																				<button class="btn btn-primary span3 btn-see-items" style="margin-left:-1px;"><i class="fa fa-search" style="font-size:20px;"></i>&nbsp;See Items</button>
																				
																			</div>
																		</div>
																		<br>
																		<div class="well well-small well-shadow" style="width:150px;margin-bottom:-20px;margin-left:20px;">
																			Transaction Breakdown
																		</div>
																		
																		<div class="box">
																			<div class="box-content">
																			<br>
																				<div class="row">
																					<div class="span9" style="width:96%;">
																						<div class="table-responsive" style="overflow-x:auto;">
																							<table class="table table-hover table-striped">
																								<thead>
																									<tr>
																										<th>Qty</th>
																										<th>Unit</th>
																										<th>Description</th>
																										<th>Unit Price (Php)</th>
																										<th>Amount (Php)</th>
																									</tr>
																								</thead>
																								<tbody class="displayItemBreakdown">
																									<!--Display Item Breakdown-->
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
													<div class="span6" style="width:33%;">
														<form class="frm-submit-transaction">
															<div class="well well-small well-shadow mainform">	
																<legend>Transaction Details</legend>
																<div class="box">
																	<div class="box-content">
																		<div class="row">
																			<div class="span6">
																				<div class="row">
																					<div class="span3">
																						<div class="row">
																							<div class="span3" style="margin-bottom:18px;">
																								<b>Charge Invoice No:</b>
																							</div>
																							<div class="span3">
																								<h5 hidden> 
																									<?php do{?>
																									<?php $rand = rand(0,1000); $zeros = '';  ?>
																									<?php if(strlen($rand) < 4):?>
																										<?php $zeroLength = 4 - strlen($rand); ?>
																										<?php for($i = 0;$i < $zeroLength; $i++):?>
																											<?php $zeros .= "0";?>
																										<?php endfor;?>
																									<?php endif;?>
																									<?php $invoiceNo =  "No-".$zeros.$rand;?>
																									<?php $verifyInvoiceNo = query('SELECT transaction_id FROM tbl_transactions','WHERE transaction_id = :id',[':id' => $invoiceNo],'variable',1);?>
																									<?php }while(!empty($verifyInvoiceNo));?>
																									<?php echo $invoiceNo;?>
																								</h5>
																								<input type="text" class="invoice-no span2 required"  id="invoice-no" placeholder="Enter invoice no&hellip;"/>
																							</div>
																						</div>
																					</div>
																					<div class="span3" style="margin-left:-2px;">
																						<div class="row">
																							<div class="span3" style="margin-bottom:18px;">
																								<b>Purchase Order No:</b>
																							</div>
																							<div class="span3">
																								<input type="text" class="purchase-order-no span2"  id="purchase-order-no" placeholder="Enter PO no.&hellip;"/>
																							</div>
																						</div>
																					</div>
																					<div class="span3">
																						<div class="row">
																							<div class="span3">
																								<b>Date:</b>
																							</div>
																							<div class="span2">
																								<div id="datepicker" class="input-prepend date" style="margin-top:20px;">
																									<span class="add-on"><i class="icon-th"></i></span>
																									<input style="width:100px;" class="transaction-date required" type="text" value="<?php echo date('m/d/Y');?>" readonly="true" />
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																
																<div class="box">
																	<div class="box-content">
																		<div class="row">
																			<div class="span2" >
																				<div style="margin-left:10px;">
																					<?php $vatValue = query('SELECT * FROM tbl_settings','','','variable',1);?>
																					<h6>VATable: </h6><h5 style="margin-top:-10px;color:red;">Php <span class="vatable">0.00</span></h5>
																					<h6><?php echo $vatValue['row']['vat'];?>% VAT: </h6>
																					<h5 style="margin-top:-10px;color:red;">Php <span class="vat">0.00</span></h5>
																				</div>
																			</div>
																			<div class="span3">
																				<div style="float:right;">
																					<h3>Amount Due:</h3> <h2 style="font-size: 27px;">Php <span class="amountDue">0.00</span></h2>
																				</div>
																			</div>	
																		</div>
																	</div>
																</div>
																<div><button class="btn btn-primary">Save transaction</button></div>
															</div>
														</form>
														
													</div>
												</div>
											</div>
											<script src="public/js/admin/transactions/createTransactionExisting.js" type="text/javascript" ></script>
										<?php }else{?>
											<h2 class="headline text-yellow" style="margin-bottom:-30px">404</h2><br>
											<div class="error-content">
												<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
												<p>
													<?php session_start();?>
													 We could not find the page you were looking for.
													<a onclick="location.reload();">Click here to go back;</a>.
												</p>
											</div><!-- /.error-content -->
										<?php }?>
									</div>
								</div>
							</div>	
						</div>
					<?php }elseif($_GET["mainsub"] == "view_transactions"){?>
						<div class="tab-pane fade in active" id="view-transaction">
							<legend>Transactions Summary</legend>
							<div class="row" style="width:1300px;">
								<div class="blockoff-right" style="margin-left:50px;">
									<div class="row" >
										<div class="span4">
											<div class="row" >
												<div class="span4">
													<div class="box well well-small well-shadow mainform">
														<div class="row">
															<div style="text-align:center;float:left;width:50%;padding-left:35px;">
																<i class="fa fa-edit fa-5x"></i>
																<p>Total Transactions</p>
															</div>
															<div style="width:30%;height:auto;float:left;margin-left:4%;">
																<div style="width:100%;">
																	<a class="btn-sort-general-transactions" style="margin-left:65px;cursor:pointer;"><i class="fa fa-calendar fa-2x"></i></a>
																</div>
																<div style="width:100%;height:50%;margin-top:50px;">
																	<h3 style="font-size:45px;">
																		<?php $totalTransactions = query('SELECT * FROM tbl_transactions','','','rows');?>
																		<span class="totalTransactions"><?php echo $totalTransactions;?></span>
																	</h3>
																</div>
																
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
											
												<div class="span4">
													<div class="row">
														<div class="span4">
															<?php 
															
																$actualCashReceived = getOverAllActualAmount();
																$expectedCashReceived =  getOverAllExpectedAmount();
																
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
													<li class="<?php if($_GET["sub"] == "existing_transactions"){echo "active";}?>"><a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1('transactions');?>&mainsub=view_transactions&sub=existing_transactions" >Existing Transactions</a></li>
													<li class="<?php if($_GET["sub"] == "walkin_transactions"){echo "active";}?>"><a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1('transactions');?>&mainsub=view_transactions&sub=walkin_transactions">Walk in Transactions</a></li>
												</ul>
											</div>
										</div>
										
										<div class="span12" style="overflow-x:hidden;">
											<div class="box box-solid">
												<div class="tab-content" style="overflow-x:hidden;">
													<?php if($_GET["sub"] == "existing_transactions"){?>
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
																												<a role="menuitem" tabindex="-1" class="menu-select-single-existing-transaction"><i class="fa fa-plus-circle"></i> Select single</a>
																											</li>
																											<li role="presentation" class="option-several-all-existing-transaction">
																												<a role="menuitem" tabindex="-1" class="menu-select-several-existing-transaction"><i class="fa fa-plus-circle"></i> Select several</a>
																											</li>
																											<li role="presentation" class="option-select-all-existing-transaction">
																												<a role="menuitem" tabindex="-1" class="menu-select-all-existing-transaction"><i class="fa fa-bars"></i> Select All Transactions</a>
																											</li>
																											<li role="presentation" class="disabled option-deselect-existing-transaction">
																												<a role="menuitem" tabindex="-1" class="menu-deselect-existing-transaction"><i class="fa fa-remove"></i> Deselect Transactions</a>
																											</li>
																											<li role="presentation" class="divider"></li>
																												<li role="presentation" class=" option-sort-by-date-existing-transaction">
																												<a role="menuitem" tabindex="-1" class="menu-sort-by-date-existing-transaction"><i class="fa fa-calendar"></i> Sort by date</a>
																											</li>
																											<li role="presentation" class="option-sort-most-previous-existing-transaction">
																												<a role="menuitem" tabindex="-1" class="menu-sort-most-previous-existing-transaction"><i class="fa fa-sort-up"></i> Sort by most previous transactions</a>
																											</li>
																											<li role="presentation" class="disabled option-sort-most-recent-existing-transaction">
																												<a role="menuitem" tabindex="-1" class="menu-sort-most-recent-existing-transaction"><i class="fa fa-sort-down"></i> Sort by most recent transactions</a>
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
																							<li ><a href="#existing-transaction-sale-status" data-toggle="tab">Transaction Status</a></li>
																						</ul>
																					</div>
																				</div>
																				<div class="span9">
																					<div class="tab-content" style="overflow-x:hidden;">
																						<div class="tab-pane fade in active" id="existing-transaction-list">
																							<div class="row">
																								<div class="span9" style="width:96%;">
																									<div class="table-responsive">
																										<table class="table table-hover table-striped table-existing-transactions">
																											<thead>
																												<tr>
																													<th style="width:150px;text-align:center;">Invoice no</th>
																													<th style="width:200px;text-align:center;">Date</th>
																													<th style="width:300px;text-align:center;">Customer</th>
																													<th style="width:200px;text-align:center;">Amount Due (Php)</th>
																												</tr>
																											</thead>
																											<tbody class="displayAllExistingTransactions" >
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
																									<div class="row">
																										<div class="span3">
																											<h4>No. of days:</h4> 
																										</div>
																										<div class="span3">
																											<h4 style="color:red;"><span class="no-of-days-existing-transactions"></span></h4>
																										</div>
																									</div>
																									<div class="row">
																										<div class="span3">
																											<h4>Expected Amount:</h4> 
																										</div>
																										<div class="span3">
																											<h4 style="color:red;">Php <span class="expected-amount-existing-transactions"></span></h4>
																										</div>
																									</div>
																									<div class="row">
																										<div class="span3">
																											<h4>Actual Amount:</h4> 
																										</div>
																										<div class="span3">
																											<h4 style="color:red;">Php <span class="actual-amount-existing-transactions"></span></h4>
																										</div>
																									</div>
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
													
													<?php }elseif($_GET["sub"] == "walkin_transactions"){?>
														<div class="tab-pane fade in active" id="walk-in-transaction">
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
																											<a role="menuitem" tabindex="-1" class="menu-select-single-walk-in-transaction"><i class="fa fa-plus-circle"></i> Select single</a>
																										</li>
																										<li role="presentation" class="option-select-several-walk-in-transaction">
																											<a role="menuitem" tabindex="-1" class="menu-select-several-walk-in-transaction"><i class="fa fa-plus-circle"></i> Select several</a>
																										</li>
																										<li role="presentation" class="option-select-all-walk-in-transaction">
																											<a role="menuitem" tabindex="-1" class="menu-select-all-walk-in-transaction"><i class="fa fa-bars"></i> Select All Transactions</a>
																										</li>
																										<li role="presentation" class="disabled option-deselect-walk-in-transaction">
																											<a role="menuitem" tabindex="-1" class="menu-deselect-walk-in-transaction"> <i class="fa fa-remove"></i> Deselect Transactions</a>
																										</li>
																										<li role="presentation" class="divider"></li>
																										<li role="presentation" class="option-sort-by-date-walk-in-transaction">
																											<a role="menuitem" tabindex="-1" class="menu-sort-by-date-walk-in-transaction"><i class="fa fa-calendar"></i> Sort by date</a>
																										</li>
																										<li role="presentation" class="option-sort-most-previous-walk-in-transaction">
																											<a role="menuitem" tabindex="-1" class="menu-sort-most-previous-walk-in-transaction"><i class="fa fa-sort-up"></i> Sort by most previous transactions</a>
																										</li>
																										<li role="presentation" class="disabled option-sort-most-recent-walk-in-transaction">
																											<a role="menuitem" tabindex="-1" class="menu-sort-most-recent-walk-in-transaction"><i class="fa fa-sort-down"></i> Sort by most recent transactions</a>
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
																							<li ><a href="#walk-in-transaction-sale-status" data-toggle="tab">Transaction Status</a></li>
																						</ul>
																					</div>
																				</div>
																				<div class="span9">
																					<div class="tab-content" style="overflow-x:hidden;">
																						<div class="tab-pane fade in active" id="walk-in-transaction-list">
																							<div class="row">
																								<div class="span9" style="width:96%;">
																									<div class="table-responsive" >
																										<table class="table table-hover table-striped table-walk-in-transactions">
																											<thead>
																												<tr>
																													<th style="width:150px;text-align:center;">Invoice no</th>
																													<th style="width:300px;text-align:center;">Date</th>
																													<th style="width:300px;text-align:center;">Amount Due (Php)</th>
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
																									<div class="row">
																										<div class="span9" style="width:96%;height:500px;">
																											<div class="row">
																												<div class="span3">
																													<h4>No. of days:</h4> 
																												</div>
																												<div class="span3">
																													<h4 style="color:red;"><span class="no-of-days-walk-in-transactions"></span></h4>
																												</div>
																											</div>
																											<div class="row">
																												<div class="span3">
																													<h4>Expected Amount:</h4> 
																												</div>
																												<div class="span3">
																													<h4 style="color:red;">Php <span class="expected-amount-walk-in-transactions"></span></h4>
																												</div>
																											</div>
																											<div class="row">
																												<div class="span3">
																													<h4>Actual Amount:</h4> 
																												</div>
																												<div class="span3">
																													<h4 style="color:red;">Php <span class="actual-amount-walk-in-transactions"></span></h4>
																												</div>
																											</div>
																										</div>
																									</div>
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
														
													<?php }else{?>
														<div class="tab-pane fade in active" id="walk-in-transaction">
															<div class="row">
																<div class="span12">
																	<h2 class="headline text-yellow" style="margin-bottom:-30px">404</h2><br>
																	<div class="error-content">
																		<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
																		<p>
																			 We could not find the page you were looking for.
																			<a href="?pg=admin">Click here to go back;</a>.
																		</p>
																	</div><!-- /.error-content -->		
																</div>
															</div>
														</div>
													<?php }?>
													
													
												</div><!-- /.tab-pane -->  
											</div>
										</div>
									</div>
								</div>
							</div>
							<script src="public/js/admin/transactions/viewTransactions.js" type="text/javascript"></script>
						</div>
	
					<?php }else{?>
						<h2 class="headline text-yellow" style="margin-bottom:-30px">404</h2><br>
						<div class="error-content">
							<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
							<p>
								 We could not find the page you were looking for.
								<a href="?pg=admin">Click here to go back;</a>.
							</p>
						</div><!-- /.error-content -->
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	
		
	</section>
</div>
</div>

<?php require_once('views/footer.php');?>
