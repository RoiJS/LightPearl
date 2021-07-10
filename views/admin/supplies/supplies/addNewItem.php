<div class="row" style="margin-left:0px;">
	<div class="nav-tabs-custom" >
		<ul class="nav nav-tabs">
			<li class="active"><a href="#single-item" data-toggle="tab">Single item</a></li>
			<li hidden><a href="#multiple-items" data-toggle="tab">Multipe items</a></li>
			<li ><a href="#upload-list-items" data-toggle="tab">Upload item list</a></li>
		</ul>
	</div>
</div>
<div class="row " style="padding-left:11px;">
	<div class="span6">
		<div class="alert alert-block alert-danger displayVerificationRespondent" hidden>
			<i class="fa fa-warning" style="font-size:18px;"></i> <span class="display-message" style="text-align:justify;"></span>
		</div>
	</div>
</div>

<div class="tab-content">
	<div class="tab-pane fade in active" id="single-item">
		<form class="frm-add-new-item">
			<div class="box">
				<div class="box-content">
					<div class="row">
						<div class="span6">
							<div class="row">
								<div class="span2">
									<div class="row">
										<?php do{?>
										<?php $rand = rand(0,1000000); $zeros = '';  ?>
										<?php if(strlen($rand) < 7):?>
											<?php $zeroLength = 7 - strlen($rand); ?>
											<?php for($i = 0;$i < $zeroLength; $i++):?>
												<?php $zeros .= "0";?>
											<?php endfor;?>
										<?php endif;?>
										<?php $invoiceNo = $zeros.$rand;?>
										<?php $verifyInvoiceNo = query('SELECT itemCode FROM tbl_items','WHERE itemCode = :id',[':id' => $invoiceNo],'variable',1);?>
										<?php }while(!empty($verifyInvoiceNo));?>
										<div class="span2">
											<h6 class="input-code">Code:<h6>
											<h6 class="input-code-success" style="color:green;" hidden>Code: <span><i class="fa fa-check"></i></span><h6>
											<h6 class="input-code-failed" style="color:red;" hidden>Code: <span><i class="fa fa-remove"></i></span><h6>
										</div>
										<div class="span2">
											<input type="text" autofocus placeholder="Enter code&hellip;" class="span2 code required" name="code" id="code" value="<?php echo $invoiceNo;?>"/>	
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
											<input type="number" min=0 onchange="if(this.value < 0){this.value = 0;}" placeholder="Enter stocks&hellip;" class="span2 stocks required" name="stocks"/>	
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
											<input type="text" placeholder="Enter unit&hellip;" class="select-unit span2 required" name="unit-id" list="unit_list">
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
									<input type="text" placeholder="Enter description&hellip;" class="span6 description required" name="description">
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
									<input type="text" placeholder="Enter supplier&hellip;" class="span4 supplier required" name="supplier" list="supplier_list" />
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
									<input type="text" placeholder="Enter area&hellip;" class="span2 area required" name="area" list="area_list" />
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
											<input type="number" min="0" step="0.01" onchange="if(this.value < 0){this.value = 0;}" placeholder="Enter price&hellip;" class="span2 whole-sale-price required" name="whole-sale-price" />
										</div>		
									</div>
								</div>
								<div class="span2">
									<div class="row">
										<div class="span2">
											<h6 class="input-whole-sale-price-increase">WSP increase:<h6>
											<h6 class="input-whole-sale-price-increase-success" style="color:green;" hidden>WSP increase: <span><i class="fa fa-check"></i></span><h6> 
											<h6 class="input-whole-whole-sale-price-increase-failed" style="color:red;" hidden>WSP increase: <span><i class="fa fa-remove"></i></span><h6>
										</div>
										<div class="span2">
											<input type="number" min="0" onchange="if(this.value < 0){this.value = 0;}" class="span1 whole-sale-price-increase" name="whole-sale-price-increase" placeholder="0"/> <b style="margin-bottom:20px;">%</b>
										</div>		
									</div>
								</div>
								<div class="span2">
									<div class="row">
										<div class="span2">
											<h6 class="input-srp">SRP:<h6>	
											<h6 class="input-srp-success" style="color:green;" hidden>SRP: <span><i class="fa fa-check"></i></span><h6>
											<h6 class="input-srp-failed" style="color:red;" hidden>SRP: <span><i class="fa fa-remove"></i></span><h6>
										</div>
										<div class="span2" style="margin-top:-8px;">
											<h5 style="color:red;">Php <span class="suggested-retail-price-hidden">0.00</span><h5>
											<input type="hidden" class="suggested-retail-price" name="suggested-retail-price"/>
										</div>		
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="span6">
							<button class="btn btn-primary" type="submit" style="float:right;">Save</button>
						</div>
					</div>
				</div>
			</div>
		</form>		
	</div>
	<div class="tab-pane fade in" id="multiple-items" hidden>
		<br>
		<div class="row">
			<div class="span6">
				<div class="box">
					<div class="box-content">
						<form class="frm-add-multiple-items">
							<div class="row">
								<div class="span6">
									<b>Enter no. of items:</b>
									<input type="number" class="span3 txt-number-of-items-to-be-addedd"/>	
									<button type="submit" class="btn btn-primary" style="margin-top: -10px;">Go</button>	
								</div>	
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade in" id="upload-list-items">
		<div class="box">
			<div class="box-content">
				<div class="row display-file-info" hidden>
					<div class="span6">
						<div class="row">
							<div class="span2">
								<b>File name: </b>
							</div>
							<div class="span4">
								<span class="file-name" style="color:red;"></span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="span2">
								<b>File size: </b>
							</div>
							<div class="span2">
								<span class="file-size" style="color:red;"></span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="span2">
								<b>Total rows:</b>
							</div>
							<div class="span2">
								<span class="total-rows" style="color:red;"></span>
							</div>
						</div>
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="span6">
						<form method="POST" action="public/php/process.php" enctype="multipart/form-data" onsubmit="javascript:return validateFile();">
							<div class="row">
								<div class="span4">
									<input type="file" class="file-upload" name="file-upload" />	
								</div>
								<div class="span2">
									<button type="submit" name="uploadFile" class="btn btn-primary"><i class="fa fa-upload"></i> Upload file</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<button class="btn btn-warning close-add-item-form" type="button">Close</button>
