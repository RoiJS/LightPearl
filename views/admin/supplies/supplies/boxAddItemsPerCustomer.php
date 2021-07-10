<span>Select items from the existing items to be added to the list of the items of the selected customer.</span>
<br>
<br>
<div class="box">
	<div class="box-content">
		<div class="row">
			<div class="span7">
				<div class="row">
					<div class="span5">
						<form class="frm-search-for-all-items-per-customer-search">
							<span >
								Search: <input type="text" class="span3 txt-search-item" placeholder="Enter item description&hellip;"/>
							</span>
							<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
							<button class="btn btn-warning btn-refresh-all-items-per-customer-search" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
						</form>
					</div>
					<div class="span2" >
						<div class="dropdown" style="float:right;">
							<button type="button" class="btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																									
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								<li role="presentation" class="option-select-all-items-per-customers-search">
									<a role="menuitem" tabindex="-1" class="menu-select-all-items-per-customer-search">Select All Items</a>
								</li>
								<li role="presentation" class="disabled option-deselect-all-items-per-customer-search">
									<a role="menuitem" tabindex="-1" class="menu-deselect-all-items-per-customer-search"> Deselect Items</a>
								</li>
								<li role="presentation" class="divider"></li>
								<li role="presentation" class="disabled option-sort-items-per-customer-a-to-z-search">
									<a role="menuitem" tabindex="-1" class="menu-sort-items-per-customer-a-to-z-search">Sort A to Z</a>
								</li>
								<li role="presentation" class=" option-sort-items-per-customer-z-to-a-search">
									<a role="menuitem" tabindex="-1" class="menu-sort-items-per-customer-z-to-a-search"> Sort Z to A</a>
								</li>
							</ul>
						</div>	
					</div>
				</div>
			</div>
			<div class="span6"></div>
		</div>
		
		<div class="row">
			<div class="span13">
				<div class="row">
					<div class="span7">
						<div class="box mainform" style="overflow-x:auto;height:400px;">
							<div class="box-content">
								<table class="table table-hover table-striped">
									<thead>
										<tr>
											<th>Unit</th>
											<th>Description</th>
											<th>SRP (Php)</th>
											<th>Stock</th>
										</tr>
									</thead>
									<tbody class="displayAllItemsPerCustomerSearched">
										
									</tbody>
								</table>	
							</div>
						</div>
					</div>
					<div class="span1">
						<br>
						<br>
						<div class="row">
							<div class="span2">
								<button class="btn btn-add-selected-items disabled" style="width:50px;"><b>>></b></button>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="span2">
								<button class=" btn btn-remove-selected-items" style="width:50px;"><b><i class="fa fa-remove"></i></b></button>
							</div>
						</div>
					</div>
					<div class="span5">
						<div class="box mainform" style="overflow-x:auto;height:400px;width:340px;">
							<div class="box-content">
								<table class="table table-hover table-striped">
									<thead>
										<tr>
											<th>Description</th>
											<th>SRP (Php)</th>
										</tr>
									</thead>
									<tbody class="displayItemsSelected">
										
									</tbody>
								</table>	
							</div>
						</div>
						
						<b>Items selected: <span class="no-of-items-selected" style="color:red;">0</span></b> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<button style="float:right;margin-left:10px;" class="btn btn-primary btn-save-selected-items-per-customer" type="button">Save</button>
<button style="float:right;" class="btn btn-warning close-add-item-form-per-customer" type="button">Close</button>

