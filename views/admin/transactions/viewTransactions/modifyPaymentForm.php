<form class="frm-modify-payment">
	<div class="row">
		<div class="span8">
			<div class="box">
				<div class="box-content">
					<div class="row">
						<div class="span7">
							<div class="row">
								<div class="span4">
									<h5>Date Paid: </h5>
								</div>
								<div class="span3">
									<input style="width:150px;" type="date" value="<?php echo date('Y-m-d');?>" class="date-paid required" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="span7">
							<div class="row">
								<div class="span4">
									<h5>Expected cash received: </h5>
								</div>
								<div class="span3" >
									<h5 style="color:red;">Php <span class="expectedCash"><?php echo $expectedCashGiven; ?></span></h5>
									<input type="hidden" class="expected-amount" value="<?php echo getExpectedAmountGivenPerCustomer($customer_id); ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="span7">
							<div class="row">
								<div class="span4">
									<h4>Total Amount Received: </h4>
								</div>
								<div class="span3" >
									<h4 style="color:red;">Php <span class="totalCash"><?php echo $actualCashGiven;?></span></h4>
									<input type="hidden" class="actual-amount" value="<?php echo getActualAmountGivenPerCustomer($customer_id); ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="span7">
							<div class="row">
								<div class="span4">
									<h4>Enter amount: </h4>
								</div>
								<div class="span3">								
									<h4 style="color:red;">Php <input type="number" min=0 step="0.01" class="txt-enter-cash" style="width:100px;"/></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="span7">
							<div class="row">
								<div class="span4">
									<h4>Change: </h4>
								</div>
								<div class="span3">								
									<h4 style="color:red;">Php <span class="payment-change">0.00</span></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="span3">
			<button class="btn btn-warning btn-close-modify-payment-form" type="button">Close</button>
		</div>
		<div class="span4" style="float:right;">
			<button class="btn btn-primary btn-pay-now" style="float:right;" type="submit">Pay now</button>
		</div>
	</div>
</form>