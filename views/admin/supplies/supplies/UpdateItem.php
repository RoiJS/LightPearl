<div class="row " style="padding-left:11px;">
	<div class="span6">
		<div class="alert alert-block alert-danger displayVerificationRespondent" hidden>
			<i class="fa fa-warning" style="font-size:18px;"></i> <span class="display-message" style="text-align:justify;"></span>
		</div>
	</div>
</div>
<form class="frm-update-item" idfui="<?php echo $itemUpdateInfo['row']['itemId'];?>">
	<div class="well well-small well-shadow" style="width:100px;margin-bottom:-20px;margin-left:20px;">
		Update item
	</div>
	<div class="box">
		<div class="box-content">
		<br>
			<div class="row">
				<div class="span6">
					<div class="row">
						<div class="span2">
							<div class="row">
								<?php if($itemUpdateInfo['row']['itemCode'] == ""){?>
									<?php do{?>
									<?php $rand = rand(0,1000000); $zeros = '';  ?>
									<?php if(strlen($rand) < 7):?>
										<?php $zeroLength = 7 - strlen($rand); ?>
										<?php for($i = 0;$i < $zeroLength; $i++):?>
											<?php $zeros .= "0";?>
										<?php endfor;?>
									<?php endif;?>
									<?php $code = $zeros.$rand;?>
									<?php $verifyInvoiceNo = query('SELECT itemCode FROM tbl_items','WHERE itemCode = :id',[':id' => $code],'variable',1);?>
									<?php }while(!empty($verifyInvoiceNo));?>
								<?php }else{?>
									<?php $code = $itemUpdateInfo['row']['itemCode']; ?>
								<?php }?>
								
								
								<div class="span2">
									<h6 class="input-code">Code:<h6>
									<h6 class="input-code-success" style="color:green;" hidden>Code: <span><i class="fa fa-check"></i></span><h6>
									<h6 class="input-code-failed" style="color:red;" hidden>Code: <span><i class="fa fa-remove"></i></span><h6>	
								</div>
								<div class="span2">
									<input type="text" id="code" placeholder="Enter code&hellip;" class="span2 code required" name="code" value="<?php echo $code;?>"/>	
									<input type="hidden" placeholder="Enter code&hellip;" class="span2 duplicate-code" value="<?php echo $code;?>"/>	
								</div>
							</div>
						</div>
						<div class="span2">
							<div class="row">
								<div class="span2">
									<h6 class="input-stocks">Stocks:<h6>	
									<h6 class="input-stocks-success" style="color:green;" hidden>Stocks: <span><i class="fa fa-check"></i></span><h6>
									<h6 class="input-stocks-failed" style="color:red;" hidden>Stocks: <span><i class="fa fa-remove"></i></span><h6>	
								</div>
								<div class="span2">
									<input type="number" min=0 onchange="if(this.value < 0){this.value = 0;}"  placeholder="Enter stocks" class="span2 stocks required" name="stocks" value="<?php echo $itemUpdateInfo['row']['stocks'];?>"/>	
									<input type="hidden" placeholder="Enter stocks&hellip;" class="span2 duplicate-stocks" value="<?php echo $itemUpdateInfo['row']['stocks'];?>"/>	
								</div>
							</div>
						</div>
						<div class="span2">
							<div class="row">
								<div class="span2">
									<h6 class="input-unit">Unit:<h6>
									<h6 class="input-unit-success" style="color:green;" hidden>Unit: <span><i class="fa fa-check"></i></span><h6>
									<h6 class="input-unit-failed" style="color:red;" hidden>Unit: <span><i class="fa fa-remove"></i></span><h6>
								</div>
								<div class="span2">
									<input type="text" placeholder="Enter unit&hellip;" class="select-unit span2 required" name="unit-id" list="unit_list" value="<?php echo $itemUpdateInfo['row']['unit'];?>">
									<datalist id="unit_list">
										<option value=""></option>
										<?php $unitList = query("SELECT DISTINCT(unit) FROM tbl_items","","","variable");?>
										<?php foreach($unitList as $unit){?>
											<option value="<?php echo $unit["row"]["unit"];?>" />
										<?php }?>
									</datalist>
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
							<input type="text" value="<?php echo htmlspecialchars($itemUpdateInfo['row']['description']);?>" placeholder="Enter description&hellip;" class="span6 description required" name="description"/>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span4">
					<div class="row">
						<div class="span4">
							<h6 class="input-supplier">Supplier:<h6>
							<h6 class="input-supplier-success" style="color:green;" hidden>Supplier: <span><i class="fa fa-check"></i></span><h6>
							<h6 class="input-supplier-failed" style="color:red;" hidden>Supplier: <span><i class="fa fa-remove"></i></span><h6>
						</div>
						
						<div class="span4">
							<input type="text" placeholder="Enter supplier&hellip;" class="span4 supplier required" name="supplier" list="supplier_list" value="<?php echo $itemUpdateInfo['row']['supplier'];?>" />
							<datalist id="supplier_list">
								<?php $supplierList = query('SELECT DISTINCT(supplier) AS supplier FROM tbl_items ORDER BY supplier ASC','','','variable');?>
								<?php foreach($supplierList as $supplier):?>
									<option value="<?php echo $supplier['row']['supplier'];?>"> 
								<?php endforeach;?>
							</datalist>
						</div>
					</div>
				</div>
				<div class="span2">
					<div class="row">
						<div class="span2">
							<h6 class="input-area">Area:<h6>	
							<h6 class="input-area-success" style="color:green;" hidden>Area: <span><i class="fa fa-check"></i></span><h6>
							<h6 class="input-area-failed" style="color:red;" hidden>Area: <span><i class="fa fa-remove"></i></span><h6>
						</div>
						<div class="span2">
							<input type="text" placeholder="Enter area&hellip;" class="span2 area required" name="area" list="area_list" value="<?php echo $itemUpdateInfo['row']['area'];?>"/>
							<datalist id="area_list">
								<?php $areaList = query('SELECT DISTINCT(area) AS area FROM tbl_items ORDER BY area ASC','','','variable');?>
								<?php foreach($areaList as $area):?>
									<option value="<?php echo $area['row']['area'];?>"> 
								<?php endforeach;?>
							</datalist>
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
									<h6 class="input-whole-sale-price-success" style="color:green;" hidden>Whole sale price:: <span><i class="fa fa-check"></i></span><h6>
									<h6 class="input-whole-sale-price-failed" style="color:red;" hidden>Whole sale price: <span><i class="fa fa-remove"></i></span><h6>
								</div>
								<div class="span2">
									<input type="number" min="0" step="0.01" onchange="if(this.value < 0){this.value = 0;}" placeholder="Enter Price" class="span2 whole-sale-price required" name="whole-sale-price" value="<?php echo number_format($itemUpdateInfo['row']['wholeSalePrice'],2,'.','');?>"/>
									<input type="hidden" placeholder="Enter Price&hellip;" class="span2 duplicate-whole-sale-price"  value="<?php echo $itemUpdateInfo['row']['wholeSalePrice'];?>"/>
								</div>		
							</div>
						</div>
						<div class="span2">
							<div class="row">
								<div class="span2">
									<h6>WSP increase:<h6>	
								</div>
								<div class="span2">
									<input type="number" min="0" onchange="if(this.value < 0){this.value = 0;}" placeholder="Enter Percentage" class="span2 whole-sale-price-increase" name="whole-sale-price-increase" style="width:30%;" value="<?php echo $itemUpdateInfo['row']['wholePricePercentageIncrease'];?>"/> <b style="margin-bottom:20px;">%</b>
									<input type="hidden" placeholder="0" class="span2 duplicate-whole-sale-price-increase"  value="<?php echo $itemUpdateInfo['row']['wholePricePercentageIncrease'];?>"/>
								</div>		
							</div>
						</div>
						<div class="span2">
							<div class="row">
								<div class="span2">
									<h6>SRP:<h6>	
								</div>
								<div class="span2" style="margin-top:-8px;">
									<h5 style="color:red;">Php <span class="suggested-retail-price-hidden"><?php echo number_format($itemUpdateInfo['row']['suggestedRetailPrice'],2,'.',',');?></span><h5>
									<input type="hidden" class="suggested-retail-price" name="suggested-retail-price" value="<?php echo number_format($itemUpdateInfo['row']['suggestedRetailPrice'],2,'.',',');?>"/>
									<input type="hidden" class="duplicate-suggested-retail-price"  value="<?php echo number_format($itemUpdateInfo['row']['suggestedRetailPrice'],2,'.',',');?>"/>
								</div>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span6" >
			<button class="btn btn-warning close-update-item-form-for-all-items" type="button">Close</button>
			<button class="btn btn-primary" type="submit" >Save</button>
		</div>
	</div>
</form>
