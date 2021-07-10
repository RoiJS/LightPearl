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
                            <small>Eiblin Enterprises</small>
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
						<div class="box well well-small well-shadow mainform">
							<div class="row">
								<div style="text-align:center;float:left;width:50%;padding-left:40px;">
									<i class="fa fa-money fa-5x"></i>
									<p>Paid<br> Transactions</p>
								</div>
								<div>
									<?php $totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND remarks = :remarks AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 1,':id' => parseSession($_SESSION['account_id'])],'rows');?>
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
									<?php $totalPendingTransactions = query('SELECT * FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND remarks = :remarks AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 0,':id' => parseSession($_SESSION['account_id'])],'rows');?>
									<h3 style="font-size:55px;margin-top:50px;float:left;"><?php echo $totalPendingTransactions;?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="span4">
						<?php $expectedCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as expectedCash FROM tbl_transactions','WHERE dateTime LIKE :dateTime AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':id' => parseSession($_SESSION['account_id'])],'variable',1);?>
						<h5>Expected cash received: </h5>Php <span class="expectedCash"><?php if(!empty($expectedCash['row']['expectedCash'])){echo $expectedCash['row']['expectedCash'];}else{echo '0.00';}?></span>
						<?php $totalCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as totalCash FROM tbl_transactions','WHERE  dateTime LIKE :dateTime AND remarks = :remarks AND account_id = :id',[':dateTime' => '%'.date('Y-m-d').'%', ':remarks' => 1, ':id' => parseSession($_SESSION['account_id'])],'variable',1);?>
						<h4>Total Amount Received: </h4> Php <span class="totalCash"><?php if(!empty($totalCash['row']['totalCash'])){echo $totalCash['row']['totalCash'];}else{ echo '0.00';}?></span>
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
