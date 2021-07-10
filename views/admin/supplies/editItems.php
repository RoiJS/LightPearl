<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<input type="hidden" value="tbl_suppliers" class="tblname"/>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Supplies<br/>
                            <small>Eiblin Enterprises</small>
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options">
                    <div class="span9">
                        <ul class="nav nav-pills">
							 <li class="btn-manage-suppliers">
                                <a>Manage Suppliers</a>
                            </li>
							<li  class="btn-manage-item-category">
                                <a >Manage Item Category</i></a>
                            </li>
							<li class="btn-manage-unit">
                                <a >Manage units</i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container">
		<div class="row">
            <?php $itemsChecked = query('SELECT * FROM tbl_items WHERE checkStatus = 1','','','variable');?>
			<?php if(!empty($itemsChecked)){?>
				<div class="span14" style="margin-bottom:15px;">
					<button class="btn btn-primary btn-save-all-edit-items" ><i class="fa fa-save"></i> Save all items</button>
				</div>
				<?php foreach($itemsChecked as $itemUpdateInfo):?>
					<div class="span7">
						<div class="well well-small well-shadow">
							<form class="frm-update-item" id="frm-update-item<?php echo $itemUpdateInfo['row']['itemId'];?>" idfui="<?php echo $itemUpdateInfo['row']['itemId']; ?>"">
								<div class="well well-small well-shadow" style="width:100px;margin-bottom:-20px;margin-left:20px;">
									Update item
								</div>
								<div class="box">
									<div class="box-content">
									<br>
										<div class="row">
											<div class="span6">
												<div class="row">
													<div class="span3">
														<div class="row">
															<div class="span3">
																<h6 class="input-code">Code:<h6>
																<h6 class="input-code-success" style="color:green;" hidden>Code: <span><i class="fa fa-check"></i></span><h6>
																<h6 class="input-code-failed" style="color:red;" hidden>Code: <span><i class="fa fa-remove"></i></span><h6>	
															</div>
															<div class="span3">
																<input type="text" placeholder="Enter code" class="span3 code required" name="code<?php echo $itemUpdateInfo['row']['itemId'];?>" value="<?php echo $itemUpdateInfo['row']['itemCode'];?>"/>	
																<input type="hidden" placeholder="Enter code" class="span3 duplicate-code" value="<?php echo $itemUpdateInfo['row']['itemCode'];?>"/>	
															</div>
														</div>
													</div>
													<div class="span3">
														<div class="row">
															<div class="span3">
																<h6 class="input-stocks">Stocks:<h6>	
																<h6 class="input-stocks-success" style="color:green;" hidden>Stocks: <span><i class="fa fa-check"></i></span><h6>
																<h6 class="input-stocks-failed" style="color:red;" hidden>Stocks: <span><i class="fa fa-remove"></i></span><h6>	
															</div>
															<div class="span3">
																<input type="text" placeholder="Enter stocks" class="span3 stocks required" name="stocks<?php echo $itemUpdateInfo['row']['itemId'];?>" value="<?php echo $itemUpdateInfo['row']['stocks'];?>"/>	
																<input type="hidden" placeholder="Enter stocks" class="span3 duplicate-stocks" value="<?php echo $itemUpdateInfo['row']['stocks'];?>"/>	
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="span6">
												<div class="row">
													<div class="span6">
														<h6 class="input-description">Description:<h6>
														<h6 class="input-description-success" style="color:green;" hidden>Description: <span><i class="fa fa-check"></i></span><h6>
														<h6 class="input-description-failed" style="color:red;" hidden>Description: <span><i class="fa fa-remove"></i></span><h6>
													</div>
													<div class="span6">
														<input type="text" placeholder="Enter description" class="span6 description required" name="description<?php echo $itemUpdateInfo['row']['itemId'];?>" value="<?php echo $itemUpdateInfo['row']['description'];?>"/>
														<input type="hidden" placeholder="Enter description" class="span6 duplicate-description" value="<?php echo $itemUpdateInfo['row']['description'];?>"/>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="span6">
												<div class="row">
													<div class="span2">
														<div class="row">
															<div class="span2">
																<h6 class="input-whole-sale-price">Whole sale price:<h6>	
																<h6 class="input-whole-sale-price-success" style="color:green;" hidden>Whole sale price: <span><i class="fa fa-check"></i></span><h6>
																<h6 class="input-whole-sale-price-failed" style="color:red;" hidden>Whole sale price: <span><i class="fa fa-remove"></i></span><h6>
															</div>
															<div class="span2">
															 
																<input type="text" placeholder="Enter Price" class="span2 whole-sale-price-multiple required" id="whole-sale-price-multiple<?php echo $itemUpdateInfo['row']['itemId']; ?>" idwspm="<?php echo $itemUpdateInfo['row']['itemId']; ?>" value="<?php echo number_format($itemUpdateInfo['row']['wholeSalePrice'],2,'.',',');?>"/>
																
															</div>		
														</div>
													</div>
													<div class="span2">
														<div class="row">
															<div class="span2">
																<h6>WSP increase:<h6>	
															</div>
															<div class="span2">
																<input type="text" placeholder="Enter Percentage" class="span1 whole-sale-price-increase-multiple" idwspim="<?php echo $itemUpdateInfo['row']['itemId'];?>" value="<?php echo $itemUpdateInfo['row']['wholePricePercentageIncrease'];?>"/> <b style="margin-bottom:20px;">%</b>
															</div>		
														</div>
													</div>
													<div class="span2">
														<div class="row">
															<div class="span2">
																<h6>SRP:<h6>	
															</div>
															<div class="span2" style="margin-top:-8px;">
															
																<h5 style="color:red;">Php <span class="suggested-retail-price-hidden" id="suggested-retail-price-hidden<?php echo $itemUpdateInfo['row']['itemId']; ?>"><?php echo number_format($itemUpdateInfo['row']['suggestedRetailPrice'],2,'.',',');?></span></h5>
																
																<input type="hidden" class="suggested-retail-price" id="suggested-retail-price<?php echo $itemUpdateInfo['row']['itemId']; ?>" value="<?php echo number_format($itemUpdateInfo['row']['suggestedRetailPrice'],2,'.',',');?>"/>
																
															</div>		
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="span6">
												<div class="row">
													<div class="span3">
														<div class="row">
															<div class="span3">
																<h6 class="input-category">Category:<h6>
																<h6 class="input-category-success" style="color:green;" hidden>Category: <span><i class="fa fa-check"></i></span><h6>
																<h6 class="input-category-failed" style="color:red;" hidden>Category: <span><i class="fa fa-remove"></i></span><h6>
															</div>
															<div class="span3">
																<select class="select-category-multiple span3" idscm="<?php echo $itemUpdateInfo['row']['itemId'];?>">	
																	<option value=""></option>
																	<?php $itemCategoryList = query('SELECT * FROM tbl_itemcategories','','','variable');?>
																	<?php foreach($itemCategoryList as $itemCategory):?>
																		<option value="<?php echo $itemCategory['row']['itemCategory_id'];?>" <?php if($itemUpdateInfo['row']['category_id'] == $itemCategory['row']['itemCategory_id']){echo 'selected="selected"';}?>><?php echo $itemCategory['row']['itemCategory'];?></option>
																	<?php endforeach;?>
																</select>
																<input type="hidden" value="<?php echo $itemUpdateInfo['row']['category_id']; ?>" class="duplicate-category"/>
															</div>		
														</div>
													</div>
													<div class="span3">
														<div class="row">
															<div class="span3">
																<h6 class="input-unit">Unit:<h6>
																<h6 class="input-unit-success" style="color:green;" hidden>Unit: <span><i class="fa fa-check"></i></span><h6>
																<h6 class="input-unit-failed" style="color:red;" hidden>Unit: <span><i class="fa fa-remove"></i></span><h6>
															</div>
															<div class="span2">
																<select class="select-unit span3" id="select-unit<?php echo $itemUpdateInfo['row']['itemId']; ?>" >
																	<option value=""></option>
																	<?php $unitList = query('SELECT * FROM tbl_units','WHERE unit_id = :id',[':id' => $itemUpdateInfo['row']['unit_id']],'variable');?>
																	<?php foreach($unitList as $unit):?>
																		<option value="<?php echo $unit['row']['unit_id'];?>" <?php if($itemUpdateInfo['row']['unit_id'] == $unit['row']['unit_id']){echo 'selected="selected"';}?>><?php echo $unit['row']['unit'];?></option>
																	<?php endforeach;?>
																</select>
																<input type="hidden" value="<?php echo $itemUpdateInfo['row']['unit_id']; ?>" class="duplicate-unit"/>
															</div>		
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="span6">
												<div class="row">	
													<div class="span6">
														<h6 class="input-supplier">Supplier:<h6>
														<h6 class="input-supplier-success" style="color:green;" hidden>Supplier: <span><i class="fa fa-check"></i></span><h6>
														<h6 class="input-supplier-failed" style="color:red;" hidden>Supplier: <span><i class="fa fa-remove"></i></span><h6>
													</div>
													<div class="span6">
														<select class="select-supplier span6" name="supplier-id<?php echo $itemUpdateInfo['row']['itemId'];?>">
															<option value=""></option>
															<?php $supplierList = query('SELECT * FROM tbl_suppliers','','','variable');?>
															<?php foreach($supplierList as $supplier):?>
																<option value="<?php echo $supplier['row']['supplier_id'];?>" <?php if($itemUpdateInfo['row']['supplier_id'] == $supplier['row']['supplier_id']){echo 'selected="selected"';}?>><?php echo $supplier['row']['supplier'];?></option>
															<?php endforeach;?>
														</select>
														<input type="hidden" value="<?php echo $itemUpdateInfo['row']['supplier_id']; ?>" class="duplicate-supplier"/>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				<?php endforeach;?>
					<div class="span14">
						<button class="btn btn-primary btn-save-all-edit-items" ><i class="fa fa-save"></i> Save all items</button>
					</div>
			<?php }else{?>
			<div class="span16">
				<h4>No items selected&hellip;</h4>
			</div>
			<?php }?>
        </div>
		<br>
		<br>
	</section>
</div>
<?php require_once('views/executionTransition.php');?>
<script src="public/js/admin/supplies/supplies.js" type="text/javascript" ></script>
<script src="public/js/admin/supplies/suppliers.js" type="text/javascript" ></script>
<script src="public/js/admin/supplies/units.js" type="text/javascript" ></script>
<script src="public/js/admin/supplies/itemCategory.js" type="text/javascript" ></script>

<?php require_once('views/footer.php');?>
