<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page"/>
<input type="hidden" value="tbl_items" class="tblname"/>
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Customers Information<br/>
                             <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
            </div>
        </div>
    </section>
	
	
	<section class="page container">
		<div class="row">
			<div class="span5">
				<div class="row">
					<div class="span5">
						<div class="box well well-small well-shadow mainform">
							<div class="row" style="margin-left:0;">
								<div style="text-align:center;float:left;width:55%;padding-left:40px;">
								<i class="fa fa-users fa-5x"></i>
									<p>Number of customers</p>
								</div>
								<div>
									<h3 style="font-size:50px;margin-top:50px;float:left;">
										<?php $totalcustomers = query('SELECT * FROM tbl_customers','','','rows');?>
										<span class="totalTransactions"><?php echo $totalcustomers;?></span>
									</h3>
								</div>
							</div>
						</div>
					</div>
					<div class="span5">
						<div class="well well-small well-shadow mainform"> 
							<legend>Add New Customer</legend>
							<form class="frm-add-customer">
								<div class="row">
									<div class="span1">
										<b>Name:</b>
									</div>
									<div class="span4">
										<input type="text" class="txt-customer-name required" name="txt-customer-name" placeholder="Customer name&hellip;"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="span1">
										<b>Address:</b>
									</div>
									<div class="span4">
										<input type="text" class=" txt-customer-address" name="txt-customer-address" placeholder="Customer address&hellip;"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="span2">
										<b>Contact Info:</b>
									</div>
									<div class="span4">
										<input type="text" class=" txt-customer-contact-info" name="txt-customer-contact-info" placeholder="Customer contact info&hellip;"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="span2">
										<b>TIN No:</b>
									</div>
									<div class="span4">
										<input type="text" class="txt-customer-tin-no" name="txt-customer-tin-no" placeholder="Customer TIN No&hellip;"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="span1">
										<input type="submit" class="btn btn-primary" value="Save"/>
									</div>
									<div class="span1">
										<input type="reset" class="btn btn-warning" value="Clear"/>
									</div>
								</div>
							</form>
						</div>
					</div>
				
				</div>
			</div>
			<div class="span10">
				<div class="box well well-small well-shadow mainform">
					<legend>List of Customers</legend>
					<div class="row">
						<div class="span5">
							<div class="row">
								<div class="span5">
									<h6>Search by customer name:</h6>
								</div>
								<div class="span5">
									<form class="frm-search-customers">
										<?php $customers = query('SELECT * FROM tbl_customers','','','variable');?>
										<span >
											<select class="customer-name required" id="customer-name" placeholder="Enter customer name&hellip;">
												<option value=""></option>
												<?php foreach($customers as $customer):?>
													<option value="<?php echo $customer['row']['customer_id'];?>" ><?php echo $customer['row']['name'];?></option>
												<?php endforeach; ?>
											</select>	
										</span>
										<button type="submit" class="btn btn-success" style="margin-top:-9px;"><i class="fa fa-search"></i></button>
										<button class="btn btn-warning btn-refresh-customers" type="button" style="margin-top:-9px;"><i class="fa fa-refresh"></i></button>
									</form>
								</div>
							</div>
						</div> 
												
						<div class="span2">
							<div class="row">
								<div class="span2">
									<h6>.</h6>
								</div>
								<div class="span2">
									<div class="dropdown" style="float:right;">
										<button type="button" class="btn dropdown-toggle  dropdown-toggle-items-per-customer" id="dropdownMenu1" data-toggle="dropdown">Options <span class="caret"></span></button>
																							
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
											<li role="presentation" class="disabled option-sort-customer-a-to-z">
												<a role="menuitem" tabindex="-1" class="menu-sort-customer-a-to-z"><i class="fa fa-sort-desc "></i> Sort A to Z</a>
											</li>
											<li role="presentation" class=" option-sort-customer-z-to-a">
												<a role="menuitem" tabindex="-1" class="menu-sort-customer-z-to-a"><i class="fa fa-sort-asc "></i>	 Sort Z to A</a>
											</li>
										</ul>
									</div>	
								</div>
							</div>
						</div>		
						
						<div class="span7">
							<div class="table-responsive" style="overflow-x:auto;height:500px;border-radius:5px;">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th>Customer</th>
											<th>Address</th>
											<th>Contact info</th>
											<th></th>	
											<th></th>
										</tr>
									</thead>
									<tbody class="displayAllCustomers">
												
									</tbody>
								</table>
							</div>
						</div>
						<div class="span2">
							<div class="row">
								<div class="span2" style="margin-top:20px;">
									<button class="span2 btn btn-update-customer disabled" style="height:70px;">Update Customer</button>
								</div>
								<div class="span2" style="margin-top:20px;">
									<button class="span2 btn btn-remove-customer disabled" style="height:70px;">Remove Customer</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
</div>
<script src="public/js/admin/customers/customer.js" type="text/javascript" ></script>
<?php require_once('views/footer.php');?>

