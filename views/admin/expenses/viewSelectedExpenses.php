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
                        <h3>View Expenses<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container" style="margin-right:20px;">
		<legend>Expenses Summary</legend>
		<div class="row">
		<?php if(isset($_SESSION["ExpensesSelected"])){ ?>
				<div class="span14">
				<?php 
					
					foreach($_SESSION["ExpensesSelected"] as $transaction){
						$getLatestTransaction = query("SELECT * FROM tbl_expenses","WHERE expenseID = :id",[":id" => $transaction],"variable",1); 
							
						$getTransactionDetails = query('SELECT * FROM tbl_expenses_breakdowns a, tbl_items b, tbl_units c','WHERE a.item_id = b.itemId AND b.unit_id = c.unit_id AND a.expenseID = :id ORDER BY a.expenses_breakdownID DESC',[':id' => $getLatestTransaction['row']['expenseID']],'variable');
						
							echo '
							<div class="well well-small well-shadow mainform" >
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
																<td >
																	<b>Date:</b> '; echo date('M d, Y',strtotime($getLatestTransaction['row']['dateTime']));
																echo'</td>
															</tr>
														</table>		
													</td>
												</tr>
												
												<!--Invoice body-->
												<tr >
													<td>
														<div class="row" style="margin-left: 4px;">
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
																<td><b>Total Amount Due:</b> Php '; echo number_format($getLatestTransaction['row']['totalAmount'],2,'.',','); echo'</td>
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
								</div>
								<hr>';
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
