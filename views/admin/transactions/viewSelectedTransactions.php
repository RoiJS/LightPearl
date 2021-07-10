<?php require_once('views/header.php');?>

<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>View Transactions<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container" style="margin-right:20px;">
		<legend>Transactions Summary</legend>
		<div class="row">
		<?php if(isset($_SESSION["TransactionsSelected"])){ ?>
				<div class="span14">
				<?php 
					foreach($_SESSION["TransactionsSelected"] as $transaction){
						$getLatestTransaction = query("SELECT * FROM tbl_transactions","WHERE id = :id",[":id" => $transaction],"variable",1); 
							
						$getTransactionDetails = query('SELECT * FROM tbl_transactionbreakdowns INNER JOIN tbl_items ON tbl_transactionbreakdowns.item_id = tbl_items.itemId','WHERE tbl_transactionbreakdowns.transaction_id = :id ORDER BY tbl_transactionbreakdowns.transactionBreakdown_id DESC',[':id' => $getLatestTransaction['row']['transaction_id']],'variable');
						
							echo '
							<div class="well well-small well-shadow" >
							<div class="row" >
							<div class="span16">
								<div >
									<div class="row">
										<div class="span14">
											<table class="transaction" >
												<!--Invoice header-->
												<tr>
													<td>
														<table cellspacing=0 class="transaction-header">';
														if($getLatestTransaction["row"]["customer_id"] != 0){
															echo '<tr >
																<td >
																	<b>Customer:</b> ';
																	$customer = query("SELECT name FROM tbl_customers","WHERE customer_id = :id",[":id" => $getLatestTransaction["row"]["customer_id"]],"variable",1);
																	
																	if(!empty($customer)) echo $customer["row"]["name"];
																echo'</td>
															</tr>';
														}
														
														echo'<tr >
																<td >
																	<b>Date:</b> '; echo date('m-d-Y',strtotime($getLatestTransaction['row']['dateTime']));
																echo'</td>
															</tr>';
														
														if($getLatestTransaction['row']['purchaseOrderNo'] != ""){
															echo'<tr >
																<td >
																	<b>Date:</b> '; echo date('m-d-Y',strtotime($getLatestTransaction['row']['purchaseOrderNo']));
																echo'</td>
															</tr>';
														}
														echo'</table>		
													</td>
												</tr>
												
												<!--Invoice body-->
												<tr >
													<td>
														<div class="row">
															<div class="span12">
																<table cellspacing=0 class="transaction-body" border=3>
																	<tr >
																		<th >Qty</th>
																		<th >Unit</th>
																		<th >Item Description</th>
																		<th >Unit Price</th>
																		<th >Amount</th>
																	</tr>';
																	 foreach($getTransactionDetails as $transaction):
																	echo'<tr >
																		<td style="text-align:center;width:70px">'; echo $transaction['row']['noOfItem']; echo'</td>
																		<td style="text-align:center;width:90px">'; echo $transaction['row']['unit']; echo'</td>
																		<td style="padding-left:5px;">'; echo $transaction['row']['description']; echo'</td>
																		<td style="text-align:center;">'; echo number_format($transaction['row']['itemPrice'],2,'.',','); echo'</td>
																		<td style="text-align:center;padding-right:10px;">'; echo number_format($transaction['row']['amount'],2,'.',','); echo'</td>
																	</tr>';
																	 endforeach;
																echo'</table>	
															</div>
														</div>
													</td>
												</tr>	
												
												<!--Invoice footer-->
												<tr>
													<td>
														<table cellspacing=0  class="transaction-footer">
															<tr >
																<td > <b>Vatable:</b> Php '; echo number_format($getLatestTransaction['row']['totalVATable'],2,'.',','); echo'</td>
															</tr>
															
															<tr >
																<td style="padding-top:18px;"><b>Vat:</b> Php '; echo number_format($getLatestTransaction['row']['totalVAT'],2,'.',','); echo'</td>
															</tr>
															<tr >
																<td><b>Total Amount Due:</b> Php '; echo number_format($getLatestTransaction['row']['discountedAmount'],2,'.',','); echo'</td>
															</tr>
															<tr>
																<td ><b>Change:</b> Php '; echo number_format($getLatestTransaction['row']['amountChange'],2,'.',','); echo'</td>
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
						<br><hr>
						<div class="row">
							<div class="span13">
								<button class="btn btn-primary btn-print-as-invoice" id="'.$getLatestTransaction['row']['id'].'" style="float:right;margin-right:10px;" type="button">Print as Invoice</button>
								<button class="btn btn-success btn-print-as-delivery-report" id="'.$getLatestTransaction['row']['id'].'" style="float:right;margin-right:10px;" type="button">Print as Delivery Report</button>
							</div>
						</div>
					</div>';
					}?>
				</div>
		<?php }else{?>
			<div class="span8">
				<h4>No transactions has been selected&hellip;</h4>
			</div>
		<?php }?>
		</div>
	</section>
</div>
<script src="public/js/admin/transactions/viewSelectedTransactions.js" type="text/javascript"></script>

<?php require_once('views/footer.php');?>
