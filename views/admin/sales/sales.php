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
                        <h3>Sales Information<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container">
		<legend>Sales Summary</legend>
		<div class="row">
			<div class="blockoff-right">
				<div class="row">
					<div class="span4">
						<div class="row">
							<div class="span5 view-start-end-date" > 
								<h6 class="view-no-of-selected-items">
								Start Date: <span style="color:red;" class="startDate"></span></h6>
								 <h6>End Date: <span style="color:red;" class="endDate"></span></h6>
							</div>
							<div class="span4">
								<div class="box well well-small well-shadow mainform">
									<div class="row">
										<div style="text-align:center;float:left;width:50%;padding-left:40px;">
											<i class="fa fa-calendar fa-5x"></i>
											<p>Number of days</p>
										</div>
										<div>
											<h3 style="font-size:50px;margin-top:50px;float:left;">
												<span class="noOfDays"></span>
											</h3>
										</div>
									</div>
								</div>
							</div>
							<div class="span4">
								<div class="row">
									<div class="span4">
										<?php $totalSalesAmount = (getOverAllActualAmount() - getOverAllExpenses()); ?>
										<h4>Total sales amount: </h4> <h4><span style="color:red;">Php <span class="totalSales"><?php echo number_format($totalSalesAmount,2,".",","); ?></span></span></h4>
									</div>
								</div>	
							</div>
						</div>
					</div>
					
					<div class="span12" style="overflow-x:hidden;">
						<div class="box box-solid">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="existing-transaction">
									<div class="row">
										<div class="span12" style="width:96%;">
											<div class="box mainform" style="padding:10px;">
												<legend>Sales Information</legend>
												<div class="box-content">
													<div class="row"> 
														<div class="span12">
															<div class="row">
																<div class="span7"></div>
																<div class="span2" >
																	<div class="row">
																		<div class="span2" > 
																			<div class="dropdown" style="float:right;">
																				<button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																						
																				<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
																					<li role="presentation" class=" option-select-single-walk-in-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-refresh-expenses-list"><i class="fa fa-refresh"></i> Refresh List</a>
																					</li>
																					<li role="presentation" class="divider"></li>
																					<li role="presentation" class=" option-sort-by-date-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-sort-by-date-existing-transaction"><i class="fa fa-calendar"></i> Sort by date</a>
																					</li>
																					<li role="presentation" class="option-sort-most-previous-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-sort-most-previous-existing-transaction"> <i class="fa fa-sort-up"></i> Sort by most previous sales</a>
																					</li>
																					<li role="presentation" class="disabled option-sort-most-recent-existing-transaction">
																						<a role="menuitem" tabindex="-1" class="menu-sort-most-recent-existing-transaction"><i class="fa fa-sort-down"></i> Sort by most recent sales</a>
																					</li>
																				</ul>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="span11">
															<div class="nav-tabs-custom" >
																<ul class="nav nav-pills">
																	<li class="active"><a href="#existing-transaction-list" data-toggle="tab">Sales List</a></li>
																	<li ><a href="#existing-transaction-sale-status" data-toggle="tab">Sales Graph</a></li>
																</ul>
															</div>
														</div>
														<div class="span11">
															<div class="tab-content">
																<div class="tab-pane fade in active" id="existing-transaction-list">
																	<div class="row">
																		<div class="span9" style="width:95%;">
																			<div class="table-responsive" >
																				<table class="table table-sales-list">
																					<thead>
																						<tr>
																							<th style="width:400px;text-align:center;">Date</th>
																							<th style="width:400px;text-align:center;">Amount</th>
																						</tr>
																					</thead>
																					<tbody class="displayAllSalesTransactions">
																						<!--Display All Transactions-->
																					</tbody>
																				</table>
																			</div>
																			
																		</div>
																	</div>
																</div>
																
																<div class="tab-pane fade in" id="existing-transaction-sale-status">
																	<div class="row">
																		<div class="span11">
																			<div class="row">
																				<div class="span11">
																					<h4 align="center"><span class="sales-date"></span></h4>
																					<h5 align="center">(Last 10 days)</h5>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="span11">
																					<div class="span9" style="width:96%;height:500px;">
																						<div id="sales-chart-container" style="width:100%;height:auto;">
																							<canvas id="sales-chart"></canvas>
																						</div>
																					</div>		
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
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
<script src="public/js/admin/sales/viewSales.js" type="text/javascript"></script>
<?php require_once('views/footer.php');?>
