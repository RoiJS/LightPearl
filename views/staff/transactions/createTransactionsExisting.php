
<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<input type="hidden" value="tbl_items" class="tblname"/>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Create Transaction (Existing)<br/>
                            <small>Eiblin Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	
	<section class="page container">
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
										<?php $customers = query('SELECT DISTINCT(customer) FROM tbl_transactions WHERE customer != "" ORDER BY customer DESC','','','variable');?>
											<div class="row">
												<div class="span6">
													<form class="select-customer">
														<div class="row">
															<div class="span4">
																<select class="customer-name required" id="customer-name" style="margin-left: -90px;width:400px;" placeholder="Enter customer name&hellip;">
																	<option value=""></option>
																	<?php foreach($customers as $customer):?>
																		<option value="<?php echo $customer['row']['customer']; ?>" ><?php echo $customer['row']['customer'];?></option>
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
										<button class="btn btn-warning btn-select-other-customer">Select other customer</button>
										
									</div>
									
								</div>
							</div>	
						</div>
					</div>
					
					<div class="span10">
						<div class="well well-small well-shadow mainform"> 
								<legend>Create Transaction</legend>
								<div class="row" style="margin-left:auto;margin-right:auto;">
									<div class="span6" style="margin-right:-12px;">
										<form class="item-select">
											<select class="select-items span6" placeholder="Enter item description&hellip;">
												<option></option>
												<?php $itemList = query('SELECT * FROM tbl_items ORDER BY itemId DESC','','','variable');?>
												<?php foreach($itemList as $item):?>
													<?php $itemUnit = query('SELECT unit FROM tbl_units','WHERE unit_id = :id',[':id' => $item['row']['unit_id']],'variable',1);?>
													<option value="<?php echo $item['row']['itemId'];?>"><?php echo $item['row']['description'];?> <?php echo !empty($itemUnit) ? "(" .$itemUnit['row']['unit'].")" : ''; ?></option>
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
			<div class="span6">
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
											<div class="span3">
												<div class="row">
													<div class="span3" style="margin-bottom:18px;">
														<b>Purchase Order No.</b>
													</div>
													<div class="span3">
														<input type="text" class="purchase-order-no span2"  id="purchase-order-no" placeholder="Enter purchase order no&hellip;"/>
													</div>
												</div>
											</div>
											<div class="span3">
												<div class="row">
													<div class="span3">
														<b>Date</b>
													</div>
													<div class="span2">
														<div id="datepicker" class="input-prepend date" style="margin-top:20px;">
															<span class="add-on"><i class="icon-th"></i></span>
															<input style="width:100px;" class="transaction-date" type="text" value="<?php echo date('m/d/Y');?>" readonly="true" />
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
											<h3>Amount Due:</h3> <h2>Php <span class="amountDue">0.00</span></h2>
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
	</section>
</div>
</div>
<script src="public/js/admin/transactions/createTransactionExisting.js" type="text/javascript" ></script>
<?php require_once('views/footer.php');?>
