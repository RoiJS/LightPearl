<?php require_once('views/header.php');?>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Dashboard<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
    <section class="page container">
		<legend>Transactions</legend>
		<div class="row">
			<div class="blockoff-right">
				<div class="row">
					<div class="span span5">
						<div class="box well well-small well-shadow mainform">
							<div class="row">
								<div style="text-align:center;float:left;width:50%;padding-left:40px;">
									<i class="fa fa-edit fa-5x"></i>
									<p>Transactions you served today</p>
								</div>
								<div>
									<?php $totalTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':id' => parseSession($_SESSION['account_id'])],'rows');?>
									<h3 style="font-size:55px;margin-top:50px;float:left;"><?php echo $totalTransactions;?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="span5">
						<div class="box well well-small well-shadow mainform" >
							<div class="row">
								<div style="text-align:center;float:left;width:50%;padding-left:40px;">
									<i class="fa fa-money fa-5x"></i>
									<p>Paid<br> Transactions</p>
								</div>
								<div>
									<?php $totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE DATE_FORMAT(transactionDate, "%Y-%m-%d") = :transactionDate AND remarks = :remarks AND account_id = :id',[':transactionDate' => date('Y-m-d'), ':remarks' => 1,':id' => parseSession($_SESSION['account_id'])],'rows');?>
									<h3 style="font-size:55px;margin-top:50px;float:left;"><?php echo $totalPaidTransactions?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="span5">
						<div class="box well well-small well-shadow mainform">
							<div class="row">
								<div style="text-align:center;float:left;width:50%;padding-left:40px;">
									<i class="fa fa-clock-o fa-5x"></i>
									<p>Pending <br>Transactions</p>
								</div>
								<div>
									<?php $totalPendingTransactions = query('SELECT * FROM tbl_transactions','WHERE DATE_FORMAT(transactionDate, "%Y-%m-%d") = :transactionDate AND remarks = :remarks AND account_id = :id',[':transactionDate' => date('Y-m-d'), ':remarks' => 0,':id' => parseSession($_SESSION['account_id'])],'rows');?>
									<h3 style="font-size:55px;margin-top:50px;float:left;"><?php echo $totalPendingTransactions;?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div hidden class="row">
					<div class="span4">
						<?php //$expectedCash = getOverAllExpectedAmountForTheCurrentDate();?>
						<h5>Expected cash received: </h5>Php <span class="expectedCash"><?php //echo number_format($expectedCash,2,".",",");?></span>
						<?php //$totalCash = getOverAllActualAmountForTheCurrentDate();?>
						<h4>Total Amount Received: </h4> Php <span class="totalCash"><?php //echo number_format($totalCash,2,".",",");?></span>
					</div>
				</div>
			</div>
			
		</div>
		
		
		<div class="row" hidden>
			<div class="blockoff-right">
				<div class="row">
					<div class="span4">
						<div class="box well well-small well-shadow mainform">
							<div class="row">
								<div style="text-align:center;float:left;width:50%;padding-left:40px;">
									<i class="fa fa-edit fa-5x"></i>
									<p>Transactions as of today</p>
								</div>
								<div>
									<?php $totalTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime',[':dateTime' => '%'.date('Y-m-d').'%'],'rows');?>
									<h3 style="font-size:55px;margin-top:50px;float:left;"><?php echo $totalTransactions;?></h3>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="span2">
								<div class="box well well-small well-shadow mainform" >
									<div class="row">
										<div  style="float:left;width:50%;padding-left:40px;">
											<p style="margin-top:-10px;">Paid</p>
											<?php $totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND remarks = :remarks',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 1],'rows');?>
											<h3 style="font-size:30px;margin-top:-15px;"><?php echo $totalPaidTransactions;?></h3>
										</div>
									</div>
								</div>
							</div>
							<div class="span2">
								<div class="box well well-small well-shadow mainform">
									<div class="row">
										<div style=";float:left;width:50%;padding-left:40px;">
											<p style="margin-top:-10px;">Pending</p>
											<?php $totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND  remarks = :remarks',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 0],'rows');?>
											<h3 style="font-size:30px;margin-top:-15px;"><?php echo $totalPendingTransactions; ?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="span9">
						<div class="panel panel-default" >
							<div class="panel-title">
								<center><p><b>Transactions made by staffs</b></center>
							</div>
						   <div class="panel-body">
								<div class="table-responsive" style="overflow-x:auto;">
									<table class="table table-hover table-striped">
									   <thead>
											<tr>
												<th>Staff Name</th>
												<th>No of Transactions (Paid,Pending)</th>
												<th>Amount (Php)</th>
											</tr>
										</thead>
										<tbody>
											<?php $accounts = query('SELECT * FROM tbl_accounts','WHERE accountStatus = :status ORDER BY account_id DESC',[':status' => 1],'variable');?>
											<?php foreach($accounts as $account):?>
												<tr>
													<td><?php echo $account['row']['accountName']?></td>
													<td>
														<?php $totalTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':id' => $account['row']['account_id']],'rows');?>
														<?php $totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND remarks = :remarks AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 1,':id' => $account['row']['account_id']],'rows');?>
														<?php $totalPendingTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND remarks = :remarks AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 0,':id' => $account['row']['account_id']],'rows');?>
														
														<?php echo $totalTransactions; ?> ( <?php echo $totalPaidTransactions; ?>,  <?php echo $totalPendingTransactions; ?>)
													</td>
													<td>
														<?php $totalCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as totalCash FROM tbl_transactions','WHERE  dateTime LIKE :dateTime AND remarks = :remarks AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 1, ':id' => $account['row']['account_id']],'variable',1);?>
														<?php if(!empty($totalCash['row']['totalCash'])){echo $totalCash['row']['totalCash'];}else{ echo '0.00';}?>
													</td>
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
					<div class="span4">
						<?php $expectedCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as expectedCash FROM tbl_transactions','WHERE dateTime LIKE :dateTime',[':dateTime' => '%'.date('Y-m-d').'%'],'variable',1);?>
						<h5>Expected cash received: </h5>Php <span class="expectedCash"><?php if(!empty($expectedCash['row']['expectedCash'])){echo $expectedCash['row']['expectedCash'];}else{echo '0.00';}?></span>
						<?php $totalCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as totalCash FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND remarks = :remarks',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 1],'variable',1);?>
						<h4>Total Amount Received: </h4> Php <span class="totalCash"><?php if(!empty($totalCash['row']['totalCash'])){echo $totalCash['row']['totalCash'];}else{ echo '0.00';}?></span>
					</div>
				</div>
			</div>
		</div>
		
		<br>
		<br>
		<legend>Supplies</legend>
		<div class="row">
			<div class="blockoff-right">
				<div class="row">
					<div class="span5">
						<div class="box well well-small well-shadow mainform">
							<div class="row">
								<div style="text-align:center;float:left;width:50%;padding-left:40px;padding-top:20px;">
									<i class="fa fa-shopping-cart fa-5x"></i>
									<p>Items need to augment</p>
								</div>
								<div>
									<?php $stocks = query('SELECT * FROM tbl_items','WHERE stocks <= :stocks',[':stocks' => 20],'rows');?>
									<h3 style="font-size:50px;margin-top:50px;float:left;"><?php echo number_format($stocks,0,"",",");?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="span9">
						<div class="panel panel-default">
							<?php $items = query('SELECT * FROM tbl_items','WHERE stocks <= :stocks',[':stocks' => 20],'variable');?>
							<?php $size = count($items);?>
							<?php if($size > 6){
									$new_items = array_slice($items,0 ,5);
								}else{
									$new_items = $items;
								}
							?>
							<?php if(!empty($items)){?>
								<div class="panel-body">
									<div class="table-responsive" style="overflow-x:auto;">
										<table class="table table-striped">
										   <thead>	
												<tr>
													<th>Code</th>
													<th>Item Description</th>
													<th>No of items</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($new_items as $item):?>
												<tr>
													<td><?php echo $item['row']['itemCode'];?></td>
													<td><?php echo $item['row']['description'];?></td>
													<td><?php echo $item['row']['stocks'];?></td>
												</tr>
												<?php endforeach;?>
												
											</tbody>
										</table>
										<div>
											<b><?php echo ($size - 6);?></b> other items. 
											<a href="?pg=admin&vw=supplies&dir=<?php echo sha1("supplies");?>&main=item_list">Click here to see more&hellip;</a>
										</div>
									</div>
								</div>
							<?php }else{?>
								<div class="alert alert-block alert-info" style="margin-top:35px;">
									<p>All items are in good stocks.</p>
								</div>
							<?php }?>
						</div>
					</div>	
				</div>
			</div>
		</div>
    </section>
    </div>
</div>

<div id="spinner" class="spinner" style="display:;">
    Loading&hellip;
</div>

<?php require_once('views/footer.php');?>
