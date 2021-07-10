<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<input type="hidden" value="tbl_suppliers" class="tblname"/>
<input type="hidden" value="<?php echo isset($_GET["p_d"]) ? $_GET["p_d"] : ""; ?>" class="date_from"/>
<input type="hidden" value="<?php echo isset($_GET["r_d"]) ? $_GET["r_d"] : ""; ?>" class="date_to"/>

<?php unset($_SESSION["itemsId"]);?>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Supplies Information<br/>
                             <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options" hidden>
                    <div class="span9">
                        <ul class="nav nav-pills">
							<li class="btn-manage-unit">
                                <a >Manage units</i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container" >
			<?php $itemsCount = query("SELECT * FROM tbl_items","","","rows");?>
			<?php $itemsCrucialStocksCount = query("SELECT * FROM tbl_items WHERE stocks <= 20","","","rows");?>
			<div class="row" >
					<div class="span3">
						<div class="row" >
							<div class="span3">
								<div class="box well well-small well-shadow mainform">
									<div class="row" style="margin-left: 0;">
										<div style="text-align:center;">
											<h3 style="font-size:30px;">
												<span class="totalTransactions"><i class="fa fa-shopping-cart fa-2x"></i> <?php echo number_format($itemsCount,0,".",",");?></span>
											</h3>
											<p style="margin-top: -20px;"><b>Total no. of Items</b></p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="span3">
								<div class="box well well-small well-shadow mainform" >
									<div class="row">
										<div style="float:center;width:70%;padding-left:40px;text-align:center;">
											<p style="margin-top:-10px;"><b>Items in crucial stocks</b></p>
											<p style="margin-top:-10px;font-size:20px;color:red;"><?php echo number_format($itemsCrucialStocksCount,0,".",",");?></p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="span3">
								<div class="box well well-small well-shadow mainform" >
									<div class="row">
										<div style="float:center;width:70%;padding-left:40px;text-align:center;">
											<p style="margin-top:-10px;"><b>Total capital</b></p>
											<p class="display-capital" style="margin-top:-8px;font-size:15px;color:red;"><?php echo "Php ".number_format(getTotalCapital(),2,".",",");?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
						
					<div class="span13">	
						<div class="row"> 
							<div class="span13" >
								<div class="nav-tabs-custom" >
									<ul class="nav nav-pills">
										<li class="<?php if($_GET["main"] == "item_list"){echo "active";}?>"><a href="?pg=admin&vw=supplies&dir=<?php echo sha1('supplies');?>&main=item_list">Item List</a></li>
										<li class="<?php if($_GET["main"] == "items_per_customer"){echo "active";}?>"><a href="?pg=admin&vw=supplies&dir=<?php echo sha1('supplies');?>&main=items_per_customer">Items per customer</a></li>
										<li class="<?php if($_GET["main"] == "inventory_status"){echo "active";}?>"><a href="?pg=admin&vw=supplies&dir=<?php echo sha1('supplies');?>&main=inventory_status">Inventory Status</a></li>
									</ul>
								</div>
							</div>
							<div class="span13">
								<div class="">
									<div class="tab-content">
										<?php if($_GET["main"] == "item_list"){?>
											<div class="tab-pane fade in active" id="all-items">
												<div class="row" >
													<div class="span12">
														<div class="row">
															<div class="span5">
																<h6>Search by item description, supplier, code or area:</h6>
															</div>
															<div class="span9">
																<form class="frm-search-for-all-item">
																	<span >
																		<input type="text" class="span7 txt-all-items-search-engine" placeholder="Enter item description, supplier, code or area&hellip;" id="search-items" />
																	</span>
																	<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
																	<button class="btn btn-warning btn-refresh-all-items" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
																</form>
															</div>
														</div>
													</div> 	
												</div>
												
												<div class="row">
													<div class="span6">
														<input type="radio" class="radio-view-all-items" checked> <b>All items</b> <span class="badge"><?php echo $itemsCount; ?></span>
														<input type="radio" class="radio-view-items-with-crucial-stocks" style="margin-left:30px;"> <b>Items in crucial stocks</b> </b> <span class="badge"><?php echo $itemsCrucialStocksCount; ?></span>
													</div>
													
													<div class="span4">
														<div class="dropdown" style="float:right;">
															<button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																						
															<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																<li role="presentation" class="disabled option-select-single-item">
																	<a role="menuitem" tabindex="-1" class="menu-select-single-item"><i class="fa fa-plus-circle"></i> Select single item</a>
																</li>
																<li role="presentation" class="option-select-several-items">
																	<a role="menuitem" tabindex="-1" class="menu-select-several-items"><i class="fa fa-plus-circle"></i> Select several items</a>
																</li>
																<li role="presentation" class="option-select-all-items">
																	<a role="menuitem" tabindex="-1" class="menu-select-all-items"><i class="fa fa-bars"></i> Select All Items</a>
																</li>
																<li role="presentation" class="disabled option-deselect-all-items">
																	<a role="menuitem" tabindex="-1" class="menu-deselect-all-items"><i class="fa fa-remove"></i> Deselect Items</a>
																</li>
																<li role="presentation" class="divider"></li>
																<li role="presentation" class="disabled option-sort-item-a-to-z">
																	<a role="menuitem" tabindex="-1" class="menu-sort-item-a-to-z"><i class="fa fa-sort-desc "></i> Sort A to Z</a>
																</li>
																<li role="presentation" class=" option-sort-item-z-to-a">
																	<a role="menuitem" tabindex="-1" class="menu-sort-item-z-to-a"><i class="fa fa-sort-asc "></i> Sort Z to A</a>
																</li>
															</ul>
														</div>		
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="span10">
														<div class="row">
															<div class="span5" > 
																<h6 style="display:none;" class="view-no-of-selected-items">No. of selected items: <span style="color:red;" class="no-of-selected-items">0</span></h6>
															</div>
															<div class="span5"> 
																<h6 style="display:none;float:right;" class="view-no-of-selected-searched">No. of search items: <span style="color:red;" class="no-of-search-items">0</span></h6>
															</div>
														</div>
													</div>
													<div class="span10">
														<div class="box mainform" style="overflow-x:auto;width:710px;">
															<div class="box-content">
																<table class="table table-hover table-item-list">
																	<thead>
																		<tr>
																			<th style="width:300px;text-align:center;">Unit</th>	
																			<th style="width:300px;text-align:center;">Code</th>
																			<th style="width:300px;text-align:center;">Description</th>
																			<th style="width:300px;text-align:center;">Original Price</th>
																			<th style="width:300px;text-align:center;">SRP (Php)</th>
																			<th style="width:300px;text-align:center;">Supplier</th>
																			<th style="width:300px;text-align:center;">Stock</th>
																			<th style="width:300px;text-align:center;">Area</th>
																		</tr>
																	</thead>
																	<tbody class="displayAllItems" style="width:1000px;">
																		<!--Display item list-->
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div class="span2">
														<div class="row">
															<div class="span2">
																<button class="span2 btn btn-add-items" style="height:70px;"> Add Items <br> <span style="font-size:12px;font-weight:bold;">(F9)</span></button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="span2 btn btn-update-items disabled" style="height:70px;"> Update Items <br> <span style="font-size:12px;font-weight:bold;">(F10)</span></button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="span2 btn btn-remove-items disabled" style="height:70px;">Remove Items <br> <span style="font-size:12px;font-weight:bold;">(F11)</span></button>
															</div>
															<div hidden class="span2" style="margin-top:20px;">
																<button class="span2 btn btn-export-items" style="height:70px;">Export Items</button>
															</div>
														</div>
													</div>
												</div>		
												<script src="public/js/admin/supplies/supplies.js" type="text/javascript" ></script>
											</div>
										<?php }else if($_GET["main"] == "inventory_status"){?>
											<div class="tab-pane fade in active" id="inventory-status">
												<div class="row search-option-items-per-customer" >
													<div class="span6">
														<div class="row">
															<div class="span4">
																<h6>Search by item description:</h6>
															</div>
															<div class="span6">
																<form class="frm-search-item">
																	<span >
																		<input type="hidden" value="<?php echo isset($_GET["name"]) ? $_GET["name"] : "" ?>" class="previous-name">
																		<input type="text" class="item_name span4 txt-items-per-customer-search-engine" placeholder="Enter item description&hellip;" name="name" value="<?php echo isset($_GET["name"]) ? $_GET["name"] : "" ?>"/>
																	</span>
																	<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
																	<a href="?pg=admin&vw=supplies&dir=<?php echo sha1("supplies");?>&main=inventory_status" class="btn btn-warning btn-refresh-items-per-customer" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></a>
																</form>
															</div>
														</div>
													</div> 
													
													<div class="span6">
														<div class="row">
															<div class="span6">
																<h6>.</h6>
															</div>
															<div class="span6">
																<div class="dropdown" >
																	<button type="button" class="btn dropdown-toggle  dropdown-toggle-items-per-customer" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																								
																	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																		<li role="presentation" class=" option-sort-items-per-customer-a-to-z">
																			<a role="menuitem" class="menu-sort-items-by-date"><i class="fa fa-calendar"></i> Sort by date</a>
																		</li>
																		<li role="presentation" class="<?php if($_GET["order"] == "description-asc" || !isset($_GET["order"])){echo "disabled";}?>  option-sort-items-per-customer-a-to-z">
																			<a href="?pg=admin&vw=supplies&dir=<?php echo sha1("supplies");?>&main=inventory_status&name=<?php echo isset($_GET["name"]) ? $_GET["name"] : "";?>&order=description-asc&p_d=<?php echo isset($_GET["p_d"]) ? $_GET["p_d"] : "";?>&r_d=<?php echo isset($_GET["r_d"]) ? $_GET["r_d"] : "";?>" tabindex="-1" class="menu-sort-items-per-customer-a-to-z"><i class="fa fa-sort-desc "></i> Sort A to Z</a>
																		</li>
																		<li role="presentation" class="<?php if($_GET["order"] == "description-desc"){echo "disabled";}?> option-sort-items-per-customer-z-to-a">
																			<a href="?pg=admin&vw=supplies&dir=<?php echo sha1("supplies");?>&main=inventory_status&name=<?php echo isset($_GET["name"]) ? $_GET["name"] : "";?>&order=description-desc&p_d=<?php echo isset($_GET["p_d"]) ? $_GET["p_d"] : "";?>&r_d=<?php echo isset($_GET["r_d"]) ? $_GET["r_d"] : "";?>" tabindex="-1" class="menu-sort-items-per-customer-z-to-a"><i class="fa fa-sort-asc "></i> Sort Z to A</a>
																		</li>
																		<li role="presentation" class="<?php if($_GET["order"] == "total-desc"){echo "disabled";}?> option-sort-items-per-customer-a-to-z">
																			<a href="?pg=admin&vw=supplies&dir=<?php echo sha1("supplies");?>&main=inventory_status&name=<?php echo isset($_GET["name"]) ? $_GET["name"] : "";?>&order=total-desc&p_d=<?php echo isset($_GET["p_d"]) ? $_GET["p_d"] : "";?>&r_d=<?php echo isset($_GET["r_d"]) ? $_GET["r_d"] : "";?>" tabindex="-1" class="menu-sort-items-per-customer-a-to-z"><i class="fa fa-sort-desc "></i> Sort by most sold items</a>
																		</li>
																		<li role="presentation" class="<?php if($_GET["order"] == "total-asc"){echo "disabled";}?> option-sort-items-per-customer-z-to-a">
																			<a href="?pg=admin&vw=supplies&dir=<?php echo sha1("supplies");?>&main=inventory_status&name=<?php echo isset($_GET["name"]) ? $_GET["name"] : "";?>&order=total-asc&p_d=<?php echo isset($_GET["p_d"]) ? $_GET["p_d"] : "";?>&r_d=<?php echo isset($_GET["r_d"]) ? $_GET["r_d"] : "";?>" tabindex="-1" class="menu-sort-items-per-customer-z-to-a"><i class="fa fa-sort-asc "></i> Sort by least sold items</a>
																		</li>
																	</ul>
																</div>	
															</div>
														</div>
													</div>
												</div>
												<div class="row" >
													<div class="span12">
														<div class="row">
														<?php
														
															$item_description = isset($_GET["name"]) ? $_GET["name"] : "";
															
															if(!isset($_GET["p_d"]) || $_GET["p_d"] == ""){
																$previous_date = (strtotime(date("Y-m-d")) - (5 * 86400));
																
															}else{
																$previous_date = strtotime(date($_GET["p_d"]));
															}
															
															if(!isset($_GET["r_d"]) || $_GET["r_d"] == ""){
																$recent_date = strtotime(date("Y-m-d"));
																
															}else{
																$recent_date = strtotime(date($_GET["r_d"]));
															}
															
															$sort_order = isset($_GET["order"]) ? explode("-", $_GET["order"]) : explode("-","description-asc");
															
															$category = $sort_order[0];
															$order = $sort_order[1];
															
															
															$one_day = 86400;
															
															$itemsPerDay = [];
															
															$query = "SELECT itemId as item_id, description FROM tbl_items";
															$preparedQuery = "";
															$actualValues = array();
															
															if($item_description != ""){
																$preparedQuery = "WHERE description LIKE :description";
																$actualValues += array(":description" => "%".$item_description."%");
															}
															
															if($category == "description"){
																if($item_description != ""){
																	$preparedQuery .= " ORDER BY ".$category." ".$order;
																}else{
																	$query .= " ORDER BY ".$category." ".$order;
																}	
															}
															
															$itemList = query($query,$preparedQuery,$actualValues,"variable");
															
															foreach($itemList as $item){
																
																$noPerDay = [];
																$total = 0;
																
																for($i = $previous_date; $i <= $recent_date; $i += $one_day){
																	$count = query("SELECT SUM(noOfItem) AS no_of_items FROM tbl_transactions a, tbl_transactionbreakdowns b ","WHERE a.transaction_id = b.transaction_id AND DATE_FORMAT(dateTime, '%Y-%m-%d') = :date AND b.item_id = :id;", [":date" => date("Y-m-d", $i), ":id" => $item["row"]["item_id"]],"variable",1);
																	
																	$no = !empty($count["row"]["no_of_items"]) ? $count["row"]["no_of_items"] : 0;
																	
																	$noPerDay[] = array("date" => date("M d, Y", $i), "count" => $no);
																	$total += $no;
																}	
																
																$itemsPerDay[] = array($item["row"]["description"], $noPerDay, $total);
															}
															
															if($category == "total"){
																
																for($i = 0; $i < count($itemsPerDay); $i++){
																	for($j = 0; $j < count($itemsPerDay); $j++){
																		if($order == "asc"){
																			if($itemsPerDay[$i][2] < $itemsPerDay[$j][2]){
																				list($itemsPerDay[$j], $itemsPerDay[$i]) = array($itemsPerDay[$i], $itemsPerDay[$j]);
																			}
																		}else if($order == "desc"){
																			if($itemsPerDay[$i][2] > $itemsPerDay[$j][2]){
																				list($itemsPerDay[$j], $itemsPerDay[$i]) = array($itemsPerDay[$i], $itemsPerDay[$j]);
																			}
																		}
																	}
																}
																
															}
														?>
															<div class="span12">
																<div class="row">
																	<div class="span5" > 
																		<h6 class="view-no-of-selected-items">
																		Start Date: <span style="color:red;" class="start-date"><?php echo date("M d, Y", $previous_date); ?></span></h6>
																		 <h6>End Date: <span style="color:red;" class="end-date"><?php echo date("M d, Y", $recent_date);  ?></span></h6>
																	</div>
																	<div class="span6" <?php if($item_description == ""){echo "hidden";}?>> 
																		<h6 style="float:right;" class="view-no-of-selected-searched">No. of search items: <span style="color:red;" class="no-of-search-items"><?php echo count($itemsPerDay); ?></span></h6>
																	</div>
																</div>
															</div>
															<div class="span12">
																<div class="box mainform" style="overflow-y:auto;height:500px;width:800px;">
																	<table border=1 class="table-inventory-list">
																		<tr>
																			<th rowspan="2" style="width:300px;">Item Name</th>
																			<?php for($i = $previous_date; $i <= $recent_date; $i += $one_day){?>
																				<th style="width:150px;"><?php echo ($i == strtotime(date("Y-m-d"))) ? "Today" : date("M d, Y", $i); ?></th>
																			<?php }?>
																			<th rowspan="2" style="width:100px;">Total</th>
																		</tr>
																		<tr>
																			<?php for($i = $previous_date; $i <= $recent_date; $i += $one_day){?>
																				<th><?php echo date("D", $i);?></th>
																			<?php }?>
																		</tr>
																		<?php for($i = 0;$i < count($itemsPerDay); $i++){?>
																		<tr>
																			<td><?php echo $itemsPerDay[$i][0];?></td>
																			<?php for($j = 0; $j < count($itemsPerDay[$i][1]); $j++){?>
																				<td align=center <?php if($itemsPerDay[$i][1][$j]["count"] > 0){echo "style='color:red;font-weight:bold;'";}?>><?php echo $itemsPerDay[$i][1][$j]["count"];?></td>
																			<?php }?>
																			<td align=center <?php if($itemsPerDay[$i][2] > 0){echo "style='color:red;font-weight:bold;'";}?>><?php echo $itemsPerDay[$i][2]; ?></td>
																		</tr>
																		<?php }?>
																	</table>
																</div>
																
															</div>
														</div>
														
													</div>
												</div>	
											</div>
											<script src="public/js/admin/supplies/inventory.js" type="text/javascript" ></script>
										<?php }else if($_GET["main"] == "items_per_customer"){?>
											
											<div class="tab-pane fade in active" id="items-per-customer">
												<div class="row" >
													<div class="span10">
														<div class="box">
															<div class="box-content">
																<legend>Select customer</legend>
																<div class="row">
																	<div class="span9 " style="width:96%;">
																		<div class="row select-existing-customer" >
																			<div class="span3" style="margin-top:5px;">
																				<b>Customer name:</b>			
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
																						<div class="span6">
																							<div class="row">
																								<div class="span3" style="margin-bottom:10px;"> 
																									<b>Customer name:</b>
																								</div>
																								<div class="span5" style="font-size:20px;color:red;"> 
																									<span class="selected-customer-name"></span>
																								</div>
																								<input type="hidden" hidden class="customer-name-selected" >
																								<input type="hidden" hidden class="customer-id-selected" >
																							</div>
																						</div>
																						<div class="span2">
																							<div class="row">
																								<div class="span3" style="margin-bottom:10px;">
																									<b>Total number of items: </b>
																								</div>
																								<div class="span3" style="font-size:20px;color:red;">
																									<span class="total-number-of-items"></span>
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
													</div>
												</div>
												<div class="row search-option-items-per-customer" hidden>
													<div class="span6">
														<div class="row">
															<div class="span4">
																<h6>Search by item description:</h6>
															</div>
															<div class="span6">
																<form class="frm-search-item-per-customer">
																	<span >
																		<input type="text" class="span4 txt-items-per-customer-search-engine" placeholder="Enter item description&hellip;" />
																	</span>
																	<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
																	<button class="btn btn-warning btn-refresh-items-per-customer" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
																</form>
															</div>
														</div>
													</div> 
													
													<div class="span4">
														<div class="row">
															<div class="span4">
																<h6>.</h6>
															</div>
															<div class="span4">
																<div class="dropdown" style="float:right;">
																	<button type="button" class="disabled btn dropdown-toggle  dropdown-toggle-items-per-customer" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																								
																	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																		<li role="presentation" class="disabled option-select-single-item-per-customer">
																			<a role="menuitem" tabindex="-1" class="menu-select-single-item-per-customer"><i class="fa fa-plus-circle"></i> Select single</a>
																		</li>
																		<li role="presentation" class="option-select-several-items-per-customer">
																			<a role="menuitem" tabindex="-1" class="menu-select-several-items-per-customer"><i class="fa fa-plus-circle"></i> Select several</a>
																		</li>
																		<li role="presentation" class="option-select-all-items-per-customers">
																			<a role="menuitem" tabindex="-1" class="menu-select-all-items-per-customer"><i class="fa fa-bars"></i> Select All Items</a>
																		</li>
																		<li role="presentation" class="disabled option-deselect-all-items-per-customer">
																			<a role="menuitem" tabindex="-1" class="menu-deselect-all-items-per-customer"><i class="fa fa-remove"></i> Deselect Items</a>
																		</li>
																		<li role="presentation" class="divider"></li>
																		<li role="presentation" class="disabled option-sort-items-per-customer-a-to-z">
																			<a role="menuitem" tabindex="-1" class="menu-sort-items-per-customer-a-to-z"><i class="fa fa-sort-asc "></i>  Sort A to Z</a>
																		</li>
																		<li role="presentation" class=" option-sort-items-per-customer-z-to-a">
																			<a role="menuitem" tabindex="-1" class="menu-sort-items-per-customer-z-to-a"><i class="fa fa-sort-desc "></i>  Sort Z to A</a>
																		</li>
																	</ul>
																</div>	
															</div>
														
														</div>
													</div>
												</div>
												<div class="row" >
													<div class="span10">
														<div class="box mainform" style="overflow-x:auto;height:500px;">
															<div class="box-content">
																<table class="table table-hover table-item-list">
																	<thead>
																		<tr >
																			<th style="width:300px;text-align:center;">Unit</th>	
																			<th style="width:300px;text-align:center;">Code</th>
																			<th style="width:300px;text-align:center;">Description</th>
																			<th style="width:300px;text-align:center;">Customer Price</th>
																			<th style="width:300px;text-align:center;">Supplier</th>
																			<th style="width:300px;text-align:center;">Stock</th>
																			<th style="width:300px;text-align:center;">Area</th>
																		</tr>
																	</thead>
																	<tbody class="displayItemsPerCsutomer" style="width:1000px;">
																		<tr>
																			<td colspan="8" style="width:100%;">
																				<div class="box-body">
																					<div class="box-body">
																						<div class="callout callout-danger">
																							<h4>Search customer to view item list..</h4>	
																						</div>
																					</div>
																				</div>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div class="span2">
														<div class="row">
															<div class="span2">
																<button class="span2 btn btn-add-items-per-customer disabled" style="height:70px;"> Add Items <br> <span style="font-size:12px;font-weight:bold;">(F9)</span></button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="span2 btn btn-update-items-per-customer disabled" style="height:70px;">Update Items <br> <span style="font-size:12px;font-weight:bold;">(F10)</span></button>
															</div>
															<div class="span2" style="margin-top:20px;">
																<button class="span2 btn btn-remove-items-per-customer disabled" style="height:70px;">Remove Items <br> <span style="font-size:12px;font-weight:bold;">(F11)</span></button>
															</div>
														</div>
													</div>
												</div>	
											</div>
											<script src="public/js/admin/supplies/supplies.js" type="text/javascript" ></script>
										<?php }?>
									</div>
								</div>
								<br>	
							</div>
						</div>
				   </div>
            </div>
	</section>
</div>
<?php require_once('views/executionTransition.php');?>

<?php require_once('views/footer.php');?>
