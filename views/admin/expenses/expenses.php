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
                        <h3>Expenses Information<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container">
		<div class="row" hidden>
			<div class="span16">
				<div class="nav-tabs-custom">
					<ul class="nav nav-pills">
						<li class="<?php if($_GET["mainsub"] == "create_expenses"){echo "active";}?>"><a href="?pg=admin&vw=expenses&dir=<?php echo sha1("expenses");?>&mainsub=create_expenses" >Create Expenses</a></li>
						<li class="<?php if($_GET["mainsub"] == "view_expenses"){echo "active";}?>"><a href="?pg=admin&vw=expenses&dir=<?php echo sha1("expenses");?>&mainsub=view_expenses" >View Expenses</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span16">
				<div class="tab-content" style="overflow-x:hidden;">
					<?php if($_GET["mainsub"] == "create_expenses"){?>
						<div class="tab-pane fade in active" id="walk-in-transaction">
							<legend>Expenses Summary</legend>
							<div class="row" style="width:1300px;">
								<div class="blockoff-right" style="margin-left:50px;">
									<div class="row" >
										<div class="span4">
											<div class="row">
												<div class="span4">
													<button style="width:100%;" class="btn btn-primary btn-add-expense">Add Expense <i class="fa fa-plus"></i></button>
												</div>
											</div>
											<hr>
											<div class="row" >
												<div class="span5 view-start-end-date" hidden > 
													<h6 class="view-no-of-selected-items">
													Start Date: <span style="color:red;" class="startDate"></span></h6>
													 <h6>End Date: <span style="color:red;" class="endDate"></span></h6>
												</div>
												<div class="span4">
													<div class="box well well-small well-shadow mainform">
														<div class="row">
															<div style="text-align:center;float:left;width:50%;padding-left:40px;">
																<i class="fa fa-edit fa-5x"></i>
																<p>Total Expenses</p>
															</div>
															<div>
																<h3 style="font-size:50px;margin-top:50px;float:left;">
																	<?php $totalTransactions = query('SELECT * FROM tbl_expenses','','','rows');?>
																	<span class="totalNoExpenses">0</span>
																</h3>
															</div>
														</div>
													</div>
												</div>
												<div class="span4">
													<div class="row">
														<div class="span4">
															<?php $amount = query("SELECT SUM(amount) AS 'overallAmount' FROM tbl_expenses","","","variable",1);?>
															<h4>Over all expenses amount: </h4> <h4 style="color:red;">Php <span class="totalExpenses">0.00</span></h4>
														</div>
													</div>	
												</div>
											</div>
										</div>
									
										<div class="span12" style="overflow-x:hidden;">
											<div class="box box-solid">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="walk-in-transaction">
														<div class="row">
															<div class="span12" style="width:96%;">
																<div class="box mainform" style="padding:10px;">
																	<legend>List of Expenses</legend>
																	
																	<div class="box-content">
																		<div class="row">
																			<div class="span7"></div>
																			<div class="span2" >
																				<div class="row">
																					<div class="span2" > 
																						<div class="dropdown" style="float:right;">
																							<button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																							
																							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																								<li role="presentation" class=" option-select-single-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-refresh-expenses-list"><i class="fa fa-refresh"></i> Refresh List</a>
																								</li>
																								<li role="presentation" class="divider"></li>
																								<li role="presentation" class="disabled option-select-single-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-select-single-walk-in-transaction"><i class="fa fa-plus-circle"></i> Select single</a>
																								</li>
																								<li role="presentation" class="option-select-several-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-select-several-walk-in-transaction"><i class="fa fa-plus-circle"></i> Select several</a>
																								</li>
																								<li role="presentation" class="option-select-all-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-select-all-walk-in-transaction"><i class="fa fa-bars"></i> Select All Expenses</a>
																								</li>
																								<li role="presentation" class="disabled option-deselect-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-deselect-walk-in-transaction"> <i class="fa fa-remove"></i> Deselect Expenses</a>
																								</li>
																								<li role="presentation" class="divider"></li>
																								<li role="presentation" class="option-sort-by-date-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-sort-by-date-walk-in-transaction"><i class="fa fa-calendar"></i> Sort by date</a>
																								</li>
																								<li role="presentation" class="option-sort-most-previous-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-sort-most-previous-walk-in-transaction"><i class="fa fa-sort-up"></i> Sort by most previous expenses</a>
																								</li>
																								<li role="presentation" class="disabled option-sort-most-recent-walk-in-transaction">
																									<a role="menuitem" tabindex="-1" class="menu-sort-most-recent-walk-in-transaction"><i class="fa fa-sort-down"></i> Sort by most recent expenses</a>
																								</li>
																							</ul>
																						</div>
																					</div>
																				</div>
																			</div>
																		
																			<div class="span9">
																				<div class="tab-content">
																					<div class="tab-pane fade in active" id="walk-in-transaction-list">
																						<div class="row">
																							<div class="span9" style="width:95%;">
																								<div class="table-responsive">
																									<table class="table table-hover table-striped table-expenses-list">
																										<thead>
																											<tr>
																												<th style="width:300px;text-align:center;">Date</th>
																												<th style="width:300px;text-align:center;">Description</th>
																												<th style="width:300px;text-align:center;">Amount (Php)</th>
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
																					<button class="btn btn-edit-walk-in-transactions disabled" style="height:70px;"> Edit Expenses</button>	
																				</div>
																				<div class="span2" style="margin-top:20px;">
																					<button class="btn btn-remove-walk-in-transactions disabled" style="height:70px;">Remove Expenses</button>
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
							<script src="public/js/admin/expenses/viewExpenses.js" type="text/javascript"></script>
							<script src="public/js/admin/expenses/createExpenses.js" type="text/javascript"></script>
						</div>
	
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
	</section>
</div>
</div>

<?php require_once('views/footer.php');?>
